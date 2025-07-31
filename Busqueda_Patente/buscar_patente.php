<?php
if (!isset($_POST['patente'])) {
    echo "No se ingresó ninguna patente.";
    exit();
}

$patente = strtoupper(trim($_POST['patente']));

// Incluir archivo de conexión
include __DIR__ . '/../Baseto/config_db.php'; // Ajusta la ruta según tu estructura

$sql = "SELECT * FROM vehiculos WHERE patente = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $patente);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $vehiculo = $result->fetch_assoc();
} else {
    echo "Patente no encontrada.";
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Estado de tu vehículo</title>
</head>
<body>
    <h1>Vehículo: <?php echo htmlspecialchars($vehiculo['patente']); ?></h1>
    <p>Marca: <?php echo htmlspecialchars($vehiculo['marca']); ?></p>
    <p>Modelo: <?php echo htmlspecialchars($vehiculo['modelo']); ?></p>
    <p>Estado: <?php echo htmlspecialchars($vehiculo['estado']); ?></p>
    <?php if (!empty($vehiculo['imagen'])): ?>
        <img src="<?php echo htmlspecialchars($vehiculo['imagen']); ?>" alt="Imagen del vehículo" width="300">
    <?php else: ?>
        <p>No hay imagen disponible.</p>
    <?php endif; ?>
</body>
</html>
