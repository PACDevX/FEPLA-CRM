<?php
// modificarAlumno.php

session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: index.html");
    exit;
}

include './includes/dbConnection.php';

// Obtener el ID del profesor desde la sesión
$profesorId = $_SESSION['user_id'];

// Obtener el ID del alumno de la solicitud GET
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: gestionarAlumnos.php?message=Alumno%20no%20encontrado&type=error");
    exit;
}

$alumnoId = intval($_GET['id']);

// Comprobar si el alumno pertenece al profesor en sesión
$sql = "SELECT * FROM alumnos WHERE id = ? AND profesor_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $alumnoId, $profesorId);
$stmt->execute();
$result = $stmt->get_result();
$alumno = $result->fetch_assoc();

if (!$alumno) {
    header("Location: gestionarAlumnos.php?message=Acceso%20no%20autorizado&type=error");
    exit;
}

// Obtener las clases disponibles para el profesor actual
$clases = [];
$classQuery = "SELECT DISTINCT clase FROM alumnos WHERE profesor_id = ? AND clase != ''";
$classStmt = $conn->prepare($classQuery);
$classStmt->bind_param("i", $profesorId);
$classStmt->execute();
$classResult = $classStmt->get_result();
while ($row = $classResult->fetch_assoc()) {
    $clases[] = $row['clase'];
}

$classStmt->close();
$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modificar Alumno - FEPLA CRM</title>
    <link rel="stylesheet" href="./assets/css/main.css">
    <link rel="stylesheet" href="./assets/css/header.css">
    <link rel="stylesheet" href="./assets/css/popups.css">
    <script src="./assets/js/popups.js" defer></script>
</head>
<body>
    <?php include './includes/header.php'; ?>

    <div class="container">
        <h1>Modificar datos del alumno <?php echo htmlspecialchars($alumno['nombre']); ?></h1>

        <form action="./functions/updateAlumno.php" method="POST">
            <input type="hidden" name="id" value="<?php echo $alumno['id']; ?>">

            <label for="nombre">Nombre (*):</label>
            <input type="text" id="nombre" name="nombre" value="<?php echo htmlspecialchars($alumno['nombre']); ?>" required>

            <label for="apellido1">Primer Apellido (*):</label>
            <input type="text" id="apellido1" name="apellido1" value="<?php echo htmlspecialchars($alumno['apellido1']); ?>" required>

            <label for="apellido2">Segundo Apellido:</label>
            <input type="text" id="apellido2" name="apellido2" value="<?php echo htmlspecialchars($alumno['apellido2']); ?>">

            <label for="email">Correo Electrónico (*):</label>
            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($alumno['email']); ?>" required>

            <label for="telefono">Teléfono (*):</label>
            <input type="text" id="telefono" name="telefono" value="<?php echo htmlspecialchars($alumno['telefono']); ?>" required>

            <label for="classSelect">Clase (*):</label>
            <select id="classSelect" name="classSelect" required>
                <?php foreach ($clases as $clase): ?>
                    <option value="<?php echo htmlspecialchars($clase); ?>"
                        <?php echo ($clase === $alumno['clase']) ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($clase); ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <button type="submit" class="button">Guardar Cambios</button>
            <a href="gestionarAlumnos.php" class="button">Cancelar</a>
        </form>
    </div>
</body>
</html>
