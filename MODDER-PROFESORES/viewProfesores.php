<?php
session_start();
if (!isset($_SESSION['is_root']) || $_SESSION['is_root'] !== true) {
    header("Location: ../index.html");
    exit;
}

include '../includes/dbConnection.php';

// Actualizamos la consulta SQL para seleccionar los nuevos campos 'apellido1' y 'apellido2'
$result = $conn->query("SELECT id, nombre, apellido1, apellido2, email FROM profesores");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Profesores</title>
    <link rel="stylesheet" href="assets/css/modder.css">
    <script src="assets/js/popups.js"></script> <!-- Asegúrate de que popups.js esté cargado -->
</head>
<body>
    <?php include('includes/header.php'); ?> <!-- Incluir el header de forma global -->

    <main class="container">
        <section>
            <h1>Lista de Profesores</h1>
            <table border="1">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Apellidos</th> <!-- Cambiado para mostrar ambos apellidos -->
                        <th>Email</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()) : ?>
                        <tr>
                            <td><?php echo $row['id']; ?></td>
                            <td><?php echo $row['nombre']; ?></td>
                            <!-- Concatenamos apellido1 y apellido2 -->
                            <td><?php echo $row['apellido1'] . ' ' . $row['apellido2']; ?></td>
                            <td><?php echo $row['email']; ?></td>
                            <td>
                                <a href="updateProfesor.php?id=<?php echo $row['id']; ?>">Modificar</a>
                                <a href="deleteProfesor.php?id=<?php echo $row['id']; ?>">Eliminar</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </section>
    </main>

    <script>
        // Mostrar los popups según los parámetros de la URL al cargar la página
        document.addEventListener("DOMContentLoaded", () => {
            initPopupsFromUrl();  // Muestra el popup si hay parámetros 'message' o 'error' en la URL
        });
    </script>
</body>
</html>
