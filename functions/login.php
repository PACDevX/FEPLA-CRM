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
        // Primera comprobación: tabla `profesores`
        $sql = "SELECT id, password, nombre FROM profesores WHERE email = ?";
        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $stmt->store_result();

            if ($stmt->num_rows == 1) {
                $stmt->bind_result($user_id, $hashed_password, $nombre);
                $stmt->fetch();

                if (password_verify($password, $hashed_password)) {
                    // Iniciar sesión como profesor
                    $_SESSION['user_id'] = $user_id;
                    $_SESSION['nombre'] = $nombre;

                    // Redirigir al panel principal
                    header("Location: ../main.php");
                    exit;
                } else {
                    $error_message = "Correo o contraseña incorrecta.";
                }
            } else {
                // Si no se encuentra en `profesores`, comprobar en `superusuarios`
                $sqlSuperusuario = "SELECT id, password, nombre FROM superusuarios WHERE email = ?";
                if ($stmtSuper = $conn->prepare($sqlSuperusuario)) {
                    $stmtSuper->bind_param("s", $email);
                    $stmtSuper->execute();
                    $stmtSuper->store_result();

                    if ($stmtSuper->num_rows == 1) {
                        $stmtSuper->bind_result($user_id, $hashed_password, $nombre);
                        $stmtSuper->fetch();

                        if (password_verify($password, $hashed_password)) {
                            // Iniciar sesión como superusuario
                            $_SESSION['user_id'] = $user_id;
                            $_SESSION['nombre'] = $nombre;
                            $_SESSION['is_root'] = true; // Marcar como superusuario

                            // Redirigir al panel de superusuarios
                            header("Location: ../MODDER-PROFESORES/index.php");
                            exit;
                        } else {
                            $error_message = "Correo o contraseña incorrecta.";
                        }
                    } else {
                        $error_message = "Correo o contraseña incorrecta.";
                    }
                    $stmtSuper->close();
                }
            }
            $stmt->close();
        } else {
            $error_message = "Error en la preparación de la consulta.";
        }
    } else {
        $error_message = "Por favor, completa todos los campos.";
    }

    // Redirigir con mensaje de error
    header("Location: ../index.html?error=" . urlencode($error_message));
    exit;
}

// Cerrar la conexión a la base de datos
$conn->close();
?>
