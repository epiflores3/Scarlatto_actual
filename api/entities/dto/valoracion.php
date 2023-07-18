<?php
require_once('../../helpers/validator.php');
require_once('../../entities/dao/valoracion_queries.php');

//Clases que se utilizarán para poder manejar los datos de la entidad correspondiente
class Valoracion extends ValoracionQueries

{
    //Declarar los atributos de los campos que se encuentran en la tabla correspondiente
    protected $id = null;
    protected $estado = null;
    protected $comentario = null;
    protected $calificacion = null;
    protected $estado_comentario = null;
    protected $fecha = null;
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
     public function setIdDetallePedido($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->id_detalle_pedido = $value;
            return true;
        } else {
            return false;
        }
    }

     //Método para validar dependiendo del dato que se utiliza, asimismo asignarle los valores de los atributos
     public function setEstado($value)
    {
        if (Validator::validateAlphanumeric($value, 1, 50)) {
            $this->estado = $value;
            return true;
        } else {
            return false;
        }
    }

     //Método para validar dependiendo del dato que se utiliza, asimismo asignarle los valores de los atributos
     public function setCalificacion($value)
    {
        if (Validator::validateAlphanumeric($value, 1, 50)) {
            $this->calificacion = $value;
            return true;
        } else {
            return false;
        }
    }

     //Método para validar dependiendo del dato que se utiliza, asimismo asignarle los valores de los atributos
     public function setComentario($value)
    {
        if (Validator::validateAlphanumeric($value, 1, 50)) {
            $this->comentario = $value;
            return true;
        } else {
            return false;
        }
    }


     //Método para validar dependiendo del dato que se utiliza, asimismo asignarle los valores de los atributos
     public function setEstadoComentario($value)
    {
        if (Validator::validateBoolean($value)) {
            $this->estado_comentario = $value;
            return true;
        } else {
            return false;
        }
    }

     //Método para validar dependiendo del dato que se utiliza, asimismo asignarle los valores de los atributos
     public function setFechaComenatrio($value)
    {
        if (Validator::validateDate($value)) {
            $this->fecha = $value;
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
    public function getEstado()
    {
        return $this->estado;
    }

    //Método para obtener los valores de los atributos correspondientes
    public function getEstadoComentario()
    {
        return $this->estado_comentario;
    }

    //Método para obtener los valores de los atributos correspondientes
    public function getFechaComentario()
    {
        return $this->fecha;
    }

    //Método para obtener los valores de los atributos correspondientes
    public function getComentario()
    {
        return $this->comentario;
    }

    //Método para obtener los valores de los atributos correspondientes
    public function getCalificacion()
    {
        return $this->calificacion;
    }
}
