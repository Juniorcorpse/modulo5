<?php

class Connection
{
    private function __construct(){}
     /** @const array */
     private const OPTIONS = [
        \PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
        \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
        \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_OBJ,
        \PDO::ATTR_CASE => \PDO::CASE_NATURAL
    ];

    public static function open(string $name)
    {
        if (file_exists("config/{$name}.ini")) {
            $db = parse_ini_file("config/{$name}.ini");
        }else{
            throw new Exception("Error Processing Request", 1);            
        }

        $user = isset($db['user']) ? $db['user'] : null;
        $pass = isset($db['pass']) ? $db['pass'] : null;
        $name = isset($db['name']) ? $db['name'] : null;
        $host = isset($db['host']) ? $db['host'] : null;
        $type = isset($db['type']) ? $db['type'] : null;
        $port = isset($db['port']) ? $db['port'] : null;

        switch ($type) {
            case 'pgsql':
                $port = isset($db['port']) ? $db['port'] : '5432';
                $conn = new PDO("{$type}:dbname={$name}; options=\'--client_encoding=UTF8\'; user={$user}; password={$pass}; host={$host}; port={$port}");
                break;
            case 'sqlite':
                $conn = new PDO("{$type}:{$name}");
                break;            
            default:
                $port = isset($db['port']) ? $db['port'] : '3306';
                $conn = new PDO("{$type}:host={$host}; port={$port}; dbname={$name}", $user, $pass, self::OPTIONS);
                break;
        }
        if ($type !== 'mysql') {
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        return $conn;
    }
}