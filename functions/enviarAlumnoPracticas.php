<?php
// enviarAlumnoPracticas.php

session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../index.html");
    exit;
}

include '../includes/dbConnection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $alumnoId = intval($_POST['alumnoId']);
    $empresaId = intval($_POST['empresaId']);
    $profesorId = $_SESSION['user_id']; // ID del profesor actual

    // Comprobar si el alumno ya está asignado
    $checkSql = "SELECT COUNT(*) FROM asignaciones WHERE alumno_id = ? AND profesor_id = ?";
    $checkStmt = $conn->prepare($checkSql);
    $checkStmt->bind_param("ii", $alumnoId, $profesorId);
    $checkStmt->execute();
    $checkStmt->bind_result($exists);
    $checkStmt->fetch();
    $checkStmt->close();

    if ($exists > 0) {
        header("Location: ../enviarPracticas.php?error=" . urlencode("El alumno ya está asignado a una empresa por este profesor."));
        exit;
    }

    // Insertar nueva asignación
    $insertSql = "INSERT INTO asignaciones (alumno_id, empresa_id, profesor_id) VALUES (?, ?, ?)";
    $insertStmt = $conn->prepare($insertSql);
    $insertStmt->bind_param("iii", $alumnoId, $empresaId, $profesorId);

    if ($insertStmt->execute()) {
        header("Location: ../enviarPracticas.php?message=" . urlencode("Alumno enviado a prácticas correctamente."));
    } else {
        header("Location: ../enviarPracticas.php?error=" . urlencode("Error al enviar al alumno a prácticas."));
    }

    $insertStmt->close();
}

$conn->close();
