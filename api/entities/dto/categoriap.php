<?php
require_once('../../helpers/validator.php');
require_once('../../entities/dao/categoriap_queries.php');

class Categoria extends CategiaQueries 
{

    protected $id = null;
    protected $nombre_categoria = null;

    public function setId($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->id = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setCategoria($value)
    {
        if (Validator::validateAlphanumeric($value, 1, 50)) {
            $this->nombre_categoria = $value;
            return true;
        } else {
            return false;
        }
    }

    public function getId()
    {
        return $this->id;
    }

    public function getCategoria()
    {
        return $this->nombre_categoria;
    }


}