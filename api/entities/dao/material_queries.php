<?php
require_once('../../helpers/database.php');

class MaterialQueries
{
    //´´¡

    public function searchRows($value)
    {
        $sql = 'SELECT id_material, nombre_material
        FROM material
        WHERE nombre_material ILIKE ? ';
        $params = array("%$value%");
        return Database::getRows($sql, $params);
    }

    
    public function readAll()
    {
        $sql = 'SELECT id_material, nombre_material
        FROM material';
        return Database::getRows($sql);
    }

    
    public function readOne()
    {
        $sql='SELECT * FROM material
        WHERE id_material = ?';
        $params = array($this->id);
        return Database::getRow($sql, $params);
    }

    //si
    public function deleteRow()
    {
        $sql = 'DELETE FROM material
                WHERE id_material = ?';
        $params = array($this->id);
        return Database::executeRow($sql, $params);
    }

    public function createRow()
    {
        $sql = 'INSERT INTO material(nombre_material)
            VALUES (?)';
        $params = array($this->nombre_material);
        return Database::executeRow($sql, $params);
    }

    public function updateRow()
    {
        $sql = 'UPDATE material
                SET nombre_material = ?
                WHERE id_material = ?';
        $params = array($this->nombre_material, $this->id);
        return Database::executeRow($sql, $params);
    }

    public function cantidadProductosMaterial()
    {
        $sql = 'SELECT nombre_material, COUNT(id_producto) cantidad
        FROM detalle_producto
        INNER JOIN material USING(id_material)
        INNER JOIN producto USING(id_producto)
        GROUP BY nombre_material ORDER BY cantidad DESC';
        return Database::getRows($sql);
    }


}