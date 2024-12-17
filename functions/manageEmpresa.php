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
    $modificado_por = $_SESSION['user_id'];  // Quién modifica los datos

    if ($action === 'delete') {
        // Deshabilitar la empresa (no eliminar)
        $sql = "UPDATE empresas SET estado = 'ya_no_existe', modificado_por = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ii", $modificado_por, $empresaId);

        if ($stmt->execute()) {
            header("Location: ../gestionarEmpresas.php?message=Empresa%20deshabilitada%20exitosamente&type=success");
        } else {
            header("Location: ../gestionarEmpresas.php?message=Error%20al%20deshabilitar%20la%20empresa&type=error");
        }

        $stmt->close();
    } elseif ($action === 'modify') {
        // Redirigir a la página de modificación de la empresa
        header("Location: ../modificarEmpresa.php?id=" . urlencode($empresaId));
    }
}

$conn->close();

?>
