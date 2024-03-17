<?php

namespace App;

use PDO;
use Exception;

class DatabaseManager
{
    protected static $instance;

    protected $pdo;

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
            echo 'ERROR: ' . $e->getMessage();
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
}