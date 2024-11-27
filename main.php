<?php
// main.php

session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: index.html");
    exit;
}

include './includes/dbConnection.php';
$nombre = $_SESSION['nombre'];
$profesorId = $_SESSION['user_id'];

// Obtener estadísticas relacionadas con el profesor actual
$totalAlumnos = $conn->query("SELECT COUNT(*) AS total 
                              FROM alumnos 
                              WHERE nombre IS NOT NULL AND nombre != '' AND profesor_id = $profesorId")->fetch_assoc()['total'];

$totalClases = $conn->query("SELECT COUNT(DISTINCT clase) AS total 
                             FROM alumnos 
                             WHERE clase IS NOT NULL AND clase != '' AND profesor_id = $profesorId")->fetch_assoc()['total'];

// Total de empresas (común para todos los profesores)
$totalEmpresas = $conn->query("SELECT COUNT(*) AS total FROM empresas")->fetch_assoc()['total'];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Principal - FEPLA CRM</title>
    <link rel="stylesheet" href="./assets/css/header.css">
    <link rel="stylesheet" href="./assets/css/main.css">
</head>
<body>
    <?php include './includes/header.php'; ?>

    <div class="container">
        <h1>Bienvenido, <?php echo htmlspecialchars($nombre); ?>!</h1>

        <!-- Panel de Estadísticas -->
        <div class="statistics">
            <div class="stat">
                <h3>Total de Alumnos</h3>
                <p><?php echo $totalAlumnos; ?></p>
            </div>
            <div class="stat">
                <h3>Total de Clases</h3>
                <p><?php echo $totalClases; ?></p>
            </div>
            <div class="stat">
                <h3>Total de Empresas</h3>
                <p><?php echo $totalEmpresas; ?></p>
            </div>
        </div>

        <!-- Accesos Rápidos -->
        <div class="quick-access">
            <h2>Accesos Rápidos</h2>
            <ul>
                <li><a href="gestionarAlumnos.php">Gestionar Alumnos (*)</a></li>
                <li><a href="gestionarEmpresas.php">Gestionar Empresas (*)</a></li>
                <li><a href="miPerfil.php">Mi Perfil (*)</a></li>
            </ul>
        </div>

        <!-- Resumen de Actividad Reciente -->
        <div class="activity-summary">
            <h2>Actividad Reciente</h2>
            <p>Últimos cambios y acciones realizadas en el sistema...</p>
            <!-- Aquí podrías añadir más detalles de la actividad -->
        </div>
    </div>
</body>
</html>
