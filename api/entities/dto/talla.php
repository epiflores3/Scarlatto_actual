<?php
require_once('../../helpers/validator.php');
require_once('../../entities/dao/talla_queries.php');

class Talla extends TallaQueries

{
    protected $id = null;
    protected $talla = null;

    public function setId($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->id = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setTalla($value)
    {
        if (Validator::validateAlphanumeric($value, 1, 50)) {
            $this->talla = $value;
            return true;
        } else {
            return false;
        }
    }

    public function getId()
    {
        return $this->id;
    }

    public function getTalla()
    {
        return $this->talla;
    }

}