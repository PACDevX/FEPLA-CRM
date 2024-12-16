<?php
session_start();
if (!isset($_SESSION['is_root']) || $_SESSION['is_root'] !== true) {
    header("Location: ../index.html");
    exit;
}
include '../includes/dbConnection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = trim($_POST['nombre']);
    $apellido = trim($_POST['apellido']);
    $email = trim($_POST['email']);
    $password = password_hash(trim($_POST['password']), PASSWORD_DEFAULT);

    $sql = "INSERT INTO profesores (nombre, apellido, email, password) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $nombre, $apellido, $email, $password);

    if ($stmt->execute()) {
        echo "Profesor creado exitosamente.";
    } else {
        echo "Error al crear el profesor: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Crear Profesor</title>
    <link rel="stylesheet" href="assets/css/modder.css">
</head>
<body>
    <h1>Crear Profesor</h1>
    <form method="POST">
        <label>Nombre:</label>
        <input type="text" name="nombre" required><br>
        <label>Apellido:</label>
        <input type="text" name="apellido" required><br>
        <label>Email:</label>
        <input type="email" name="email" required><br>
        <label>Contraseña:</label>
        <input type="password" name="password" required><br>
        <button type="submit">Crear</button>
    </form>
</body>
</html>
