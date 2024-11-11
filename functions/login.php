<?php
// login.php

// Incluir el archivo de conexión a la base de datos
include '../includes/dbConnection.php';

// Iniciar la sesión
session_start();

// Verificar si se ha enviado el formulario mediante una solicitud POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Recoger los datos del formulario
    $email = $_POST['email'];
    $password = $_POST['contraseña'];

    // Verificar que los campos de correo electrónico y contraseña no estén vacíos
    if (!empty($email) && !empty($password)) {
        // Preparar la consulta SQL para buscar al usuario por su correo electrónico
        $sql = "SELECT id, password, nombre FROM profesores WHERE email = ?";

        // Preparar la declaración
        if ($stmt = $conn->prepare($sql)) {
            // Vincular el correo electrónico como parámetro a la consulta
            $stmt->bind_param("s", $email);

            // Ejecutar la consulta
            $stmt->execute();

            // Almacenar el resultado
            $stmt->store_result();

            // Verificar si se ha encontrado un usuario con ese correo
            if ($stmt->num_rows == 1) {
                // Vincular los resultados: id de usuario, contraseña hasheada y nombre
                $stmt->bind_result($user_id, $hashed_password, $nombre);
                $stmt->fetch();

                // Verificar si la contraseña ingresada coincide con la contraseña hasheada
                if (password_verify($password, $hashed_password)) {
                    // Si la contraseña es correcta, guardar el id de usuario y nombre en la sesión
                    $_SESSION['user_id'] = $user_id;
                    $_SESSION['nombre'] = $nombre;

                    // Redirigir al usuario a la página principal
                    header("Location: ../main.php");
                    exit;
                } else {
                    // Si la contraseña no es correcta, establecer un mensaje de error
                    $error_message = "Correo o contraseña incorrecta.";
                }
            } else {
                // Si no se encuentra un usuario con ese correo, establecer un mensaje de error
                $error_message = "Correo o contraseña incorrecta.";
            }

            // Cerrar la declaración
            $stmt->close();
        } else {
            // Si hay un error en la preparación de la declaración, establecer un mensaje de error
            $error_message = "Error en la preparación de la declaración.";
        }
    } else {
        // Si alguno de los campos está vacío, establecer un mensaje de error
        $error_message = "Por favor, completa todos los campos.";
    }

    // Redirigir al usuario a la página de inicio de sesión con el mensaje de error en la URL
    header("Location: ../index.html?error=" . urlencode($error_message));
    exit;
}

// Cerrar la conexión a la base de datos
$conn->close();
?>
