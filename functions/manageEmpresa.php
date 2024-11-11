<?php
// manageEmpresa.php

session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../index.html");
    exit;
}

include '../includes/dbConnection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $action = $_POST['action'];
    $empresaId = trim($_POST['empresaSelect']);

    if ($action === 'delete') {
        // Eliminar la empresa
        $sql = "DELETE FROM empresas WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $empresaId);

        if ($stmt->execute()) {
            header("Location: ../gestionarEmpresas.php?message=Empresa%20eliminada%20exitosamente&type=success");
        } else {
            header("Location: ../gestionarEmpresas.php?message=Error%20al%20eliminar%20la%20empresa&type=error");
        }

        $stmt->close();
    } elseif ($action === 'modify') {
        // Redirigir a la página de modificación de la empresa
        header("Location: ../modificarEmpresa.php?id=" . urlencode($empresaId));
    }
}

$conn->close();
?>
