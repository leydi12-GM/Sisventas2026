<?php require __DIR__ . '/../../layouts/header.php'; ?>
<div class="card p-3">
    <h3>Registrar Nuevo Usuario</h3>
    <form action="<?= BASE_URL ?>/admin/usuarios/guardar" method="post">
        <div class="row">
            <div class="col-md-4 form-group">
                <label for="nombre">Nombre y Apellidos :</label>
                <input type="text" name="nombre" id="nombre" class="form-control" maxlength="150" required>
            </div>
            <div class="col-md-3 form-group">
                <label for="correo">Correo Electrónico :</label>
                <input type="email" name="correo" id="correo" class="form-control" maxlength="150" required>
            </div>
            <div class="col-md-3 form-group">
                <label for="password">Contraseña :</label>
                <div class="input-group">
                    <input type="password" name="password" id="password" class="form-control" required>
                    <button class="btn btn-outline-secondary" type="button" id="btnTogglePassword">
                        <i class="fas fa-eye" id="iconoPassword"></i>
                    </button>
                </div>
            </div>
            <div class="col-md-2 form-group">
                <label for="rol">Rol :</label>
                <select name="rol" id="rol" class="form-control" required>
                    <option value="">Seleccione...</option>
                    <option value="1">Administrador</option>
                    <option value="2">Vendedor</option>
                </select>
            </div>
        </div>
        <div class="form-group mt-3 text-center">
            <a class="btn btn-danger" href="<?= BASE_URL ?>/admin/usuarios"><i class="fas fa-times"></i> Cancelar</a>
            <button class="btn btn-info" type="reset"><i class="fas fa-trash"></i> Limpiar</button>
            <button class="btn btn-success" type="submit"><i class="fas fa-save"></i> Guardar</button>
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