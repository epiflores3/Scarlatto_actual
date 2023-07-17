<?php
require_once('../../entities/dto/cliente.php');

// Se comprueba si existe una acción a realizar, de lo contrario se finaliza el script con un mensaje de error.
if (isset($_GET['action'])) {
    // Se crea una sesión o se reanuda la actual para poder utilizar variables de sesión en el script.
    session_start();
    // Se instancia la clase correspondiente.
    $cliente = new Cliente;
    // Se declara e inicializa un arreglo para guardar el resultado que retorna la API.  Agregas fullname y id
    $result = array('status' => 0, 'session' => 0, 'recaptcha' => 0, 'message' => null, 'exception' => null, 'username' => null, 'id'=>0);
    // Se verifica si existe una sesión iniciada como cliente para realizar las acciones correspondientes.
    if (isset($_SESSION['id_cliente'])) {
        $result['session'] = 1;
        // Se compara la acción a realizar cuando un cliente ha iniciado sesión.
        switch ($_GET['action']) {

            case 'getUser':
                if (isset($_SESSION['correo_cliente'])) {
                    $result['status'] = 1;
                    $result['username'] = $_SESSION['correo_cliente'];
                    $result['id']=$_SESSION['id_cliente'];
                } else {
                    $result['exception'] = 'Correo de usuario indefinido';
                }
                break;

            case 'logOut':
                if (session_destroy()) {
                    $result['status'] = 1;
                    $result['message'] = 'Sesión eliminada correctamente';
                } else {
                    $result['exception'] = 'Ocurrió un problema al cerrar la sesión';
                }
                break;
            default:
                $result['exception'] = 'Acción no disponible dentro de la sesión';
        }
    } else {
        // Se compara la acción a realizar cuando el cliente no ha iniciado sesión.
        switch ($_GET['action']) {

         

            case 'signup':
                $_POST = Validator::validateForm($_POST);
   
                $secretKey = '6LdBzLQUAAAAAL6oP4xpgMao-SmEkmRCpoLBLri-';
                $ip = $_SERVER['REMOTE_ADDR'];

                $data = array('secret' => $secretKey, 'response' => $_POST['g-recaptcha-response'], 'remoteip' => $ip);

                $options = array(
                    'http' => array('header'  => "Content-type: application/x-www-form-urlencoded\r\n", 'method' => 'POST', 'content' => http_build_query($data)),
                    'ssl' => array('verify_peer' => false, 'verify_peer_name' => false)
                );

                $url = 'https://www.google.com/recaptcha/api/siteverify';
                $context  = stream_context_create($options);
                $response = file_get_contents($url, false, $context);
                $captcha = json_decode($response, true);

                // if (!$captcha['success']) {
                //     $result['recaptcha'] = 1;
                //     $result['exception'] = 'No eres humano';
                // }else

                
                if (!$cliente->setNombre($_POST['nombre_cliente'])) {
                    $result['exception'] = 'Nombres incorrectos';
                } elseif (!$cliente->setApellido($_POST['apellido_cliente'])) {
                    $result['exception'] = 'Apellidos incorrectos';
                } elseif (!$cliente->setCorreo($_POST['correo_cliente'])) {
                    $result['exception'] = 'Correo incorrecto';
                } elseif (!$cliente->setDUI($_POST['DUI_cliente'])) {
                    $result['exception'] = 'Alias incorrecto';

                } elseif (!$cliente->setTelefono($_POST['telefono_cliente'])) {
                    $result['exception'] = 'Alias incorrecto';

                } elseif (!$cliente->setNacimiento($_POST['fecha_cliente'])) {
                    $result['exception'] = 'Alias incorrecto';

                } elseif (!$cliente->setDireccion($_POST['direccion_cliente'])) {
                    $result['exception'] = 'Alias incorrecto';


                } elseif (!$cliente->setClave($_POST['contra_primer'])) {
                    $result['exception'] = Validator::getPasswordError();

                } elseif ($_POST['rescon_primer'] != $_POST['contra_primer']) {
                    $result['exception'] = 'Claves diferentes';

            
                } elseif ($cliente->createCuenta()) {
                    $result['status'] = 1;
                    $result['message'] = 'Usuario creado correctamente';
               
                } else {
                    $result['exception'] = Database::getException();
                }
                break;

            case 'login':
                $_POST = Validator::validateForm($_POST);
                if (!$cliente->checkUser($_POST['correo'])) {
                    $result['exception'] = 'Correo incorrecto';
                } elseif (!$cliente->getEstado()) {
                    $result['exception'] = 'La cuenta ha sido desactivada';
                } elseif ($cliente->checkPassword($_POST['clave'])) {
                    $result['status'] = 1;
                    $result['message'] = 'Autenticación correcta';
                    $_SESSION['id_cliente'] = $cliente->getId();
                    $_SESSION['correo_cliente'] = $cliente->getCorreo();
                } else {
                    $result['exception'] = 'Clave incorrecta';
                }
                break;

            default:
                $result['exception'] = 'Acción no disponible fuera de la sesión';
        }
    }
    // Se indica el tipo de contenido a mostrar y su respectivo conjunto de caracteres.
    header('content-type: application/json; charset=utf-8');
    // Se imprime el resultado en formato JSON y se retorna al controlador.
    print(json_encode($result));
} else {
    print(json_encode('Recurso no disponible'));
}
