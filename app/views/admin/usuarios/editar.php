<?php require __DIR__ . '/../../layouts/header.php'; ?>
<div class="card p-3">
    <h3>Editar Usuario</h3>
    <form action="<?= BASE_URL ?>/admin/usuarios/actualizar" method="post">
        <input type="hidden" name="id" value="<?= $usuario['id'] ?>">
        <div class="row">
            <div class="col-md-3 form-group">
                <label for="nombre">Nombres :</label>
                <input type="text" class="form-control" name="nombre" id="nombre" maxlength="40" value="<?= htmlspecialchars($usuario['nombre'] ?? '') ?>" required>
            </div>
            <div class="col-md-3 form-group">
                <label for="apellidos">Apellidos :</label>
                <input type="text" class="form-control" name="apellidos" id="apellidos" maxlength="80" value="<?= htmlspecialchars($usuario['apellidos'] ?? '') ?>" required>
            </div>
            <div class="col-md-3 form-group">
                <label for="telefono">Teléfono :</label>
                <input type="text" class="form-control" name="telefono" id="telefono" maxlength="20" value="<?= htmlspecialchars($usuario['telefono'] ?? '') ?>">
            </div>
            <div class="col-md-3 form-group">
                <label for="correo">Correo Electrónico :</label>
                <input type="email" class="form-control" name="correo" id="correo" maxlength="150" value="<?= htmlspecialchars($usuario['correo'] ?? '') ?>" required>
            </div>
            <div class="col-md-3 form-group">
                <label for="password">Nueva Contraseña :</label>
                <div class="input-group">
                    <input type="password" class="form-control" name="password" id="password" placeholder="(Opcional)">
                    <button class="btn btn-outline-secondary" type="button" id="btnTogglePassword">
                        <i class="fas fa-eye" id="iconoPassword"></i>
                    </button>
                </div>
            </div>
            <div class="col-md-3 form-group">
                <label for="rol">Rol :</label>
                <select name="rol" id="rol" class="form-control" required>
                    <?php if(!empty($roles)): ?>
                        <?php foreach($roles as $r): ?>
                            <option value="<?= $r['id'] ?>" <?= ($usuario['rol'] == $r['id']) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($r['nombre']) ?>
                            </option>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <option value="1" <?= ($usuario['rol'] == 1) ? 'selected' : '' ?>>Administrador</option>
                        <option value="2" <?= ($usuario['rol'] == 2) ? 'selected' : '' ?>>Vendedor</option>
                    <?php endif; ?>
                </select>
            </div>
            <div class="col-md-3 form-group">
                <label for="estado">Estado :</label>
                <select name="estado" id="estado" class="form-control" required>
                    <option value="1" <?= ($usuario['activo'] == 1) ? 'selected' : '' ?>>Activo</option>
                    <option value="0" <?= ($usuario['activo'] == 0) ? 'selected' : '' ?>>Inactivo</option>
                </select>
            </div>
        </div>
        <div class="form-group mt-3 text-center">
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

<?php require __DIR__ . '/../../layouts/footer.php'; ?>
