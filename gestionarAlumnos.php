<?php
// gestionarAlumnos.php

session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: index.html");
    exit;
}

include './includes/dbConnection.php';
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Alumnos - FEPLA CRM</title>
    <link rel="stylesheet" href="./assets/css/main.css">
    <link rel="stylesheet" href="./assets/css/header.css">
    <script>
        // Función para mostrar el popup
        function showPopup(message, type) {
            const popup = document.createElement("div");
            popup.className = `popup-message ${type}`;
            popup.textContent = message;
            document.body.appendChild(popup);

            // Desaparecer el popup después de 3 segundos
            setTimeout(() => {
                popup.style.opacity = '0';
                setTimeout(() => popup.remove(), 500);
            }, 3000);
        }

        // Leer los parámetros de la URL
        document.addEventListener("DOMContentLoaded", () => {
            const urlParams = new URLSearchParams(window.location.search);
            const message = urlParams.get("message");
            const type = urlParams.get("type");

            if (message && type) {
                showPopup(decodeURIComponent(message), type);
            }
        });
    </script>
    <style>
        /* Estilos para el popup */
        .popup-message {
            position: fixed;
            top: 20px;
            left: 50%;
            transform: translateX(-50%);
            padding: 10px 20px;
            border-radius: 5px;
            font-size: 14px;
            opacity: 1;
            transition: opacity 0.5s ease;
            z-index: 1000;
            color: #fff;
        }

        .popup-message.error {
            background-color: #f44336;
            /* Rojo para errores */
        }

        .popup-message.success {
            background-color: #4CAF50;
            /* Verde para éxito */
        }
    </style>
</head>

<body>
    <?php include './includes/header.php'; ?>

    <div class="container">
        <h1>Gestión de Alumnos</h1>

        <!-- Sección para crear una clase -->
        <div class="section">
            <h2>Crear Clase</h2>
            <form action="./functions/createClass.php" method="POST">
                <label for="className">Nombre de la Clase:</label>
                <input type="text" id="className" name="className" required>
                <button type="submit" class="button">Crear Clase</button>
            </form>
        </div>

        <!-- Sección para crear un alumno dentro de una clase -->
        <div class="section">
            <h2>Crear Alumno</h2>
            <form action="./functions/createAlumno.php" method="POST">
                <label for="classSelect">Clase:</label>
                <select id="classSelect" name="classSelect" required>
                    <!-- Aquí se llenarán las opciones de clase desde la base de datos -->
                    <?php
                    $result = $conn->query("SELECT DISTINCT clase FROM alumnos WHERE clase != ''");
                    while ($row = $result->fetch_assoc()) {
                        echo "<option value='" . htmlspecialchars($row['clase']) . "'>" . htmlspecialchars($row['clase']) . "</option>";
                    }
                    ?>
                </select>
                <label for="nombre">Nombre del Alumno:</label>
                <input type="text" id="nombre" name="nombre" required>

                <label for="apellido1">Primer Apellido:</label>
                <input type="text" id="apellido1" name="apellido1" required>

                <label for="apellido2">Segundo Apellido:</label>
                <input type="text" id="apellido2" name="apellido2" required>

                <label for="email">Correo Electrónico:</label>
                <input type="email" id="email" name="email" required>

                <label for="telefono">Teléfono:</label>
                <input type="text" id="telefono" name="telefono" required>

                <button type="submit" class="button">Crear Alumno</button>
            </form>
        </div>

        <!-- Sección para mover un alumno de clase -->
        <div class="section">
            <h2>Mover Alumno</h2>
            <form action="./functions/moveAlumno.php" method="POST">
                <label for="alumnoSelect">Seleccionar Alumno:</label>
                <select id="alumnoSelect" name="alumnoSelect" required>
                    <!-- Aquí se llenarán las opciones de alumnos con nombre, apellidos y clase desde la base de datos -->
                    <?php
                    $result = $conn->query("SELECT id, nombre, apellido1, apellido2, clase FROM alumnos WHERE nombre != ''");
                    while ($row = $result->fetch_assoc()) {
                        echo "<option value='" . htmlspecialchars($row['id']) . "'>" .
                            htmlspecialchars($row['nombre'] . ' ' . $row['apellido1'] . ' ' . $row['apellido2'] . ' - ' . $row['clase']) .
                            "</option>";
                    }
                    ?>
                </select>

                <label for="newClass">Nueva Clase:</label>
                <select id="newClass" name="newClass">
                    <!-- Opciones de clases -->
                    <?php
                    $result = $conn->query("SELECT DISTINCT clase FROM alumnos WHERE clase != ''");
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
                <label for="alumnoSelect">Seleccionar Alumno:</label>
                <select id="alumnoSelect" name="id" required>
                    <!-- Aquí se llenarán las opciones de alumnos con nombre, apellidos y clase desde la base de datos -->
                    <?php
                    $result = $conn->query("SELECT id, nombre, apellido1, apellido2, clase FROM alumnos WHERE nombre != ''");
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