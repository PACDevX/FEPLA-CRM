<?php
session_start();
if (!isset($_SESSION['is_root']) || $_SESSION['is_root'] !== true) {
    header("Location: ../index.html");
    exit;
}

include '../includes/dbConnection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = trim($_POST['nombre']);
    $apellido1 = trim($_POST['apellido1']);
    $apellido2 = trim($_POST['apellido2']);
    $email = trim($_POST['email']);
    $password = password_hash(trim($_POST['password']), PASSWORD_DEFAULT);

    // Validar que todos los campos estén completos
    if (empty($nombre) || empty($apellido1) || empty($email) || empty($password)) {
        // Redirigir con un mensaje de error
        header("Location: createProfesor.php?error=" . urlencode("Todos los campos son obligatorios."));
        exit;
    } else {
        // Comprobar si el email ya existe en la base de datos
        $sql_check_email = "SELECT id FROM profesores WHERE email = ?";
        $stmt_check_email = $conn->prepare($sql_check_email);
        $stmt_check_email->bind_param("s", $email);
        $stmt_check_email->execute();
        $stmt_check_email->store_result();

        if ($stmt_check_email->num_rows > 0) {
            // Si el email ya está en la base de datos, mostrar un mensaje de error
            header("Location: createProfesor.php?error=" . urlencode("Este correo ya está en uso o asignado a un profesor. Por favor, elige otro."));
            exit;
        } else {
            // Si el email no está en la base de datos, proceder con la inserción
            $sql = "INSERT INTO profesores (nombre, apellido1, apellido2, email, password) VALUES (?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sssss", $nombre, $apellido1, $apellido2, $email, $password);

            if ($stmt->execute()) {
                // Redirigir con un mensaje de éxito
                header("Location: createProfesor.php?message=" . urlencode("Profesor creado exitosamente."));
                exit;
            } else {
                // Redirigir con un mensaje de error
                header("Location: createProfesor.php?error=" . urlencode("Error al crear el profesor: " . $stmt->error));
                exit;
            }

            $stmt->close();
        }

        $stmt_check_email->close();
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Crear Profesor</title>
    <link rel="stylesheet" href="assets/css/modder.css">
</head>
<body>
    <?php include('includes/header.php'); ?> <!-- Incluir el header -->

    <main class="container">
        <section>
            <h1>Crear Profesor</h1>
            <form method="POST">
                <label>Nombre:</label>
                <input type="text" name="nombre" required><br>

                <label>Apellido 1:</label>
                <input type="text" name="apellido1" required><br>

                <label>Apellido 2:</label>
                <input type="text" name="apellido2"><br>

                <label>Email:</label>
                <input type="email" name="email" required><br>

                <label>Contraseña:</label>
                <input type="password" name="password" required><br>

                <button type="submit">Crear</button>
            </form>
        </section>
    </main>

    <script src="assets/js/popups.js"></script> <!-- Agregar el archivo de popups -->
    
    <script>
        // Ejecutar popups.js para mostrar los mensajes en caso de que haya parámetros en la URL
        document.addEventListener("DOMContentLoaded", () => {
            initPopupsFromUrl(); // Muestra el popup si hay parámetros 'message' o 'error' en la URL
        });
    </script>
</body>
</html>
