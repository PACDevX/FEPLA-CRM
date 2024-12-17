<?php
// gestionarEmpresas.php

session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: index.html");
    exit;
}

include './includes/dbConnection.php';
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Empresas - FEPLA CRM</title>
    <link rel="stylesheet" href="./assets/css/main.css">
    <link rel="stylesheet" href="./assets/css/header.css">
    <link rel="stylesheet" href="./assets/css/popups.css">
    <script src="./assets/js/popups.js" defer></script> <!-- Usando el archivo popups.js -->
</head>

<body>
    <?php include './includes/header.php'; ?>

    <div class="container">
        <h1>Gestión de Empresas</h1>

<!-- Sección para crear una empresa -->
<div class="section">
    <h2>Crear Empresa</h2>
    <form action="./functions/createEmpresa.php" method="POST">
        <label for="nombre">Nombre de la Empresa (*):</label>
        <input type="text" id="nombre" name="nombre" required>

        <label for="nombre_oficial">Nombre Oficial:</label>
        <input type="text" id="nombre_oficial" name="nombre_oficial">

        <label for="direccion_sede_central">Dirección Sede Central:</label>
        <input type="text" id="direccion_sede_central" name="direccion_sede_central">

        <label for="poblacion">Población:</label>
        <input type="text" id="poblacion" name="poblacion">

        <label for="codigo_postal">Código Postal:</label>
        <input type="text" id="codigo_postal" name="codigo_postal">

        <label for="provincia">Provincia:</label>
        <input type="text" id="provincia" name="provincia">

        <label for="web">Página Web:</label>
        <input type="url" id="web" name="web">

        <label for="correo_electronico_principal">Correo Electrónico Principal (*):</label>
        <input type="email" id="correo_electronico_principal" name="correo_electronico_principal" required>

        <label for="actividad_principal">Actividad Principal:</label>
        <textarea id="actividad_principal" name="actividad_principal"></textarea>

        <label for="otras_actividades">Otras Actividades:</label>
        <textarea id="otras_actividades" name="otras_actividades"></textarea>

        <label for="descripcion_breve">Descripción Breve:</label>
        <textarea id="descripcion_breve" name="descripcion_breve"></textarea>

        <label for="contacto_principal">Contacto Principal:</label>
        <select id="contacto_principal" name="contacto_principal">
            <?php
            // Recuperamos los contactos de la base de datos y limpiamos cualquier HTML no permitido
            $result_contactos = $conn->query("SELECT id, nombre FROM contactos_empresas");
            while ($row_contacto = $result_contactos->fetch_assoc()) {
                // Eliminar cualquier tag HTML de los datos
                $nombre_contacto = strip_tags($row_contacto['nombre']);
                echo "<option value='" . htmlspecialchars($row_contacto['id']) . "'>" . htmlspecialchars($nombre_contacto) . "</option>";
            }
            ?>
        </select>
        <br>

        <button type="submit" class="button">Crear Empresa</button>
    </form>
</div>


        <!-- Sección para gestionar las empresas -->
        <div class="section">
            <h2>Gestionar Empresas</h2>
            <form action="./functions/manageEmpresa.php" method="POST">
                <label for="empresaSelect">Seleccionar Empresa (*):</label>
                <select id="empresaSelect" name="empresaSelect" required>
                    <!-- Aquí se llenarán las opciones de empresas desde la base de datos -->
                    <?php
                    $result = $conn->query("SELECT id, nombre, estado, fecha_creacion, fecha_modificacion FROM empresas");
                    while ($row = $result->fetch_assoc()) {
                        echo "<option value='" . htmlspecialchars($row['id']) . "'>" . htmlspecialchars($row['nombre']) . " - " . htmlspecialchars($row['estado']) . " (Creada el: " . htmlspecialchars($row['fecha_creacion']) . ")</option>";
                    }
                    ?>
                </select>

                <button type="submit" name="action" value="delete" class="button">Deshabilitar Empresa</button>
                <button type="submit" name="action" value="modify" class="button">Modificar Datos</button>
            </form>
        </div>

        <!-- Sección para crear un contacto de empresa -->
        <div class="section">
            <h2>Crear Contacto de Empresa</h2>
            <form action="./functions/createContacto.php" method="POST">
                <label for="nombre_contacto">Nombre del Contacto:</label>
                <input type="text" id="nombre_contacto" name="nombre_contacto" required>

                <label for="email_contacto">Correo Electrónico:</label>
                <input type="email" id="email_contacto" name="email_contacto" required>

                <label for="telefono_contacto">Teléfono:</label>
                <input type="text" id="telefono_contacto" name="telefono_contacto" required>

                <button type="submit" class="button">Crear Contacto</button>
            </form>
        </div>

        <!-- Sección para gestionar contactos de empresa -->
        <div class="section">
            <h2>Gestionar Contactos de Empresa</h2>
            <form action="./functions/manageContacto.php" method="POST">
                <label for="contactoSelect">Seleccionar Contacto:</label>
                <select id="contactoSelect" name="contactoSelect" required>
                    <!-- Aquí se llenarán las opciones de contactos desde la base de datos -->
                    <?php
                    // Se consulta los contactos con su estado (activo o inactivo), y el nombre de la empresa
                    $result_contactos = $conn->query("SELECT id, nombre, habilitado, empresa_id 
                                                    FROM contactos_empresas");

                    while ($row_contacto = $result_contactos->fetch_assoc()) {
                        // Determinar el estado del contacto (activo o inactivo) basado en la columna 'habilitado'
                        $estado_contacto = ($row_contacto['habilitado'] == 1) ? "Activo" : "Inactivo";
                        // Mostrar el nombre del contacto junto con su estado
                        echo "<option value='" . htmlspecialchars($row_contacto['id']) . "'>"
                            . htmlspecialchars($row_contacto['nombre']) . " - " . $estado_contacto . "</option>";
                    }
                    ?>
                </select>

                <!-- Botones para deshabilitar o modificar los contactos -->
                <button type="submit" name="action" value="disable" class="button">Deshabilitar Contacto</button>
                <button type="submit" name="action" value="modify" class="button">Modificar Datos</button>
            </form>
        </div>

        <!-- Sección para ver el log de la empresa -->
        <div class="section">
            <h2>Ver Log de la Empresa</h2>
            <form action="viewLog.php" method="GET">
                <label for="empresaSelectLog">Seleccionar Empresa:</label>
                <select id="empresaSelectLog" name="empresaSelectLog" required>
                    <?php
                    $result = $conn->query("SELECT id, nombre FROM empresas");
                    while ($row = $result->fetch_assoc()) {
                        echo "<option value='" . htmlspecialchars($row['id']) . "'>" . htmlspecialchars($row['nombre']) . "</option>";
                    }
                    ?>
                </select>

                <button type="submit" class="button">Ver Log</button>
            </form>
        </div>

    </div>
</body>

</html>