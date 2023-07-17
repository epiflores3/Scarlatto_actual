<?php
require_once('../../helpers/validator.php');
require_once('../../entities/dao/detalle_producto_queries.php');

class DetalleProducto extends DetalleProductoQueries
{
    protected $id = null;
    protected $existencia = null;
    protected $producto = null;
    protected $material = null;
    protected $talla = null;
    protected $marca = null;
    protected $precio = null;


    public function setId($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->id = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setExistencia($value)
    {
        if (Validator::validateAlphanumeric($value, 1, 50)) {
            $this->existencia = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setProducto($value)
    {
        if (Validator::validateAlphanumeric($value, 1, 50)) {
            $this->producto = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setPrecio($value)
    {
        if (Validator::validateMoney($value)) {
            $this->producto = $value;
            return true;
        } else {
            return false;
        }
    }


    public function setMaterial($value)
    {
        if (Validator::validateAlphanumeric($value, 1, 50)) {
            $this->material = $value;
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

    public function setMarca($value)
    {
        if (Validator::validateAlphanumeric($value, 1, 50)) {
            $this->marca = $value;
            return true;
        } else {
            return false;
        }
    }

    public function getId()
    {
        return $this->id;
    }

    public function getExistencia()
    {
        return $this->talla;
    }
    public function getProducto()
    {
        return $this->producto;
    }

    public function getMaterial()
    {
        return $this->material;
    }
    public function getTalla()
    {
        return $this->talla;
    }

    public function getPrecio()
    {
        return $this->precio;
    }

    public function getMarca()
    {
        return $this->marca;
    }
}