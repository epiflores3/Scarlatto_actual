<?php
require_once('../../helpers/validator.php');
require_once('../../entities/dao/producto_queries.php');

//Clases que se utilizarán para poder manejar los datos de la entidad correspondiente
class Producto extends ProductoQueries
{
    //Declarar los atributos de los campos que se encuentran en la tabla correspondiente
    protected $id = null;
    protected $idvalo = null;
    protected $nombrep = null;
    protected $imgp = null;
    protected $descripp = null;
    protected $estadop = null;
    protected $descuentop = null;
    protected $usuario = null;
    protected $categp = null;
    protected $talla = null;
    protected $ruta = '../../imagenes/productos/';


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
    public function setTalla($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->talla = $value;
            return true;
        } else {
            return false;
        }
    }

    //Método para validar dependiendo del dato que se utiliza, asimismo asignarle los valores de los atributos
    public function setIdValo($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->idvalo = $value;
            return true;
        } else {
            return false;
        }
    }

    //Método para validar dependiendo del dato que se utiliza, asimismo asignarle los valores de los atributos
    public function setNombre($value)
    {
        if (Validator::validateAlphanumeric($value, 1, 50)) {
            $this->nombrep = $value;
            return true;
        } else {
            return false;
        }
    }

    //Método para validar dependiendo del dato que se utiliza, asimismo asignarle los valores de los atributos
    public function setImagen($file)
    {
        if (Validator::validateImageFile($file, 500, 500)) {
            $this->imgp = Validator::getFileName();
            return true;
        } else {
            return false;
        }
    }

    //Método para validar dependiendo del dato que se utiliza, asimismo asignarle los valores de los atributos
    public function setDescripcion($value)
    {
        if (Validator::validateString($value, 1, 250)) {
            $this->descripp = $value;
            return true;
        } else {
            return false;
        }
    }

    //Método para validar dependiendo del dato que se utiliza, asimismo asignarle los valores de los atributos
    public function setEstadoProductos($value)
    {
        if (Validator::validateBoolean($value)) {
            $this->estadop = $value;
            return true;
        } else {
            return false;
        }
    }

    //Método para validar dependiendo del dato que se utiliza, asimismo asignarle los valores de los atributos
    public function setDescuento($value)
    {
        if (Validator::validateMoney($value)) {
            $this->descuentop = $value;
            return true;
        } else {
            return false;
        }
    }

    //Método para validar dependiendo del dato que se utiliza, asimismo asignarle los valores de los atributos
    public function setUsuario($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->usuario = $value;
            return true;
        } else {
            return false;
        }
    }

    //Método para validar dependiendo del dato que se utiliza, asimismo asignarle los valores de los atributos
    public function setCategoria($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->categp = $value;
            return true;
        } else {
            return false;
        }
    }

    //Método para validar dependiendo del dato que se utiliza, asimismo asignarle los valores de los atributos
    public function getId()
    {
        return $this->id;
    }

    //Método para validar dependiendo del dato que se utiliza, asimismo asignarle los valores de los atributos
    public function getIdValo()
    {
        return $this->idvalo;
    }


    //Método para validar dependiendo del dato que se utiliza, asimismo asignarle los valores de los atributos
    public function getNombre()
    {
        return $this->nombrep;
    }

    //Método para validar dependiendo del dato que se utiliza, asimismo asignarle los valores de los atributos
    public function getImagen()
    {
        return $this->imgp;
    }


    //Método para validar dependiendo del dato que se utiliza, asimismo asignarle los valores de los atributos
    public function getDescripcion()
    {
        return $this->descripp;
    }

    //Método para obtener los valores de los atributos correspondientes
    public function getEstado()
    {
        return $this->estadop;
    }

    //Método para obtener los valores de los atributos correspondientes
    public function getDescuento()
    {
        return $this->descuentop;
    }

    //Método para obtener los valores de los atributos correspondientes
    public function getUsuario()
    {
        return $this->usuario;
    }

    //Método para obtener los valores de los atributos correspondientes
    public function getCategoria()
    {
        return $this->categp;
    }

    //Método para obtener los valores de los atributos correspondientes
    public function getRuta()
    {
        return $this->ruta;
    }
}
