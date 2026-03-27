<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2"><i class="bi bi-person-plus"></i> Nuevo Usuario</h1>
</div>

<div class="row">
    <div class="col-md-8">
        <?php if (isset($success)): ?>
            <div class="alert alert-success"><?php echo $success; ?></div>
        <?php endif; ?>
        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>
        
        <form method="POST" class="card p-4 shadow-sm">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Usuario <span class="text-danger">*</span></label>
                    <input type="text" name="username" class="form-control" required maxlength="50">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Email <span class="text-danger">*</span></label>
                    <input type="email" name="email" class="form-control" required>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Contraseña <span class="text-danger">*</span></label>
                    <input type="password" name="password" class="form-control" required minlength="6">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Rol <span class="text-danger">*</span></label>
                    <select name="rol_id" class="form-select" required>
                        <option value="">Seleccionar...</option>
                        <?php foreach ($roles as $rol): ?>
                        <option value="<?php echo $rol['id']; ?>"><?php echo $rol['nombre']; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                <a href="/usuarios" class="btn btn-secondary me-md-2">Cancelar</a>
                <button type="submit" class="btn btn-primary">Crear Usuario</button>
            </div>
        </form>
    </div>
</div>
