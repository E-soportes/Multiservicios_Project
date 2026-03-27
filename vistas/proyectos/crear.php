<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2"><i class="bi bi-plus-circle"></i> Nuevo Proyecto</h1>
</div>

<form method="POST" class="row g-3">
    <div class="col-md-6">
        <label class="form-label">Nombre del Proyecto *</label>
        <input type="text" name="nombre" class="form-control" required>
    </div>
    <div class="col-md-6">
        <label class="form-label">Cliente</label>
        <select name="cliente_id" class="form-select">
            <option value="">Seleccionar cliente...</option>
            <?php foreach ($clientes as $cliente): ?>
            <option value="<?php echo $cliente['id']; ?>"><?php echo htmlspecialchars($cliente['nombre']); ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="col-md-6">
        <label class="form-label">Empresa ejecutora</label>
        <input type="text" name="empresa" class="form-control">
    </div>
    <div class="col-md-6">
        <label class="form-label">Valor ($)</label>
        <input type="text" name="valor" class="form-control" placeholder="1.234.567">
    </div>
    <div class="col-md-4">
        <label class="form-label">Fecha Inicio</label>
        <input type="date" name="fecha_inicio" class="form-control">
    </div>
    <div class="col-md-4">
        <label class="form-label">Fecha Fin</label>
        <input type="date" name="fecha_fin" class="form-control">
    </div>
    <div class="col-md-4">
        <label class="form-label">Estado inicial *</label>
        <select name="estado" class="form-select" required>
            <option value="Oferta">Oferta</option>
            <option value="Asignacion">Asignación</option>
        </select>
    </div>
    <div class="col-md-6">
        <label class="form-label">Responsable General</label>
        <select name="responsable_id" class="form-select">
            <option value="">Seleccionar usuario...</option>
            <?php foreach ($usuarios as $usuario): ?>
            <option value="<?php echo $usuario['id']; ?>"><?php echo htmlspecialchars($usuario['username']); ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="col-md-6">
        <label class="form-label">Prioridad</label>
        <select name="prioridad" class="form-select">
            <option value="Media">Media</option>
            <option value="Alta">Alta</option>
            <option value="Urgente">Urgente</option>
        </select>
    </div>
    <div class="col-12">
        <label class="form-label">Descripción</label>
        <textarea name="descripcion" rows="3" class="form-control"></textarea>
    </div>
    <div class="col-12">
        <label class="form-label">Observaciones</label>
        <textarea name="observaciones" rows="2" class="form-control"></textarea>
    </div>
    <div class="col-12">
        <button type="submit" class="btn btn-primary btn-lg">
            <i class="bi bi-check-lg"></i> Crear Proyecto
        </button>
        <a href="/proyectos" class="btn btn-secondary btn-lg ms-2">Cancelar</a>
    </div>
</form>

<script>
$(document).ready(function() {
    $('input[name=valor]').on('input', function() {
        this.value = this.value.replace(/[^0-9]/g, '').replace(/\B(?=(\d{3})+(?!\d))/g, ',');
    });
});
</script>
