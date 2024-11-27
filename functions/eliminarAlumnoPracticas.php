<?php
// eliminarAlumnoPracticas.php

session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../index.html");
    exit;
}

include '../includes/dbConnection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['asignacionId'])) {
        $asignacionId = trim($_POST['asignacionId']);

        // Eliminar la asignación de la tabla
        $deleteSql = "DELETE FROM asignaciones WHERE id = ?";
        $stmt = $conn->prepare($deleteSql);
        $stmt->bind_param("i", $asignacionId);

        if ($stmt->execute()) {
            header("Location: ../enviarPracticas.php?message=Prácticas%20eliminadas%20satisfactoriamente&type=success");
        } else {
            header("Location: ../enviarPracticas.php?message=Error%20al%20eliminar%20las%20prácticas&type=error");
        }

        $stmt->close();
    } else {
        header("Location: ../enviarPracticas.php?message=Error:%20Datos%20insuficientes&type=error");
    }
}

$conn->close();
