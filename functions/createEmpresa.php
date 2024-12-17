<?php
// createEmpresa.php

session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../index.html");
    exit;
}

include '../includes/dbConnection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Recoger los datos del formulario
    $nombre = trim($_POST['nombre']);
    $nombre_oficial = trim($_POST['nombre_oficial']);
    $direccion_sede_central = trim($_POST['direccion_sede_central']);
    $poblacion = trim($_POST['poblacion']);
    $codigo_postal = trim($_POST['codigo_postal']);
    $provincia = trim($_POST['provincia']);
    $web = trim($_POST['web']);
    $correo_electronico_principal = trim($_POST['correo_electronico_principal']);
    $actividad_principal = trim($_POST['actividad_principal']);
    $otras_actividades = trim($_POST['otras_actividades']);
    $descripcion_breve = trim($_POST['descripcion_breve']);
    $contacto_principal = trim($_POST['contacto_principal']);

    // Obtener el id del usuario que crea la empresa
    $creado_por = $_SESSION['user_id'];
    
    // Estado por defecto
    $estado = 'interesada'; 

    // Verificar que los campos obligatorios no estén vacíos
    if (!empty($nombre) && !empty($correo_electronico_principal)) {
        // Verificar si el correo electrónico ya existe
        $checkEmailSql = "SELECT COUNT(*) FROM empresas WHERE correo_electronico_principal = ?";
        $checkEmailStmt = $conn->prepare($checkEmailSql);
        $checkEmailStmt->bind_param("s", $correo_electronico_principal);
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
            header("Location: ../gestionarEmpresas.php?message=El%20correo%20ya%20existe&type=error");
        } elseif ($nameCount > 0) {
            header("Location: ../gestionarEmpresas.php?message=El%20nombre%20de%20la%20empresa%20ya%20existe&type=error");
        } else {
            // Insertar la nueva empresa en la base de datos
            $sql = "INSERT INTO empresas (nombre, nombre_oficial, direccion_sede_central, poblacion, codigo_postal, provincia, web, correo_electronico_principal, actividad_principal, otras_actividades, descripcion_breve, contacto_principal, estado, creado_por) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sssssssssssssi", $nombre, $nombre_oficial, $direccion_sede_central, $poblacion, $codigo_postal, $provincia, $web, $correo_electronico_principal, $actividad_principal, $otras_actividades, $descripcion_breve, $contacto_principal, $estado, $creado_por);

            if ($stmt->execute()) {
                header("Location: ../gestionarEmpresas.php?message=Empresa%20creada%20exitosamente&type=success");
            } else {
                header("Location: ../gestionarEmpresas.php?message=Error%20al%20crear%20la%20empresa&type=error");
            }

            $stmt->close();
        }
    } else {
        header("Location: ../gestionarEmpresas.php?message=Los%20campos%20nombre%20y%20correo%20electrónico%20son%20obligatorios&type=error");
    }
}

$conn->close();
?>
