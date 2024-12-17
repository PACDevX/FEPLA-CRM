<?php
// createContacto.php

session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../index.html");
    exit;
}

include '../includes/dbConnection.php';

// Recoger los datos del formulario
$nombre = trim($_POST['nombre_contacto']);
$email = trim($_POST['email_contacto']);
$telefono = trim($_POST['telefono_contacto']);

// Insertar el contacto, por defecto habilitado = 1 (activo) y sin empresa (empresa_id = NULL)
if (!empty($nombre) && !empty($email) && !empty($telefono)) {
    $sql_insert_contacto = "INSERT INTO contactos_empresas (nombre, email, telefono, habilitado, empresa_id) VALUES (?, ?, ?, 1, NULL)";
    $stmt_insert_contacto = $conn->prepare($sql_insert_contacto);
    $stmt_insert_contacto->bind_param("sss", $nombre, $email, $telefono);

    if ($stmt_insert_contacto->execute()) {
        // Redirigir con un mensaje de éxito
        header("Location: ../gestionarEmpresas.php?message=Contacto%20creado%20exitosamente&type=success");
    } else {
        // Redirigir con un mensaje de error si la inserción falla
        header("Location: ../gestionarEmpresas.php?message=Error%20al%20crear%20el%20contacto&type=error");
    }

    $stmt_insert_contacto->close();
} else {
    // Redirigir con un mensaje de error si los campos están vacíos
    header("Location: ../gestionarEmpresas.php?message=Todos%20los%20campos%20son%20obligatorios&type=error");
}

$conn->close();
?>
