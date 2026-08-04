<?php
define('DB_HOST', getenv('DB_HOST') ?: '127.0.0.1');
define('DB_PORT', getenv('DB_PORT') ?: '3309');
define('DB_NAME', getenv('DB_NAME') ?: 'sweet_dreams');
define('DB_USER', getenv('DB_USER') ?: 'root');
define('DB_PASS', getenv('DB_PASS') ?: '');
define('DB_CHARSET', getenv('DB_CHARSET') ?: 'utf8mb4');

class Database{
    private static $conexion = null;

    public static function getConexion(){
        if( self::$conexion === null){
            try{
                $dsn = 'mysql:host='. DB_HOST.
                ';port='. DB_PORT.
                ';dbname='. DB_NAME .
                ';charset=' . DB_CHARSET;

                self::$conexion = new PDO($dsn,DB_USER,DB_PASS ,[
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES => false,
                ]);
            }catch(PDOException $ex){
                die("Error de conexion de la base de datos" . $ex->getMessage());
            }
        }
        return self::$conexion;
    }
    
    private function __clone(){}
    private function __construct(){}
}
?>