<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2"><i class="bi bi-list-task"></i> Proyectos</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="input-group me-2" style="width: 250px;">
            <input type="text" class="form-control" placeholder="Buscar..." 
                   id="busqueda" onkeyup="filtrarProyectos()">
        </div>
        <select class="form-select me-2" style="width: auto;" id="estadoFiltro" onchange="filtrarProyectos()">
            <option value="">Todos estados</option>
            <option value="Oferta">Oferta</option>
            <option value="Ejecucion">Ejecución</option>
            <!-- Más -->
        </select>
        <a href="/proyectos/crear" class="btn btn-sm btn-primary">
            <i class="bi bi-plus-lg"></i> Nuevo Proyecto
        </a>
    </div>
</div>

<div class="table-responsive">
    <table id="proyectosTable" class="table table-striped table-sm">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Cliente/Empresa</th>
                <th>Valor</th>
                <th>Estado</th>
                <th>Responsable</th>
                <th>Avance</th>
                <th>Prioridad</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($proyectos as $proyecto): 
                $avance = Proyecto::avanceTotal($proyecto['id']);
            ?>
            <tr>
                <td><?php echo $proyecto['id']; ?></td>
                <td>
                    <a href="/proyectos/ver/<?php echo $proyecto['id']; ?>">
                        <?php echo htmlspecialchars($proyecto['nombre']); ?>
                    </a>
                </td>
                <td><?php echo htmlspecialchars($proyecto['cliente_nombre'] ?: $proyecto['empresa']); ?></td>
                <td>$<?php echo number_format($proyecto['valor'], 0, ',', '.'); ?></td>
                <td>
                    <span class="badge bg-<?php 
                        echo $proyecto['estado']=='Finalizacion' ? 'success' : 
                             ($proyecto['estado']=='Ejecucion' ? 'primary' : 'warning'); 
                    ?>">
                        <?php echo $proyecto['estado']; ?>
                    </span>
                </td>
                <td><?php echo $proyecto['responsable_nombre']; ?></td>
                <td>
                    <div class="progress" style="height: 20px;">
                        <div class="progress-bar" style="width: <?php echo $avance; ?>%">
                            <?php echo round($avance, 1); ?>%
                        </div>
                    </div>
                </td>
                <td>
                    <?php if ($proyecto['prioridad']=='Urgente'): ?>
                        <span class="badge bg-danger">Urgente</span>
                    <?php elseif ($proyecto['prioridad']=='Alta'): ?>
                        <span class="badge bg-warning">Alta</span>
                    <?php endif; ?>
                </td>
                <td>
                    <div class="btn-group btn-group-sm">
                        <a href="/proyectos/ver/<?php echo $proyecto['id']; ?>" class="btn btn-outline-primary">
                            <i class="bi bi-eye"></i>
                        </a>
                        <a href="/proyectos/editar/<?php echo $proyecto['id']; ?>" class="btn btn-outline-secondary">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <button class="btn btn-outline-danger" onclick="eliminarProyecto(<?php echo $proyecto['id']; ?>)">
                            <i class="bi bi-trash"></i>
                        </button>
                    </div>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<script>
function filtrarProyectos() {
    const busqueda = $('#busqueda').val();
    const estado = $('#estadoFiltro').val();
    const params = new URLSearchParams({busqueda, estado});
    window.location.search = params.toString();
}

function eliminarProyecto(id) {
    if (confirm('¿Eliminar proyecto? Esto eliminará etapas y actividades.')) {
        window.location = `/proyectos/eliminar/${id}`;
    }
}

$(document).ready(function() {
    $('#proyectosTable').DataTable({
        responsive: true,
        pageLength: 25,
        order: [[0, 'desc']]
    });
});
</script>
