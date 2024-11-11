<?php
// db_connection.php

// Configuración de la base de datos
$host = 'localhost'; // Cambia esto si tu servidor de base de datos está en otra dirección
$user = 'root'; // Usuario de MySQL
$password = ''; // Contraseña de MySQL (por defecto está vacía en XAMPP)
$db_name = 'fepla_crm'; // Nombre de la base de datos

// Crear conexión
$conn = new mysqli($host, $user, $password, $db_name);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
?>
