<?php
namespace App\Models\Admin; // (PADRE) es el namespace de la clase Categorias, que indica que pertenece al módulo Admin de la aplicación.
use Core\Model; // se importa la clase Model del espacio de nombres Core, que es la clase base para los modelos de la aplicación.
use PDO; // se importa la clase PDO que es la clase de PHP para trabajar con bases de datos.
class Productos extends Model{ 

    protected $table = 'productos'; 

    public function registrar($data){
        $sql ="INSERT INTO {$this->table} (categoria_id, codigo_sku,nombre,descripcion, precio_venta,stock_actual) VALUES (:categoria_id, :codigo_sku, :nombre, :descripcion, :precio_venta, :stock_actual)";
        $params = [    //aqui se trabaja los datos  que se van a insertar y su asignacion de valores a los parametros de la consulta SQL (ARRAY).
            ':categoria_id' => $data['categoria_id'],
            ':codigo_sku' => $data['codigo_sku'],
            ':nombre' => $data['nombre'],
            ':descripcion' => $data['descripcion'],
            ':precio_venta' => $data['precio_venta'],
            ':stock_actual' => $data['stock_actual']
        ];

        $preparado = self::$db->prepare($sql); // se prepara la consulta 
        return $preparado->execute($params); // se ejecuta la consulta con los parametros


    }
    public function buscar(){
        
    }
    public function ver(){
        
    }
    public function actualizar(){
        
    }
    public function eliminar(){
        
    }
    

}