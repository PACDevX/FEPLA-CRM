<?php
// enviarAlumnoPracticas.php

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
    $alumnoId = trim($_POST['alumnoId']);
    $empresaId = trim($_POST['empresaId']);

    // Comprobar si el alumno ya está asignado a una empresa
    $checkSql = "SELECT COUNT(*) FROM asignaciones WHERE alumno_id = ?";
    $checkStmt = $conn->prepare($checkSql);
    $checkStmt->bind_param("i", $alumnoId);
    $checkStmt->execute();
    $checkStmt->bind_result($count);
    $checkStmt->fetch();
    $checkStmt->close();

    if ($count > 0) {
        showPopup("El alumno ya está asignado a una empresa.", "error");
    } else {
        // Asignar el alumno a la empresa
        $insertSql = "INSERT INTO asignaciones (alumno_id, empresa_id) VALUES (?, ?)";
        $insertStmt = $conn->prepare($insertSql);
        $insertStmt->bind_param("ii", $alumnoId, $empresaId);

        if ($insertStmt->execute()) {
            showPopup("Alumno enviado a prácticas satisfactoriamente.", "success");
        } else {
            showPopup("Error al enviar al alumno a prácticas.", "error");
        }

        $insertStmt->close();
    }
}

$conn->close();
?>
