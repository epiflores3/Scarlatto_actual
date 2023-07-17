<?php
require_once('../../entities/dto/material.php');

if (isset($_GET['action'])) {
    // Se crea una sesión o se reanuda la actual para poder utilizar variables de sesión en el script.
    session_start();
    // Se instancia la clase correspondiente.
    $material = new Material;
    // Se declara e inicializa un arreglo para guardar el resultado que retorna la API.
    $result = array('status' => 0, 'message' => null, 'exception' => null, 'dataset' => null);
    // Se verifica si existe una sesión iniciada como administrador, de lo contrario se finaliza el script con un mensaje de error.
    if (isset($_SESSION['id_usuario'])) {
        // Se compara la acción a realizar cuando un administrador ha iniciado sesión.
        switch ($_GET['action']) {
            case 'readAll':
                if ($result['dataset'] = $material->readAll()) {
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
                } elseif ($result['dataset'] = $material->searchRows($_POST['search'])) {
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
                    if (!$material->setMaterial($_POST['material'])) {
                        $result['exception'] = 'Material incorrecta';
                    } elseif ($material->createRow()) {
                            $result['status'] = 1;
                            $result['message'] = 'Material creada correctamente';
                    } else {
                            $result['exception'] = Database::getException();
                    }
                break;
            case 'readOne':
                if (!$material->setId($_POST['id_material'])) {
                    $result['exception'] = 'Material incorrecto';
                } elseif ($result['dataset'] = $material->readOne()) {
                    $result['status'] = 1;
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'Material inexistente';
                }
                break;


            case 'update':
                $_POST = Validator::validateForm($_POST);
                if (!$material->setId($_POST['id'])) {
                    $result['exception'] = 'Material incorrecta';
                } elseif (!$data = $material->readOne()) {
                    $result['exception'] = 'Material inexistente';
                } elseif (!$material->setMaterial($_POST['material'])) {
                    $result['exception'] = 'Material incorrecto';
                } elseif ($material->updateRow()) {
                    $result['status'] = 1;
                    $result['message'] = 'Material modificado correctamente';
                } else {
                    $result['exception'] = Database::getException();
                    $result['message'] = 'Error al  modificar';
                }
                break;

                //si
            case 'delete':
                if (!$material->setId($_POST['id_material'])) {
                    $result['exception'] = 'Material incorrecto';
                } elseif (!$data = $material->readOne()) {
                    $result['exception'] = 'Material inexistente';
                } elseif ($material->deleteRow()) {
                    $result['status'] = 1;
                    $result['message'] = 'Material eliminada correctamente';
                } else {
                    $result['exception'] = Database::getException();
                }
                break;

            case 'cantidadProductosMaterial':
                    if ($result['dataset'] = $material->cantidadProductosMaterial()) {
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