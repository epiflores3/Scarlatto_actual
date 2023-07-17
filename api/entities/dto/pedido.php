<?php
require_once('../../helpers/validator.php');
require_once('../../entities/dao/pedido_queries.php');

class Pedido extends PedidoQueries
{
    protected $id = null;
    protected $idDetalle = null;
    protected $estado_pedido = null;
    protected $fecha_pedido = null;
    protected $direccion_pedido = null;
    protected $cliente = null;
    protected $id_detalle_producto = null;
    protected $cantidad = null;
    protected $id_detalle_pedido = null;
  

    public function setId($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->id = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setIdDetalle($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->id_detalle_pedido = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setEstadoPedido($value)
    {
        if (Validator::validateAlphanumeric($value, 1, 50)) {
            $this->estado_pedido = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setFechaPedido($value)
    {
        if (Validator::validateDate($value)) {
            $this->fecha_pedido = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setDireccionPedido($value)
    {
        if (Validator::validateString($value, 1, 200)) {
            $this->direccion_pedido = $value;
            return true;
        } else {
            return false;
        } 
    }

    public function setCliente($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->cliente = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setIdProducto($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->id_detalle_producto = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setCantidad($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->cantidad = $value;
            return true;
        } else {
            return false;
        }
    }




    public function getId()
    {
        return $this->id;
    }
    public function getIdDetallePedido()
    {
        return $this->id_detalle_pedido;
    }

    public function getEstadoPedido()
    {
        return $this->estado_pedido;
    }

    public function getDireccionPedido()
    {
        return $this->direccion_pedido;
    }

    public function getFechaPedido()
    {
        return $this->fecha_pedido;
    }

    public function getCliente()
    {
        return $this->cliente;
    }

    public function getIdProducto()
    {
        return $this->id_detalle_producto;
    }

    public function getCantidad()
    {
        return $this->cantidad;
    }

 
}
