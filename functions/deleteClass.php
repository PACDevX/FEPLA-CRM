<?php
// deleteClass.php

session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../index.html");
    exit;
}

include '../includes/dbConnection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $classToDelete = trim($_POST['classToDelete']);
    $profesorId = $_SESSION['user_id'];

    if (!empty($classToDelete)) {
        $sql = "DELETE FROM alumnos WHERE clase = ? AND profesor_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("si", $classToDelete, $profesorId);

        if ($stmt->execute()) {
            header("Location: ../gestionarAlumnos.php?message=Clase%20eliminada%20exitosamente&type=success");
        } else {
            header("Location: ../gestionarAlumnos.php?message=Error%20al%20eliminar%20la%20clase&type=error");
        }

        $stmt->close();
    } else {
        header("Location: ../gestionarAlumnos.php?message=Selecciona%20una%20clase&type=error");
    }
}

$conn->close();
?>
