<?php
require_once('../../helpers/validator.php');
require_once('../../entities/dao/tipo_usuario_queries.php');

class TipoUs extends TipoUsuarioQueries

{
    protected $id = null;
    protected $tipo = null;

    public function setId($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->id = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setTipo($value)
    {
        if (Validator::validateAlphanumeric($value, 1, 50)) {
            $this->tipo = $value;
            return true;
        } else {
            return false;
        }
    }

    public function getId()
    {
        return $this->id;
    }

    public function getTipo()
    {
        return $this->tipo;
    }

}