<?php
session_start();
if (!isset($_SESSION['is_root']) || $_SESSION['is_root'] !== true) {
    header("Location: ../index.html");
    exit;
}

include '../includes/dbConnection.php';

$profesorId = $_GET['id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = trim($_POST['nombre']);
    $apellido1 = trim($_POST['apellido1']);
    $apellido2 = trim($_POST['apellido2']);
    $email = trim($_POST['email']);

    // Actualizamos la consulta SQL para reflejar los cambios de los apellidos
    $sql = "UPDATE profesores SET nombre = ?, apellido1 = ?, apellido2 = ?, email = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssi", $nombre, $apellido1, $apellido2, $email, $profesorId);

    if ($stmt->execute()) {
        // Redirigir a la misma página con un mensaje de éxito
        header("Location: updateProfesor.php?id=" . $profesorId . "&message=" . urlencode("Profesor actualizado exitosamente."));
    } else {
        // Redirigir a la misma página con un mensaje de error
        header("Location: updateProfesor.php?id=" . $profesorId . "&error=" . urlencode("Error al actualizar el profesor: " . $stmt->error));
    }

    $stmt->close();
    $conn->close();
    exit;
}

// Consultamos los datos actuales del profesor, ahora recuperamos apellido1 y apellido2
$result = $conn->query("SELECT nombre, apellido1, apellido2, email FROM profesores WHERE id = $profesorId");
$profesor = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Modificar Profesor</title>
    <link rel="stylesheet" href="assets/css/modder.css">
    <script src="assets/js/popups.js"></script> <!-- Asegúrate de incluir el archivo de popups.js -->
</head>
<body>
    <?php include('includes/header.php'); ?> <!-- Incluir el header de forma global -->

    <main class="container">
        <section>
            <h1>Modificar Profesor</h1>
            <form method="POST">
                <label>Nombre:</label>
                <input type="text" name="nombre" value="<?php echo $profesor['nombre']; ?>" required><br>

                <!-- Cambiamos los campos de apellido para que sean apellido1 y apellido2 -->
                <label>Apellido 1:</label>
                <input type="text" name="apellido1" value="<?php echo $profesor['apellido1']; ?>" required><br>

                <label>Apellido 2:</label>
                <input type="text" name="apellido2" value="<?php echo $profesor['apellido2']; ?>"><br>

                <label>Email:</label>
                <input type="email" name="email" value="<?php echo $profesor['email']; ?>" required><br>

                <button type="submit">Guardar Cambios</button>
            </form>
        </section>
    </main>

    <script>
        // Esto activará el popup si hay algún mensaje de éxito o error en la URL
        document.addEventListener("DOMContentLoaded", () => {
            initPopupsFromUrl();  // Función que muestra el popup cuando hay parámetros en la URL
        });
    </script>
</body>
</html>
