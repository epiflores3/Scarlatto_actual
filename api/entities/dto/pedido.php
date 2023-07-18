<?php
require_once('../../helpers/validator.php');
require_once('../../entities/dao/pedido_queries.php');

//Clases que se utilizarán para poder manejar los datos de la entidad correspondiente
class Pedido extends PedidoQueries
{
    //Declarar los atributos de los campos que se encuentran en la tabla correspondiente
    protected $id = null;
    protected $idDetalle = null;
    protected $estado_pedido = null;
    protected $fecha_pedido = null;
    protected $direccion_pedido = null;
    protected $cliente = null;
    protected $id_detalle_producto = null;
    protected $cantidad = null;
    protected $id_detalle_pedido = null;

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
    public function setIdDetalle($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->id_detalle_pedido = $value;
            return true;
        } else {
            return false;
        }
    }

    //Método para validar dependiendo del dato que se utiliza, asimismo asignarle los valores de los atributos
    public function setEstadoPedido($value)
    {
        if (Validator::validateAlphanumeric($value, 1, 50)) {
            $this->estado_pedido = $value;
            return true;
        } else {
            return false;
        }
    }

    //Método para validar dependiendo del dato que se utiliza, asimismo asignarle los valores de los atributos
    public function setFechaPedido($value)
    {
        if (Validator::validateDate($value)) {
            $this->fecha_pedido = $value;
            return true;
        } else {
            return false;
        }
    }

    //Método para validar dependiendo del dato que se utiliza, asimismo asignarle los valores de los atributos
    public function setDireccionPedido($value)
    {
        if (Validator::validateString($value, 1, 200)) {
            $this->direccion_pedido = $value;
            return true;
        } else {
            return false;
        }
    }

    //Método para validar dependiendo del dato que se utiliza, asimismo asignarle los valores de los atributos
    public function setCliente($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->cliente = $value;
            return true;
        } else {
            return false;
        }
    }

    //Método para validar dependiendo del dato que se utiliza, asimismo asignarle los valores de los atributos
    public function setIdProducto($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->id_detalle_producto = $value;
            return true;
        } else {
            return false;
        }
    }

    //Método para validar dependiendo del dato que se utiliza, asimismo asignarle los valores de los atributos
    public function setCantidad($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->cantidad = $value;
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
    public function getIdDetallePedido()
    {
        return $this->id_detalle_pedido;
    }

    //Método para obtener los valores de los atributos correspondientes
    public function getEstadoPedido()
    {
        return $this->estado_pedido;
    }

    //Método para obtener los valores de los atributos correspondientes
    public function getDireccionPedido()
    {
        return $this->direccion_pedido;
    }

    //Método para obtener los valores de los atributos correspondientes
    public function getFechaPedido()
    {
        return $this->fecha_pedido;
    }

    //Método para obtener los valores de los atributos correspondientes
    public function getCliente()
    {
        return $this->cliente;
    }

    //Método para obtener los valores de los atributos correspondientes
    public function getIdProducto()
    {
        return $this->id_detalle_producto;
    }

    //Método para obtener los valores de los atributos correspondientes
    public function getCantidad()
    {
        return $this->cantidad;
    }
}
