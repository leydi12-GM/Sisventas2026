<?php
namespace App\Controllers\Admin;

include_once __DIR__ . '/../../models/Admin/Usuarios.php';

use Core\Controller;
use App\Models\Admin\Usuarios;

class UsuariosController extends Controller
{
    protected $usuariosModel; 

    public function __construct(){
        parent::__construct(); // esto es para heredar el constructor de la clase padre Controller
        $this->usuariosModel = new Usuarios();
    }

    public function index()
    {
        $usuarios = $this->usuariosModel->buscar(); 
        
        $this->view('admin/usuarios/index', [
            'isAdmin'   => true,
            'usuarios'  => $usuarios,
            'module'    => 'admin',
            'pageTitle' => 'Usuarios'
        ]);
        exit;
    }

    public function nuevo(){
        $roles = $this->usuariosModel->obtenerRoles();
        
        $this->view('admin/usuarios/nuevo', [
            'isAdmin'   => true,
            'roles'     => $roles,
            'module'    => 'admin',
            'pageTitle' => 'Nuevo Usuario'
        ]);
        exit;
    }

    public function guardar(){
       $data = $_POST; 
       
       // Validar los datos obligatorios recibidos
       if(!empty($data['nombre']) && !empty($data['apellidos']) && !empty($data['correo']) && !empty($data['password']) && !empty($data['rol'])){
        
        // Encriptar la contraseña por seguridad antes de enviarla al modelo
        $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);

        $resultado = $this->usuariosModel->registrar($data);
        
        if($resultado){
            $_SESSION['flash_success'] = "Usuario registrado correctamente.";
            header('Location: ' . BASE_URL . '/admin/usuarios');
        }else{
            $_SESSION['flash_error'] = "Error al registrar el usuario.";
            header('Location: ' . BASE_URL . '/admin/usuarios/nuevo');
        }

       }else {
            $_SESSION['flash_error'] = "Todos los campos obligatorios deben ser completados (Nombres, Apellidos, Correo, Contraseña, Rol).";
            header('Location: ' . BASE_URL . '/admin/usuarios/nuevo');
       }
    }

    public function editar($id){
        $usuario = $this->usuariosModel->ver($id);
        $roles = $this->usuariosModel->obtenerRoles();
        
        $this->view('admin/usuarios/editar', [
            'isAdmin'   => true,
            'module'    => 'admin',
            'pageTitle' => 'Editar Usuario',
            'usuario'   => $usuario,
            'roles'     => $roles
        ]);
        exit;
    }

    public function actualizar(){
        $data = $_POST;
        
        // La contraseña puede venir vacía (significa que no la quieren cambiar)
        if(!empty($data['nombre']) && !empty($data['apellidos']) && !empty($data['correo']) && !empty($data['rol']) && isset($data['estado'])){
            
            // Si el usuario ingresó una nueva contraseña, la encriptamos. Si no, se manda vacía y el modelo lo gestiona.
            if(!empty($data['password'])){
                $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
            }

            $respuesta = $this->usuariosModel->actualizar($data);
            
            if($respuesta){
                $_SESSION['flash_success'] = "Usuario actualizado correctamente.";
                header('Location: ' . BASE_URL . '/admin/usuarios');
            }else{
                $_SESSION['flash_error'] = "Error al actualizar el usuario.";
                
                // Redirección con los datos devueltos para no perder lo que escribieron
                $datos_usuario = [
                    'id'        => $data['id'],
                    'nombre'    => $data['nombre'],
                    'apellidos' => $data['apellidos'],
                    'telefono'  => $data['telefono'] ?? '',
                    'correo'    => $data['correo'],
                    'rol'       => $data['rol'],
                    'activo'    => $data['estado']
                ];
                
                $roles = $this->usuariosModel->obtenerRoles();

                $this->view('admin/usuarios/editar', [
                    'isAdmin'   => true,
                    'module'    => 'admin',
                    'pageTitle' => 'Editar Usuario',
                    'usuario'   => $datos_usuario,
                    'roles'     => $roles
                ]);
            }
        }else{
            $_SESSION['flash_error'] = "Error: Campos obligatorios vacíos (Nombres, Apellidos, Correo, Rol, Estado).";
            
            $datos_usuario = [
                'id'        => $data['id'] ?? '',
                'nombre'    => $data['nombre'] ?? '',
                'apellidos' => $data['apellidos'] ?? '',
                'telefono'  => $data['telefono'] ?? '',
                'correo'    => $data['correo'] ?? '',
                'rol'       => $data['rol'] ?? '',
                'activo'    => $data['estado'] ?? 1
            ];
            
            $roles = $this->usuariosModel->obtenerRoles();

            $this->view('admin/usuarios/editar', [
                'isAdmin'   => true,
                'module'    => 'admin',
                'pageTitle' => 'Editar Usuario',
                'usuario'   => $datos_usuario,
                'roles'     => $roles
            ]);
        }
    }

    public function eliminar($id){
        try {
            $eliminar = $this->usuariosModel->eliminar($id);
            
            if($eliminar){
                $_SESSION['flash_success'] = "Usuario eliminado correctamente.";
            }else{
                $_SESSION['flash_error'] = "Error al eliminar el usuario.";
            }
            
        } catch (\PDOException $e) {
            // Capturamos el error fatal de la base de datos
            // El código 23000 significa "Violación de restricción de integridad" (llave foránea)
            if ($e->getCode() == '23000') {
                $_SESSION['flash_error'] = "No se puede eliminar este usuario porque tiene ventas u otros registros asociados en el sistema.";
            } else {
                // Para cualquier otro error de base de datos
                $_SESSION['flash_error'] = "Error de base de datos al intentar eliminar el usuario.";
            }
        }

        header('Location: ' . BASE_URL . '/admin/usuarios');
        exit;
    }
}
