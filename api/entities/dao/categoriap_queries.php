<?php
require_once('../../helpers/database.php');

class CategiaQueries
{

    public function searchRows($value)
    {
        $sql = 'SELECT id_categoria_producto, nombre_categoria
        FROM categoria_producto
        WHERE nombre_categoria ILIKE ?';
        $params = array("%$value%");
        return Database::getRows($sql, $params);
    }

    public function readAll()
    {
        $sql = 'SELECT id_categoria_producto, nombre_categoria
        FROM categoria_producto';
        return Database::getRows($sql);
    }

    public function readOne()
    {
        $sql = 'SELECT id_categoria_producto, nombre_categoria
        FROM categoria_producto
        WHERE id_categoria_producto =?';
        $params = array($this->id);
        return Database::getRow($sql, $params);
    }

    public function createRow()
    {
        $sql = 'INSERT INTO categoria_producto(nombre_categoria)
            VALUES (?)';
        $params = array($this->nombre_categoria);
        return Database::executeRow($sql, $params);
    }

    public function updateRow()
    {
        $sql = 'UPDATE categoria_producto
                SET nombre_categoria=?
                WHERE id_categoria_producto = ?';
        $params = array($this->nombre_categoria, $this->id);
        return Database::executeRow($sql, $params);
    }

    public function deleteRow()
    {
        $sql = 'DELETE FROM categoria_producto
                WHERE id_categoria_producto = ?';
        $params = array($this->id);
        return Database::executeRow($sql, $params);
    }


}