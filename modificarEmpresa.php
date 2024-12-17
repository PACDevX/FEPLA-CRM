<?php
// modificarEmpresa.php

session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../index.html");
    exit;
}

include './includes/dbConnection.php';

// Obtener el ID de la empresa a modificar
$empresaId = $_GET['id'];

// Recuperar los datos actuales de la empresa
$sql = "SELECT nombre, nombre_oficial, direccion_sede_central, poblacion, codigo_postal, provincia, web, correo_electronico_principal, actividad_principal, otras_actividades, descripcion_breve, contacto_principal, estado, fecha_creacion, fecha_modificacion
        FROM empresas WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $empresaId);
$stmt->execute();
$stmt->bind_result($nombre, $nombre_oficial, $direccion_sede_central, $poblacion, $codigo_postal, $provincia, $web, $correo_electronico_principal, $actividad_principal, $otras_actividades, $descripcion_breve, $contacto_principal, $estado, $fecha_creacion, $fecha_modificacion);
$stmt->fetch();
$stmt->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modificar Empresa - FEPLA CRM</title>
    <link rel="stylesheet" href="./assets/css/main.css">
    <link rel="stylesheet" href="./assets/css/header.css">
    <link rel="stylesheet" href="./assets/css/popups.css">
</head>
<body>
    <?php include './includes/header.php'; ?>

    <div class="container">
        <h1>Modificar Empresa</h1>

        <form action="./functions/updateEmpresa.php" method="POST">
    <input type="hidden" name="id" value="<?php echo htmlspecialchars($empresaId); ?>">

    <label for="nombre">Nombre de la Empresa (*):</label>
    <input type="text" id="nombre" name="nombre" value="<?php echo htmlspecialchars($nombre); ?>" required>

    <label for="nombre_oficial">Nombre Oficial:</label>
    <input type="text" id="nombre_oficial" name="nombre_oficial" value="<?php echo htmlspecialchars($nombre_oficial); ?>">

    <label for="direccion_sede_central">Dirección Sede Central:</label>
    <input type="text" id="direccion_sede_central" name="direccion_sede_central" value="<?php echo htmlspecialchars($direccion_sede_central); ?>">

    <label for="poblacion">Población:</label>
    <input type="text" id="poblacion" name="poblacion" value="<?php echo htmlspecialchars($poblacion); ?>">

    <label for="codigo_postal">Código Postal:</label>
    <input type="text" id="codigo_postal" name="codigo_postal" value="<?php echo htmlspecialchars($codigo_postal); ?>">

    <label for="provincia">Provincia:</label>
    <input type="text" id="provincia" name="provincia" value="<?php echo htmlspecialchars($provincia); ?>">

    <label for="web">Página Web:</label>
    <input type="url" id="web" name="web" value="<?php echo htmlspecialchars($web); ?>">

    <label for="correo_electronico_principal">Correo Electrónico Principal:</label>
    <input type="email" id="correo_electronico_principal" name="correo_electronico_principal" value="<?php echo htmlspecialchars($correo_electronico_principal); ?>">

    <label for="actividad_principal">Actividad Principal:</label>
    <textarea id="actividad_principal" name="actividad_principal"><?php echo htmlspecialchars($actividad_principal); ?></textarea>

    <label for="otras_actividades">Otras Actividades:</label>
    <textarea id="otras_actividades" name="otras_actividades"><?php echo htmlspecialchars($otras_actividades); ?></textarea>

    <label for="descripcion_breve">Descripción Breve:</label>
    <textarea id="descripcion_breve" name="descripcion_breve"><?php echo htmlspecialchars($descripcion_breve); ?></textarea>

    <label for="contacto_principal">Contacto Principal:</label>
    <select id="contacto_principal" name="contacto_principal">
        <?php
        // Recuperamos los contactos de la base de datos y limpiamos cualquier HTML no permitido
        $result_contactos = $conn->query("SELECT id, nombre FROM contactos_empresas");
        while ($row_contacto = $result_contactos->fetch_assoc()) {
            $nombre_contacto = strip_tags($row_contacto['nombre']);
            $selected = ($row_contacto['id'] == $contacto_principal) ? 'selected' : '';
            echo "<option value='" . htmlspecialchars($row_contacto['id']) . "' $selected>" . htmlspecialchars($nombre_contacto) . "</option>";
        }
        ?>
    </select>

    <label for="estado">Estado (*):</label>
    <select id="estado" name="estado" required>
        <option value="interesada" <?php echo ($estado == 'interesada') ? 'selected' : ''; ?>>Interesada</option>
        <option value="no_interesada" <?php echo ($estado == 'no_interesada') ? 'selected' : ''; ?>>No Interesada</option>
        <option value="ya_no_existe" <?php echo ($estado == 'ya_no_existe') ? 'selected' : ''; ?>>Ya No Existe</option>
    </select>

    <label>Fecha de Creación:</label>
    <input type="text" value="<?php echo htmlspecialchars($fecha_creacion); ?>" disabled>

    <label>Última Modificación:</label>
    <input type="text" value="<?php echo htmlspecialchars($fecha_modificacion); ?>" disabled>

    <label for="explicacion">Explicación de los Cambios:</label>
    <textarea id="explicacion" name="explicacion" required></textarea>

    <button type="submit" class="button">Guardar Cambios</button>
    <a href="gestionarEmpresas.php" class="button">Cancelar</a>
</form>
    </div>
</body>
</html>
