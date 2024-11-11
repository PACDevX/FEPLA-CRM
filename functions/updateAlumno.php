<?php
// updateAlumno.php

session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../index.html");
    exit;
}

include '../includes/dbConnection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $nombre = trim($_POST['nombre']);
    $apellido1 = trim($_POST['apellido1']);
    $apellido2 = trim($_POST['apellido2']);
    $email = trim($_POST['email']);
    $telefono = trim($_POST['telefono']);
    $classSelect = trim($_POST['classSelect']);

    if (!empty($nombre) && !empty($apellido1) && !empty($apellido2) && !empty($email) && !empty($telefono) && !empty($classSelect)) {
        // Actualizar los datos del alumno
        $sql = "UPDATE alumnos SET nombre = ?, apellido1 = ?, apellido2 = ?, email = ?, telefono = ?, clase = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssssi", $nombre, $apellido1, $apellido2, $email, $telefono, $classSelect, $id);

        if ($stmt->execute()) {
            header("Location: ../gestionarAlumnos.php?message=Cambios%20realizados%20exitosamente&type=success");
        } else {
            header("Location: ../gestionarAlumnos.php?message=Error%20al%20guardar%20los%20cambios&type=error");
        }

        $stmt->close();
    } else {
        header("Location: ../gestionarAlumnos.php?message=Todos%20los%20campos%20son%20obligatorios&type=error");
    }
}

$conn->close();
?>
