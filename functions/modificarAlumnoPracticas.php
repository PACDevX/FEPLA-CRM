<?php
// modificarAlumnoPracticas.php

session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: index.html");
    exit;
}

include '../includes/dbConnection.php';

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

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Verificar que 'alumnoId' y 'empresaId' están definidos
    if (isset($_POST['alumnoId']) && isset($_POST['empresaId'])) {
        $alumnoId = trim($_POST['alumnoId']);
        $empresaId = trim($_POST['empresaId']);

        // Modificar la empresa asignada al alumno
        $updateSql = "UPDATE asignaciones SET empresa_id = ? WHERE alumno_id = ?";
        $updateStmt = $conn->prepare($updateSql);
        $updateStmt->bind_param("ii", $empresaId, $alumnoId);

        if ($updateStmt->execute()) {
            showPopup("Prácticas modificadas satisfactoriamente.", "success");
        } else {
            showPopup("Error al modificar las prácticas.", "error");
        }

        $updateStmt->close();
    } else {
        showPopup("Error: Datos insuficientes para modificar las prácticas.", "error");
    }
}

$conn->close();
?>
