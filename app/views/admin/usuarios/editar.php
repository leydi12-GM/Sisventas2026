<?php require  __DIR__ . '/../../layouts/header.php'; ?>
<div class="card p-3">
    <h3>Editar Usuario</h3>
    <form action="<?= BASE_URL ?>/admin/usuarios/actualizar" method="post">
        <input type="hidden" name="id" value="<?= $usuario['id'] ?>">
        
        <div class="row">
            <div class="col-md-4 form-group">
                <label for="nombre">Nombre y Apellidos :</label>
                <input type="text" class="form-control" name="nombre" id="nombre" maxlength="150" value="<?= htmlspecialchars($usuario['nombre']) ?>" required>
            </div>
            <div class="col-md-4 form-group">
                <label for="correo">Correo Electrónico :</label>
                <input type="email" class="form-control" name="correo" id="correo" maxlength="150" value="<?= htmlspecialchars($usuario['correo']) ?>" required>
            </div>
            <div class="col-md-4 form-group">
                <label for="password">Nueva Contraseña : <small class="text-muted">(Dejar vacío para no cambiarla)</small></label>
                <div class="input-group">
                    <input type="password" class="form-control" name="password" id="password">
                    <button class="btn btn-outline-secondary" type="button" id="btnTogglePassword">
                        <i class="fas fa-eye" id="iconoPassword"></i>
                    </button>
                </div>
            </div>
        </div>

        <div class="row mt-2">
            <div class="col-md-2 form-group">
                <label for="rol">Rol :</label>
                <select name="rol" id="rol" class="form-control" required>
                    <option value="1" <?php if ($usuario['rol'] == 1) echo "selected"; ?>>Administrador</option>
                    <option value="2" <?php if ($usuario['rol'] == 2) echo "selected"; ?>>Vendedor</option>
                </select>
            </div>
            <div class="col-md-2 form-group">
                <label for="estado">Estado :</label>
                <select name="estado" id="estado" class="form-control">
                    <option value="1" <?php if ($usuario['activo'] == 1) echo "selected"; ?>>Activo</option>
                    <option value="0" <?php if ($usuario['activo'] == 0) echo "selected"; ?>>Inactivo</option>
                </select>
            </div>
        </div>

        <div class="mt-4 text-center">
            <a class="btn btn-danger" href="<?= BASE_URL ?>/admin/usuarios"><i class="fas fa-times"></i> Cancelar</a>
            <button class="btn btn-info" type="reset"><i class="fas fa-trash"></i> Limpiar</button>
            <button class="btn btn-success" type="submit"><i class="fas fa-save"></i> Actualizar</button>
        </div>
    </form>
</div>

<script>
    document.getElementById('btnTogglePassword').addEventListener('click', function() {
        const passwordInput = document.getElementById('password');
        const icono = document.getElementById('iconoPassword');
        
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            icono.classList.remove('fa-eye');
            icono.classList.add('fa-eye-slash');
        } else {
            passwordInput.type = 'password';
            icono.classList.remove('fa-eye-slash');
            icono.classList.add('fa-eye');
        }
    });
</script>

<?php require  __DIR__ . '/../../layouts/footer.php'; ?>