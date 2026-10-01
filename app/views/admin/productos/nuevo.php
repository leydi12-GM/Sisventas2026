<?php require __DIR__ . '/../../layouts/header.php'; ?>
<div class="card p-3">
    <h3>Registrar nuevo producto</h3>
    <form action="" method="POST">
        <div class="row">
            <div class="col-md-4 form-group">
                <label for="" >Categoría :</label>
                <select name="" id=""></select>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4 form-group">
                <label for="codigo" >Código :</label>
                <input type="text" class="form-control" name="codigo" id="codigo"  maxlength="50" required>
            </div>
            <div class="col-md-4 form-group">
                <label for="nombre" >Nombre :</label>
                <input type="text" class="form-control" name="nombre" id="nombre"  maxlength="150" required>
            </div>
            <div class="col-md-4 form-group">
                <label for="descripcion" >Descripción :</label>
                <textarea class="form-control" name="descripcion" id="descripcion" required></textarea>
            </div>
            <div> class="col-md-4 form-group">
                <label for="precio" >Precio :</label>
                <input type="decimal" class="form-control" name="precio" id="precio" required>
            </div>
            <div class="col-md-4 form-group">
                <label for="stock" >Stock :</label>
                <input type="number" class="form-control" name="stock" id="stock" maxlength="11" required>
        </div>
    </form> 

</div>


<?php require __DIR__ . '/../../layouts/footer.php'; ?>
