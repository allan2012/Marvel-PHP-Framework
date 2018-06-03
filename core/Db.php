<?php

class Db
{
    // The server host
    public $host;
    
    /*
     * Database username
     */
    public $username;
    
    /*
     * Database password
     */
    public $password;
    
    /*
     * Database name
     */
    public $database;
    
    /*
     * query string innitializer
     */
    public $q;
    
    /*
     * table name
     */
    public $table;
    
    /*
     * WHERE query string
     */
    public $where;
    private $query_string;
    private $connection;
    private $limit;
    private $order_by;
    
    /*
     * Resultset Holder
     */
    private $result;

    public function __construct()
    {
        $this->query_string = '';       

        $this->host = HOST;

        $this->username = USERNAME;

        $this->password = PASSWORD;

        $this->database = DATABASE;

        $this->order_by = '';
        
        $this->where = '';

        $this->limit = '';
        
        $this->table = '';
        
        $this->result = [];


        try {
            $this->connection = new PDO("mysql:host={$this->host};dbname={$this->database}", $this->username, $this->password);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
    }

    /**
     * Set table name
     * 
     * @param type $table
     * @return \Db
     */
    public function table($table)
    {
        $this->table = $table;

        return $this;
    }

    /**
     * Table row insert
     * 
     * @param array $data
     * @return \Db
     */
    public function insert($data)
    {
        $field_names_array = array_keys($data);

        $field_values_array = array_values($data);

        $fields_string = implode(',', $field_names_array);

        $value_string = '"' . implode('","', $field_values_array) . '"';

        $this->connection->exec("INSERT INTO {$this->table}($fields_string) "
                . "VALUES($value_string)");

        return $this;
    }

    /**
     * Set delete string
     * 
     * @return \Db
     */
    public function delete()
    {
        $this->connection->exec("DELETE FROM {$this->table} {$this->where}");

        return $this;
    }

    /**
     * Update table with array associative array of fields as keys and values 
     * 
     * @param array
     * @return bool
     */
    public function update($data)
    {
        foreach ($data as $key => $val) {
            $this->query_string .= " {$key} = '{$val}' ";
        }

        $this->q = "UPDATE  {$this->table} SET {$this->query_string} {$this->where}";

        $this->connection->exec($this->q);

        return $this;
    }

    /**
     * Set query raw string
     * 
     * @param type $query_string
     * @return \Db
     */
    public function raw($query_string)
    {
        $this->q = $query_string;

        return $this;
    }

    /**
     * Select query string
     * 
     * @param type $query_string
     * @return \Db
     */
    public function select($query_string = '*')
    {
        $this->q = "SELECT {$query_string} FROM "
                . "{$this->table} "
                . "{$this->where} "
                . "{$this->order_by} "
                . "{$this->limit}";

        return $this;
    }

    /**
     * Update where string
     * 
     * @param type $field
     * @param type $val
     * @return \Db
     */
    public function where($field, $val)
    {
        $this->where = "WHERE $field = '$val' ";

        return $this;
    }

    /**
     * Get result array
     * 
     * @return array
     */
    public function get()
    {
        $query = $this->connection->prepare($this->q);

        $query->execute();

        $result = $query->fetchAll(PDO::FETCH_OBJ);

        return $result;
    }

    /** 
     * Limit the rows returned
     * 
     * @param int $val
     * @return string
     */
    public function limit($val)
    {
        return "LIMIT $val";
    }

    /**
     * Get one row only
     * 
     * @return array
     */
    public function first()
    {
        $query = $this->connection->prepare($this->q);

        $query->execute();

        $result = $query->fetch(PDO::FETCH_OBJ);

        return $result;
    }

    /** Order the result set by field in ASC or DESC order
     * 
     * @param string $field
     * @param string $order
     * @return string
     */
    public function orderBy($field, $order)
    {
        return $this->order_by = "ORDER BY {$field} {$order}";
    }

    /**
     * Return query result count
     * 
     * @return int
     */
    public function rowCount()
    {
        $query = $this->connection->prepare($this->q);

        $query->execute();

        return (int) $query->rowCount();
    }

    /*
     * Checks if a row is returned
     * 
     * @return Boolean
     */
    public function exists()
    {
        $query = $this->connection->prepare($this->q);

        $query->execute();

        return ($query->rowCount() > 0) ? true : false;

    }

    /**
     * Class __desctruct() will close connection after all query exection 
     * 
     */
    public function __destruct()
    {
        $this->connection = null;
    }

}
