<?php
// manageContacto.php

session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../index.html");
    exit;
}

include '../includes/dbConnection.php';

// Obtener el ID del contacto y la acción
$contactoId = $_POST['contactoSelect'];
$action = $_POST['action'];

if ($action === 'disable') {
    // Deshabilitar el contacto
    $sql_disable = "UPDATE contactos_empresas SET habilitado = 0 WHERE id = ?";
    $stmt_disable = $conn->prepare($sql_disable);
    $stmt_disable->bind_param("i", $contactoId);
    if ($stmt_disable->execute()) {
        header("Location: ../gestionarEmpresas.php?message=Contacto%20deshabilitado%20exitosamente&type=success");
    } else {
        header("Location: ../gestionarEmpresas.php?message=Error%20al%20deshabilitar%20el%20contacto&type=error");
    }
    $stmt_disable->close();
} elseif ($action === 'modify') {
    // Modificar los datos del contacto
    header("Location: ../modificarContacto.php?id=$contactoId");
}

$conn->close();
?>
