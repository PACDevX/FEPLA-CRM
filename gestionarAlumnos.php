<?php
// gestionarAlumnos.php

session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: index.html");
    exit;
}

include './includes/dbConnection.php';

// Obtener el ID del profesor de la sesión
$profesorId = $_SESSION['user_id'];
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Alumnos - FEPLA CRM</title>
    <link rel="stylesheet" href="./assets/css/main.css">
    <link rel="stylesheet" href="./assets/css/header.css">
    <script src="./assets/js/popups.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const urlParams = new URLSearchParams(window.location.search);
            const message = urlParams.get("message");
            const type = urlParams.get("type");

            if (message && type) {
                showPopup(decodeURIComponent(message), type);
            }
        });
    </script>
</head>

<body>
    <?php include './includes/header.php'; ?>

    <div class="container">
        <h1>Gestión de Alumnos</h1>

        <!-- Sección para crear una clase -->
        <div class="section">
            <h2>Crear Clase</h2>
            <form action="./functions/createClass.php" method="POST">
                <label for="className">Nombre de la Clase (*):</label>
                <input type="text" id="className" name="className" required>
                <button type="submit" class="button">Crear Clase</button>
            </form>
        </div>

        <!-- Sección para crear un alumno dentro de una clase -->
        <div class="section">
            <h2>Crear Alumno</h2>
            <form action="./functions/createAlumno.php" method="POST">
                <label for="classSelect">Clase (*):</label>
                <select id="classSelect" name="classSelect" required>
                    <!-- Mostrar clases relacionadas con el profesor actual -->
                    <?php
                    $result = $conn->query("SELECT DISTINCT clase 
                                            FROM alumnos 
                                            WHERE clase != '' AND profesor_id = $profesorId");
                    while ($row = $result->fetch_assoc()) {
                        echo "<option value='" . htmlspecialchars($row['clase']) . "'>" . htmlspecialchars($row['clase']) . "</option>";
                    }
                    ?>
                </select>
                <label for="nombre">Nombre del Alumno (*):</label>
                <input type="text" id="nombre" name="nombre" required>

                <label for="apellido1">Primer Apellido (*):</label>
                <input type="text" id="apellido1" name="apellido1" required>

                <label for="apellido2">Segundo Apellido:</label>
                <input type="text" id="apellido2" name="apellido2">

                <label for="email">Correo Electrónico (*):</label>
                <input type="email" id="email" name="email" required>

                <label for="telefono">Teléfono (*):</label>
                <input type="text" id="telefono" name="telefono" required>

                <button type="submit" class="button">Crear Alumno</button>
            </form>
        </div>

        <!-- Sección para mover un alumno de clase -->
        <div class="section">
            <h2>Mover Alumno</h2>
            <form action="./functions/moveAlumno.php" method="POST">
                <label for="alumnoSelect">Seleccionar Alumno (*):</label>
                <select id="alumnoSelect" name="alumnoSelect" required>
                    <!-- Mostrar alumnos del profesor actual -->
                    <?php
                    $result = $conn->query("SELECT id, nombre, apellido1, apellido2, clase 
                                            FROM alumnos 
                                            WHERE profesor_id = $profesorId AND nombre != ''");
                    while ($row = $result->fetch_assoc()) {
                        echo "<option value='" . htmlspecialchars($row['id']) . "'>" .
                            htmlspecialchars($row['nombre'] . ' ' . $row['apellido1'] . ' ' . $row['apellido2'] . ' - ' . $row['clase']) .
                            "</option>";
                    }
                    ?>
                </select>

                <label for="newClass">Nueva Clase (*):</label>
                <select id="newClass" name="newClass" required>
                    <!-- Mostrar clases relacionadas con el profesor actual -->
                    <?php
                    $result = $conn->query("SELECT DISTINCT clase 
                                            FROM alumnos 
                                            WHERE clase != '' AND profesor_id = $profesorId");
                    while ($row = $result->fetch_assoc()) {
                        echo "<option value='" . htmlspecialchars($row['clase']) . "'>" . htmlspecialchars($row['clase']) . "</option>";
                    }
                    ?>
                </select>

                <button type="submit" class="button">Mover Alumno</button>
            </form>
        </div>

        <!-- Sección para eliminar o modificar un alumno -->
        <div class="section">
            <h2>Gestionar Alumnos</h2>
            <form action="modificarAlumno.php" method="GET">
                <label for="alumnoSelect">Seleccionar Alumno (*):</label>
                <select id="alumnoSelect" name="id" required>
                    <!-- Mostrar alumnos del profesor actual -->
                    <?php
                    $result = $conn->query("SELECT id, nombre, apellido1, apellido2, clase 
                                            FROM alumnos 
                                            WHERE profesor_id = $profesorId AND nombre != ''");
                    while ($row = $result->fetch_assoc()) {
                        echo "<option value='" . htmlspecialchars($row['id']) . "'>" .
                            htmlspecialchars($row['nombre'] . ' ' . $row['apellido1'] . ' ' . $row['apellido2'] . ' - ' . $row['clase']) .
                            "</option>";
                    }
                    ?>
                </select>

                <button type="submit" name="action" value="delete" class="button">Eliminar Alumno</button>
                <button type="submit" class="button">Modificar Datos</button>
            </form>
        </div>
    </div>
</body>

</html>
