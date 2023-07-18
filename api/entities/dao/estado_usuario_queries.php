<?php
require_once('../../helpers/database.php');

//Clase para poder tener acceso a todos de la entidad requerida
class EstadoUsuarioQueries
{

    //Método para realizar el mantenimiento read(leer)
    public function readAll()
    {
        $sql = 'SELECT id_estado_usuario, estado_usuario
        FROM estado_usuario';
        return Database::getRows($sql);
    }
}
