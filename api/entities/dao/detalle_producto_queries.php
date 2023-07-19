<?php
require_once('../../helpers/database.php');

//Clase para poder tener acceso a todos de la entidad requerida
class DetalleProductoQueries
{
    //Método para realizar el mantenimiento buscar(search)
    public function searchRows($value)
    {
        $sql = 'SELECT id_detalle_producto, existencia, nombre_producto, nombre_material, talla, marca
        FROM detalle_producto
        INNER JOIN producto USING(id_producto)
        INNER JOIN material USING(id_material)
        INNER JOIN talla USING(id_talla)
        INNER JOIN marca USING(id_marca)
        WHERE existencia ILIKE ? OR nombre_producto ILIKE ? OR nombre_material ILIKE ? OR talla ILIKE ? OR marca ILIKE ?';
        $params = array("%$value%", "%$value%", "%$value%", "%$value%", "%$value%");
        return Database::getRows($sql, $params);
    }

    //Método para realizar el mantenimiento read(leer)
    public function readAll()
    {
        $sql = 'SELECT id_detalle_producto, existencia, nombre_producto, nombre_material, talla, marca
        FROM detalle_producto
        INNER JOIN producto USING(id_producto)
        INNER JOIN material USING(id_material)
        INNER JOIN talla USING(id_talla)
        INNER JOIN marca USING(id_marca)';
        return Database::getRows($sql);
    }

    public function readOne()
    {
        $sql = 'SELECT id_detalle_producto, existencia, id_producto, id_material, id_talla, id_marca
        FROM detalle_producto
        INNER JOIN producto USING(id_producto)
        INNER JOIN material USING(id_material)
        INNER JOIN talla USING(id_talla)
        INNER JOIN marca USING(id_marca)
        WHERE id_detalle_producto=?';
        $params = array($this->id);
        return Database::getRow($sql, $params);
    }

    //Método para realizar el mantenimiento crear(create)
    public function createRow()
    {
        $sql = 'INSERT INTO detalle_producto(existencia, id_producto, id_material, id_talla, id_marca)
            VALUES (?, ?, ?, ?, ?)';
        $params = array($this->existencia, $this->producto, $this->material, $this->talla, $this->marca);
        return Database::executeRow($sql, $params);
    }

    //Método para realizar el mantenimiento actualizar(update)
    public function updateRow()
    {
        $sql = 'UPDATE detalle_producto
                SET existencia = ?, id_producto = ?, id_material = ?, id_talla = ?, id_marca = ?
                WHERE id_detalle_producto = ?';
        $params = array($this->existencia, $this->producto, $this->material, $this->talla, $this->marca, $this->id);
        return Database::executeRow($sql, $params);
    }

    //Método para realizar el mantenimiento eliminar(delete)
    public function deleteRow()
    {
        $sql = 'DELETE FROM detalle_producto
                WHERE id_detalle_producto = ?';
        $params = array($this->id);
        return Database::executeRow($sql, $params);
    }

    //Se hace la consulta para mostrar los productos por marca 
    public function cantidadProductosMarcas()
    {
        $sql = 'SELECT marca, ROUND((COUNT(id_producto) * 100.0 / (SELECT COUNT(id_detalle_producto) FROM detalle_producto)), 2) porcentaje
        FROM detalle_producto
        INNER JOIN marca USING(id_marca)
        INNER JOIN producto USING(id_producto)
        GROUP BY marca ORDER BY porcentaje DESC';
        return Database::getRows($sql);
    }

    //Para hacer reporte general de tallas por material
    public function tallasPorMaterial()
    {
        $sql = 'SELECT talla, sum(existencia) suma
        FROM detalle_producto
        INNER JOIN talla USING(id_talla)
        INNER JOIN material USING(id_material)
        WHERE id_material = ?
        group by talla
        ORDER BY talla';
        $params = array($this->material);
        return Database::getRows($sql, $params);
    }

    //Para hacer reporte general de producto por material
    public function productoPorMaterial()
    {
        $sql = 'SELECT nombre_material, sum(existencia) suma
         FROM detalle_producto
         INNER JOIN material USING(id_material)
         WHERE id_producto = ?
         group by nombre_material
         ORDER BY nombre_material';
        $params = array($this->producto);
        return Database::getRows($sql, $params);
    }

    //Para hacer reporte general de tallas por marca
    public function tallasPorMarca()
    {
        $sql = 'SELECT talla, sum(existencia) suma
        FROM detalle_producto
        INNER JOIN marca USING(id_marca)
		INNER JOIN talla USING(id_talla)
        WHERE id_marca = ?
        group by talla
        ORDER BY talla';
        $params = array($this->marca);
        return Database::getRows($sql, $params);
    }


    // Se hace la consulta para que se muestre los porcentajes de los productos mas vendidos 
    public function porcentajeProducto()
    {
        $sql = 'SELECT nombre_producto, ROUND((COUNT(id_producto) * 100.0 / (SELECT COUNT(id_detalle_producto) FROM detalle_producto)), 2) porcentaje
         FROM detalle_producto
         INNER JOIN producto USING(id_producto)
         GROUP BY nombre_producto ORDER BY porcentaje DESC
         limit 6';
        return Database::getRows($sql);
    }

    // Filtra todas las tallas que le pertenecen a un producto en específico
    public function productoTalla()
    {
        $sql = 'SELECT talla, sum(existencia) suma
        FROM detalle_producto
        INNER JOIN talla USING(id_talla)
        WHERE id_producto = ? 
        group by talla
        ORDER BY talla';
        $params = array($this->producto);
        return Database::getRows($sql, $params);
    }
}
