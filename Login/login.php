<?php
session_start();

// Incluir conexión centralizada
// Asegúrate de que esta ruta sea correcta para tu configuración
include __DIR__ . '/../Baseto/config_db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? ''); // Usar ?? para evitar errores si no se envía
    $password = trim($_POST['password'] ?? '');

    // Validar campos vacíos
    if (empty($username) || empty($password)) {
        echo "invalid"; // O podrías ser más específico como "empty_fields"
        exit();
    }

    $sql = "SELECT id, username, password FROM usuarios WHERE username = ?"; // Seleccionar también el username para la sesión
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows === 1) {
            $stmt->bind_result($id, $db_username, $hash); // Obtener también el username de la DB
            $stmt->fetch();

            if (password_verify($password, $hash)) {
                // Guardar datos en sesión
                $_SESSION['user_id'] = $id;
                $_SESSION['username'] = $db_username; // Usar el username de la DB
                echo "success";
            } else {
                echo "invalid"; // Contraseña incorrecta
            }
        } else {
            echo "invalid"; // Usuario no encontrado
        }

        $stmt->close();
    } else {
        // Error en la preparación de la consulta (ej. error de sintaxis SQL)
        error_log("Error al preparar la consulta en login.php: " . $conn->error); // Registrar el error para depuración
        echo "error";
    }

    $conn->close();
} else {
    echo "invalid"; // Método no permitido (solo POST)
}
?>
