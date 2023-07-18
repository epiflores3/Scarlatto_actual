<?php
require_once('../../helpers/database.php');

//Clase para poder tener acceso a todos de la entidad requerida
class TallaQueries
{
    //Método para realizar el mantenimiento read(leer)
    public function readAll()
    {
        $sql = 'SELECT id_talla, talla
        FROM talla';
        return Database::getRows($sql);
    }

    public function readOne()
    {
        $sql = 'SELECT id_talla, talla 
        FROM talla
        WHERE id_talla = ?';
        $params = array($this->id);
        return Database::getRow($sql, $params);
    }

    //Método para realizar el mantenimiento eliminar(delete)
    public function deleteRow()
    {
        $sql = 'DELETE FROM talla
                WHERE id_talla = ?';
        $params = array($this->id);
        return Database::executeRow($sql, $params);
    }

    //Método para realizar el mantenimiento actualizar(update)
    public function createRow()
    {
        $sql = 'INSERT INTO talla(talla)
            VALUES (?)';
        $params = array($this->talla);
        return Database::executeRow($sql, $params);
    }

    //Método para realizar el mantenimiento actualizar(update)
    public function updateRow()
    {
        $sql = 'UPDATE talla
                SET talla=?
                WHERE id_talla = ?';
        $params = array($this->talla, $this->id);
        return Database::executeRow($sql, $params);
    }

    //Método para realizar el mantenimiento buscar(search)
    public function searchRows($value)
    {
        $sql = 'SELECT id_talla, talla
        FROM talla
        WHERE talla ILIKE ? ';
        $params = array("%$value%");
        return Database::getRows($sql, $params);
    }
}
