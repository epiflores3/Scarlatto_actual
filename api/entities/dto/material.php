<?php
require_once('../../helpers/validator.php');
require_once('../../entities/dao/material_queries.php');

//Clases que se utilizarán para poder manejar los datos de la entidad correspondiente
class Material extends MaterialQueries
{
    //Declarar los atributos de los campos que se encuentran en la tabla correspondiente
    protected $id = null;
    protected $nombre_material = null;

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
    public function setMaterial($value)
    {
        if (Validator::validateAlphanumeric($value, 1, 50)) {
            $this->nombre_material = $value;
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
    public function getMaterial()
    {
        return $this->nombre_material;
    }
}
