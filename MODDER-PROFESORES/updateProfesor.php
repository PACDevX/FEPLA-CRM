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
    $apellido = trim($_POST['apellido']);
    $email = trim($_POST['email']);

    $sql = "UPDATE profesores SET nombre = ?, apellido = ?, email = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssi", $nombre, $apellido, $email, $profesorId);

    if ($stmt->execute()) {
        echo "Profesor actualizado exitosamente.";
    } else {
        echo "Error al actualizar: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
    exit;
}

$result = $conn->query("SELECT nombre, apellido, email FROM profesores WHERE id = $profesorId");
$profesor = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Modificar Profesor</title>
    <link rel="stylesheet" href="assets/css/modder.css">
</head>
<body>
    <h1>Modificar Profesor</h1>
    <form method="POST">
        <label>Nombre:</label>
        <input type="text" name="nombre" value="<?php echo $profesor['nombre']; ?>" required><br>
        <label>Apellido:</label>
        <input type="text" name="apellido" value="<?php echo $profesor['apellido']; ?>" required><br>
        <label>Email:</label>
        <input type="email" name="email" value="<?php echo $profesor['email']; ?>" required><br>
        <button type="submit">Guardar Cambios</button>
    </form>
</body>
</html>
