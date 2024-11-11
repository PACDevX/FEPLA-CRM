<?php
// updateEmpresa.php

session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../index.html");
    exit;
}

include '../includes/dbConnection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $nombre = trim($_POST['nombre']);
    $contacto_principal = trim($_POST['contacto_principal']);
    $email = trim($_POST['email']);
    $telefono = trim($_POST['telefono']);

    if (!empty($nombre) && !empty($contacto_principal) && !empty($email) && !empty($telefono)) {
        // Preparar la consulta para actualizar los datos de la empresa
        $sql = "UPDATE empresas SET nombre = ?, contacto_principal = ?, email = ?, telefono = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssi", $nombre, $contacto_principal, $email, $telefono, $id);

        if ($stmt->execute()) {
            // Redirigir con un mensaje de éxito
            header("Location: ../gestionarEmpresas.php?message=Cambios%20realizados%20exitosamente&type=success");
        } else {
            // Redirigir con un mensaje de error si la actualización falla
            header("Location: ../gestionarEmpresas.php?message=Error%20al%20guardar%20los%20cambios&type=error");
        }

        $stmt->close();
    } else {
        // Redirigir con un mensaje de error si faltan datos
        header("Location: ../gestionarEmpresas.php?message=Todos%20los%20campos%20son%20obligatorios&type=error");
    }
}

$conn->close();
?>
