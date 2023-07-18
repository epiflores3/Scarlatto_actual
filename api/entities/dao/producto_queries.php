<?php
require_once('../../helpers/database.php');

class ProductoQueries
{

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
    
    public function readAll()
    {
        $sql = 'SELECT id_producto, nombre_producto, imagen_principal, descripcion_producto, estado_producto, descuento_producto, nombre_usuario, nombre_categoria
        FROM producto
        INNER JOIN usuario USING(id_usuario)
        INNER JOIN categoria_producto USING(id_categoria_producto)';
        return Database::getRows($sql);
    }

    
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

  /**CARGAR TODOS LOS PRODUCTOS */
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

//     /*CARGAR PRODUCTOS MAS PEDIDOS*/

    // public function readProductosMasVendidos()
    // {
    //     $sql = 'SELECT nombre_producto, precio_producto, nombre_categoria, nombre_material, talla, imagen_principal
    //     from (
    //         select d.id_producto, d.nombre_producto,d.imagen_principal,o.precio_producto, n.nombre_categoria, h.nombre_material, v.talla,
    //         count (*) as cantidad_producto,
    //         rank() over (order by count(*) desc) as rango
    //         from detalle_pedido o
    //         inner join detalle_producto u on u.id_detalle_producto = o.id_detalle_producto
    //         inner join talla v on v.id_talla = u.id_talla
    //         inner join material h on h.id_material = u.id_material
    //         inner join producto d on d.id_producto = u.id_producto
    //         inner join categoria_producto n on n.id_categoria_producto = d.id_categoria_producto
    //         group by d.id_producto, d.nombre_producto,d.imagen_principal, o.precio_producto, n.nombre_categoria, h.nombre_material, v.talla
    //     )sub
    //     order by rango asc, id_producto asc
    //     limit 4';
    //     return Database::getRows($sql);
    // }

    public function deleteRowValo($estado)
    {
        ($estado) ? $estado=0 : $estado=1;
        $sql = 'UPDATE valoracion
        SET estado_comentario = ?
        WHERE id_valoracion = ?';
        $params = array($estado, $this->idvalo);
        return Database::executeRow($sql, $params);
    }

    public function readOneValo()
    {
        $sql = 'SELECT id_valoracion, calificacion_producto, comentario_producto, fecha_comentario, estado_comentario, id_detalle_pedido
        FROM valoracion
        WHERE id_valoracion = ?';
        $params = array($this->idvalo);
        return Database::getRow($sql, $params);
    }

//      /****************************************************/
//     /* Leer un solo registro*/
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
     /****************************************************/


    public function createRow()
    {
        $sql = 'INSERT INTO producto(nombre_producto, imagen_principal, descripcion_producto, estado_producto, descuento_producto, id_usuario, id_categoria_producto)
            VALUES (?, ?, ?, ?, ?, ?, ?)';
        $params = array($this->nombrep, $this->imgp, $this->descripp, $this->estadop, $this->descuentop, $this->usuario, $this->categp);
        return Database::executeRow($sql, $params);
    }


    public function deleteRow()
    {
        $sql = 'DELETE FROM producto
                WHERE id_producto = ?';
        $params = array($this->id);
        return Database::executeRow($sql, $params);
    }
    

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
        return Database::getRows($sql,  $params );
    }

    public function readPrecioProducto()
    {
        $sql = 'SELECT  precio_producto
        FROM detalle_producto
         WHERE id_producto = ? AND id_talla=?';
        $params = array($this->id, $this->talla);
        return Database::getRow($sql, $params);
    }

    //CARGAR LOS COMENTARIOS//
    public function cargarComentarios(){

        $sql="SELECT b.comentario_producto, b.fecha_comentario, b.calificacion_producto, e.nombre_cliente, c.nombre_producto, b.id_valoracion, c.id_producto, h.id_detalle_producto, b.estado_comentario
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