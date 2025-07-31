<?php
// Archivo: Baseto/config_db.php

// Mostrar errores (opcional, para desarrollo)
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Configuración de la base de datos
$db_host = "localhost";
$db_user = "root";
$db_pass = "marco123";
$db_name = "usuarios_web";

// Conexión
$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
?>
