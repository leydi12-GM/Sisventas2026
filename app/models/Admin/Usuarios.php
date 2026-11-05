<?php
namespace App\Models\Admin;

use Core\Model;
use PDO;

class Usuarios extends Model{ 

    protected $table = 'usuarios'; 

    public function registrar($data){
        $sql = "INSERT INTO {$this->table} (nombre, apellidos, email, telefono, password_hash, rol_id) VALUES (:nombre, :apellidos, :email, :telefono, :password_hash, :rol_id)";
        $params = [
            ':nombre'        => trim($data['nombre']),
            ':apellidos'     => trim($data['apellidos']),
            ':email'         => trim($data['correo']),
            ':telefono'      => !empty($data['telefono']) ? trim($data['telefono']) : null,
            ':password_hash' => $data['password'], 
            ':rol_id'        => $data['rol'] 
        ];

        $preparado = self::$db->prepare($sql);
        return $preparado->execute($params);
    }

    public function buscar(){ 
        $sql = "SELECT u.id, u.nombre, u.apellidos, u.email AS correo, u.telefono, u.rol_id AS rol, r.nombre AS rol_nombre, u.activo 
                FROM {$this->table} u
                LEFT JOIN roles r ON u.rol_id = r.id 
                ORDER BY u.id ASC";
        $preparado = self::$db->prepare($sql);
        $preparado->execute();
        return $preparado->fetchAll(PDO::FETCH_ASSOC);
    }

    public function ver(Int $id){
        $params = [':id' => $id];
        $sql = "SELECT id, nombre, apellidos, email AS correo, telefono, rol_id AS rol, activo FROM {$this->table} WHERE id=:id";
        $preparado = self::$db->prepare($sql);
        $preparado->execute($params);
        return $preparado->fetch(PDO::FETCH_ASSOC); 
    }

    public function actualizar($data){
        if(!empty($data['password'])){
            $sql = "UPDATE {$this->table} SET nombre=:nombre, apellidos=:apellidos, email=:email, telefono=:telefono, password_hash=:password_hash, rol_id=:rol_id, activo=:activo WHERE id=:id";
            $params = [
                ':nombre'        => trim($data['nombre']),
                ':apellidos'     => trim($data['apellidos']),
                ':email'         => trim($data['correo']),
                ':telefono'      => !empty($data['telefono']) ? trim($data['telefono']) : null,
                ':password_hash' => $data['password'],
                ':rol_id'        => $data['rol'],
                ':activo'        => $data['estado'],
                ':id'            => $data['id']
            ];
        } else {
            $sql = "UPDATE {$this->table} SET nombre=:nombre, apellidos=:apellidos, email=:email, telefono=:telefono, rol_id=:rol_id, activo=:activo WHERE id=:id";
            $params = [
                ':nombre'    => trim($data['nombre']),
                ':apellidos' => trim($data['apellidos']),
                ':email'     => trim($data['correo']),
                ':telefono'  => !empty($data['telefono']) ? trim($data['telefono']) : null,
                ':rol_id'    => $data['rol'],
                ':activo'    => $data['estado'],
                ':id'        => $data['id']
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

    public function obtenerRoles(){
        try {
            $sql = "SELECT id, nombre FROM roles ORDER BY id ASC";
            $preparado = self::$db->prepare($sql);
            $preparado->execute();
            return $preparado->fetchAll(PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            return [];
        }
    }
}
