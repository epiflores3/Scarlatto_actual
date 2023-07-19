<?php
require_once('../../helpers/database.php');

//Clase para poder tener acceso a todos de la entidad requerida
class PedidoQueries
{
    //Método para realizar el mantenimiento buscar(search)
    public function searchRows($value)
    {
        $sql = 'SELECT id_pedido, estados_pedido, fecha_pedido, direccion_pedido, nombre_cliente
        FROM pedido
        INNER JOIN cliente USING(id_cliente)
        WHERE nombre_cliente ILIKE ? OR fecha_pedido::text ILIKE ? OR direccion_pedido ILIKE ?';
        $params = array("%$value%", "%$value%", "%$value%");
        return Database::getRows($sql, $params);
    }

    //Método para realizar el mantenimiento read(leer)
    public function readAll()
    {
        $sql = 'SELECT id_pedido, estados_pedido, fecha_pedido, direccion_pedido, nombre_cliente
        FROM pedido
        INNER JOIN cliente USING(id_cliente)';
        return Database::getRows($sql);
    }

    public function readOne()
    {
        $sql = 'SELECT id_pedido, estados_pedido, fecha_pedido, direccion_pedido, nombre_cliente, id_cliente
        FROM pedido 
        INNER JOIN cliente USING(id_cliente)
        WHERE id_pedido=?';
        $params = array($this->id);
        return Database::getRow($sql, $params);
    }

    //Método para realizar el mantenimiento eliminar(delete)
    public function deleteRow()
    {
        $sql = 'DELETE FROM pedido 
              WHERE id_pedido = ?';
        $params = array($this->id);
        return Database::executeRow($sql, $params);
    }

    //Método para realizar el mantenimiento crear(create)
    public function createRow()
    {
        $sql = 'INSERT INTO pedido(estados_pedido, fecha_pedido, direccion_pedido, id_cliente)
            VALUES (?, ?, ?, ?)';
        $params = array($this->estado_pedido, $this->fecha_pedido, $this->direccion_pedido, $this->cliente);
        return Database::executeRow($sql, $params);
    }

    //Método para realizar el mantenimiento actualizar(update)
    public function updateRow()
    {
        $sql = 'UPDATE pedido
                SET  fecha_pedido = ?, direccion_pedido = ?, id_cliente = ?, estados_pedido = ?  
                WHERE id_pedido = ?';
        $params = array($this->fecha_pedido, $this->direccion_pedido, $this->cliente, $this->estado_pedido, $this->id);

        return Database::executeRow($sql, $params);
    }

    // Método para verificar si existe un pedido en proceso para seguir comprando, de lo contrario se crea uno.
    public function startOrder()
    {
        $sql = "SELECT id_pedido
                FROM pedido
                WHERE estados_pedido = 'Pendiente' AND id_cliente = ?";
        $params = array($_SESSION['id_cliente']);

        if ($data = Database::getRow($sql, $params)) {
            $this->id = $data['id_pedido'];
            return true;
        } else {
            $sql = 'INSERT INTO pedido(direccion_pedido, id_cliente)
                    VALUES((SELECT direccion_cliente FROM cliente WHERE id_cliente = ?), ?)';
            $params = array($_SESSION['id_cliente'], $_SESSION['id_cliente']);
            // Se obtiene el ultimo valor insertado en la llave primaria de la tabla pedidos.
            if ($this->id = Database::getLastRow($sql, $params)) {
                return true;
            } else {
                return false;
            }
        }
    }


    // Método para agregar un producto al carrito de compras.
    public function createDetail()
    {
        $sql = 'INSERT INTO detalle_pedido(id_detalle_producto, precio_producto,cantidad_producto, id_pedido)
                VALUES(?, (SELECT precio_producto FROM detalle_producto WHERE id_detalle_producto = ?), ?, ?)';
        $params = array($this->id_detalle_producto, $this->id_detalle_producto, $this->cantidad, $this->id);
        return Database::executeRow($sql, $params);
    }

    // Método para obtener los productos que se encuentran en el carrito de compras.
    public function readOrderDetail()
    {
        $sql = 'SELECT id_detalle_pedido, nombre_producto, correo_cliente, detalle_pedido.precio_producto, detalle_pedido.cantidad_producto
        FROM pedido
        INNER JOIN cliente USING(id_cliente) 
        INNER JOIN detalle_pedido USING(id_pedido) 
        INNER JOIN detalle_producto USING(id_detalle_producto) 
        INNER JOIN producto USING(id_producto)
        WHERE id_pedido = ?
        group by id_detalle_pedido, nombre_producto,correo_cliente, detalle_pedido.precio_producto, detalle_pedido.cantidad_producto';
        $params = array($this->id);
        return Database::getRows($sql, $params);
    }

    //Método para finalizar un pedido por parte del cliente.
    public function finishOrder()
    {
        date_default_timezone_set('America/El_Salvador');
        $date = date('Y-m-d');
        $this->estado_pedido = 'Finalizado';
        $sql = 'UPDATE pedido
                SET estados_pedido = ?, fecha_pedido = ?
                WHERE id_pedido = ?';
        $params = array($this->estado_pedido, $date, $_SESSION['id_pedido']);
        return Database::executeRow($sql, $params);
    }

    // Método para actualizar la cantidad de un producto agregado al carrito de compras.
    public function updateDetail()
    {
        $sql = 'UPDATE detalle_pedido
                SET cantidad_producto = ?
                WHERE id_detalle_pedido = ? AND id_pedido = ?';
        $params = array($this->cantidad, $this->id_detalle_pedido, $_SESSION['id_pedido']);
        return Database::executeRow($sql, $params);
    }

    // Método para eliminar un producto que se encuentra en el carrito de compras.
    public function deleteDetail()
    {
        $sql = 'DELETE FROM detalle_pedido
                WHERE id_detalle_pedido = ? AND id_pedido = ?';
        $params = array($this->id_detalle_pedido, $_SESSION['id_pedido']);
        return Database::executeRow($sql, $params);
    }

    // Método para cargar los pedidos de mi cliente
    public function cargarHistorial()
    {
        $sql = 'SELECT id_pedido, estados_pedido, fecha_pedido, direccion_pedido
         FROM pedido
         INNER JOIN cliente USING(id_cliente)
         where id_cliente = ?';
        $params = array($this->id);
        return Database::getRows($sql, $params);
    }

    // Método poder visualizar la compra ha realizar
    public function readVerCompra()
    {
        $sql = 'SELECT id_pedido, nombre_producto, detalle_pedido.id_detalle_pedido, detalle_pedido.precio_producto, detalle_pedido.cantidad_producto, producto.descripcion_producto, producto.imagen_principal, pedido.estados_pedido 
         FROM pedido
         INNER JOIN detalle_pedido USING(id_pedido)
         INNER JOIN detalle_producto  USING(id_detalle_producto) 
         INNER JOIN producto USING(id_producto) 
         WHERE id_pedido = ?';
        $params = array($this->id);
        return Database::getRows($sql, $params);
    }

    // Metodos para el detalle del pedido

    public function readAllDetallePedido()
    {
        $sql = 'SELECT d.id_detalle_pedido, d.cantidad_producto, d.precio_producto, p.nombre_producto, d.id_pedido
        from detalle_pedido d
        inner join detalle_producto dp USING (id_detalle_producto)
        inner join producto p USING (id_producto)
        where id_pedido = ?';
        $params = array($this->id);
        return Database::getRows($sql, $params);
    }

    // Método para cargar los pedidos de mi cliente
    public function deleteDetalle($estado)
    {
        $sql = 'DELETE detalle_pedido
        WHERE id_detalle_pedido = ?';
        $params = array($estado, $this->idDetalle);
        return Database::executeRow($sql, $params);
    }

    public function readOneDetalle()
    {
        $sql = 'SELECT d.id_detalle_pedido, d.cantidad_producto, d.precio_producto, p.nombre_producto, d.id_pedido
        from detalle_pedido d
        inner join detalle_producto dp USING (id_detalle_producto)
        inner join producto p USING (id_producto)
        where id_pedido = ?';
        $params = array($this->idDetalle);
        return Database::getRow($sql, $params);
    }


    //Para hacer grafico de pastel, donde se muestra la cantidad de los pedidos por estado.
    public function CantidadEstadoPedido()
    {
        $sql = 'SELECT pedido.estados_pedido, ROUND((COUNT(id_pedido) * 100.0 / (SELECT COUNT(id_detalle_pedido) FROM detalle_pedido)), 2) porcentaje
        FROM detalle_pedido
		INNER JOIN detalle_producto USING(id_detalle_producto)
		INNER JOIN pedido USING(id_pedido)
        GROUP BY pedido.estados_pedido ORDER BY porcentaje DESC';
        return Database::getRows($sql);
    }

    //Consulta para grafico lineal top 5 fechas con mas pedidos, se crean 2 variables de uso, feha inicio, y fecha final para que funcione
    public function cantidadPedidosFechas($fecha_inicial, $fecha_final)
    {
        $sql = 'SELECT count(id_pedido) as pedidos, fecha_pedido from pedido
		where fecha_pedido between ? and ?
		group by fecha_pedido
		order by pedidos desc limit 5';
        $params = array($fecha_inicial, $fecha_final);
        return Database::getRows($sql, $params);
    }
}
