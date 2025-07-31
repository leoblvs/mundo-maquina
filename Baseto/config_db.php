<?php
// Archivo: Baseto/config_db.php

// Mostrar errores (opcional, para desarrollo)
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Configuración de la base de datos
$db_host = "sql209.infinityfree.com";
$db_user = "if0_39482482";
$db_pass = "j9fIXe3iyQEh0RX";
$db_name = "if0_39482482_usuarios_web";

// Conexión
$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
?>
