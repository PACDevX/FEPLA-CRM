<?php
// createEmpresa.php

session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../index.html");
    exit;
}

include '../includes/dbConnection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = trim($_POST['nombre']);
    $contacto_principal = trim($_POST['contacto_principal']);
    $email = trim($_POST['email']);
    $telefono = trim($_POST['telefono']);

    if (!empty($nombre) && !empty($contacto_principal) && !empty($email) && !empty($telefono)) {
        // Verificar si el correo electrónico ya existe
        $checkEmailSql = "SELECT COUNT(*) FROM empresas WHERE email = ?";
        $checkEmailStmt = $conn->prepare($checkEmailSql);
        $checkEmailStmt->bind_param("s", $email);
        $checkEmailStmt->execute();
        $checkEmailStmt->bind_result($emailCount);
        $checkEmailStmt->fetch();
        $checkEmailStmt->close();

        // Verificar si el nombre de la empresa ya existe
        $checkNameSql = "SELECT COUNT(*) FROM empresas WHERE nombre = ?";
        $checkNameStmt = $conn->prepare($checkNameSql);
        $checkNameStmt->bind_param("s", $nombre);
        $checkNameStmt->execute();
        $checkNameStmt->bind_result($nameCount);
        $checkNameStmt->fetch();
        $checkNameStmt->close();

        // Verificar si el correo o el nombre de la empresa ya existen
        if ($emailCount > 0) {
            // Si el correo ya existe, redirigir con un mensaje de error
            header("Location: ../gestionarEmpresas.php?message=El%20correo%20ya%20existe&type=error");
        } elseif ($nameCount > 0) {
            // Si el nombre de la empresa ya existe, redirigir con un mensaje de error
            header("Location: ../gestionarEmpresas.php?message=El%20nombre%20de%20la%20empresa%20ya%20existe&type=error");
        } else {
            // Preparar la consulta para insertar una empresa
            $sql = "INSERT INTO empresas (nombre, contacto_principal, email, telefono) VALUES (?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssss", $nombre, $contacto_principal, $email, $telefono);

            if ($stmt->execute()) {
                header("Location: ../gestionarEmpresas.php?message=Empresa%20creada%20exitosamente&type=success");
            } else {
                header("Location: ../gestionarEmpresas.php?message=Error%20al%20crear%20la%20empresa&type=error");
            }

            $stmt->close();
        }
    } else {
        header("Location: ../gestionarEmpresas.php?message=Todos%20los%20campos%20son%20obligatorios&type=error");
    }
}

$conn->close();
?>
