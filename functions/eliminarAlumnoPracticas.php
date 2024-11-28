<?php
// eliminarAlumnoPracticas.php

session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../index.html");
    exit;
}

include '../includes/dbConnection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $asignacionId = intval($_POST['asignacionId'] ?? 0);

    if ($asignacionId > 0) {
        $deleteSql = "DELETE FROM asignaciones WHERE id = ?";
        $stmt = $conn->prepare($deleteSql);
        $stmt->bind_param("i", $asignacionId);

        if ($stmt->execute()) {
            header("Location: ../enviarPracticas.php?message=" . urlencode("Asignación eliminada correctamente."));
        } else {
            header("Location: ../enviarPracticas.php?error=" . urlencode("Error al eliminar la asignación."));
        }

        $stmt->close();
    } else {
        header("Location: ../enviarPracticas.php?error=" . urlencode("Datos insuficientes para eliminar la asignación."));
    }
}

$conn->close();
