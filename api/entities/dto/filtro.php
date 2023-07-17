<?php
require_once('../../helpers/validator.php');
require_once('../../entities/dao/filtro_queries.php');

class Filtro extends FiltroQueries 
{

    protected $id = null;
    protected $nombre_producto = null;

    public function setId($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->id = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setProducto($value)
    {
        if (Validator::validateAlphanumeric($value, 1, 50)) {
            $this->nombre_producto = $value;
            return true;
        } else {
            return false;
        }
    }

    public function getId()
    {
        return $this->id;
    }

    public function getProducto()
    {
        return $this->nombre_producto;
    }


}