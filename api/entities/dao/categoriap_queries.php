<?php
require_once('../../helpers/database.php');

//Clase para poder tener acceso a todos de la entidad requerida
class CategiaQueries
{

    //Método para realizar el mantenimiento buscar(search)
    public function searchRows($value)
    {
        $sql = 'SELECT id_categoria_producto, nombre_categoria
        FROM categoria_producto
        WHERE nombre_categoria ILIKE ?';
        $params = array("%$value%");
        return Database::getRows($sql, $params);
    }

    //Método para realizar el mantenimiento read(leer)
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

    //Método para realizar el mantenimiento crear(create)
    public function createRow()
    {
        $sql = 'INSERT INTO categoria_producto(nombre_categoria)
            VALUES (?)';
        $params = array($this->nombre_categoria);
        return Database::executeRow($sql, $params);
    }

    //Método para realizar el mantenimiento actualizar(update)
    public function updateRow()
    {
        $sql = 'UPDATE categoria_producto
                SET nombre_categoria=?
                WHERE id_categoria_producto = ?';
        $params = array($this->nombre_categoria, $this->id);
        return Database::executeRow($sql, $params);
    }

    //Método para realizar el mantenimiento eliminar(delete)
    public function deleteRow()
    {
        $sql = 'DELETE FROM categoria_producto
                WHERE id_categoria_producto = ?';
        $params = array($this->id);
        return Database::executeRow($sql, $params);
    }
}
