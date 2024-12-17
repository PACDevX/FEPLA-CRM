<?php
// updateEmpresa.php

session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../index.html");
    exit;
}

include '../includes/dbConnection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Verificar si cada campo está presente antes de usar trim
    $id = $_POST['id'];
    $nombre = isset($_POST['nombre']) ? trim($_POST['nombre']) : '';
    $contacto_principal = isset($_POST['contacto_principal']) ? trim($_POST['contacto_principal']) : '';
    $estado = isset($_POST['estado']) ? $_POST['estado'] : '';
    $modificado_por = $_SESSION['user_id']; // Quien modifica los datos
    $explicacion = isset($_POST['explicacion']) ? trim($_POST['explicacion']) : null; // Explicación del cambio

    // Nuevos campos añadidos
    $nombre_oficial = isset($_POST['nombre_oficial']) ? trim($_POST['nombre_oficial']) : '';
    $direccion_sede_central = isset($_POST['direccion_sede_central']) ? trim($_POST['direccion_sede_central']) : '';
    $poblacion = isset($_POST['poblacion']) ? trim($_POST['poblacion']) : '';
    $codigo_postal = isset($_POST['codigo_postal']) ? trim($_POST['codigo_postal']) : '';
    $provincia = isset($_POST['provincia']) ? trim($_POST['provincia']) : '';
    $web = isset($_POST['web']) ? trim($_POST['web']) : '';
    $correo_electronico_principal = isset($_POST['correo_electronico_principal']) ? trim($_POST['correo_electronico_principal']) : '';
    $actividad_principal = isset($_POST['actividad_principal']) ? trim($_POST['actividad_principal']) : '';
    $otras_actividades = isset($_POST['otras_actividades']) ? trim($_POST['otras_actividades']) : '';
    $descripcion_breve = isset($_POST['descripcion_breve']) ? trim($_POST['descripcion_breve']) : '';

    // Consultar los datos anteriores de la empresa
    $sql_old = "SELECT nombre, contacto_principal, estado, nombre_oficial, direccion_sede_central, poblacion, codigo_postal, provincia, web, correo_electronico_principal, actividad_principal, otras_actividades, descripcion_breve FROM empresas WHERE id = '$id'";
    $result_old = mysqli_query($conn, $sql_old);
    $old_data = mysqli_fetch_assoc($result_old);

    // Si la consulta es exitosa
    if ($old_data) {
        // Recuperar los datos anteriores
        $old_nombre = $old_data['nombre'];
        $old_contacto = $old_data['contacto_principal'];
        $old_estado = $old_data['estado'];
        $old_nombre_oficial = $old_data['nombre_oficial'];
        $old_direccion_sede_central = $old_data['direccion_sede_central'];
        $old_poblacion = $old_data['poblacion'];
        $old_codigo_postal = $old_data['codigo_postal'];
        $old_provincia = $old_data['provincia'];
        $old_web = $old_data['web'];
        $old_correo_electronico_principal = $old_data['correo_electronico_principal'];
        $old_actividad_principal = $old_data['actividad_principal'];
        $old_otras_actividades = $old_data['otras_actividades'];
        $old_descripcion_breve = $old_data['descripcion_breve'];

        // Inicializamos un array para almacenar las acciones
        $acciones = [];

        // Solo comparar los campos que han cambiado
        if ($old_nombre != $nombre) {
            $acciones[] = "Cambio de nombre";
        }
        if ($old_contacto != $contacto_principal) {
            $acciones[] = "Cambio de contacto principal";
        }
        if ($old_estado != $estado) {
            $acciones[] = "Cambio de estado";
        }
        if ($old_nombre_oficial != $nombre_oficial) {
            $acciones[] = "Cambio de nombre oficial";
        }
        if ($old_direccion_sede_central != $direccion_sede_central) {
            $acciones[] = "Cambio de dirección sede central";
        }
        if ($old_poblacion != $poblacion) {
            $acciones[] = "Cambio de población";
        }
        if ($old_codigo_postal != $codigo_postal) {
            $acciones[] = "Cambio de código postal";
        }
        if ($old_provincia != $provincia) {
            $acciones[] = "Cambio de provincia";
        }
        if ($old_web != $web) {
            $acciones[] = "Cambio de página web";
        }
        if ($old_correo_electronico_principal != $correo_electronico_principal) {
            $acciones[] = "Cambio de correo electrónico principal";
        }
        if ($old_actividad_principal != $actividad_principal) {
            $acciones[] = "Cambio de actividad principal";
        }
        if ($old_otras_actividades != $otras_actividades) {
            $acciones[] = "Cambio de otras actividades";
        }
        if ($old_descripcion_breve != $descripcion_breve) {
            $acciones[] = "Cambio de descripción breve";
        }

        // Si no hay cambios, solo se guarda la explicación
        if (count($acciones) > 0 || !empty($explicacion)) {
            // Unir todas las acciones en un solo texto, separadas por coma
            $accion_log = implode(", ", $acciones);

            // Escapar los valores para evitar problemas con las comillas simples
            $accion_log = mysqli_real_escape_string($conn, $accion_log);
            $datos_anterior = mysqli_real_escape_string($conn, "Nombre: $old_nombre, Contacto: $old_contacto, Estado: $old_estado, Nombre Oficial: $old_nombre_oficial, Dirección Sede Central: $old_direccion_sede_central, Población: $old_poblacion, Código Postal: $old_codigo_postal, Provincia: $old_provincia, Web: $old_web, Correo Electrónico Principal: $old_correo_electronico_principal, Actividad Principal: $old_actividad_principal, Otras Actividades: $old_otras_actividades, Descripción Breve: $old_descripcion_breve");
            $datos_nuevo = mysqli_real_escape_string($conn, "Nombre: $nombre, Contacto: $contacto_principal, Estado: $estado, Nombre Oficial: $nombre_oficial, Dirección Sede Central: $direccion_sede_central, Población: $poblacion, Código Postal: $codigo_postal, Provincia: $provincia, Web: $web, Correo Electrónico Principal: $correo_electronico_principal, Actividad Principal: $actividad_principal, Otras Actividades: $otras_actividades, Descripción Breve: $descripcion_breve");

            // Actualizar los datos de la empresa con declaración directa
            $sql_update = "UPDATE empresas SET 
                            nombre = '$nombre', 
                            contacto_principal = '$contacto_principal', 
                            estado = '$estado', 
                            nombre_oficial = '$nombre_oficial', 
                            direccion_sede_central = '$direccion_sede_central', 
                            poblacion = '$poblacion', 
                            codigo_postal = '$codigo_postal', 
                            provincia = '$provincia', 
                            web = '$web', 
                            correo_electronico_principal = '$correo_electronico_principal', 
                            actividad_principal = '$actividad_principal', 
                            otras_actividades = '$otras_actividades', 
                            descripcion_breve = '$descripcion_breve', 
                            modificado_por = '$modificado_por' 
                            WHERE id = '$id'";

            $result_update = mysqli_query($conn, $sql_update);

            if ($result_update) {
                // Registrar la modificación en el log
                $sql_log = "INSERT INTO log_empresas (empresa_id, accion, datos_anteriores, datos_nuevos, explicado_por, realizado_por) 
                            VALUES ('$id', '$accion_log', '$datos_anterior', '$datos_nuevo', '$explicacion', '$modificado_por')";
                $result_log = mysqli_query($conn, $sql_log);

                if ($result_log) {
                    // Redirigir con un mensaje de éxito
                    header("Location: ../gestionarEmpresas.php?message=Cambios%20realizados%20exitosamente&type=success");
                } else {
                    header("Location: ../gestionarEmpresas.php?message=Error%20al%20guardar%20los%20cambios&type=error");
                }
            } else {
                header("Location: ../gestionarEmpresas.php?message=Error%20al%20actualizar%20los%20datos&type=error");
            }
        } else {
            header("Location: ../gestionarEmpresas.php?message=No%20se%20han%20realizado%20cambios&type=error");
        }
    } else {
        header("Location: ../gestionarEmpresas.php?message=Empresa%20no%20encontrada&type=error");
    }
}

mysqli_close($conn);
