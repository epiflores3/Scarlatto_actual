<?php
require_once('../../helpers/database.php');

//Clase para poder tener acceso a todos de la entidad requerida
class TipoUsuarioQueries
{
    //Método para realizar el mantenimiento read(leer)
    public function readAll()
    {
        $sql = 'SELECT id_tipo_usuario, tipo_usuario
        FROM tipo_usuario';
        return Database::getRows($sql);
    }
}
