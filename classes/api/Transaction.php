<?php
class Transaction
{
    private function __construct(){}

    /** @var \PDO */
    private static $conn;

    public static function open(string $database)
    {
        self::$conn = Connection::open($database);
        self::$conn->beginTransaction();
    }

    public static function close()
    {
        if (self::$conn) {
            self::$conn->commit();
            self::$conn = null;
        }
    }

    public static function get()
    {
        return self::$conn;
    }

    public static function rollback()
    {
        if (self::$conn) {
            self::$conn->rollBack();
        }
        
    }
}