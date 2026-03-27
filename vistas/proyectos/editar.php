<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2"><i class="bi bi-pencil-square"></i> Editar <?php echo htmlspecialchars($proyecto['nombre']); ?></h1>
</div>

<form method="POST" class="row g-3">
    <input type="hidden" name="id" value="<?php echo $proyecto['id']; ?>">
    
    <div class="col-md-6">
        <label class="form-label">Nombre del Proyecto *</label>
        <input type="text" name="nombre" class="form-control" 
               value="<?php echo htmlspecialchars($proyecto['nombre']); ?>" required>
    </div>
    <div class="col-md-6">
        <label class="form-label">Cliente</label>
        <select name="cliente_id" class="form-select">
            <option value="">Seleccionar cliente...</option>
            <?php foreach ($clientes as $cliente): ?>
            <option value="<?php echo $cliente['id']; ?>" 
                    <?php echo $proyecto['cliente_id'] == $cliente['id'] ? 'selected' : ''; ?>>
                <?php echo htmlspecialchars($cliente['nombre']); ?>
            </option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="col-md-6">
        <label class="form-label">Empresa ejecutora</label>
        <input type="text" name="empresa" class="form-control" 
               value="<?php echo htmlspecialchars($proyecto['empresa']); ?>">
    </div>
    <div class="col-md-6">
        <label class="form-label">Valor ($)</label>
        <input type="text" name="valor" class="form-control" 
               value="<?php echo number_format((float)$proyecto['valor'], 0, ',', '.'); ?>">
    </div>
    <div class="col-md-4">
        <label class="form-label">Fecha Inicio</label>
        <input type="date" name="fecha_inicio" class="form-control" 
               value="<?php echo $proyecto['fecha_inicio']; ?>">
    </div>
    <div class="col-md-4">
        <label class="form-label">Fecha Fin</label>
        <input type="date" name="fecha_fin" class="form-control" 
               value="<?php echo $proyecto['fecha_fin']; ?>">
    </div>
    <div class="col-md-4">
        <label class="form-label">Estado</label>
        <select name="estado" class="form-select">
            <option value="Oferta" <?php echo $proyecto['estado']=='Oferta' ? 'selected' : ''; ?>>Oferta</option>
            <option value="Asignacion" <?php echo $proyecto['estado']=='Asignacion' ? 'selected' : ''; ?>>Asignación</option>
            <option value="Ejecucion" <?php echo $proyecto['estado']=='Ejecucion' ? 'selected' : ''; ?>>Ejecución</option>
            <option value="Portal" <?php echo $proyecto['estado']=='Portal' ? 'selected' : ''; ?>>Portal</option>
            <option value="Liquidacion" <?php echo $proyecto['estado']=='Liquidacion' ? 'selected' : ''; ?>>Liquidación</option>
            <option value="Finalizacion" <?php echo $proyecto['estado']=='Finalizacion' ? 'selected' : ''; ?>>Finalización</option>
        </select>
    </div>
    <div class="col-md-6">
        <label class="form-label">Responsable General</label>
        <select name="responsable_id" class="form-select">
            <option value="">Seleccionar usuario...</option>
            <?php foreach ($usuarios as $usuario): ?>
            <option value="<?php echo $usuario['id']; ?>" <?php echo $proyecto['responsable_id'] == $usuario['id'] ? 'selected' : ''; ?>>
                <?php echo htmlspecialchars($usuario['username']); ?>
            </option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="col-md-6">
        <label class="form-label">Prioridad</label>
        <select name="prioridad" class="form-select">
            <option value="Baja" <?php echo $proyecto['prioridad']=='Baja' ? 'selected' : ''; ?>>Baja</option>
            <option value="Media" <?php echo $proyecto['prioridad']=='Media' ? 'selected' : ''; ?>>Media</option>
            <option value="Alta" <?php echo $proyecto['prioridad']=='Alta' ? 'selected' : ''; ?>>Alta</option>
            <option value="Urgente" <?php echo $proyecto['prioridad']=='Urgente' ? 'selected' : ''; ?>>Urgente</option>
        </select>
    </div>
    <div class="col-12">
        <label class="form-label">Descripción</label>
        <textarea name="descripcion" rows="3" class="form-control"><?php echo htmlspecialchars($proyecto['descripcion']); ?></textarea>
    </div>
    <div class="col-12">
        <label class="form-label">Observaciones</label>
        <textarea name="observaciones" rows="2" class="form-control"><?php echo htmlspecialchars($proyecto['observaciones']); ?></textarea>
    </div>
    <div class="col-12">
        <button type="submit" class="btn btn-primary btn-lg">
            <i class="bi bi-check-lg"></i> Actualizar Proyecto
        </button>
        <a href="/proyectos/ver/<?php echo $proyecto['id']; ?>" class="btn btn-secondary btn-lg ms-2">Cancelar</a>
    </div>
</form>

<script>
$(document).ready(function() {
    $('input[name=valor]').on('input', function() {
        this.value = this.value.replace(/[^0-9]/g, '').replace(/\B(?=(\d{3})+(?!\d))/g, ',');
    });
});
</script>
