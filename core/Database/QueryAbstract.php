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

    /** @var array */
    private $_order;

    /**
     * QueryAbstract constructor.
     * @throws \Exception
     */
    public function __construct(){
        $this->_connection = PDOConnection::getConnection('default');
        $this->_table = null;
        $this->_where = [];
        $this->_offset = null;
        $this->_order = [];
        $this->_limit = null;
    }

    /**
     * @return \PDO
     */
    protected function connection(){
        return $this->_connection;
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
            $where = " WHERE ";
            foreach ($this->_where as $clause){
                $where .= "{$clause['condition']} = '{$clause['value']}'";
                $where .= $count > 1 ? " AND " : "";
                $count --;
            }
            $this->_query .= $where;
        }

        if(!empty($this->_order)){
            $count = count($this->_order);
            $order = " ORDER BY ";
            foreach ($this->_order as $value){
                $order .= "{$value['column']} {$value['order']}";
                $order .= $count > 1 ? ", " : "";
                $count --;
            }
            $this->_query .= $order;
        }

        if(!is_null($this->_limit)){
            $this->_query .= " LIMIT {$this->_limit}";
        }

        if(!is_null($this->_offset)){
            $this->_query .= " OFFSET {$this->_offset}";
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
     * @return mixed
     */
    protected function fetchOneCriteria(){
        $query = $this->build();
        return $this->_connection->query($query)->fetch();
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
        $this->_connection->exec($sql);
    }

    /**
     * @param null $table
     * @param array $data
     * @param null $where
     */
    public function update($table = null, $data = [], $where = null){
        $update = [];

        $table = is_null($table) ? $this->_table : $table;

        foreach ($data as $key => $value){
            $update[] =  "$key = '$value'";
        }

        $condition = [];
        if (!is_null($where)){
            foreach ($where as $key => $value){
                $condition[] =  "$key = '$value'";
            }
        }

        $sql = "UPDATE {$table} SET " . implode(', ', $update) . " WHERE " . implode(', ', $condition);
        $this->_connection->query($sql)->execute();
    }

    /**
     * @param $table
     * @return $this
     */
    public function from($table){
        $this->_table = $table;
        return $this;
    }

    /**
     * @param $condition
     * @param $value
     * @return $this
     */
    public function where($condition, $value){
        $this->_where[] = ['condition' => $condition, 'value' => $value];
        return $this;
    }

    /**
     * @param $num
     * @return $this
     */
    public function limit($num){
        $this->_limit = $num;
        return $this;
    }

    /**
     * @param $num
     * @return $this
     */
    public function offset($num){
        $this->_offset = $num;
        return $this;
    }

    /**
     * @param $column
     * @param $type
     * @return $this
     */
    public function order($column, $type){
        $this->_order[] = ['column' => $column, 'order' => $type];
        return $this;
    }

    /**
     * @return mixed
     */
    public abstract function count();

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