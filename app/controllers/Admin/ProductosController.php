<?php
namespace App\Controllers\Admin;


include_once __DIR__ . '/../../models/Admin/Categorias.php';
include_once __DIR__ . '/../../models/Admin/Productos.php';
include_once __DIR__ . '/../../models/Admin/Ventas.php';

use Core\Controller;
use App\Models\Admin\Categorias;
use App\Models\Admin\Productos;
use App\Models\Admin\Ventas;

class ProductosController extends Controller
{
    protected $categoriasModel;//atributo de la clase controller para manejar el modelo Categorias
    protected $productosModel; //atributo de la clase controller para manejar el modelo Productos
    protected $ventasModel; //atributo de la clase controller para manejar el modelo Ventas

    public function __construct(){
        //Inicializar el modelo Categorias y productos para poder usarlo en los metodos de la clase controller
        $this->categoriasModel = new Categorias();
        $this->productosModel = new Productos();
        $this->ventasModel = new Ventas();
    }

    public function index()
    {
        $productos = $this->productosModel->buscar(); //llama al metodo buscar del modelo productos para obtener la lista de productos
        // envia a la vista el modulo actual y el titulo de la pagina
        $this->view('admin/productos/index', [
            'isAdmin'   => true,
            'productos' => $productos,
            'module'    => 'admin',
            'pageTitle' => 'Productos'
        ]);
        exit;
    }
    public function nuevo(){
        // Estas categorias se utilizan  para llenar el select de categorias en la vista de nuevo producto
        $categorias = $this->categoriasModel->categorias_select();
        $this->view('admin/productos/nuevo', [
            'isAdmin'   => true,
            'module'    => 'admin',
            'pageTitle' => 'Nuevo Producto',
            'categorias' => $categorias
        ]);
        exit;
    }

    public function guardar(){
       $data = $_POST; //la variable $data contiene los datos enviados desde el formulario
       //Validar los datos recibidos
       if(!empty($data['categoria']) && !empty($data['codigo']) && !empty($data['nombre']) && !empty($data['descripcion']) && !empty($data['precio']) && !empty($data['stock'])){
        // GUARDAR EL PRODUCTO EN LA BASE DE DATOS
        // LLAMAR AL MODELO DE PRODUCTOS PARA GUARDAR EL PRODUCTO
        $resultado = $this->productosModel->registrar($data);
        if($resultado){
            // notificar al usuario que el producto se guardo correctamente
            $_SESSION['flash_success'] = "Producto registrado correctamente.";
            // redireccion a la lista de productos
            header('Location: ' . BASE_URL . '/admin/productos');
        }else{
            // Notificar al usuario que hubo un error al guardar el producto
            $_SESSION['flash_error'] = "Error al registrar el producto.";
            // redireccion a la lista de nuevo producto
            header('Location: ' . BASE_URL . '/admin/productos/nuevo');
        }

       }else {
            header('Location: ' . BASE_URL . '/admin/productos/nuevo');
       }

    }

  //metodo editar
    public function editar($id){
        // Estas categorías se utilizan para llenar el selector del formulario.
        $categorias = $this->categoriasModel->categorias_select();
        //buscar un producto por id
        $producto = $this->productosModel->ver($id);
        //var_dump($producto); 
        // Envía a la vista los datos necesarios para renderizar el formulario.
        $this->view('admin/productos/editar', [
            'isAdmin'   => true,
            'module'    => 'admin',
            'pageTitle' => 'editar Producto',
            'categorias' => $categorias,
            'producto' => $producto
        ]);
        exit;
    }

    //metodo actualizar
    public function actualizar(){
        $data = $_POST;
        if(!empty($data['categoria']) && !empty($data['codigo']) && !empty($data['nombre']) && !empty($data['descripcion']) && !empty($data['precio']) && !empty($data['stock'])){
            // actualizar el producto
            $respuesta = $this->productosModel->actualizar($data);
            if($respuesta){
                //notificar al usuario que el producto se guardo correctamente
                $_SESSION['flash_success'] = "Producto actualizado correctamente";
                //redireccion a la lista de productos
                header('Location: ' . BASE_URL . '/admin/productos');
            }else{
                //notificar al usuario que hubo un error al guardar el producto
                $_SESSION['flash_error'] = "Error al actualizar el producto";
                //redireccion al formulario de editar con los datos modificados
                $datos_producto = [
                    'id'=> $data['id'],
                    'categoria_id'=> $data['categoria'],
                    'codigo_sku'=> $data['codigo'],
                    'nombre'=> $data['nombre'],
                    'descripcion'=> $data['descripcion'],
                    'precio_venta'=> $data['precio'],
                    'stock_actual'=> $data['stock'],
                    'activo'=> $data['estado']
                ];
                $categorias = $this->categoriasModel->categorias_select();
                $this->view('admin/productos/editar', [
                    'isAdmin'   => true,
                    'module'    => 'admin',
                    'pageTitle' => 'Editar Producto',
                    'categorias' => $categorias,
                    'producto' => $datos_producto
                ]);
            }
        }else{
            $_SESSION['flash_error'] ="Error: Campos vacíos";
            $datos_producto = [
                    'id'=> $data['id'],
                    'categoria_id'=> $data['categoria'],
                    'codigo_sku'=> $data['codigo'],
                    'nombre'=> $data['nombre'],
                    'descripcion'=> $data['descripcion'],
                    'precio_venta'=> $data['precio'],
                    'stock_actual'=> $data['stock'],
                    'activo'=> $data['estado']
                ];
                $categorias = $this->categoriasModel->categorias_select();
                $this->view('admin/productos/editar', [
                    'isAdmin'   => true,
                    'module'    => 'admin',
                    'pageTitle' => 'Editar Producto',
                    'categorias' => $categorias,
                    'producto' => $datos_producto
                ]);
        }
    }
    public function eliminar($id){
        $detalle_ventas = $this->ventasModel->ver_detalle_ventas_Id_producto($id);
        if($detalle_ventas){
            $_SESSION['flash_error'] = "No se puede eliminar el producto porque tiene ventas asociadas";
            header('Location: ' . BASE_URL . '/admin/productos');
        }else{
            $eliminar = $this->productosModel->eliminar($id);
            if($eliminar){
                $_SESSION['flash_success'] = "Producto eliminado correctamente";
                header('Location: ' . BASE_URL . '/admin/productos');
            }else{
                $_SESSION['flash_error'] = "Error al eliminar el producto";
                header('Location: ' . BASE_URL . '/admin/productos');
            }
        }
    }

}