<?php
require_once('../../entities/dto/producto.php');

// Se comprueba si existe una acción a realizar, de lo contrario se finaliza el script con un mensaje de error.
if (isset($_GET['action'])) {
    // Se instancia la clase correspondiente.
    $producto = new Producto;
    // Se declara e inicializa un arreglo para guardar el resultado que retorna la API.
    $result = array('status' => 0, 'message' => null, 'exception' => null, 'dataset' => null);
    // Se compara la acción a realizar según la petición del controlador.
    switch ($_GET['action']) {
        case 'readTallasProducto':
            if (!$producto->setId($_POST['value'])) {
                $result['exception'] = 'Producto incorrecto';
            } elseif ($result['dataset'] = $producto->readTallasProducto()) {
                $result['status'] = 1;
            } elseif (Database::getException()) {
                $result['exception'] = Database::getException();
            } else {
                $result['exception'] = 'No hay datos registrados';
            }
            break;
        case 'readMaterialesProducto':
            if (!$producto->setId($_POST['value'])) {
                $result['exception'] = 'Producto incorrecto';
            } elseif ($result['dataset'] = $producto->readMaterialesProducto()) {
                $result['status'] = 1;
            } elseif (Database::getException()) {
                $result['exception'] = Database::getException();
            } else {
                $result['exception'] = 'No hay datos registrados';
            }
            break;
        case 'readProductosCatalogo':
            if ($result['dataset'] = $producto->readProductos()) {
                $result['status'] = 1;
                $result['message'] = 'Existen ' . count($result['dataset']) . ' registros';
            } elseif (Database::getException()) {
                $result['exception'] = Database::getException();
            } else {
                $result['exception'] = 'No hay datos registrados';
            }
            break;

        // case 'readProductosMasVendidos':
        //     if ($result['dataset'] = $producto->readProductosMasVendidos()) {
        //         $result['status'] = 1;
        //         $result['message'] = 'Existen ' . count($result['dataset']) . ' registros';
        //     } elseif (Database::getException()) {
        //         $result['exception'] = Database::getException();
        //     } else {
        //         $result['exception'] = 'No hay datos registrados';
        //     }
        //     break;

             /****************************************************/
            /*Leer un solo registro */
        case 'readOne':
            if (!$producto->setId($_POST['id_producto'])) {
                $result['exception'] = 'Producto incorrecto';
            } elseif ($result['dataset'] = $producto->readOne()) {
                $result['status'] = 1;
            } elseif (Database::getException()) {
                $result['exception'] = Database::getException();
            } else {
                $result['exception'] = 'Producto inexistente';
            }
            break;
            /****************************************************/

            case 'readPrecioProducto':
                if (!$producto->setId($_POST['id_producto'])) {
                    $result['exception'] = 'Detalle producto incorrecto';
                }elseif (!$producto->setTalla($_POST['id_talla'])) {
                        $result['exception'] = 'Talla incorrecto';
                } elseif ($result['dataset'] = $producto->readPrecioProducto()) {
                    $result['status'] = 1;
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'Producto inexistente';
                }
                break;
       
        default:
            $result['exception'] = 'Acción no disponible';
    }
    // Se indica el tipo de contenido a mostrar y su respectivo conjunto de caracteres.
    header('content-type: application/json; charset=utf-8');
    // Se imprime el resultado en formato JSON y se retorna al controlador.
    print(json_encode($result));
} else {
    print(json_encode('Recurso no disponible'));
}
