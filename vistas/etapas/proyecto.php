<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h2>Etapas - <?php echo htmlspecialchars($proyecto['nombre']); ?></h2>
    <a href="/proyectos/ver/<?php echo $proyecto['id']; ?>" class="btn btn-secondary">
        ← Volver al proyecto
    </a>
</div>

<div class="alert alert-info">
    <strong>Suma porcentajes:</strong> <?php echo $suma_porcentajes; ?>% 
    <span class="badge <?php echo $suma_porcentajes == 100 ? 'bg-success' : 'bg-warning'; ?>">
        <?php echo $suma_porcentajes == 100 ? 'Completo' : 'Pendiente'; ?>
    </span>
</div>

<!-- Form asignar nueva etapa -->
<div class="card mb-4">
    <div class="card-header">
        <h5>Asignar Etapa</h5>
    </div>
    <div class="card-body">
        <form method="POST">
            <div class="row">
                <div class="col-md-3">
                    <label>Etapa *</label>
                    <select name="etapa_id" class="form-select" required>
                        <?php foreach ($etapas_master as $etapa): ?>
                            <?php 
                            $existe = array_filter($etapas, fn($e) => $e['etapa_id'] == $etapa['id']);
                            if (empty($existe)): 
                            ?>
                            <option value="<?php echo $etapa['id']; ?>">
                                <?php echo $etapa['nombre']; ?> (<?php echo $etapa['porcentaje_default']; ?>%)
                            </option>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-2">
                    <label>Porcentaje *</label>
                    <input type="number" name="porcentaje" class="form-control" min="1" max="100" required>
                </div>
                <div class="col-md-2">
                    <label>Responsable</label>
                    <select name="responsable_id" class="form-select">
                        <option value="">Sin asignar</option>
                        <?php foreach ($usuarios as $u): ?>
                        <option value="<?php echo $u['id']; ?>"><?php echo $u['username']; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-2">
                    <label>Estado</label>
                    <select name="estado" class="form-select">
                        <option value="Pendiente">Pendiente</option>
                        <option value="En_proceso">En proceso</option>
                    </select>
                </div>
                <div class="col-md-3 d-flex align-items-end">
                    <button type="submit" name="asignar_etapa" class="btn btn-primary w-100">
                        <i class="bi bi-plus"></i> Asignar
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Lista etapas asignadas -->
<div class="table-responsive">
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Etapa</th>
                <th>%</th>
                <th>Responsable</th>
                <th>Estado</th>
                <th>Avance</th>
                <th>Fechas</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($etapas as $etapa): ?>
            <tr>
                <td><strong><?php echo $etapa['nombre']; ?></strong></td>
                <td><span class="badge bg-info"><?php echo $etapa['porcentaje']; ?>%</span></td>
                <td><?php echo $etapa['responsable_nombre']; ?></td>
                <td>
                    <span class="badge bg-<?php 
                        echo $etapa['estado']=='Finalizado' ? 'success' :
                             ($etapa['estado']=='Atrasado' ? 'danger' : 'warning'); 
                    ?>">
                        <?php echo $etapa['estado']; ?>
                    </span>
                </td>
                <td>
                    <div class="progress">
                        <div class="progress-bar bg-success" style="width: <?php echo $etapa['avance']; ?>%"></div>
                    </div>
                    <?php echo $etapa['avance']; ?>%
                </td>
                <td>
                    <?php echo $etapa['fecha_inicio'] ?: '-'; ?> <br>
                    <?php echo $etapa['fecha_estimada'] ?: '-'; ?> <br>
                    <?php echo $etapa['fecha_final'] ?: '-'; ?>
                </td>
                <td>
                    <button class="btn btn-sm btn-outline-primary" onclick="editarEtapa(<?php echo $etapa['id']; ?>)">
                        Editar
                    </button>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<!-- Modal editar etapa (JS) -->

