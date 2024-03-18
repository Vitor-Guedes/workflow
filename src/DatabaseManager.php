<?php

namespace App;

use PDO;
use Exception;

class DatabaseManager
{
    protected static $instance;

    protected $pdo;

    public $hasActiveTransaction = false;

    public static function getSingleton()
    {
        if (! static::$instance) {
            static::$instance = new static;
            static::$instance->connect();
        }
        return static::$instance;
    }

    /**
     * @return void
     */
    protected function connect() : void
    {
        try {
            $conn = new PDO('mysql:host=mysql;dbname=workflow', 'root', 'root');
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->pdo = $conn;
        } catch(Exception $e) {
            $response = new \Symfony\Component\HttpFoundation\Response(
                'Database Error: ' . $e->getMessage(),
                501
            );
            $response->send();
            exit(0);
        }
    }

    /**
     * @return null|PDO
     */
    public function getPdo()
    {
        return $this->pdo;
    }

    /**
     * @return PDO
     */
    public static function connection()
    {
        return static::getSingleton()->getPdo();
    }

    public static function getSingletonWithoutDatabase()
    {
        if (! static::$instance) {
            static::$instance = new static;
            static::$instance->connectWithoutDatabase();
        }
        return static::$instance;
    }

    /**
     * @return void
     */
    public function connectWithoutDatabase()
    {
        try {
            $conn = new PDO('mysql:host=mysql', 'root', 'root');
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->pdo = $conn;
        } catch(Exception $e) {
            $response = new \Symfony\Component\HttpFoundation\Response(
                'Database Error: ' . $e->getMessage(),
                501
            );
            $response->send();
            exit(0);
        }
    }

    public static function beginTransaction()
    {
        if (self::getSingleton()->hasActiveTransaction) {
            return ;
        }
        self::getSingleton()->getPdo()->beginTransaction();
        self::getSingleton()->hasActiveTransaction = true;
    }

    public static function commit()
    {
        if (self::getSingleton()->hasActiveTransaction) {
            self::getSingleton()->getPdo()->commit();
            self::getSingleton()->hasActiveTransaction = false;
        }
    }

    public static function rollback()
    {
        if (self::getSingleton()->hasActiveTransaction) {
            self::getSingleton()->getPdo()->rollback();
            self::getSingleton()->hasActiveTransaction = false;
        }
    }
}