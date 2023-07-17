<?php
require_once('../../helpers/validator.php');
require_once('../../entities/dao/usuario_queries.php');

class Usuario extends UsuarioQueries
{
    protected $id = null;
    protected $nombres = null;
    protected $apellidos = null;
    protected $correo = null;
    protected $alias = null;
    protected $clave = null;
    protected $tipousuario = null;
    protected $estadousuario = null;

    public function setId($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->id = $value;
            return true;
        } else {
            return false;
        }
    }


    public function setNombres($value)
    {
        if (Validator::validateAlphabetic($value, 1, 50)) {
            $this->nombres = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setApellidos($value)
    {
        if (Validator::validateAlphabetic($value, 1, 50)) {
            $this->apellidos = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setCorreo($value)
    {
        if (Validator::validateEmail($value)) {
            $this->correo = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setAlias($value)
    {
        if (Validator::validateAlphanumeric($value, 1, 50)) {
            $this->alias = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setClave($value)
    {
        if (Validator::validatePassword($value)) {
            
            $this->clave = password_hash($value, PASSWORD_DEFAULT);
            return true;
        } else {
            return false;
        }
    }

    public function setTipousuario($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            
            $this->tipousuario = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setEstadousuario($value)
    {
        if (Validator::validateBoolean($value)) {
            
            $this->estadousuario = $value;
            return true;
        } else {
            return false;
        }
    }

    public function getId()
    {
        return $this->id;
    }

    public function getNombres()
    {
        return $this->nombres;
    }

    public function getApellidos()
    {
        return $this->apellidos;
    }

    public function getCorreo()
    {
        return $this->correo;
    }

    public function getAlias()
    {
        return $this->alias;
    }

    public function getClave()
    {
        return $this->clave;
    }

    public function getTipousuario()
    {
        return $this->tipousuario;
    }
    public function getEstadousuario()
    {
        return $this->estadousuario;
    }
   
}

