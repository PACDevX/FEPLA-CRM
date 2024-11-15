<?php
// createClass.php

session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../index.html");
    exit;
}

include '../includes/dbConnection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $className = trim($_POST['className']);

    if (!empty($className)) {
        // Comprobar si la clase ya existe
        $checkSql = "SELECT COUNT(*) FROM alumnos WHERE clase = ?";
        $checkStmt = $conn->prepare($checkSql);
        $checkStmt->bind_param("s", $className);
        $checkStmt->execute();
        $checkStmt->bind_result($count);
        $checkStmt->fetch();
        $checkStmt->close();

        if ($count > 0) {
            // Si la clase ya existe, mostrar un popup de error
            header("Location: ../gestionarAlumnos.php?message=Esta%20clase%20ya%20existe&type=error");
        } else {
            // Si la clase no existe, proceder a insertarla
            $sql = "INSERT INTO alumnos (clase) VALUES (?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s", $className);

            if ($stmt->execute()) {
                header("Location: ../gestionarAlumnos.php?message=Clase%20creada%20exitosamente&type=success");
            } else {
                header("Location: ../gestionarAlumnos.php?message=Error%20al%20crear%20la%20clase&type=error");
            }

            $stmt->close();
        }
    } else {
        header("Location: ../gestionarAlumnos.php?message=El%20nombre%20de%20la%20clase%20es%20obligatorio&type=error");
    }
}

$conn->close();
?>
