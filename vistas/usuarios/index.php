<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2"><i class="bi bi-people"></i> Usuarios</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="/usuarios/crear" class="btn btn-sm btn-primary">
            <i class="bi bi-plus-lg"></i> Nuevo Usuario
        </a>
    </div>
</div>

<div class="table-responsive">
    <table id="usuariosTable" class="table table-striped table-sm">
        <thead>
            <tr>
                <th>ID</th>
                <th>Usuario</th>
                <th>Email</th>
                <th>Rol</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($usuarios as $usuario): ?>
            <tr>
                <td><?php echo $usuario['id']; ?></td>
                <td><?php echo htmlspecialchars($usuario['username']); ?></td>
                <td><?php echo htmlspecialchars($usuario['email']); ?></td>
                <td>
                    <span class="badge bg-<?php echo $usuario['rol_nombre'] == 'Administrador' ? 'danger' : 'secondary'; ?>">
                        <?php echo $usuario['rol_nombre']; ?>
                    </span>
                </td>
                <td>
                    <?php if ($usuario['activo']): ?>
                        <span class="badge bg-success">Activo</span>
                    <?php else: ?>
                        <span class="badge bg-warning">Inactivo</span>
                    <?php endif; ?>
                </td>
                <td>
                    <a href="/usuarios/editar/<?php echo $usuario['id']; ?>" class="btn btn-sm btn-outline-primary">
                        <i class="bi bi-pencil"></i>
                    </a>
                    <a href="/usuarios/eliminar/<?php echo $usuario['id']; ?>" 
                       class="btn btn-sm btn-outline-danger" 
                       onclick="return confirm('¿Eliminar?')">
                        <i class="bi bi-trash"></i>
                    </a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<script>
$(document).ready(function() {
    $('#usuariosTable').DataTable({
        language: { url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json' },
        responsive: true
    });
});
</script>
