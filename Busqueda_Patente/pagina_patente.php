<?php
// Mostrar errores
ini_set('display_errors', 1);
error_reporting(E_ALL);

if (!isset($_POST['patente'])) {
    echo "No se ingresó ninguna patente.";
    exit();
}

$patente = strtoupper(trim($_POST['patente']));

// Incluir archivo de configuración
include __DIR__ . '/../Baseto/config_db.php'; // Ajusta la ruta según tu estructura

// Buscar la patente en la base de datos
$sql = "SELECT * FROM vehiculos WHERE patente = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $patente);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $vehiculo = $result->fetch_assoc();
} else {
    echo "Patente no registrada.";
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Estado del Vehículo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body class="bg-light">
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h1 class="card-title mb-4 text-center">Estado de tu Vehículo</h1>
                        <ul class="list-group list-group-flush mb-4">
                            <li class="list-group-item"><strong>Patente:</strong> <?= htmlspecialchars($vehiculo['patente']) ?></li>
                            <li class="list-group-item"><strong>Marca:</strong> <?= htmlspecialchars($vehiculo['marca']) ?></li>
                            <li class="list-group-item"><strong>Modelo:</strong> <?= htmlspecialchars($vehiculo['modelo']) ?></li>
                            <li class="list-group-item"><strong>Estado:</strong> <?= nl2br(htmlspecialchars($vehiculo['estado'])) ?></li>
                        </ul>
                        <?php if (!empty($vehiculo['imagen'])): ?>
                            <div class="text-center">
                               <img src="/car-repair-html-template/admin_panel/<?= htmlspecialchars($vehiculo['imagen']) ?>" alt="Imagen del vehículo" class="img-fluid rounded" style="max-width: 300px;">
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
                <p class="text-center text-muted mt-3 small">© 2025 Marco Vega</p>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
