<?php
// updatePerfil.php

session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../index.html");
    exit;
}

include '../includes/dbConnection.php';

// Obtener el id del profesor desde la sesión
$profesorId = $_SESSION['user_id'];

// Recoger los datos del formulario
$nombre = trim($_POST['nombre']);
$email = trim($_POST['email']);
$apellido1 = trim($_POST['apellido1']);
$apellido2 = trim($_POST['apellido2']);
$descripcion = trim($_POST['descripcion']);  // No se requiere que esté vacío

if (!empty($nombre) && !empty($email) && !empty($apellido1)) {
    // Preparar la consulta para actualizar los datos del profesor
    $sql = "UPDATE profesores SET nombre = ?, email = ?, apellido1 = ?, apellido2 = ?, descripcion = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssi", $nombre, $email, $apellido1, $apellido2, $descripcion, $profesorId);

    if ($stmt->execute()) {
        // Redirigir con un mensaje de éxito
        header("Location: ../miPerfil.php?message=Cambios%20realizados%20exitosamente&type=success");
    } else {
        // Redirigir con un mensaje de error si la actualización falla
        header("Location: ../miPerfil.php?message=Error%20al%20guardar%20los%20cambios&type=error");
    }

    $stmt->close();
} else {
    // Redirigir con un mensaje de error si los campos obligatorios están vacíos
    header("Location: ../miPerfil.php?message=Los%20campos%20obligatorios%20deben%20ser%20nombre,%20email%20y%20apellido1&type=error");
}

$conn->close();
?>
