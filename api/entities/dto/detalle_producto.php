<?php
require_once('../../helpers/validator.php');
require_once('../../entities/dao/detalle_producto_queries.php');

//Clases que se utilizarán para poder manejar los datos de la entidad correspondiente
class DetalleProducto extends DetalleProductoQueries
{
    //Declarar los atributos de los campos que se encuentran en la tabla correspondiente
    protected $id = null;
    protected $existencia = null;
    protected $producto = null;
    protected $material = null;
    protected $talla = null;
    protected $marca = null;
    protected $precio = null;

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
    public function setExistencia($value)
    {
        if (Validator::validateAlphanumeric($value, 1, 50)) {
            $this->existencia = $value;
            return true;
        } else {
            return false;
        }
    }

    //Método para validar dependiendo del dato que se utiliza, asimismo asignarle los valores de los atributos
    public function setProducto($value)
    {
        if (Validator::validateAlphanumeric($value, 1, 50)) {
            $this->producto = $value;
            return true;
        } else {
            return false;
        }
    }

    //Método para validar dependiendo del dato que se utiliza, asimismo asignarle los valores de los atributos
    public function setPrecio($value)
    {
        if (Validator::validateMoney($value)) {
            $this->producto = $value;
            return true;
        } else {
            return false;
        }
    }

    //Método para validar dependiendo del dato que se utiliza, asimismo asignarle los valores de los atributos
    public function setMaterial($value)
    {
        if (Validator::validateAlphanumeric($value, 1, 50)) {
            $this->material = $value;
            return true;
        } else {
            return false;
        }
    }

    //Método para validar dependiendo del dato que se utiliza, asimismo asignarle los valores de los atributos
    public function setTalla($value)
    {
        if (Validator::validateAlphanumeric($value, 1, 50)) {
            $this->talla = $value;
            return true;
        } else {
            return false;
        }
    }

    //Método para validar dependiendo del dato que se utiliza, asimismo asignarle los valores de los atributos
    public function setMarca($value)
    {
        if (Validator::validateAlphanumeric($value, 1, 50)) {
            $this->marca = $value;
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
    public function getExistencia()
    {
        return $this->talla;
    }
    //Método para obtener los valores de los atributos correspondientes
    public function getProducto()
    {
        return $this->producto;
    }

    //Método para obtener los valores de los atributos correspondientes
    public function getMaterial()
    {
        return $this->material;
    }

    //Método para obtener los valores de los atributos correspondientes
    public function getTalla()
    {
        return $this->talla;
    }

    //Método para obtener los valores de los atributos correspondientes
    public function getPrecio()
    {
        return $this->precio;
    }

    //Método para obtener los valores de los atributos correspondientes
    public function getMarca()
    {
        return $this->marca;
    }
}
