<?php
// createAlumno.php

session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../index.html");
    exit;
}

include '../includes/dbConnection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $classSelect = trim($_POST['classSelect']);
    $nombre = trim($_POST['nombre']);
    $apellido1 = trim($_POST['apellido1']);
    $apellido2 = trim($_POST['apellido2']);
    $email = trim($_POST['email']);
    $telefono = trim($_POST['telefono']);

    if (!empty($classSelect) && !empty($nombre) && !empty($apellido1) && !empty($apellido2) && !empty($email) && !empty($telefono)) {
        // Verificar si el correo electrónico ya existe
        $checkSql = "SELECT COUNT(*) FROM alumnos WHERE email = ?";
        $checkStmt = $conn->prepare($checkSql);
        $checkStmt->bind_param("s", $email);
        $checkStmt->execute();
        $checkStmt->bind_result($count);
        $checkStmt->fetch();
        $checkStmt->close();

        if ($count > 0) {
            // Si el correo ya existe, redirigir con un mensaje de error
            header("Location: ../gestionarAlumnos.php?message=El%20correo%20ya%20existe&type=error");
        } else {
            // Preparar la consulta para insertar un alumno
            $sql = "INSERT INTO alumnos (nombre, apellido1, apellido2, email, telefono, clase) VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssssss", $nombre, $apellido1, $apellido2, $email, $telefono, $classSelect);

            if ($stmt->execute()) {
                header("Location: ../gestionarAlumnos.php?message=Alumno%20creado%20exitosamente&type=success");
            } else {
                header("Location: ../gestionarAlumnos.php?message=Error%20al%20crear%20el%20alumno&type=error");
            }

            $stmt->close();
        }
    } else {
        header("Location: ../gestionarAlumnos.php?message=Todos%20los%20campos%20son%20obligatorios&type=error");
    }
}

$conn->close();
?>
