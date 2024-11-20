<?php
// enviarPracticas.php

session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: index.html");
    exit;
}

include './includes/dbConnection.php';

// Función para mostrar el popup
function showPopup($message, $type) {
    echo "<script>
        document.addEventListener('DOMContentLoaded', function() {
            const popup = document.createElement('div');
            popup.className = 'popup-message ' + '$type';
            popup.textContent = '$message';
            document.body.appendChild(popup);
            setTimeout(() => { popup.style.opacity = '0'; setTimeout(() => popup.remove(), 500); }, 3000);
        });
    </script>";
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enviar Alumnos a Prácticas - FEPLA CRM</title>
    <link rel="stylesheet" href="./assets/css/main.css">
    <link rel="stylesheet" href="./assets/css/header.css">
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
        }
        .popup-message.success {
            background-color: #4CAF50;
        }
        /* Estilos para la vista gráfica */
        .view-table {
            width: 100%;
            border-collapse: collapse;
        }
        .view-table th, .view-table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        .view-table th {
            background-color: #f4f4f4;
        }
        .actions {
            display: flex;
            gap: 10px;
        }
    </style>
</head>
<body>
    <?php include './includes/header.php'; ?>

    <div class="container">
        <h1>Enviar Alumnos a Prácticas</h1>

        <!-- Formulario para enviar alumno a prácticas -->
        <form action="./functions/enviarAlumnoPracticas.php" method="POST">
            <label for="alumnoId">Seleccionar Alumno:</label>
            <select id="alumnoId" name="alumnoId" required>
                <?php
                // Asegurarte de que se están mostrando los alumnos correctos
                $result = $conn->query("SELECT id, nombre, apellido1, apellido2 FROM alumnos WHERE nombre IS NOT NULL AND nombre != ''");
                while ($row = $result->fetch_assoc()) {
                    echo "<option value='" . htmlspecialchars($row['id']) . "'>" .
                        htmlspecialchars($row['nombre'] . ' ' . $row['apellido1'] . ' ' . $row['apellido2']) . "</option>";
                }
                ?>
            </select>

            <label for="empresaId">Seleccionar Empresa:</label>
            <select id="empresaId" name="empresaId" required>
                <?php
                $result = $conn->query("SELECT id, nombre FROM empresas");
                while ($row = $result->fetch_assoc()) {
                    echo "<option value='" . htmlspecialchars($row['id']) . "'>" . htmlspecialchars($row['nombre']) . "</option>";
                }
                ?>
            </select>

            <button type="submit" name="action" value="enviar" class="button">Enviar a Prácticas</button>
        </form>

        <!-- Vista Gráfica para Modificar o Eliminar -->
        <h2>Alumnos en Prácticas</h2>
        <table class="view-table">
            <thead>
                <tr>
                    <th>Alumno</th>
                    <th>Empresa</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Consulta para obtener las asignaciones de los alumnos a las empresas
                $result = $conn->query("SELECT asignaciones.id AS asignacion_id, alumnos.nombre, alumnos.apellido1, alumnos.apellido2, empresas.id AS empresa_id, empresas.nombre AS empresa_nombre
                                        FROM asignaciones
                                        JOIN alumnos ON asignaciones.alumno_id = alumnos.id
                                        JOIN empresas ON asignaciones.empresa_id = empresas.id");
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row['nombre'] . ' ' . $row['apellido1'] . ' ' . $row['apellido2']) . "</td>";
                    echo "<td>";
                    echo "<form action='./functions/modificarAlumnoPracticas.php' method='POST' class='inline-form'>";
                    echo "<input type='hidden' name='asignacionId' value='" . htmlspecialchars($row['asignacion_id']) . "'>";
                    echo "<select name='empresaId'>";
                    
                    // Generar las opciones de empresa
                    $empresas = $conn->query("SELECT id, nombre FROM empresas");
                    while ($empresa = $empresas->fetch_assoc()) {
                        $selected = ($empresa['id'] == $row['empresa_id']) ? "selected" : "";
                        echo "<option value='" . htmlspecialchars($empresa['id']) . "' $selected>" . htmlspecialchars($empresa['nombre']) . "</option>";
                    }
                    
                    echo "</select>";
                    echo "<button type='submit' class='button'>Modificar</button>";
                    echo "</form>";
                    echo "</td>";
                    echo "<td class='actions'>";
                    echo "<form action='./functions/eliminarAlumnoPracticas.php' method='POST' class='inline-form'>";
                    echo "<input type='hidden' name='asignacionId' value='" . htmlspecialchars($row['asignacion_id']) . "'>";
                    echo "<button type='submit' class='button'>Eliminar</button>";
                    echo "</form>";
                    echo "</td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>
