<?php
require_once('../../entities/dto/producto.php');

// Se comprueba si se cumplirá una acción, es decir, caso(case) a realizar, si no se llegará a cumplir ninguna acción se mostrará un mensaje de error.
if (isset($_GET['action'])) {
    // Se realiza una sesión o se sigue manejando la actual.
    session_start();
    // Se instancia una clase.
    $producto = new Producto;
   // Se declara e inicializa un arreglo para guardar el resultado que se retorna.
   $result = array('status' => 0, 'message' => null, 'exception' => null, 'dataset' => null);
    // Se verifica si existe una sesión iniciada como administrador, de lo contrario se finaliza el script con un mensaje de error.
    if (isset($_SESSION['id_usuario'])) {
        // Se compara la acción a realizar cuando un administrador ha iniciado sesión.
        switch ($_GET['action']) {
    //Se lee todos los datos que están almacenandos y lo que se agregarán posteriormente
    case 'readAll':
                if ($result['dataset'] = $producto->readAll()) {
                    $result['status'] = 1;
                    $result['message'] = 'Existen '.count($result['dataset']).' registros';
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'No hay datos registrados';
                } 
                break;
                //Se lee todos los datos que están almacenandos y lo que se agregarán posteriormente
                case 'readAllValoracion':
                if (!$producto->setId($_POST['id_producto'])) {

                   $result['exception'] = 'Valoracion incorrecta';
                    
                   }elseif ($result['dataset'] = $producto->readAllValoracion()) {
                    
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
                if (!$producto->setId($_POST['id'])) {
                    $result['exception'] = 'Producto incorrecto';
                } elseif ($result['dataset'] = $producto->readOneProductosPrivados()) {
                    $result['status'] = 1;
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'Producto inexistente';
                }
                break;    
     //Acción para poder buscar dentro de la interfaz
     case 'search':
                    $_POST = Validator::validateForm($_POST);
                    if ($_POST['search'] == '') {
                        $result['exception'] = 'Ingrese un valor para buscar';
                    } elseif ($result['dataset'] = $producto->searchRows($_POST['search'])) {
                        $result['status'] = 1;
                        $result['message'] = 'Existen '.count($result['dataset']).' coincidencias';
                    } elseif (Database::getException()) {
                        $result['exception'] = Database::getException();
                    } else {
                        $result['exception'] = 'No hay coincidencias';
                    }
                break;
     //Se comprueba que todos los datos estén correcto, de lo contario mostrará mensajes de error, y si todo es correcto creará un nuevo registro.
     case 'create':
                    $_POST = Validator::validateForm($_POST);

                    if (!$producto->setNombre($_POST['nombrep'])) {
                        $result['exception'] = 'Nombre incorrecto';

                    } elseif (!$producto->setDescripcion($_POST['descrip'])) {
                        $result['exception'] = 'Descripción incorrecta';

                    } elseif (!$producto->setDescuento($_POST['descp'])) {
                        $result['exception'] = 'Descuento incorrecta';

                    } elseif (!$producto->setUsuario($_POST['usuap'])) {
                        $result['exception'] = 'Uusario incorrecta';

                    } elseif (!$producto->setCategoria($_POST['catgp'])) {
                        $result['exception'] = 'Categoría incorrecta';

                    } elseif (!$producto->setEstadoProductos(isset($_POST['estado']) ? 1 : 0)) {
                        $result['exception'] = 'Estado incorrecto';

                    } elseif (!is_uploaded_file($_FILES['archivo']['tmp_name'])) {
                        $result['exception'] = 'Seleccione una imagen';

                    } elseif (!$producto->setImagen($_FILES['archivo'])) {
                        $result['exception'] = Validator::getFileError();

                    } elseif ($producto->createRow()) {
                        $result['status'] = 1;
                        if (Validator::saveFile($_FILES['archivo'], $producto->getRuta(), $producto->getImagen())) {
                            $result['message'] = 'Producto creado correctamente';
                        } else {
                            $result['message'] = 'Producto creado pero no se guardó la imagen';
                        }
                    } else {
                        $result['exception'] = Database::getException();;
                    }
                    break;
                //Se comprueba que todos los datos estén correctos, de lo contarrio se mostrará mensaje de error, y si todo está correcto se pondrá realizar la acción de actualizar.
                case 'update':
                        $_POST = Validator::validateForm($_POST);
                        if (!$producto->setId($_POST['id'])) {
                            $result['exception'] = 'Id del producto incorrecto';

                        } elseif (!$data = $producto->readOneProductosPrivados()) {
                            $result['exception'] = 'Producto inexistente';

                        } elseif (!$producto->setNombre($_POST['nombrep'])) {
                            $result['exception'] = 'Nombre incorrecto';

                        } elseif (!$producto->setDescripcion($_POST['descrip'])) {
                            $result['exception'] = 'Descripción incorrecta';

                    
                         } elseif (!$producto->setDescuento($_POST['descp'])) {
                        $result['exception'] = 'Descuento incorrecta';

                        } elseif (!$producto->setUsuario($_POST['usuap'])) {
                            $result['exception'] = 'Uusario incorrecta';

                        } elseif (!$producto->setCategoria($_POST['catgp'])) {
                            $result['exception'] = 'Categoría incorrecta';


                        } elseif (!$producto->setEstadoProductos(isset($_POST['estado']) ? 1 : 0)) {
                            $result['exception'] = 'Estado incorrecto';

                        
                        } elseif (!is_uploaded_file($_FILES['archivo']['tmp_name'])) {
                            if ($producto->updateRow($data['imagen_principal'])) {
                                $result['status'] = 1;
                                $result['message'] = 'Producto modificado correctamente';
                            } else {
                                $result['exception'] = Database::getException();
                            }

                        } elseif (!$producto->setImagen($_FILES['archivo'])) {
                            $result['exception'] = Validator::getFileError();

                        } elseif ($producto->updateRow($data['imagen_principal'])) {
                            $result['status'] = 1;

                            if (Validator::saveFile($_FILES['archivo'], $producto->getRuta(), $producto->getImagen())) {
                                $result['message'] = 'Producto modificado correctamente';
                            } else {
                                $result['message'] = 'Producto modificado pero no se guardó la imagen';
                            }
                        } else {
                            $result['exception'] = Database::getException();
                        }
                        break;
     //Se comprueba que el registro existe y si esta correcto, si todo es correcto se podrán eliminar el registro.    
     case 'delete':
                        if (!$producto->setId($_POST['id_producto'])) {
                            $result['exception'] = 'Producto incorrecto';
                        } elseif (!$data = $producto->readOneProductosPrivados()) {
                            $result['exception'] = 'Producto inexistente';
                        } elseif ($producto->deleteRow()) {
                            $result['status'] = 1;
                                $result['message'] = 'Producto eliminado correctamente';
                        } else {
                            $result['exception'] = Database::getException();
                        }
                        break;
     //Se comprueba que el registro existe y si esta correcto, si todo es correcto se podrán eliminar el registro.    
     case 'deleteValo':
                            if (!$producto->setIdValo($_POST['id_valoracion'])) {
                                $result['exception'] = 'Valoracion incorrecto';
                            } elseif (!$data = $producto->readOneValo()) {
                                $result['exception'] = 'Valoracion inexistente';
                            } elseif ($producto->deleteRowValo($data['estado_comentario'])) {
                                $result['status'] = 1;
                                    $result['message'] = 'Valoracion eliminado correctamente';
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