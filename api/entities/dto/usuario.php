<?php
require_once('../../helpers/validator.php');
require_once('../../entities/dao/usuario_queries.php');

//Clases que se utilizarán para poder manejar los datos de la entidad correspondiente
class Usuario extends UsuarioQueries
{
    //Declarar los atributos de los campos que se encuentran en la tabla correspondiente
    protected $id = null;
    protected $nombres = null;
    protected $apellidos = null;
    protected $correo = null;
    protected $alias = null;
    protected $clave = null;
    protected $tipousuario = null;
    protected $estadousuario = null;

    //Método para validar dependiendo del dato que se utiliza, asimismo asignarle los valores de los atributos
    public function setId($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->id = $value;
            return true;
        } else {
            return false;
        }
    }

    //Método para validar dependiendo del dato que se utiliza, asimismo asignarle los valores de los atributos
    public function setNombres($value)
    {
        if (Validator::validateAlphabetic($value, 1, 50)) {
            $this->nombres = $value;
            return true;
        } else {
            return false;
        }
    }

    //Método para validar dependiendo del dato que se utiliza, asimismo asignarle los valores de los atributos
    public function setApellidos($value)
    {
        if (Validator::validateAlphabetic($value, 1, 50)) {
            $this->apellidos = $value;
            return true;
        } else {
            return false;
        }
    }

    //Método para validar dependiendo del dato que se utiliza, asimismo asignarle los valores de los atributos
    public function setCorreo($value)
    {
        if (Validator::validateEmail($value)) {
            $this->correo = $value;
            return true;
        } else {
            return false;
        }
    }

    //Método para validar dependiendo del dato que se utiliza, asimismo asignarle los valores de los atributos
    public function setAlias($value)
    {
        if (Validator::validateAlphanumeric($value, 1, 50)) {
            $this->alias = $value;
            return true;
        } else {
            return false;
        }
    }

    //Método para validar dependiendo del dato que se utiliza, asimismo asignarle los valores de los atributos
    public function setClave($value)
    {
        if (Validator::validatePassword($value)) {

            $this->clave = password_hash($value, PASSWORD_DEFAULT);
            return true;
        } else {
            return false;
        }
    }

    //Método para validar dependiendo del dato que se utiliza, asimismo asignarle los valores de los atributos
    public function setTipousuario($value)
    {
        if (Validator::validateNaturalNumber($value)) {

            $this->tipousuario = $value;
            return true;
        } else {
            return false;
        }
    }

    //Método para validar dependiendo del dato que se utiliza, asimismo asignarle los valores de los atributos
    public function setEstadousuario($value)
    {
        if (Validator::validateBoolean($value)) {

            $this->estadousuario = $value;
            return true;
        } else {
            return false;
        }
    }

    //Método para obtener los valores de los atributos correspondientes
    public function getId()
    {
        return $this->id;
    }

    //Método para obtener los valores de los atributos correspondientes
    public function getNombres()
    {
        return $this->nombres;
    }

    //Método para obtener los valores de los atributos correspondientes
    public function getApellidos()
    {
        return $this->apellidos;
    }

    //Método para obtener los valores de los atributos correspondientes
    public function getCorreo()
    {
        return $this->correo;
    }

    //Método para obtener los valores de los atributos correspondientes
    public function getAlias()
    {
        return $this->alias;
    }

    //Método para obtener los valores de los atributos correspondientes
    public function getClave()
    {
        return $this->clave;
    }

    //Método para obtener los valores de los atributos correspondientes
    public function getTipousuario()
    {
        return $this->tipousuario;
    }

    //Método para obtener los valores de los atributos correspondientes
    public function getEstadousuario()
    {
        return $this->estadousuario;
    }
}
