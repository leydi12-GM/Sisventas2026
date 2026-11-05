<?php require __DIR__ . '/../../layouts/header.php'; ?>
<div class="card p-2">
    <h3>Lista de Usuarios</h3>
    <br>
    <a href="<?= BASE_URL ?>/admin/usuarios/nuevo" class="btn btn-success col-2"> + Nuevo </a>
    <table class="table-bordered m-3">
        <thead>
            <tr>
                <th>Nro</th>
                <th>Nombres</th>
                <th>Apellidos</th>
                <th>Correo</th>
                <th>Teléfono</th>
                <th>Rol</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $contador = 0;
            foreach ($usuarios as $usuario) { 
                $contador += 1;
                $rolDisplay = $usuario['rol_nombre'] ?? ($usuario['rol'] == 1 ? 'Administrador' : ($usuario['rol'] == 2 ? 'Vendedor' : 'Rol ' . $usuario['rol']));
            ?>
            <tr>
                <td><?php echo $contador; ?></td>
                <td><?php echo htmlspecialchars($usuario['nombre']); ?></td>
                <td><?php echo htmlspecialchars($usuario['apellidos'] ?? ''); ?></td>
                <td><?php echo htmlspecialchars($usuario['correo']); ?></td>
                <td><?php echo !empty($usuario['telefono']) ? htmlspecialchars($usuario['telefono']) : '-'; ?></td>
                <td><?php echo htmlspecialchars($rolDisplay); ?></td>
                <td>
                    <?php if($usuario['activo'] == 1): ?>
                        <span class="badge bg-success text-white">Activo</span>
                    <?php else: ?>
                        <span class="badge bg-danger text-white">Inactivo</span>
                    <?php endif; ?>
                </td>
                <td>
                    <a class="btn btn-outline-primary" title="Editar" href="<?= BASE_URL ?>/admin/usuarios/editar/<?= $usuario['id'] ?>" onclick="return confirm('¿Estás seguro de editar este usuario?');" data-sigi-confirm ><i class="fa fa-edit"></i></a>
                    <a class="btn btn-outline-danger" title="Eliminar" href="<?= BASE_URL ?>/admin/usuarios/eliminar/<?= $usuario['id'] ?>" onclick="return confirm('¿Estás seguro de eliminar este usuario?');" data-sigi-confirm ><i class="fa fa-trash"></i></a>
                </td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
</div>
<?php require __DIR__ . '/../../layouts/footer.php'; ?>
