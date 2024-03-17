<?php

namespace App\Traits;

use PDO;
use App\DatabaseManager;

trait DB
{
    protected $fetchType = PDO::FETCH_ASSOC;

    /**
     * @param int $id
     * 
     * @return object
     */
    public function find($id)
    {
        $query = "SELECT * FROM {$this->table} WHERE id = :id";
        $statement = DatabaseManager::connection()->prepare($query);
        $statement->execute(['id' => $id]);
        return $this->makeInstance($statement->fetch($this->fetchType));
    }

    /**
     * @return bool
     */
    public function update()
    {
        $query = "UPDATE {$this->table} SET %s WHERE id = :id";
        $query = sprintf($query, $this->bindColumnsValues());
        $statement = DatabaseManager::connection()->prepare($query);
        return $statement->execute(array_merge(
            $this->bindValues(),
            ['id' => $this->id]
        ));
    }

    /**
     * @return object
     */
    public function save()
    {
        if (isset($this->id) && $this->id !== null) {
            $this->update();
            return $this;
        }
        
        $query = "INSERT INTO {$this->table} (%s) VALUES (%s)";

        var_dump($query, $this->bindValues());

        $query = sprintf($query, $this->bindColumns(), $this->binds());
        $statement = DatabaseManager::connection()->prepare($query);
        $statement->execute($this->bindValues());
        $this->id = DatabaseManager::connection()->lastInsertId();
        return $this;
    }

    /**
     * @return string
     */
    private function bindColumns()
    {
        return implode(', ', $this->fillable);
    }

    /**
     * @return string
     */
    private function binds()
    {
        return implode(', ', array_map(function ($attribute) {
            return ":$attribute";
        }, $this->fillable));
    }

    /**
     * @return array
     */
    private function bindValues()
    {
        $values = [];

        foreach ($this->fillable as $attribute) {
            $values[$attribute] = $this->{$attribute};
        }

        return $values;
    }

    /**
     * @return string
     */
    private function bindColumnsValues()
    {
        $columnsValues = [];

        foreach ($this->fillable as $attribute) {
            $columnsValues[] = "$attribute = :$attribute";
        }

        return implode(', ', $columnsValues);
    }

    /**
     * @return array
     */
    public function get()
    {
        $query = "SELECT * FROM {$this->table}";
        $statement = DatabaseManager::connection()->query($query);
        $rows = $statement->fetchAll($this->fetchType);

        $items = [];
        foreach ($rows as $item) {
            $items[] = $this->makeInstance($item);
        }

        return $items;
    }

    /**
     * @param $item
     * 
     * @return object
     */
    public function makeInstance($item)
    {
        $class = get_called_class();
        $instance = new $class;
        foreach ($item as $property => $value) {
            $instance->{$property} = $value;
        }
        return $instance;
    }

    /**
     * @return string
     */
    public function getTable()
    {
        return $this->table;
    }
}