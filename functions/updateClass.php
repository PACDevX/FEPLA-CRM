<?php
// updateClass.php

session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../index.html");
    exit;
}

include '../includes/dbConnection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $classSelect = trim($_POST['classSelect']);
    $newClassName = trim($_POST['newClassName']);
    $profesorId = $_SESSION['user_id'];

    if (!empty($classSelect) && !empty($newClassName)) {
        $sql = "UPDATE alumnos SET clase = ? WHERE clase = ? AND profesor_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssi", $newClassName, $classSelect, $profesorId);

        if ($stmt->execute()) {
            header("Location: ../gestionarAlumnos.php?message=Clase%20modificada%20exitosamente&type=success");
        } else {
            header("Location: ../gestionarAlumnos.php?message=Error%20al%20modificar%20la%20clase&type=error");
        }

        $stmt->close();
    } else {
        header("Location: ../gestionarAlumnos.php?message=Todos%20los%20campos%20son%20obligatorios&type=error");
    }
}

$conn->close();
?>
