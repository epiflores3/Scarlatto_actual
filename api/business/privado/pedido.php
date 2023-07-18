<?php
require_once('../../entities/dto/pedido.php');

if (isset($_GET['action'])) {
    // Se crea una sesión o se reanuda la actual para poder utilizar variables de sesión en el script.
    session_start();
    // Se instancia la clase correspondiente.
    $pedido = new Pedido;
    // Se declara e inicializa un arreglo para guardar el resultado que retorna la API.
    $result = array('status' => 0, 'message' => null, 'exception' => null, 'dataset' => null);
    // Se verifica si existe una sesión iniciada como administrador, de lo contrario se finaliza el script con un mensaje de error.
    if (isset($_SESSION['id_usuario'])) {
        // Se compara la acción a realizar cuando un administrador ha iniciado sesión.
        switch ($_GET['action']) {
            case 'readAll':
                if ($result['dataset'] = $pedido->readAll()) {
                    $result['status'] = 1;
                    $result['message'] = 'Existen ' . count($result['dataset']) . ' registros';
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'No hay datos registrados';
                }
                break;

                //Proceso para cargar el detalle del pedido
            case 'readAllDetallePedido':
                if (!$pedido->setId($_POST['id_pedido'])) {
                    $result['exception'] = 'Pedido incorrecto';
                } elseif ($result['dataset'] = $pedido->readAllDetallePedido()) {
                    $result['status'] = 1;
                    $result['message'] = 'Existen ' .  count($result['dataset']) . ' registros';
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'No hay datos registrados';
                }
                break;
            case 'readOne':
                if (!$pedido->setId($_POST['id_pedido'])) {
                    $result['exception'] = 'Pedido incorrecto';
                } elseif ($result['dataset'] = $pedido->readOne()) {
                    $result['status'] = 1;
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'Pedido inexistente';
                }
                break;

                //Se simula los datos ocupandos en type en la base de datos, por medio de un array.
            case 'readEstadoPedido':
                $result['status'] = 1;
                $result['dataset'] = array(
                    array('Pendiente', 'Pendiente'),
                    array('Anulado', 'Anulado'),
                    array('Finalizado', 'Finalizado')
                );
                break;

            case 'search':
                $_POST = Validator::validateForm($_POST);
                if ($_POST['search'] == '') {
                    $result['exception'] = 'Ingrese un valor para buscar';
                } elseif ($result['dataset'] = $pedido->searchRows($_POST['search'])) {
                    $result['status'] = 1;
                    $result['message'] = 'Existen ' . count($result['dataset']) . ' coincidencias';
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'No hay coincidencias';
                }
                break;


            case 'create':
                $_POST = Validator::validateForm($_POST);
                if (!$pedido->setEstadoPedido($_POST['estado'])) {
                    $result['exception'] = 'Estado del pedido incorrecto';
                } elseif (!$pedido->setFechaPedido($_POST['fecha'])) {
                    $result['exception'] = 'Fecha del pedido incorrecto';
                } elseif (!$pedido->setDireccionPedido($_POST['direccion'])) {
                    $result['exception'] = 'Dirección del pedido incorrecto';
                } elseif (!$pedido->setCliente($_POST['cliente'])) {
                    $result['exception'] = 'Cliente incorrecto';
                } elseif ($pedido->createRow()) {
                    $result['status'] = 1;
                    $result['message'] = 'Pedido creado correctamente';
                } else {
                    $result['exception'] = Database::getException();
                }
                break;

            case 'update':
                $_POST = Validator::validateForm($_POST);
                if (!$pedido->setId($_POST['id'])) {
                    $result['exception'] = 'Pedido incorrecto';
                } elseif (!$data = $pedido->readOne()) {
                    $result['exception'] = 'Pedido inexistente';
                } elseif (!$pedido->setEstadoPedido($_POST['estado'])) {
                    $result['exception'] = 'Estado del pedido incorrecto';
                } elseif (!$pedido->setFechaPedido($_POST['fecha'])) {
                    $result['exception'] = 'Fecha del pedido incorrecto';
                } elseif (!$pedido->setDireccionPedido($_POST['direccion'])) {
                    $result['exception'] = 'Dirección del pedido incorrecto';
                } elseif (!$pedido->setCliente($_POST['cliente'])) {
                    $result['exception'] = 'Cliente incorrecto';
                } elseif ($pedido->updateRow()) {
                    $result['status'] = 1;
                    $result['message'] = 'Pedido modificado correctamente';
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
                //Delete del detalle del pedido
            case 'deleteDetalle':
                if (!$pedido->setIdDetalle($_POST['id_detalle_pedido'])) {
                    $result['exception'] = 'Detalle incorrecto';
                } elseif (!$data = $pedido->readOneDetalle()) {
                    $result['exception'] = 'Detalle inexistente';
                } elseif ($pedido->deleteDetalle($data['estado_comentario'])) {
                    $result['status'] = 1;
                    $result['message'] = 'Detalle eliminado correctamente';
                } else {
                    $result['exception'] = Database::getException();
                }
                break;

            case 'delete':
                if (!$pedido->setId($_POST['id_pedido'])) {
                    $result['exception'] = 'Pedido incorrecto';
                } elseif (!$data = $pedido->readOne()) {
                    $result['exception'] = 'Pedido inexistente';
                } elseif ($pedido->deleteRow()) {
                    $result['status'] = 1;
                    $result['message'] = 'Pedido eliminado correctamente';
                } else {
                    $result['exception'] = Database::getException();
                }
                break;

                 case 'cantidadEstadosPedidos':
                    if ($result['dataset'] = $pedido->CantidadEstadoPedido()) {
                        $result['status'] = 1;
                    } else {
                        $result['exception'] = 'No hay datos disponibles';
                    }
                break;

                //Se manda a llamar el método que trae los datos de la base de datos se cconvierte en json para mandarlo a JS
                case 'cantidadDePedidosMasSolicitados':
                    if ($result['dataset'] = $pedido->cantidadPedidosFechas($_POST['fecha_inicial'], $_POST['fecha_final'])) {
                        $result['status'] = 1;
                        $result['message'] = 'Top 5 encontrado correctamente';
                    } else {
                        $result['exception'] = 'No hay datos disponibles';
                    }
                    break;


                
            default:
                $result['exception'] = 'Acción no disponible dentro de la sesión';
        }
        // Se indica el tipo de contenido a mostrar y su respectivo conjunto de caracteres.
        header('content-type: application/json; charset=utf-8');
        // Se imprime el resultado en formato JSON y se retorna al controlador.
        print(json_encode($result));
    } else {
        print(json_encode('Acceso denegado'));
    }
} else {
    print(json_encode('Recurso no disponible'));
}
