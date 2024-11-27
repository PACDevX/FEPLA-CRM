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
$sql = "SELECT nombre, contacto_principal, email, telefono FROM empresas WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $empresaId);
$stmt->execute();
$stmt->bind_result($nombre, $contacto_principal, $email, $telefono);
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
</head>
<body>
    <?php include './includes/header.php'; ?>

    <div class="container">
        <h1>Modificar Empresa</h1>

        <form action="./functions/updateEmpresa.php" method="POST">
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($empresaId); ?>">

            <label for="nombre">Nombre de la Empresa (*):</label>
            <input type="text" id="nombre" name="nombre" value="<?php echo htmlspecialchars($nombre); ?>" required>

            <label for="contacto_principal">Contacto Principal (*):</label>
            <input type="text" id="contacto_principal" name="contacto_principal" value="<?php echo htmlspecialchars($contacto_principal); ?>" required>

            <label for="email">Correo Electrónico (*):</label>
            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>" required>

            <label for="telefono">Teléfono (*):</label>
            <input type="text" id="telefono" name="telefono" value="<?php echo htmlspecialchars($telefono); ?>" required>

            <button type="submit" class="button">Guardar Cambios</button>
            <a href="gestionarEmpresas.php" class="button">Cancelar</a>
        </form>
    </div>
</body>
</html>
