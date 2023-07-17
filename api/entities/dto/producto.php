<?php
require_once('../../helpers/validator.php');
require_once('../../entities/dao/producto_queries.php');

class Producto extends ProductoQueries
{
    protected $id = null;
    protected $idvalo = null;
    protected $nombrep = null;
    
    protected $imgp = null;

    protected $descripp = null;
    // protected $preciop = null;
    protected $estadop = null;
    protected $descuentop = null;
    protected $usuario = null;
    protected $categp = null;
    protected $talla = null;
    
    protected $ruta = '../../imagenes/productos/';


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
        if (Validator::validateNaturalNumber($value)) {
            $this->talla = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setIdValo($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->idvalo = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setNombre($value)
    {
        if (Validator::validateAlphanumeric($value, 1, 50)) {
            $this->nombrep = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setImagen($file)
    {
        if (Validator::validateImageFile($file, 500, 500)) {
            $this->imgp = Validator::getFileName();
            return true;
        } else {
            return false;
        }
    }

    public function setDescripcion($value)
    {
        if (Validator::validateString($value, 1, 250)) {
            $this->descripp = $value;
            return true;
        } else {
            return false;
        }
    }

    // public function setPrecio($value)
    // {
    //     if (Validator::validateMoney($value)) {
    //         $this->preciop = $value;
    //         return true;
    //     } else {
    //         return false;
    //     }
    // }

    public function setEstadoProductos($value)
    {
        if (Validator::validateBoolean($value)) {
            $this->estadop = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setDescuento($value)
    {
        if (Validator::validateMoney($value)) {
            $this->descuentop = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setUsuario($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->usuario = $value;
            return true;
        } else {
            return false;
        }
    }

    
    public function setCategoria($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->categp = $value;
            return true;
        } else {
            return false;
        }
    }

    public function getId()
    {
        return $this->id;
    }

    public function getIdValo()
    {
        return $this->idvalo;
    }


    public function getNombre()
    {
        return $this->nombrep;
    }

    public function getImagen()
    {
        return $this->imgp;
    }


    public function getDescripcion()
    {
        return $this->descripp;
    }

    // public function getPrecio()
    // {
    //     return $this->preciop;
    // }

    public function getEstado()
    {
        return $this->estadop;
    }

    public function getDescuento()
    {
        return $this->descuentop;
    }

    public function getUsuario()
    {
        return $this->usuario;
    }

    public function getCategoria()
    {
        return $this->categp;
    }

    public function getRuta()
    {
        return $this->ruta;
    }
}
