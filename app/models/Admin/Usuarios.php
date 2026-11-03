<?php
namespace App\Models\Admin;

use Core\Model;
use PDO;

class Usuarios extends Model{ 

    protected $table = 'usuarios'; 

    public function registrar($data){
        // Usamos los nombres reales de la BD: email, password_hash, rol_id
        $sql ="INSERT INTO {$this->table} (nombre, email, password_hash, rol_id) VALUES (:nombre, :email, :password_hash, :rol_id)";
        $params = [
            ':nombre'        => $data['nombre'],
            ':email'         => $data['correo'], // Lo recibimos como 'correo' desde el form
            ':password_hash' => $data['password'], // Viene encriptada desde el controller
            ':rol_id'        => $data['rol'] // Lo recibimos como 'rol'
        ];

        $preparado = self::$db->prepare($sql);
        return $preparado->execute($params);
    }

    public function buscar(){ 
        // Traemos todos los usuarios usando AS para que coincida con lo que espera la vista
        $sql = "SELECT id, nombre, email AS correo, rol_id AS rol, activo FROM {$this->table} ORDER BY id ASC";
        $preparado = self::$db->prepare($sql);
        $preparado->execute();
        return $preparado->fetchAll(PDO::FETCH_ASSOC);
    }

    public function ver(Int $id){
        $params = [':id' => $id];
        $sql = "SELECT id, nombre, email AS correo, rol_id AS rol, activo FROM {$this->table} WHERE id=:id";
        $preparado = self::$db->prepare($sql);
        $preparado->execute($params);
        return $preparado->fetch(PDO::FETCH_ASSOC); 
    }

    public function actualizar($data){
        // Si el password viene vacío, no lo actualizamos
        if(!empty($data['password'])){
            $sql = "UPDATE {$this->table} SET nombre=:nombre, email=:email, password_hash=:password_hash, rol_id=:rol_id, activo=:activo WHERE id=:id";
            $params = [
                ':nombre'        => $data['nombre'],
                ':email'         => $data['correo'],
                ':password_hash' => $data['password'],
                ':rol_id'        => $data['rol'],
                ':activo'        => $data['estado'],
                ':id'            => $data['id']
            ];
        } else {
            // Actualización sin cambiar la contraseña
            $sql = "UPDATE {$this->table} SET nombre=:nombre, email=:email, rol_id=:rol_id, activo=:activo WHERE id=:id";
            $params = [
                ':nombre' => $data['nombre'],
                ':email'  => $data['correo'],
                ':rol_id' => $data['rol'],
                ':activo' => $data['estado'],
                ':id'     => $data['id']
            ];
        }
        
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