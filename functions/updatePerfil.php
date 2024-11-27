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
$apellido = trim($_POST['apellido']);
$descripcion = trim($_POST['descripcion']);

if (!empty($nombre) && !empty($email) && !empty($apellido) && !empty($descripcion)) {
    // Preparar la consulta para actualizar los datos del profesor
    $sql = "UPDATE profesores SET nombre = ?, email = ?, apellido = ?, descripcion = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssi", $nombre, $email, $apellido, $descripcion, $profesorId);

    if ($stmt->execute()) {
        // Redirigir con un mensaje de éxito
        header("Location: ../miPerfil.php?message=Cambios%20realizados%20exitosamente&type=success");
    } else {
        // Redirigir con un mensaje de error si la actualización falla
        header("Location: ../miPerfil.php?message=Error%20al%20guardar%20los%20cambios&type=error");
    }

    $stmt->close();
} else {
    // Redirigir con un mensaje de error si los campos están vacíos
    header("Location: ../miPerfil.php?message=Todos%20los%20campos%20son%20obligatorios&type=error");
}

$conn->close();
?>
