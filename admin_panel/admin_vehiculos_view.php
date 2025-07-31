<?php
// Guardas: evita warnings si la vista se carga directa
if (!isset($vehiculos) || !is_array($vehiculos)) {
    $vehiculos = [];
}
if (!isset($mensaje)) {
    $mensaje = '';
}
if (!isset($mostrarModalDuplicado)) {
    $mostrarModalDuplicado = false;
}

// Detectar tipo de alerta según contenido de $mensaje
$alertClass = 'info';
if (str_contains($mensaje, '✅')) {
    $alertClass = 'success';
} elseif (str_contains($mensaje, '❌')) {
    $alertClass = 'danger';
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Administrador de Vehículos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body class="bg-light">

    <div class="container py-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="m-0">Panel de Administrador</h1>
            <!-- Botón volver -->
            <a href="../index.html" class="btn btn-primary">
                Volver a Página Principal
            </a>
        </div>

        <div class="card shadow mb-5">
            <div class="card-header bg-primary text-white">
                Agregar nuevo vehículo
            </div>
            <div class="card-body">
                <?php if (!empty($mensaje)): ?>
                    <div class="alert alert-<?= $alertClass ?>"><?= $mensaje ?></div>
                <?php endif; ?>

                <form method="POST" action="admin_vehiculos.php" enctype="multipart/form-data" novalidate>
                    <div class="mb-3">
                        <label for="patente" class="form-label">Patente</label>
                        <input type="text" class="form-control" id="patente" name="patente" required>
                    </div>

                    <div class="mb-3">
                        <label for="marca" class="form-label">Marca</label>
                        <input type="text" class="form-control" id="marca" name="marca" required>
                    </div>

                    <div class="mb-3">
                        <label for="modelo" class="form-label">Modelo</label>
                        <input type="text" class="form-control" id="modelo" name="modelo" required>
                    </div>

                    <div class="mb-3">
                        <label for="estado" class="form-label">Estado del vehículo</label>
                        <textarea class="form-control" id="estado" name="estado" rows="4" required></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="imagen" class="form-label">Foto del vehículo (opcional)</label>
                        <input type="file" class="form-control" id="imagen" name="imagen" accept="image/*">
                    </div>

                    <button type="submit" class="btn btn-success">Agregar vehículo</button>
                </form>
            </div>
        </div>

        <div class="card shadow">
            <div class="card-header bg-dark text-white">
                Vehículos registrados
            </div>
            <div class="card-body table-responsive">
                <table class="table table-bordered table-hover table-striped align-middle mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Patente</th>
                            <th>Marca</th>
                            <th>Modelo</th>
                            <th>Estado</th>
                            <th>Foto</th>
                            <th>Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($vehiculos)): ?>
                            <tr>
                                <td colspan="7" class="text-center text-muted py-4">No hay vehículos registrados.</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($vehiculos as $vehiculo): ?>
                                <tr>
                                    <td><?= htmlspecialchars($vehiculo['id']) ?></td>
                                    <td><?= htmlspecialchars($vehiculo['patente']) ?></td>
                                    <td><?= htmlspecialchars($vehiculo['marca']) ?></td>
                                    <td><?= htmlspecialchars($vehiculo['modelo']) ?></td>
                                    <td><?= htmlspecialchars($vehiculo['estado']) ?></td>
                                    <td class="text-center" style="width:120px;">
                                        <?php if (!empty($vehiculo['imagen'])): ?>
                                            <img src="<?= htmlspecialchars($vehiculo['imagen']) ?>" alt="Foto vehículo" style="max-height:60px; max-width:100px;" class="img-thumbnail" />
                                        <?php else: ?>
                                            <span class="text-muted">Sin foto</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <a href="admin_vehiculos.php?eliminar=<?= (int)$vehiculo['id'] ?>"
                                           class="btn btn-sm btn-danger"
                                           onclick="return confirm('¿Eliminar este vehículo?');">
                                            Eliminar
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div><!-- /.container -->

    <!-- Modal Duplicado -->
    <div class="modal fade" id="modalDuplicado" tabindex="-1" aria-labelledby="modalDuplicadoLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-danger">
          <div class="modal-header bg-danger text-white">
            <h5 class="modal-title" id="modalDuplicadoLabel">❗ Vehículo ya registrado</h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
          </div>
          <div class="modal-body">
            Los datos ingresados ya existen en la base de datos. Por favor verifica la información.
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Entendido</button>
          </div>
        </div>
      </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <?php if ($mostrarModalDuplicado): ?>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        var modalEl = document.getElementById('modalDuplicado');
        if (modalEl) {
            var modal = new bootstrap.Modal(modalEl);
            modal.show();
        }
    });
    </script>
    <?php endif; ?>

</body>
</html>
