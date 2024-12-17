<?php
// modificarContacto.php

session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../index.html");
    exit;
}

include './includes/dbConnection.php';

// Obtener el ID del contacto a modificar
$contactoId = $_GET['id'];

// Recuperar los datos actuales del contacto
$sql = "SELECT nombre, email, telefono, habilitado FROM contactos_empresas WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $contactoId);
$stmt->execute();
$stmt->bind_result($nombre, $email, $telefono, $habilitado);
$stmt->fetch();
$stmt->close();  // Cerramos la consulta después de haberla usado
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modificar Contacto - FEPLA CRM</title>
    <link rel="stylesheet" href="./assets/css/main.css">
    <link rel="stylesheet" href="./assets/css/header.css">
</head>
<body>
    <?php include './includes/header.php'; ?>

    <div class="container">
        <h1>Modificar Contacto</h1>

        <form action="./functions/updateContacto.php" method="POST">
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($contactoId); ?>">

            <label for="nombre_contacto">Nombre del Contacto:</label>
            <input type="text" id="nombre_contacto" name="nombre_contacto" value="<?php echo htmlspecialchars($nombre); ?>" required>

            <label for="email_contacto">Correo Electrónico:</label>
            <input type="email" id="email_contacto" name="email_contacto" value="<?php echo htmlspecialchars($email); ?>" required>

            <label for="telefono_contacto">Teléfono:</label>
            <input type="text" id="telefono_contacto" name="telefono_contacto" value="<?php echo htmlspecialchars($telefono); ?>" required>

            <label for="habilitado">Estado:</label>
            <select id="habilitado" name="habilitado">
                <option value="1" <?php echo ($habilitado == 1) ? 'selected' : ''; ?>>Activo</option>
                <option value="0" <?php echo ($habilitado == 0) ? 'selected' : ''; ?>>Inactivo</option>
            </select>

            <button type="submit" class="button">Guardar Cambios</button>
        </form>
    </div>
</body>
</html>
