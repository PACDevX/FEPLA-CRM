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
<<<<<<< HEAD
    $profesorId = $_SESSION['user_id']; // Obtener el ID del profesor desde la sesión

    // Comprobar si el alumno ya está asignado a una empresa bajo el profesor actual
    $checkSql = "SELECT COUNT(*) FROM asignaciones WHERE alumno_id = ? AND profesor_id = ?";
    $checkStmt = $conn->prepare($checkSql);
    $checkStmt->bind_param("ii", $alumnoId, $profesorId);
=======

    // Comprobar si el alumno ya está asignado a una empresa
    $checkSql = "SELECT COUNT(*) FROM asignaciones WHERE alumno_id = ?";
    $checkStmt = $conn->prepare($checkSql);
    $checkStmt->bind_param("i", $alumnoId);
>>>>>>> a6ead99ffbf64f87010048c87d2ccee2fe4f7c47
    $checkStmt->execute();
    $checkStmt->bind_result($count);
    $checkStmt->fetch();
    $checkStmt->close();

    if ($count > 0) {
<<<<<<< HEAD
        showPopup("El alumno ya está asignado a una empresa por este profesor.", "error");
    } else {
        // Asignar el alumno a la empresa bajo el profesor actual
        $insertSql = "INSERT INTO asignaciones (alumno_id, empresa_id, profesor_id) VALUES (?, ?, ?)";
        $insertStmt = $conn->prepare($insertSql);
        $insertStmt->bind_param("iii", $alumnoId, $empresaId, $profesorId);
=======
        showPopup("El alumno ya está asignado a una empresa.", "error");
    } else {
        // Asignar el alumno a la empresa
        $insertSql = "INSERT INTO asignaciones (alumno_id, empresa_id) VALUES (?, ?)";
        $insertStmt = $conn->prepare($insertSql);
        $insertStmt->bind_param("ii", $alumnoId, $empresaId);
>>>>>>> a6ead99ffbf64f87010048c87d2ccee2fe4f7c47

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
