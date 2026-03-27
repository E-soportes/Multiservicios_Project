<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2"><?php echo htmlspecialchars($proyecto['nombre']); ?></h1>
    <div>
        <a href="/proyectos/editar/<?php echo $proyecto['id']; ?>" class="btn btn-outline-primary me-2">
            <i class="bi bi-pencil"></i> Editar
        </a>
        <span class="badge fs-6 bg-<?php echo $proyecto['estado']=='Finalizacion' ? 'success' : 'primary'; ?>">
            <?php echo $proyecto['estado']; ?>
        </span>
    </div>
</div>

<div class="row mb-4">
    <div class="col-md-6">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Información General</h5>
                <table class="table table-borderless">
                    <tr><th>Cliente:</th><td><?php echo htmlspecialchars($proyecto['cliente_nombre'] ?: 'N/A'); ?></td></tr>
                    <tr><th>Empresa:</th><td><?php echo htmlspecialchars($proyecto['empresa']); ?></td></tr>
                    <tr><th>Valor:</th><td>$<?php echo number_format($proyecto['valor'], 0, ',', '.'); ?></td></tr>
                    <tr><th>Fechas:</th><td><?php echo $proyecto['fecha_inicio'] . ' → ' . $proyecto['fecha_fin']; ?></td></tr>
                    <tr><th>Responsable:</th><td><?php echo $proyecto['responsable_nombre']; ?></td></tr>
                    <tr><th>Prioridad:</th><td><span class="badge bg-<?php echo $proyecto['prioridad']=='Urgente' ? 'danger' : 'warning'; ?>"><?php echo $proyecto['prioridad']; ?></span></td></tr>
                </table>
                <?php if ($proyecto['descripcion']): ?>
                <hr>
                <h6>Descripción:</h6>
                <p><?php echo nl2br(htmlspecialchars($proyecto['descripcion'])); ?></p>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Progreso General</h5>
                <div class="mb-3">
                    <label>Avance Total: <strong><?php echo round($avance, 1); ?>%</strong></label>
                    <div class="progress">
                        <div class="progress-bar bg-success" style="width: <?php echo $avance; ?>%"></div>
                    </div>
                </div>
                <a href="/proyecto_etapas/<?php echo $proyecto['id']; ?>" class="btn btn-primary w-100">
                    <i class="bi bi-gear"></i> Gestionar Etapas
                </a>
                <a href="/actividades/proyecto/<?php echo $proyecto['id']; ?>" class="btn btn-outline-info w-100 mt-2">
                    <i class="bi bi-list-ul"></i> Actividades
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Tabs Etapas, Actividades, etc. cuando estén listas -->

<script>
// Más JS aquí
</script>
