<?php
require_once('../../helpers/validator.php');
require_once('../../entities/dao/material_queries.php');

class Material extends MaterialQueries
{
    protected $id = null;
    protected $nombre_material= null;

    public function setId($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->id = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setMaterial($value)
    {
        if (Validator::validateAlphanumeric($value, 1, 50)) {
            $this->nombre_material = $value;
            return true;
        } else {
            return false;
        }
    }

    public function getId()
    {
        return $this->id;
    }

    public function getMaterial()
    {
        return $this->nombre_material;
    }

}