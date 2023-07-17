<?php
require_once('../../helpers/database.php');

class TallaQueries
{

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

    public function deleteRow()
    {
        $sql = 'DELETE FROM talla
                WHERE id_talla = ?';
        $params = array($this->id);
        return Database::executeRow($sql, $params);
    }
    
   
    public function createRow()
    {
        $sql = 'INSERT INTO talla(talla)
            VALUES (?)';
        $params = array($this->talla);
        return Database::executeRow($sql, $params);
    }

    public function updateRow()
    {
        $sql = 'UPDATE talla
                SET talla=?
                WHERE id_talla = ?';
        $params = array($this->talla, $this->id);
        return Database::executeRow($sql, $params);
    }

    public function searchRows($value)
    {
        $sql = 'SELECT id_talla, talla
        FROM talla
        WHERE talla ILIKE ? ';
        $params = array("%$value%");
        return Database::getRows($sql, $params);
    }

    
}