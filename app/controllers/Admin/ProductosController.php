<?php
namespace App\Controllers\Admin;

use Core\Controller;

class ProductosController extends Controller
{
    public function index()
    {
        $this->view('admin/productos/index', [
            'isAdmin'   => true,
            'module'    => 'admin',
            'pageTitle' => 'Productos'
        ]);
        exit;
    }
    public function nuevo(){
        // Estas categorias se utilizan para llenar el selct del formulario 
        $categorias = ['Electrónica', 'Ropa', 'Hogar'];

        //Envia a la vista los datos necesarios para renderizar el formulario.
        $this->view('admin/productos/nuevo', [
            'isAdmin'   => true,
            'module'    => 'admin',
            'pageTitle' => 'Nuevo Producto',
            'categorias' => $categorias
        ]);
        exit;
    }
}