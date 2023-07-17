<?php
require_once('../../entities/dto/talla.php');

if (isset($_GET['action'])) {
    // Se crea una sesión o se reanuda la actual para poder utilizar variables de sesión en el script.
    session_start();
    // Se instancia la clase correspondiente.
    $talla = new Talla;
    // Se declara e inicializa un arreglo para guardar el resultado que retorna la API.
    $result = array('status' => 0, 'message' => null, 'exception' => null, 'dataset' => null);
    // Se verifica si existe una sesión iniciada como administrador, de lo contrario se finaliza el script con un mensaje de error.
    if (isset($_SESSION['id_usuario'])) {
        // Se compara la acción a realizar cuando un administrador ha iniciado sesión.
        switch ($_GET['action']) {
            case 'readAll':
                if ($result['dataset'] = $talla->readAll()) {
                    $result['status'] = 1;
                    $result['message'] = 'Existen '.count($result['dataset']).' registros';
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'No hay datos registrados';
                }
                break;
                
                case 'search':
                    $_POST = Validator::validateForm($_POST);
                    if ($_POST['search'] == '') {
                        $result['exception'] = 'Ingrese un valor para buscar';
                    } elseif ($result['dataset'] = $talla->searchRows($_POST['search'])) {
                        $result['status'] = 1;
                        $result['message'] = 'Existen '.count($result['dataset']).' coincidencias';
                    } elseif (Database::getException()) {
                        $result['exception'] = Database::getException();
                    } else {
                        $result['exception'] = 'No hay coincidencias';
                    }
                    break;
                case 'readOne':
                    if (!$talla->setId($_POST['id_talla'])) {
                        $result['exception'] = 'talla incorrecta';
                    } elseif ($result['dataset'] = $talla->readOne()) {
                        $result['status'] = 1;
                    } elseif (Database::getException()) {
                        $result['exception'] = Database::getException();
                    } else {
                        $result['exception'] = 'talla inexistente';
                    }
                break;

            case 'search':
                $_POST = Validator::validateForm($_POST);
                if ($_POST['search'] == '') {
                    $result['exception'] = 'Ingrese un valor para buscar';
                } elseif ($result['dataset'] = $talla->searchRows($_POST['search'])) {
                    $result['status'] = 1;
                    $result['message'] = 'Existen '.count($result['dataset']).' coincidencias';
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'No hay coincidencias';
                }
                break;



            case 'create':
                $_POST = Validator::validateForm($_POST);
                if (!$talla->setTalla($_POST['talla'])) {
                    $result['exception'] = 'Talla incorrecta';
                    
                } elseif ($talla->createRow()) {
                    $result['status'] = 1;
                    $result['message'] = 'Talla creada correctamente';
                } else {
                    $result['exception'] = Database::getException();
                }
                break;




            case 'update':
                $_POST = Validator::validateForm($_POST);
                if (!$talla->setId($_POST['id'])) {
                    $result['exception'] = 'id de talla incorrecta';
                } elseif (!$data = $talla->readOne()) {
                    $result['exception'] = 'talla inexistente';
                } elseif (!$talla->setTalla($_POST['talla'])) {
                    $result['exception'] = 'talla incorrecto';
                } elseif ($talla->updateRow()) {
                    $result['status'] = 1;
                    $result['message'] = 'Talla modificada correctamente';
                } else {
                    $result['exception'] = Database::getException();
                }
            break;

            

            case 'delete':
                if (!$talla->setId($_POST['id_talla'])) {
                    $result['exception'] = 'Talla incorrecta';
                } elseif (!$data = $talla->readOne()) {
                    $result['exception'] = 'talla inexistente';
                } elseif ($talla->deleteRow()) {
                    $result['status'] = 1;
                    $result['message'] = 'Talla eliminada correctamente';
                } else {
                    $result['exception'] = Database::getException();
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