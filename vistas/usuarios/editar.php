<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2"><i class="bi bi-pencil-square"></i> Editar Usuario</h1>
</div>

<div class="row">
    <div class="col-md-8">
        <?php if (isset($success)): ?>
            <div class="alert alert-success"><?php echo $success; ?></div>
        <?php endif; ?>
        
        <form method="POST" class="card p-4 shadow-sm">
            <input type="hidden" name="id" value="<?php echo $usuario['id']; ?>">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Usuario</label>
                    <input type="text" name="username" class="form-control" 
                           value="<?php echo htmlspecialchars($usuario['username']); ?>" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" 
                           value="<?php echo htmlspecialchars($usuario['email']); ?>" required>
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label">Rol</label>
                <select name="rol_id" class="form-select">
                    <?php foreach ($roles as $rol): ?>
                    <option value="<?php echo $rol['id']; ?>" 
                            <?php echo $usuario['rol_id'] == $rol['id'] ? 'selected' : ''; ?>>
                        <?php echo $rol['nombre']; ?>
                    </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">Activo</label>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="activo" 
                           id="activo" <?php echo $usuario['activo'] ? 'checked' : ''; ?> value="1">
                    <label class="form-check-label" for="activo">Usuario activo</label>
                </div>
            </div>
            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                <a href="/usuarios" class="btn btn-secondary me-md-2">Cancelar</a>
                <button type="submit" class="btn btn-primary">Actualizar</button>
            </div>
        </form>
    </div>
</div>
