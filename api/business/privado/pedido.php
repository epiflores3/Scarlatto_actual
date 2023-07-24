<?php
require_once('../../entities/dto/pedido.php');

// Se comprueba si se cumplirá una acción, es decir, caso(case) a realizar, si no se llegará a cumplir ninguna acción se mostrará un mensaje de error.
if (isset($_GET['action'])) {
    // Se realiza una sesión o se sigue manejando la actual.
    session_start();
    // Se instancia una clase.
    $pedido = new Pedido;
    // Se declara e inicializa un arreglo para guardar el resultado que retorna la API.
    $result = array('status' => 0, 'message' => null, 'exception' => null, 'dataset' => null);
    // Se verifica si existe una sesión, de lo contrario se muestra un mensaje de error.
    if (isset($_SESSION['id_usuario'])) {
        // Se compara la acciones que el usuario puede realizar cuando ha iniciado sesión.
        switch ($_GET['action']) {
                //Se lee todos los datos que están almacenandos y lo que se agregarán posteriormente
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
                //Se lee todos los datos que están almacenandos y lo que se agregarán posteriormente
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
                //Se comprueba que los id estén correctos y que existen
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
                //Acción para poder buscar dentro de la interfaz
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
                //Se comprueba que todos los datos estén correcto, de lo contario mostrará mensajes de error, y si todo es correcto creará un nuevo registro.
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
                //Se comprueba que todos los datos estén correctos, de lo contarrio se mostrará mensaje de error, y si todo está correcto se pondrá realizar la acción de actualizar.
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
                //Se comprueba que el registro existe y si esta correcto, si todo es correcto se podrán eliminar el registro.    
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
                //Se comprueba que el registro existe y si esta correcto, si todo es correcto se podrán eliminar el registro.    
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
                // Se mandar a llamar a la consulta, para que se pueda mostrar futuramente la gráfica de pastel
            case 'cantidadEstadosPedidos':
                if ($result['dataset'] = $pedido->CantidadEstadoPedido()) {
                    $result['status'] = 1;
                } else {
                    $result['exception'] = 'No hay datos disponibles';
                }
                break;
                //Se manda a llamar el método que trae los datos de la base de datos, que se convertran en grafico lineal
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
