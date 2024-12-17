<?php
// miPerfil.php

session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: index.html");
    exit;
}

include './includes/dbConnection.php';

// Obtener el id del profesor desde la sesión
$profesorId = $_SESSION['user_id'];

// Obtener los datos actuales del profesor
$sql = "SELECT nombre, email, apellido1, apellido2, descripcion FROM profesores WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $profesorId);
$stmt->execute();
$stmt->bind_result($nombre, $email, $apellido1, $apellido2, $descripcion);
$stmt->fetch();
$stmt->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi Perfil - FEPLA CRM</title>
    <link rel="stylesheet" href="./assets/css/main.css">
    <link rel="stylesheet" href="./assets/css/header.css">
    <link rel="stylesheet" href="./assets/css/popups.css">
    <script src="./assets/js/popups.js" defer></script> <!-- Usando el archivo popups.js -->
</head>
<body>
    <?php include './includes/header.php'; ?>

    <div class="container">
        <h1>Mi Perfil</h1>

        <form action="./functions/updatePerfil.php" method="POST">
            <label for="nombre">Nombre (*):</label>
            <input type="text" id="nombre" name="nombre" value="<?php echo htmlspecialchars($nombre); ?>" required>

            <label for="email">Correo Electrónico (*):</label>
            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>" required>

            <label for="apellido1">Apellido 1 (*):</label>
            <input type="text" id="apellido1" name="apellido1" value="<?php echo htmlspecialchars($apellido1); ?>" required>

            <label for="apellido2">Apellido 2:</label>
            <input type="text" id="apellido2" name="apellido2" value="<?php echo htmlspecialchars($apellido2); ?>">

            <label for="descripcion">Descripción:</label>
            <textarea id="descripcion" name="descripcion"><?php echo htmlspecialchars($descripcion); ?></textarea>

            <button type="submit" class="button">Guardar Cambios</button>
        </form>
    </div>
</body>
</html>
