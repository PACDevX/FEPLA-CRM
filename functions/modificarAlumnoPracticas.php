<?php
// modificarAlumnoPracticas.php

session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../index.html");
    exit;
}

include '../includes/dbConnection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $asignacionId = intval($_POST['asignacionId'] ?? 0);
    $empresaId = intval($_POST['empresaId'] ?? 0);

    if ($asignacionId > 0 && $empresaId > 0) {
        $updateSql = "UPDATE asignaciones SET empresa_id = ? WHERE id = ?";
        $stmt = $conn->prepare($updateSql);
        $stmt->bind_param("ii", $empresaId, $asignacionId);

        if ($stmt->execute()) {
            header("Location: ../enviarPracticas.php?message=" . urlencode("Asignación actualizada correctamente."));
        } else {
            header("Location: ../enviarPracticas.php?error=" . urlencode("Error al actualizar la asignación."));
        }

        $stmt->close();
    } else {
        header("Location: ../enviarPracticas.php?error=" . urlencode("Datos insuficientes para actualizar la asignación."));
    }
}

$conn->close();
