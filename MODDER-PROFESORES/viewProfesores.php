<?php
session_start();
if (!isset($_SESSION['is_root']) || $_SESSION['is_root'] !== true) {
    header("Location: ../index.html");
    exit;
}
include '../includes/dbConnection.php';

$result = $conn->query("SELECT id, nombre, apellido, email FROM profesores");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Profesores</title>
    <link rel="stylesheet" href="assets/css/modder.css">
</head>
<body>
    <h1>Lista de Profesores</h1>
    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Email</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()) : ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo $row['nombre']; ?></td>
                    <td><?php echo $row['apellido']; ?></td>
                    <td><?php echo $row['email']; ?></td>
                    <td>
                        <a href="updateProfesor.php?id=<?php echo $row['id']; ?>">Modificar</a>
                        <a href="deleteProfesor.php?id=<?php echo $row['id']; ?>">Eliminar</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</body>
</html>
