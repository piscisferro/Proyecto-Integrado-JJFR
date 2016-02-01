<?php
// Clase abstracta blogDB
abstract class restDB {
    // Atributos estaticos con la informacion de la conexion
    private static $server = 'localhost';
    private static $comidadb = "comida";
    private static $bebidadb = "bebida";
    private static $user = 'root';
    private static $password = '';

    // Funcion estatica para conectar con al base de datos
    public static function connectComidaDB() {
        try {
          $connection = new PDO("mysql:host=".self::$server.";dbname=".self::$comidadb.";charset=utf8", self::$user, self::$password);
        } catch (PDOException $e) {
          echo "No se ha podido establecer conexión con el servidor de bases de datos.<br>";
          die ("Error: " . $e->getMessage());
        }

        return $connection;
    }
    
    // Funcion estatica para conectar con al base de datos
    public static function connectBebidaDB() {
        try {
          $connection = new PDO("mysql:host=".self::$server.";dbname=".self::$bebidadb.";charset=utf8", self::$user, self::$password);
        } catch (PDOException $e) {
          echo "No se ha podido establecer conexión con el servidor de bases de datos.<br>";
          die ("Error: " . $e->getMessage());
        }

        return $connection;
    }
}
