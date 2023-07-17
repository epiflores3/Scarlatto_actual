<?php
// Se incluye la clase con las plantillas para generar reportes.
require_once('../../helpers/report.php');
// Se incluyen las clases para la transferencia y acceso a datos.
require_once('../../entities/dto/producto.php');
require_once('../../entities/dto/marca.php');

// Se instancia la clase para crear el reporte.
$pdf = new Report;
// Se inicia el reporte con el encabezado del documento.
$pdf->startReport('Producto por marca');
// Se instancia el módelo Categoría para obtener los datos.
$marca = new Marca;
// Se verifica si existen registros para mostrar, de lo contrario se imprime un mensaje.
if ($dataMarca = $marca->readAll()) {
    // Se establece un color de relleno para los encabezados.
    $pdf->setFillColor(175);
    // Se establece la fuente para los encabezados.
    $pdf->setFont('Times', 'B', 11);
    // Se imprimen las celdas con los encabezados.
    // $pdf->cell(126, 10, 'Nombre', 1, 0, 'C', 1);
    $pdf->cell(93, 10, 'Producto', 1, 0, 'C', 1);
    $pdf->cell(93, 10, 'Existencias:', 1, 1, 'C', 1);

    // Se establece un color de relleno para mostrar el nombre de la categoría.
    $pdf->setFillColor(225);
    // Se establece la fuente para los datos de los productos.
    $pdf->setFont('Times', '', 11);

    // Se recorren los registros fila por fila.
    foreach ($dataMarca as $rowMarca) {
        // Se imprime una celda con el nombre de la categoría.
        $pdf->cell(0, 10, $pdf->encodeString('Marca: ' . $rowMarca['marca']), 1, 1, 'C', 1);
        // Se instancia el módelo Producto para procesar los datos.
        $producto = new Producto;
        // Se establece la marca para obtener sus productos, de lo contrario se imprime un mensaje de error.
        if ($producto->setNombre($rowMarca['id_marca'])) {
            // Se verifica si existen registros para mostrar, de lo contrario se imprime un mensaje.
            if ($producto = $producto->ProductosPorMarca()) {
                // Se recorren los registros fila por fila.
                foreach ($producto as $rowProc) {
                    // ($rowMaterial['estado_producto']) ? $estado = 'Activo' : $estado = 'Inactivo';
                    // Se imprimen las celdas con los datos de los productos.
                    $pdf->cell(93, 10, $pdf->encodeString($rowProc['nombre_producto']), 1, 0);
                    $pdf->cell(93, 10, $rowProc['suma'], 1, 1);
                 
                }
            } else {
                $pdf->cell(0, 10, $pdf->encodeString('No hay producto para marcas'), 1, 1);
            }
        } else {
            $pdf->cell(0, 10, $pdf->encodeString('Marca incorrecto o inexistente'), 1, 1);
        }
    }
} else {
    $pdf->cell(0, 10, $pdf->encodeString('No hay producto por marca para mostrar'), 1, 1);
}
// Se llama implícitamente al método footer() y se envía el documento al navegador web.
$pdf->output('I', 'Producto-Marca.pdf');
