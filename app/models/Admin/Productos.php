<?php
namespace App\Models\Admin; // (PADRE) es el namespace de la clase Categorias, que indica que pertenece al módulo Admin de la aplicación.
use Core\Model; // se importa la clase Model del espacio de nombres Core, que es la clase base para los modelos de la aplicación.
use PDO; // se importa la clase PDO que es la clase de PHP para trabajar con bases de datos.
class Productos extends Model{ 

    protected $table = 'productos'; 

    public function registrar($data){
        $sql ="INSERT INTO {$this->table} (categoria_id, codigo_sku,nombre,descripcion, precio_venta,stock_actual) VALUES (:categoria_id, :codigo_sku, :nombre, :descripcion, :precio_venta, :stock_actual)";
        $params = [    //aqui se trabaja los datos  que se van a insertar y su asignacion de valores a los parametros de la consulta SQL (ARRAY).
            ':categoria_id' => $data['categoria'],
            ':codigo_sku' => $data['codigo'],
            ':nombre' => $data['nombre'],
            ':descripcion' => $data['descripcion'],
            ':precio_venta' => $data['precio'],
            ':stock_actual' => $data['stock']
        ];

        $preparado = self::$db->prepare($sql); // se prepara la consulta 
        return $preparado->execute($params); // se ejecuta la consulta con los parametros


    }
    public function buscar(){ // BUSCAR SERA PARA BUSCAR TODOS LOS PRODUCTOS DE LA BASE DE DATOS Y MOSTRARLOS EN LA VISTA DE LISTA DE PRODUCTOS
        // Lógica para ver lista de productos
        $sql = "SELECT p.*, c.nombre AS categoria_nombre FROM {$this->table} p INNER JOIN categorias c ON p.categoria_id = c.id ORDER BY p.id ASC"; // consulta SQL para obtener todos los productos y su categoria
        $preparado = self::$db->prepare($sql);//prepara la consulta
        $preparado->execute();//ejecuta la consulta
        return $preparado->fetchAll(PDO::FETCH_ASSOC);//reordena los resultados // el fetchAll es para obtener todos los resultados de la consulta y devolverlos como un array asociativo.

        
    }
    public function ver(Int $id){
        $params = [':id' => $id];
        $sql = "SELECT * FROM {$this->table} WHERE id=:id";
        $preparado = self::$db->prepare($sql);
        $preparado->execute($params);
        return $preparado->fetch(PDO::FETCH_ASSOC); // fetch(PDO::FETCH_ASSOC) devuelve un solo registro como un array asociativo.
    }

    public function actualizar($data){
        $params = [
            ':categoria_id' => $data['categoria'],
            ':codigo_sku' => $data['codigo'],
            ':nombre' => $data['nombre'],
            ':descripcion' => $data['descripcion'],
            ':precio_venta' => $data['precio'],
            ':stock_actual' => $data['stock'],
            ':activo' => $data['estado'],
            ':id' => $data['id']
        ];
        
        $sql = "UPDATE {$this->table} SET categoria_id=:categoria_id, codigo_sku=:codigo_sku, nombre=:nombre, descripcion=:descripcion, precio_venta=:precio_venta, stock_actual=:stock_actual, activo=:activo WHERE id=:id";
        
        $preparado = self::$db->prepare($sql);
        return $preparado->execute($params);
        
    }
    public function eliminar($id){
        $sql = "DELETE FROM {$this->table} WHERE id=:id";
        $params = [':id' => $id];
        $preparado = self::$db->prepare($sql);
        return $preparado->execute($params);
        
    }
    
    

}