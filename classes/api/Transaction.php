<?php
class Transaction
{
    private function __construct(){}

    /** @var \PDO */
    private static $conn;

    /** @var Logger */
    private static $logger;
    
    /**
     * open
     *
     * @param  string $database
     * @return void
     */
    public static function open(string $database)
    {
        self::$conn = Connection::open($database);
        self::$conn->beginTransaction();
        self::$logger = null;
    }
    
    /**
     * close
     *
     * 
     */
    public static function close()
    {
        if (self::$conn) {
            self::$conn->commit();
            self::$conn = null;
        }
    }
    
    /**
     * get [pega a trasação ativa]
     *
     * @return self::$conn
     */
    public static function get()
    {
        return self::$conn;
    }
    
    /**
     * rollback [desfaz se algo der errado]
     *
     * @return void
     */
    public static function rollback()
    {
        if (self::$conn) {
            self::$conn->rollBack();
        }
        
    }
    
    /**
     * setLogger
     * design patterns strategy END injection dependency
     * @param  Logger $logger
     * @return void
     */
    public static function setLogger(Logger $logger)
    {
        self::$logger = $logger;
    }
        
    /**
     * log
     *
     * @param  string $message
     * @return void
     */
    public static function log(string $message)
    {
        if (self::$logger) {
            self::$logger->write($message);
        }
    }
}