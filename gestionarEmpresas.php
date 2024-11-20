<?php
// gestionarEmpresas.php

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
    <title>Gestión de Empresas - FEPLA CRM</title>
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
        <h1>Gestión de Empresas</h1>

        <!-- Sección para crear una empresa -->
        <div class="section">
            <h2>Crear Empresa</h2>
            <form action="./functions/createEmpresa.php" method="POST">
                <label for="nombre">Nombre de la Empresa (*):</label>
                <input type="text" id="nombre" name="nombre" required>

                <label for="contacto_principal">Contacto Principal (*):</label>
                <input type="text" id="contacto_principal" name="contacto_principal" required>

                <label for="email">Correo Electrónico (*):</label>
                <input type="email" id="email" name="email" required>

                <label for="telefono">Teléfono (*):</label>
                <input type="text" id="telefono" name="telefono" required>

                <button type="submit" class="button">Crear Empresa</button>
            </form>
        </div>

        <!-- Sección para gestionar las empresas -->
        <div class="section">
            <h2>Gestionar Empresas</h2>
            <form action="./functions/manageEmpresa.php" method="POST">
                <label for="empresaSelect">Seleccionar Empresa (*):</label>
                <select id="empresaSelect" name="empresaSelect" required>
                    <!-- Aquí se llenarán las opciones de empresas desde la base de datos -->
                    <?php
                    $result = $conn->query("SELECT id, nombre FROM empresas");
                    while ($row = $result->fetch_assoc()) {
                        echo "<option value='" . htmlspecialchars($row['id']) . "'>" . htmlspecialchars($row['nombre']) . "</option>";
                    }
                    ?>
                </select>

                <button type="submit" name="action" value="delete" class="button">Eliminar Empresa</button>
                <button type="submit" name="action" value="modify" class="button">Modificar Datos</button>
            </form>
        </div>
    </div>
</body>
</html>
