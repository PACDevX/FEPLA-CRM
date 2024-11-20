<?php
// miPerfil.php

session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: index.html");
    exit;
}

include './includes/dbConnection.php';

// Obtener el id del profesor desde la sesión
$profesorId = $_SESSION['user_id'];

// Obtener los datos actuales del profesor
$sql = "SELECT nombre, email, apellido, descripcion FROM profesores WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $profesorId);
$stmt->execute();
$stmt->bind_result($nombre, $email, $apellido, $descripcion);
$stmt->fetch();
$stmt->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi Perfil - FEPLA CRM</title>
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
            background-color: #f44336; /* Rojo para errores */
        }
        .popup-message.success {
            background-color: #4CAF50; /* Verde para éxito */
        }
    </style>
</head>
<body>
    <?php include './includes/header.php'; ?>

    <div class="container">
        <h1>Mi Perfil</h1>

        <form action="./functions/updatePerfil.php" method="POST">
            <label for="nombre">Nombre (*):</label>
            <input type="text" id="nombre" name="nombre" value="<?php echo htmlspecialchars($nombre); ?>" required>

            <label for="email">Correo Electrónico (*):</label>
            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>" required>

            <label for="apellido">Apellido (*):</label>
            <input type="text" id="apellido" name="apellido" value="<?php echo htmlspecialchars($apellido); ?>" required>

            <label for="descripcion">Descripción (*):</label>
            <textarea id="descripcion" name="descripcion" required><?php echo htmlspecialchars($descripcion); ?></textarea>

            <button type="submit" class="button">Guardar Cambios</button>
        </form>
    </div>
</body>
</html>
