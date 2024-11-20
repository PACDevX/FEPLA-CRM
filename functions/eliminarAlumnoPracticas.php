<?php
// eliminarAlumnoPracticas.php

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
    // Verificar que 'alumnoId' está definido
    if (isset($_POST['alumnoId'])) {
        $alumnoId = trim($_POST['alumnoId']);

        // Eliminar la asignación del alumno
        $deleteSql = "DELETE FROM asignaciones WHERE alumno_id = ?";
        $deleteStmt = $conn->prepare($deleteSql);
        $deleteStmt->bind_param("i", $alumnoId);

        if ($deleteStmt->execute()) {
            showPopup("Alumno eliminado de las prácticas satisfactoriamente.", "success");
        } else {
            showPopup("Error al eliminar las prácticas del alumno.", "error");
        }

        $deleteStmt->close();
    } else {
        showPopup("Error: Datos insuficientes para eliminar las prácticas.", "error");
    }
}

$conn->close();
?>
