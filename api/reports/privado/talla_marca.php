<?php
// Se manda a traer el archivo que actua como plantilla para los reportes
require_once('../../helpers/report.php');
//Se mandan a traer las clases donde se encuentran los gets y los sets que usaremos en el reporte
require_once('../../entities/dto/detalle_producto.php');
require_once('../../entities/dto/marca.php');

// Se crea un objeto de la clase reporte.
$pdf = new Report;
// Se coloca un titulo al documento.
$pdf->startReport('Tallas por marca');
// Se instancia el módelo Categoría para obtener los datos.
$marca = new Marca;
// Verifica si exiten registros a mostrar.
if ($dataMarca = $marca->readAll()) {
    // Se pone un color al encabezado.
    $pdf->setFillColor(175);
    // Se pone una fuente.
    $pdf->setFont('Times', 'B', 11);
        // Se rellenan las celdas del encabezado.

    // Significado de los numeros de cell: 
        // Primero es el ancho de la celda
        // Segundo el alto de la celda
        // Tercero El valor que tendra la celda: TEXTO
        // Cuarto Indica si se dibujan los bordes alrededor de la celda: 0 Sin bordes, 1 Marco, o tambien L izquierda, T arriba, R derecha, B abajo
        // Quinto indica donde puede ir la posición: 0 A la derecha, 1 Al comienzo de la siguiente línea, 2 Abajo
        // Sexto indica el alineamiento del texto: L Alineación a la izquierda, C centro, R Alineación a la derecha
        
    $pdf->cell(93, 10, 'Tallas', 1, 0, 'C', 1);
    $pdf->cell(93, 10, 'Existencias', 1, 1, 'C', 1);

    // Se establece un color de relleno para mostrar el nombre de la categoría.
    $pdf->setFillColor(225);
    // Se establece la fuente para los datos de los productos.
    $pdf->setFont('Times', '', 11);

    // Se recorren los registros fila por fila.
    foreach ($dataMarca as $rowMarca) {
        // Se imprime una celda con el nombre de la categoría.
        $pdf->cell(0, 10, $pdf->encodeString('Marcas: ' . $rowMarca['marca']), 1, 1, 'C', 1);
        // Se instancia el módelo Producto para procesar los datos.
        $detalleproducto = new DetalleProducto;
        // Se establece la categoría para obtener sus productos, de lo contrario se imprime un mensaje de error.
        if ($detalleproducto->setMarca($rowMarca['id_marca'])) {
            // Se verifica si existen registros para mostrar, de lo contrario se imprime un mensaje.
            if ($dataDetalleProducto = $detalleproducto->tallasPorMarca()) {
                // Se recorren los registros fila por fila.
                foreach ($dataDetalleProducto as $rowTalla) {
                    // ($rowMaterial['estado_producto']) ? $estado = 'Activo' : $estado = 'Inactivo';
                    // Se imprimen las celdas con los datos de los productos.
                    $pdf->cell(93, 10, $pdf->encodeString($rowTalla['talla']), 1, 0);
                    $pdf->cell(93, 10, $rowTalla['suma'], 1, 1);
                 
                }
            } else {
                $pdf->cell(0, 10, $pdf->encodeString('No hay tallas para esta marca'), 1, 1);
            }
        } else {
            $pdf->cell(0, 10, $pdf->encodeString('Marca incorrecto o inexistente'), 1, 1);
        }
    }
} else {
    $pdf->cell(0, 10, $pdf->encodeString('No hay tallas por marca para mostrar'), 1, 1);
}
// Se pone el nombre del archivo cuando se descarga y envía el documento a un destino determinado.
// Significado de las letras:
// I: envía el archivo en línea al navegador. Se utiliza el visor de PDF si está disponible.
// D: enviar al navegador y forzar la descarga de un archivo con el nombre dado por name.
// F: guarde en un archivo local con el nombre dado por name(puede incluir una ruta).
// S: devuelve el documento como una cadena.

$pdf->output('I', 'Tallas-Marca.pdf');
