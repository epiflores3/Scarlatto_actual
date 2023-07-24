<?php
// Se incluye la clase con las plantillas para generar reportes.
require_once('../../helpers/reportpublic.php');

// Se instancia la clase para crear el reporte.
$pdf = new Report;
// Se verifica si existe un valor para la categoría, de lo contrario se muestra un mensaje.
if (isset($_GET['id_pedido'])) {
    // Se incluyen las clases para la transferencia y acceso a datos.
  
    require_once('../../entities/dto/pedido.php');
    // Se instancian las entidades correspondientes.
    
    $pedido = new Pedido;
    // Se establece el valor de la categoría, de lo contrario se muestra un mensaje.
    if ($pedido->setId($_GET['id_pedido'])) {
        // Se verifica si la categoría existe, de lo contrario se muestra un mensaje.
        if ($rowPedido = $pedido->readOne()) {
            // Se inicia el reporte con el encabezado del documento.
            $pdf->startReport('Comprobante: ');
            // Se verifica si existen registros para mostrar, de lo contrario se imprime un mensaje.
            if ($dataProductos = $pedido->startReport()) {
                // Se establece un color de relleno para los encabezados.
                $pdf->setFillColor(225);
                // Se establece la fuente para los encabezados.
                $pdf->setFont('Times', 'B', 11);
                // Se imprimen las celdas con los encabezados.
               
                $pdf->cell(80, 10, 'Producto', 1, 0, 'C', 1);
                $pdf->cell(40, 10, 'Precio (US$)', 1, 0, 'C', 1);
                $pdf->cell(40, 10, 'Cantidad (US$)', 1, 0, 'C', 1);
                $pdf->cell(26, 10, 'Subtotal', 1, 1, 'C', 1);
            
                // Se establece la fuente para los datos de los productos.
                $pdf->setFont('Times', '', 11);
                $total = 0;

                

                // Se recorren los registros fila por fila.
                foreach ($dataProductos as $rowProducto) {
                    
                    $subtotal = $rowProducto['precio_producto'] * $rowProducto['cantidad_producto'];
                    $total += $subtotal;


                    // ($rowProducto['estado_producto']) ? $estado = 'Activo' : $estado = 'Inactivo';
                    // Se imprimen las celdas con los datos de los productos.
                  
                    $pdf->cell(80, 10, $pdf->encodeString($rowProducto['nombre_producto']), 1, 0);
                    $pdf->cell(40, 10, $rowProducto['precio_producto'], 1, 0);
                    $pdf->cell(40, 10, $rowProducto['cantidad_producto'], 1, 0);
                    $pdf->cell(26, 10, $subtotal, 1, 1);

                }
                $pdf->setFont('Times', '', 11);
                $pdf->setFillColor(225);
                $pdf->cell(130, 10, 'Factura a nombre de: '. $pdf->encodeString($rowProducto['nombre_cliente']), 1, 0, 'L' , 1);
                $pdf->cell(56, 10, 'DUI: '. $pdf->encodeString($rowProducto['dui_cliente']), 1, 1, 'L' , 1);
                $pdf->cell(26, 10, 'Total: $'.$total, 1, 1, 'C', 1);
           
           
                


            } else {
                $pdf->cell(0, 10, $pdf->encodeString('No hay productos para la categoría'), 1, 1);
            }
            // Se llama implícitamente al método footer() y se envía el documento al navegador web.
            $pdf->output('I', 'categoria.pdf');
        } else {
            print('Categoría inexistente');
        }
    } else {
        print('Categoría incorrecta');
    }
} else {
    print('Debe seleccionar una categoría');
}
