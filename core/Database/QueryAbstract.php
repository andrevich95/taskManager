<?php

namespace Core\Database;

abstract class QueryAbstract{

    /** @var \PDO */
    private $_connection;

    /** @var string */
    private $_query;

    /** @var string */
    private $_table;

    /** @var array|null */
    private $_where;

    /** @var integer */
    private $_limit;

    /** @var integer */
    private $_offset;

    /**
     * QueryAbstract constructor.
     * @throws \Exception
     */
    public function __construct(){
        $this->_connection = PDOConnection::getConnection('default');
        $this->_table = null;
        $this->_where = [];
        $this->_offset = null;
        $this->_limit = null;
    }

    /**
     * @return bool|string
     */
    protected function build(){
        if(is_null($this->_table)){
            return false;
        }

        $this->_query = "SELECT * FROM {$this->_table}";

        if(!empty($this->_where)){
            $count = count($this->_where);
            $where = "WHERE ";
            foreach ($this->_where as $clause){
                $where .= "{$clause['condition']} = {$clause['value']}";
                $where .= $count > 1 ? " AND " : "";
                $count --;
            }
            $this->_query .= $where;
        }


        if(!is_null($this->_offset)){
            $this->_query .= "OFFSET {$this->_offset}";
        }

        if(!is_null($this->_limit)){
            $this->_query .= "LIMIT {$this->_limit}";
        }

        return $this->_query;
    }

    /**
     * @param $id
     * @return bool
     */
    protected function fetchOne($id){
        return $this->_connection->query("SELECT * FROM {$this->_table} WHERE ID = {$id} LIMIT 1")->fetch();
    }

    /**
     * @return array
     */
    protected function fetchAll(){
        $query = $this->build();
        return $this->_connection->query($query)->fetchAll();
    }

    /**
     * @param null $table
     * @param array $data
     */
    public function insert($table = null, $data = []){
        $keys = array_keys($data);
        $values = array_values($data);

        $table = is_null($table) ? $this->_table : $table;

        $sql = "INSERT INTO {$table} (". implode(',',$keys) . ") VALUES (" . implode(',', array_map(function ($value){ return "'{$value}'";}, $values)) . ")";
        $this->_connection->query($sql)->execute();
    }

    /**
     * @param $table
     * @param $where
     * @param $data
     */
    public function update($table = null, $data = [], $where = null){
        $update = [];

        $table = is_null($table) ? $this->_table : $table;

        foreach ($data as $key => $value){
            $update[] =  "$key = $value";
        }

        $condition = [];
        if (!is_null($where)){
            foreach ($where as $key => $value){
                $condition[] =  "$key = $value";
            }
        }

        $sql = "UPDATE {$table} SET " . implode(', ', $update) . implode(', ', $condition);
        $this->_connection->query($sql)->execute();
    }

    /**
     * @param $table
     * @return $this
     */
    protected function from($table){
        $this->_table = $table;
        return $this;
    }

    /**
     * @param $condition
     * @param $value
     * @return $this
     */
    protected function where($condition, $value){
        $this->_where[] = ['condition' => $condition, 'value' => $value];
        return $this;
    }

    /**
     * @param $num
     * @return $this
     */
    protected function limit($num){
        $this->_limit = $num;
        return $this;
    }

    /**
     * @param $num
     * @return $this
     */
    protected function offset($num){
        $this->_offset = $num;
        return $this;
    }

    /**
     * @param $id
     * @return mixed
     */
    public abstract function findOne($id);

    /**
     * @return mixed
     */
    public abstract function findAll();

}