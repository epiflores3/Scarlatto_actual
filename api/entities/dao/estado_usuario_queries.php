<?php
require_once('../../helpers/database.php');

class EstadoUsuarioQueries
{

    public function readAll()
    {
        $sql = 'SELECT id_estado_usuario, estado_usuario
        FROM estado_usuario';
        return Database::getRows($sql);
    }

}