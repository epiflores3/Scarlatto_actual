<?php
require_once('../../helpers/database.php');

//Clase para poder tener acceso a todos de la entidad requerida
class ValoracionQueries
{
    //Método para realizar el mantenimiento buscar(search)
    public function readAll()
    {
        $sql = 'SELECT id_valoracion, calificacion_producto, comentario_producto, fecha_comentario, estado_comentario
        from valoracion 
        inner join detalle_pedido USING (id_detalle_pedido)
        inner join detalle_producto USING (id_detalle_producto)
        inner join producto USING (id_producto)
        where id_producto = ?';
        $params = array($this->id);
        return Database::getRows($sql, $params);
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
    public function updateRow()
    {
        $sql = 'UPDATE talla
                SET talla=?
                WHERE id_talla = ?';
        $params = array($this->talla, $this->id);
        return Database::executeRow($sql, $params);
    }

    //Método para crear la valoración 
    public function createValoComentario()
    {
        $fecha = date("d-m-Y");
        $estado = 'true';
        $sql = "INSERT INTO valoracion(calificacion_producto, comentario_producto, fecha_comentario, estado_comentario, id_detalle_pedido)
        VALUES(?, ?, ?, ?, ?)";
        $params = array($this->calificacion, $this->comentario, $fecha, $estado, $this->id_detalle_pedido);
        return Database::executeRow($sql, $params);
    }

    //Método para validar el comentraio sea exitoso
    public function validarComentario()
    {
        $sql = 'SELECT a.comentario_producto from valoracion a 
		INNER JOIN detalle_pedido b using (id_detalle_pedido)
		INNER JOIN pedido d using (id_pedido)
		INNER JOIN detalle_producto h using (id_detalle_producto)
		INNER JOIN producto c using (id_producto) 
		where id_detalle_pedido = ?';
        $params = array($this->id_detalle_pedido);
        return Database::getRow($sql, $params);
    }
}
