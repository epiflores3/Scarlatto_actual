<?php
// Se incluye la clase con las plantillas para generar reportes.
require_once('../../helpers/report.php');
// Se incluyen las clases para la transferencia y acceso a datos.
require_once('../../entities/dto/producto.php');
require_once('../../entities/dto/detalle_producto.php');

// Se instancia la clase para crear el reporte.
$pdf = new Report;
// Se inicia el reporte con el encabezado del documento.
$pdf->startReport('Productos por tallas');
// Se instancia el módelo Categoría para obtener los datos.
$producto = new Producto;
// Se verifica si existen registros para mostrar, de lo contrario se imprime un mensaje.
if ($dataProducto = $producto->readAll()) {
    // Se establece un color de relleno para los encabezados.
    $pdf->setFillColor(175);
    // Se establece la fuente para los encabezados.
    $pdf->setFont('Times', 'B', 11);
    // Se imprimen las celdas con los encabezados.
    // $pdf->cell(126, 10, 'Nombre', 1, 0, 'C', 1);
    $pdf->cell(93, 10, 'Talla', 1, 0, 'C', 1);
    $pdf->cell(93, 10, 'Existencias', 1, 1, 'C', 1);

    // Se establece un color de relleno para mostrar el nombre de la categoría.
    $pdf->setFillColor(225);
    // Se establece la fuente para los datos de los productos.
    $pdf->setFont('Times', '', 11);

    // Se recorren los registros fila por fila.
    foreach ($dataProducto as $rowProducto) {
        // Se imprime una celda con el nombre de la categoría.
        $pdf->cell(0, 10, $pdf->encodeString('Nombre del producto: ' . $rowProducto['nombre_producto']), 1, 1, 'C', 1);
        // Se instancia el módelo Producto para procesar los datos.
        $detalle_producto = new DetalleProducto;
        // Se establece la categoría para obtener sus productos, de lo contrario se imprime un mensaje de error.
        if ($detalle_producto->setProducto($rowProducto['id_producto'])) {
            // Se verifica si existen registros para mostrar, de lo contrario se imprime un mensaje.
            if ($dataDetalleProducto = $detalle_producto->productoTalla()) {
                // Se recorren los registros fila por fila.
                foreach ($dataDetalleProducto as $rowProducto) {
                    // ($rowMaterial['estado_producto']) ? $estado = 'Activo' : $estado = 'Inactivo';
                    // Se imprimen las celdas con los datos de los productos.
                    $pdf->cell(93, 10, $pdf->encodeString($rowProducto['talla']), 1, 0);
                    $pdf->cell(93, 10, $rowProducto['suma'], 1, 1);
                 
                }
            } else {
                $pdf->cell(0, 10, $pdf->encodeString('No hay tallas para productos'), 1, 1);
            }
        } else {
            $pdf->cell(0, 10, $pdf->encodeString('Producto incorrecto o inexistente'), 1, 1);
        }
    }
} else {
    $pdf->cell(0, 10, $pdf->encodeString('No hay tallas por productos para mostrar'), 1, 1);
}
// Se llama implícitamente al método footer() y se envía el documento al navegador web.
$pdf->output('I', 'Producto-tallas.pdf');
