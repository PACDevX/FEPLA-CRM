<?php
// readme.php
include './includes/version.php'; // Incluir la versión desde otro archivo
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>README - FEPLA CRM</title>
    <link rel="stylesheet" href="./assets/css/main.css">
</head>
<body>
    <div class="container">
        <h1>README - FEPLA CRM</h1>
        <p>Versión del Programa: <strong><?php echo htmlspecialchars($version); ?></strong></p>
        <p>Bienvenido al sistema de gestión FEPLA CRM. Este software está diseñado para facilitar la gestión de alumnos, clases y empresas.</p>
        <ul>
            <li>Gestiona alumnos y clases.</li>
            <li>Asigna alumnos a empresas para prácticas.</li>
            <li>Accede a estadísticas clave de forma rápida y sencilla.</li>
        </ul>
        <a href="main.php" class="button">Volver al Panel Principal</a>
    </div>
</body>
</html>
