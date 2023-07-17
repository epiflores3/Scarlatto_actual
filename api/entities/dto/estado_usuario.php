<?php
require_once('../../helpers/validator.php');
require_once('../../entities/dao/estado_usuario_queries.php');

class EstadoUs extends EstadoUsuarioQueries

{
    protected $id = null;
    protected $estadous = null;

    public function setId($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->id = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setTipous($value)
    {
        if (Validator::validateAlphanumeric($value, 1, 50)) {
            $this->estadous = $value;
            return true;
        } else {
            return false;
        }
    }

    public function getId()
    {
        return $this->id;
    }

    public function getTipous()
    {
        return $this->estadous;
    }

}
