<?php
require_once('../../helpers/database.php');

//Clase para poder tener acceso a todos de la entidad requerida
class ProductoQueries
{
    //Método para realizar el mantenimiento buscar(search)
    public function searchRows($value)
    {
        $sql = 'SELECT id_producto, nombre_producto, imagen_principal, descripcion_producto, precio_producto, estado_producto, descuento_producto, correo_usuario, nombre_categoria
        FROM producto
        INNER JOIN usuario USING(id_usuario)
        INNER JOIN categoria_producto USING(id_categoria_producto)
        WHERE nombre_producto ILIKE ? OR precio_producto::Text ILIKE ? OR estado_producto ILIKE ? OR correo_usuario ILIKE ? OR nombre_categoria ILIKE ?';
        $params = array("%$value%", "%$value%", "%$value%");
        return Database::getRows($sql, $params);
    }

    //Método para realizar el mantenimiento read(leer)
    public function readAll()
    {
        $sql = 'SELECT id_producto, nombre_producto, imagen_principal, descripcion_producto, estado_producto, descuento_producto, nombre_usuario, nombre_categoria
        FROM producto
        INNER JOIN usuario USING(id_usuario)
        INNER JOIN categoria_producto USING(id_categoria_producto)';
        return Database::getRows($sql);
    }

    //Método para poder leer los productos que se han adquiridos
    public function readOneProductosPrivados()
    {
        $sql = 'SELECT id_producto, nombre_producto, imagen_principal, descripcion_producto, estado_producto, descuento_producto, id_usuario, id_categoria_producto
        FROM producto
        INNER JOIN usuario USING(id_usuario)
        INNER JOIN categoria_producto USING(id_categoria_producto)
        WHERE id_producto=?';
        $params = array($this->id);
        return Database::getRow($sql, $params);
    }

    //Método para leer todas las valoraciones, es decir, el mantenimiento leer
    public function readAllValoracion()
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

    //Método para cargar todos los productos
    public function readProductos()
    {
        $sql = 'SELECT id_producto, imagen_principal, nombre_producto, descripcion_producto, nombre_categoria, nombre_material, talla , marca
        FROM detalle_producto
        INNER JOIN producto USING(id_producto)
        INNER JOIN categoria_producto USING(id_categoria_producto)
        INNER JOIN material USING(id_material)
        INNER JOIN marca USING(id_marca)
        INNER JOIN talla USING(id_talla)';
        return Database::getRows($sql);
    }


    //Método para realizar el mantenimiento eliminar(delete)
    public function deleteRowValo($estado)
    {
        ($estado) ? $estado = 0 : $estado = 1;
        $sql = 'UPDATE valoracion
        SET estado_comentario = ?
        WHERE id_valoracion = ?';
        $params = array($estado, $this->idvalo);
        return Database::executeRow($sql, $params);
    }

    //Método para leer una valoración
    public function readOneValo()
    {
        $sql = 'SELECT id_valoracion, calificacion_producto, comentario_producto, fecha_comentario, estado_comentario, id_detalle_pedido
        FROM valoracion
        WHERE id_valoracion = ?';
        $params = array($this->idvalo);
        return Database::getRow($sql, $params);
    }

    //Método para leer un producto
    public function readOne()
    {
        $sql = 'SELECT id_producto, imagen_principal, nombre_producto, descripcion_producto, descuento_producto, nombre_categoria, nombre_material, talla , marca
        FROM detalle_producto
        INNER JOIN producto USING(id_producto)
        INNER JOIN categoria_producto USING(id_categoria_producto)
        INNER JOIN material USING(id_material)
        INNER JOIN marca USING(id_marca)
        INNER JOIN talla USING(id_talla)
        WHERE id_producto = ?';
        $params = array($this->id);
        return Database::getRow($sql, $params);
    }

    //Método para realizar el mantenimiento crear(create)
    public function createRow()
    {
        $sql = 'INSERT INTO producto(nombre_producto, imagen_principal, descripcion_producto, estado_producto, descuento_producto, id_usuario, id_categoria_producto)
            VALUES (?, ?, ?, ?, ?, ?, ?)';
        $params = array($this->nombrep, $this->imgp, $this->descripp, $this->estadop, $this->descuentop, $this->usuario, $this->categp);
        return Database::executeRow($sql, $params);
    }

    //Método para realizar el mantenimiento eliminar(delete)
    public function deleteRow()
    {
        $sql = 'DELETE FROM producto
                WHERE id_producto = ?';
        $params = array($this->id);
        return Database::executeRow($sql, $params);
    }

    //Método para realizar el mantenimiento actualizar(update)
    public function updateRow($current_image)
    {
        ($this->imgp) ? Validator::deleteFile($this->getRuta(), $current_image) : $this->imgp = $current_image;

        $sql = 'UPDATE producto
                SET imagen_principal = ?, nombre_producto = ?, descripcion_producto = ?, estado_producto = ?, descuento_producto = ?, id_usuario = ?, id_categoria_producto = ?
                WHERE id_producto = ?';
        $params = array($this->imgp, $this->nombrep, $this->descripp,  $this->estadop, $this->descuentop, $this->usuario, $this->categp, $this->id);
        return Database::executeRow($sql, $params);
    }

    // Método para obtener las tallas de un producto.
    public function readTallasProducto()
    {
        $sql = 'SELECT id_talla, talla
        FROM talla
        INNER JOIN detalle_producto USING(id_talla) WHERE id_producto = ?';
        $params = array($this->id);
        return Database::getRows($sql, $params);
    }

    // Método para obtener los materiales de un producto.
    public function readMaterialesProducto()
    {
        $sql = 'SELECT id_material, nombre_material
        FROM material
        INNER JOIN detalle_producto USING(id_material) WHERE id_producto = ?';
        $params = array($this->id);
        return Database::getRows($sql,  $params);
    }

    // Método para obtener el precio del producto
    public function readPrecioProducto()
    {
        $sql = 'SELECT  precio_producto
        FROM detalle_producto
         WHERE id_producto = ? AND id_talla=?';
        $params = array($this->id, $this->talla);
        return Database::getRow($sql, $params);
    }

    //Método para cargar comentarios
    public function cargarComentarios()
    {

        $sql = "SELECT b.comentario_producto, b.fecha_comentario, b.calificacion_producto, e.nombre_cliente, c.nombre_producto, b.id_valoracion, c.id_producto, h.id_detalle_producto, b.estado_comentario
		from valoracion b 
		INNER JOIN detalle_pedido a using (id_detalle_pedido)
		INNER JOIN pedido d using (id_pedido)
		INNER JOIN cliente e using (id_cliente)
		INNER JOIN detalle_producto h using (id_detalle_producto)
		INNER JOIN producto c using (id_producto) 
		where id_producto = ? and estado_comentario = 'true'";
        $params = array($this->id);
        return Database::getRows($sql, $params);
    }

    //Para hacer reporte general de tallas por material
    public function ProductoPorMaterial()
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

     //Función para hacer reporte general de productos por marca
    public function ProductosPorMarca()
    {
        $sql = 'SELECT nombre_producto, sum(existencia) suma
         FROM detalle_producto
         INNER JOIN marca USING(id_marca)
         INNER JOIN producto USING(id_producto)
         WHERE id_marca = ?
         group by nombre_producto
         ORDER BY nombre_producto';
        $params = array($this->nombrep);
        return Database::getRows($sql, $params);
    }
}
