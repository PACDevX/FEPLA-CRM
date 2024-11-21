<?php
// modificarAlumnoPracticas.php

session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../index.html");
    exit;
}

include '../includes/dbConnection.php';

// Función para mostrar un popup
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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['asignacionId']) && isset($_POST['empresaId'])) {
        $asignacionId = trim($_POST['asignacionId']);
        $empresaId = trim($_POST['empresaId']);

        // Actualizar la asignación con la nueva empresa
        $updateSql = "UPDATE asignaciones SET empresa_id = ? WHERE id = ?";
        $stmt = $conn->prepare($updateSql);
        $stmt->bind_param("ii", $empresaId, $asignacionId);

        if ($stmt->execute()) {
            header("Location: ../enviarPracticas.php?message=Prácticas%20modificadas%20satisfactoriamente&type=success");
        } else {
            header("Location: ../enviarPracticas.php?message=Error%20al%20modificar%20las%20prácticas&type=error");
        }

        $stmt->close();
    } else {
        header("Location: ../enviarPracticas.php?message=Error:%20Datos%20insuficientes&type=error");
    }
}

$conn->close();
