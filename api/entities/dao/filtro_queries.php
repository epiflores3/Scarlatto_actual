<?php
require_once('../../helpers/database.php');

class FiltroQueries
{
     /*
    *   Métodos para realizar las operaciones de buscar(search) de marca
    */
   

    public function readAllAnillo()
    {
        $sql = "SELECT producto.id_producto,producto.nombre_producto,producto.imagen_principal, producto.descripcion_producto, talla.talla, categoria_producto.nombre_categoria, material.nombre_material, marca.marca
        from detalle_producto
        INNER JOIN producto   USING(id_producto)
        INNER JOIN talla   USING(id_talla)
        INNER JOIN marca USING(id_marca)
        INNER JOIN material USING(id_material)
        INNER JOIN categoria_producto USING(id_categoria_producto)
        where  categoria_producto.nombre_categoria='Compromiso' and producto.nombre_producto like 'Anillo%' ";
        return Database::getRows($sql);
    }

  
}