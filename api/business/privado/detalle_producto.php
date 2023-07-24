<?php
require_once('../../entities/dto/detalle_producto.php');

// Se comprueba si se cumplirá una acción, es decir, caso(case) a realizar, si no se llegará a cumplir ninguna acción se mostrará un mensaje de error.
if (isset($_GET['action'])) {
    // Se realiza una sesión o se sigue manejando la actual.
    session_start();
    // Se instancia una clase.
    $detalle_producto = new DetalleProducto;
    // Se declara e inicializa un arreglo para guardar el resultado que se retorna.
    $result = array('status' => 0, 'message' => null, 'exception' => null, 'dataset' => null);
    // Se verifica si existe una sesión, de lo contrario se muestra un mensaje de error.
    if (isset($_SESSION['id_usuario'])) {
        // Se compara la acciones que el usuario puede realizar cuando ha iniciado sesión.
        switch ($_GET['action']) {
                //Se lee todos los datos que están almacenandos y lo que se agregarán posteriormente
            case 'readAll':
                if ($result['dataset'] = $detalle_producto->readAll()) {
                    $result['status'] = 1;
                    $result['message'] = 'Existen ' . count($result['dataset']) . ' registros';
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'No hay datos registrados';
                }
                break;
                //Se comprueba que los id estén correctos y que existen
            case 'readOne':
                if (!$detalle_producto->setId($_POST['id_detalle_producto'])) {
                    $result['exception'] = 'Detalle del producto incorrecta';
                } elseif ($result['dataset'] = $detalle_producto->readOne()) {
                    $result['status'] = 1;
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'Detalle del producto inexistente';
                }
                break;
                //Acción para poder buscar dentro de la interfaz
            case 'search':
                $_POST = Validator::validateForm($_POST);
                if ($_POST['search'] == '') {
                    $result['exception'] = 'Ingrese un valor para buscar';
                } elseif ($result['dataset'] = $detalle_producto->searchRows($_POST['search'])) {
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
                if (!$detalle_producto->setExistencia($_POST['existencia'])) {
                    $result['exception'] = 'Existencia del producto incorrecto';
                } elseif (!$detalle_producto->setProducto($_POST['producto'])) {
                    $result['exception'] = 'Producto incorrecto';
                } elseif (!$detalle_producto->setMaterial($_POST['material'])) {
                    $result['exception'] = 'Material del producto incorrecto';
                } elseif (!$detalle_producto->setTalla($_POST['talla'])) {
                    $result['exception'] = 'Talla del producto incorrecto';
                } elseif (!$detalle_producto->setMarca($_POST['marca'])) {
                    $result['exception'] = 'Marca del producto incorrecto';
                } elseif ($detalle_producto->createRow()) {
                    $result['status'] = 1;
                    $result['message'] = 'Detalle de producto creado correctamente';
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
                //Se comprueba que todos los datos estén correctos, de lo contarrio se mostrará mensaje de error, y si todo está correcto se pondrá realizar la acción de actualizar.
            case 'update':
                $_POST = Validator::validateForm($_POST);
                if (!$detalle_producto->setId($_POST['id'])) {
                    $result['exception'] = 'Detalle de producto incorrecto';
                } elseif (!$data = $detalle_producto->readOne()) {
                    $result['exception'] = 'Detalle del producto inexistente';
                } elseif (!$detalle_producto->setExistencia($_POST['existencia'])) {
                    $result['exception'] = 'Existencia del producto incorrecto';
                } elseif (!$detalle_producto->setProducto($_POST['producto'])) {
                    $result['exception'] = 'Producto incorrecto';
                } elseif (!$detalle_producto->setMaterial($_POST['material'])) {
                    $result['exception'] = 'Material del producto incorrecto';
                } elseif (!$detalle_producto->setTalla($_POST['talla'])) {
                    $result['exception'] = 'Talla del producto incorrecto';
                } elseif (!$detalle_producto->setMarca($_POST['marca'])) {
                    $result['exception'] = 'Marca del producto   incorrecto';
                } elseif ($detalle_producto->updateRow()) {
                    $result['status'] = 1;
                    $result['message'] = 'Detalle del producto modificado correctamente';
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
                //Se comprueba que el registro existe y si esta correcto, si todo es correcto se podrán eliminar el registro.    
            case 'delete':
                if (!$detalle_producto->setId($_POST['id_detalle_producto'])) {
                    $result['exception'] = 'Detalle del producto incorrecta';
                } elseif (!$data = $detalle_producto->readOne()) {
                    $result['exception'] = 'Detalle del producto inexistente';
                } elseif ($detalle_producto->deleteRow()) {
                    $result['status'] = 1;
                    $result['message'] = 'Detalle del producto fue eliminada correctamente';
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
                //Se comprueba que existen los datos para mostrar en la gráfica   
            case 'cantidadProductosMarcas':
                if ($result['dataset'] = $detalle_producto->cantidadProductosMarcas()) {
                    $result['status'] = 1;
                } else {
                    $result['exception'] = 'No hay datos disponibles';
                }
                break;
                //Se comprueba que existen los datos para mostrar en la gráfica   
            case 'porcentajeProducto':
                if ($result['dataset'] = $detalle_producto->porcentajeProducto()) {
                    $result['status'] = 1;
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
