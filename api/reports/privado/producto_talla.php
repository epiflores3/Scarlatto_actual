<?php
// Se manda a traer el archivo que actua como plantilla para los reportes
require_once('../../helpers/report.php');
//Se mandan a traer las clases donde se encuentran los gets y los sets que usaremos en el reporte
require_once('../../entities/dto/producto.php');
require_once('../../entities/dto/detalle_producto.php');

// Se crea un objeto de la clase reporte.
$pdf = new Report;
// Se coloca un titulo al documento.
$pdf->startReport('Productos por tallas');
// Se crea un objeto de la clase producto ya que estos sera por lo que se filtrara.
$producto = new Producto;
// Verifica si exiten registros a mostrar.
if ($dataProducto = $producto->readAll()) {
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
        


    $pdf->cell(93, 10, 'Talla', 1, 0, 'C', 1);
    $pdf->cell(93, 10, 'Existencias', 1, 1, 'C', 1);


    // Cell(float w [, float h [, string txt [, mixed border [, int ln [, string align [, boolean fill [, mixed link]]]]]]])


    // Se estabelce un color para la celda que muestra por lo que se filtra.
    $pdf->setFillColor(225);
    // Se establece una fuente para las celdas que muestran resultados.
    $pdf->setFont('Times', '', 11);

    // Recorre filas una por una.
    foreach ($dataProducto as $rowProducto) {
        // Se muestra la celda que tendra el dato por el que se filtra.
        $pdf->cell(0, 10, $pdf->encodeString('Nombre del producto: ' . $rowProducto['nombre_producto']), 1, 1, 'C', 1);
        // Se crea un objeto de la clase detalle producto ya que esto sera lo que se filtrara .
        $detalle_producto = new DetalleProducto;
        // Se establece por el id que tiene que capturar.
        if ($detalle_producto->setProducto($rowProducto['id_producto'])) {
            // Verifica si exiten registros a mostrar.
            if ($dataDetalleProducto = $detalle_producto->productoTalla()) {
                // Recorre filas una por una.
                foreach ($dataDetalleProducto as $rowProducto) {
                    // Se rellenan las celdas de las tallas deacuerdo a un producto en especifico.
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

// Se pone el nombre del archivo cuando se descarga y envía el documento a un destino determinado.
// Significado de las letras:
// I: envía el archivo en línea al navegador. Se utiliza el visor de PDF si está disponible.
// D: enviar al navegador y forzar la descarga de un archivo con el nombre dado por name.
// F: guarde en un archivo local con el nombre dado por name(puede incluir una ruta).
// S: devuelve el documento como una cadena.

$pdf->output('I', 'Producto-tallas.pdf');
