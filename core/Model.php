<?php

namespace Core;

use PDO;
// este model es la clase maestra de todos los modelos, es decir que todos los modelos heredan de esta clase
class Model
{
    protected static $db = null;

    public function __construct()
    {
        // Solo si el model se instancia tras un dispatch MVC:
        if (defined('MVC_DISPATCHED') && ! Auth::user()) {
            throw new \Exception('Acceso no autorizado');
        }
        if (self::$db === null) {
            $dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8';
            // Crea tu conexión aquí solo si no existe
            self::$db = new \PDO($dsn, DB_USER, DB_PASS);
            self::$db->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        }
        return self::$db; // el db es la variable que contiene la conexión a la base de datos, y es estática para que todos los modelos compartan la misma conexión
    }
    /**
     * Mágico: intercepta llamadas a métodos de instancia y vuelve a chequear autenticación.
     */
    public function __call($name, $arguments)
    {
        if (!Auth::user()) {
            throw new \Exception('Acceso no autorizado. Debes iniciar sesión.');
        }
        return call_user_func_array([$this, $name], $arguments);
    }

    public static function getDB(): PDO
    {        // ← getter público
        return self::$db;
    }

}
