<?php
session_start();
if (!isset($_SESSION['is_root']) || $_SESSION['is_root'] !== true) {
    header("Location: ../index.html");
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Profesores - MODDER</title>
    <link rel="stylesheet" href="assets/css/modder.css">
</head>
<body>
    <header>
        <h1>Gestión de Cuentas de Profesores</h1>
        <nav>
            <ul class="nav-menu">
                <li><a href="createProfesor.php">Crear Profesor</a></li>
                <li><a href="viewProfesores.php">Ver Profesores</a></li>
                <li><a href="../main.php">Volver al CRM</a></li>
                <li><a href="../functions/logout.php">Cerrar Sesión</a></li>
            </ul>
        </nav>
    </header>

    <main class="container">
        <section>
            <h2>Bienvenido, Superusuario</h2>
            <p>Desde aquí puedes gestionar las cuentas de los profesores. Utiliza las opciones del menú para realizar las siguientes acciones:</p>
            <ul class="feature-list">
                <li>Crear nuevas cuentas de profesores.</li>
                <li>Ver, editar o eliminar profesores existentes.</li>
            </ul>
        </section>

        <section class="quick-links">
            <h2>Accesos Rápidos</h2>
            <div class="button-group">
                <a href="createProfesor.php" class="button-link">Crear Profesor</a>
                <a href="viewProfesores.php" class="button-link">Ver Profesores</a>
            </div>
        </section>
    </main>

    <footer>
        <p>© 2024 MODDER - FEPLA CRM. Todos los derechos reservados.</p>
    </footer>
</body>
</html>
