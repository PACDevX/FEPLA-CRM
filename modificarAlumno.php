<?php
// modificarAlumno.php

session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: index.html");
    exit;
}

include './includes/dbConnection.php';

$alumnoId = $_GET['id'];
$result = $conn->query("SELECT * FROM alumnos WHERE id = $alumnoId");
$alumno = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modificar Alumno - FEPLA CRM</title>
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
        .popup-message.success {
            background-color: #4CAF50; /* Verde para éxito */
        }
        .popup-message.error {
            background-color: #f44336; /* Rojo para errores */
        }
    </style>
</head>
<body>
    <?php include './includes/header.php'; ?>

    <div class="container">
        <h1>Modificar datos del alumno <?php echo htmlspecialchars($alumno['nombre']); ?></h1>

        <form action="./functions/updateAlumno.php" method="POST">
            <input type="hidden" name="id" value="<?php echo $alumno['id']; ?>">

            <label for="nombre">Nombre (*):</label>
            <input type="text" id="nombre" name="nombre" value="<?php echo htmlspecialchars($alumno['nombre']); ?>" required>

            <label for="apellido1">Primer Apellido (*):</label>
            <input type="text" id="apellido1" name="apellido1" value="<?php echo htmlspecialchars($alumno['apellido1']); ?>" required>

            <label for="apellido2">Segundo Apellido:</label>
            <input type="text" id="apellido2" name="apellido2" value="<?php echo htmlspecialchars($alumno['apellido2']); ?>">

            <label for="email">Correo Electrónico (*):</label>
            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($alumno['email']); ?>" required>

            <label for="telefono">Teléfono (*):</label>
            <input type="text" id="telefono" name="telefono" value="<?php echo htmlspecialchars($alumno['telefono']); ?>" required>

            <label for="classSelect">Clase (*):</label>
            <select id="classSelect" name="classSelect" required>
                <?php
                $result = $conn->query("SELECT DISTINCT clase FROM alumnos WHERE clase != ''");
                while ($row = $result->fetch_assoc()) {
                    $selected = ($row['clase'] === $alumno['clase']) ? 'selected' : '';
                    echo "<option value='" . htmlspecialchars($row['clase']) . "' $selected>" . htmlspecialchars($row['clase']) . "</option>";
                }
                ?>
            </select>

            <button type="submit" class="button">Guardar Cambios</button>
            <a href="gestionarAlumnos.php" class="button">Cancelar</a>
        </form>
    </div>
</body>
</html>
