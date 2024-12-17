<?php
// updateContacto.php

session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../index.html");
    exit;
}

include '../includes/dbConnection.php';

// Obtener el ID del contacto a modificar
$contactoId = $_POST['id'];
$nombre_contacto = $_POST['nombre_contacto'];
$email_contacto = $_POST['email_contacto'];
$telefono_contacto = $_POST['telefono_contacto'];
$habilitado = $_POST['habilitado'];  // Recoger el estado del contacto

// Verificar que el contacto existe
$sql_check_contacto = "SELECT id FROM contactos_empresas WHERE id = ?";
$stmt_check_contacto = $conn->prepare($sql_check_contacto);
$stmt_check_contacto->bind_param("i", $contactoId);
$stmt_check_contacto->execute();
$stmt_check_contacto->store_result();

if ($stmt_check_contacto->num_rows > 0) {
    // Si el contacto existe, proceder a actualizar los datos
    if (!empty($nombre_contacto) && !empty($email_contacto) && !empty($telefono_contacto)) {
        $sql_update_contacto = "UPDATE contactos_empresas SET nombre = ?, email = ?, telefono = ?, habilitado = ? WHERE id = ?";
        $stmt_update_contacto = $conn->prepare($sql_update_contacto);
        $stmt_update_contacto->bind_param("sssii", $nombre_contacto, $email_contacto, $telefono_contacto, $habilitado, $contactoId);

        if ($stmt_update_contacto->execute()) {
            // Redirigir con un mensaje de éxito
            header("Location: ../gestionarEmpresas.php?message=Contacto%20modificado%20exitosamente&type=success");
        } else {
            // Redirigir con un mensaje de error si la actualización falla
            header("Location: ../gestionarEmpresas.php?message=Error%20al%20modificar%20el%20contacto&type=error");
        }

        $stmt_update_contacto->close();
    } else {
        // Redirigir con un mensaje de error si los campos están vacíos
        header("Location: ../gestionarEmpresas.php?message=Todos%20los%20campos%20son%20obligatorios&type=error");
    }
} else {
    // Redirigir con un mensaje si el contacto no existe
    header("Location: ../gestionarEmpresas.php?message=El%20contacto%20no%20existe&type=error");
}

$stmt_check_contacto->close();
$conn->close();
?>
