<?php

namespace Core;

use Core\Database\QueryAbstract;

abstract class ModelAbstract{

    /** @var QueryAbstract */
    private $_query;

    /**
     * @return QueryAbstract
     */
    public function getQuery()
    {
        return $this->_query;
    }

    /**
     * @param QueryAbstract $query
     */
    public function setQuery($query)
    {
        $this->_query = $query;
    }

    /**
     * @param $data
     * @return mixed
     */
    public abstract function map($data);

    /**
     * @return mixed
     */
    public abstract function save();

    /**
     * @return mixed
     */
    public abstract function update();

}