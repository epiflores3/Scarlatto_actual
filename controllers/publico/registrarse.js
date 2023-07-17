const CLIENTE_API = 'business/publico/cliente.php';
// Constante para establecer el formulario de registro del primer usuario.
const SIGNUP_FORM = document.getElementById('first-use');



document.addEventListener('DOMContentLoaded', () => {
    // LLamada a la función para asignar el token del reCAPTCHA al formulario.
    // reCAPTCHA();
    // Constante tipo objeto para obtener la fecha y hora actual.
    const TODAY = new Date();
    // Se declara e inicializa una variable para guardar el día en formato de 2 dígitos.
    let day = ('0' + TODAY.getDate()).slice(-2);
    // Se declara e inicializa una variable para guardar el mes en formato de 2 dígitos.
    var month = ('0' + (TODAY.getMonth() + 1)).slice(-2);
    // Se declara e inicializa una variable para guardar el año con la mayoría de edad.
    let year = TODAY.getFullYear() - 18;
    // Se declara e inicializa una variable para establecer el formato de la fecha.
    let date = `${year}-${month}-${day}`;
    // Se asigna la fecha como valor máximo en el campo del formulario.
    document.getElementById('fecha_cliente').max = date;
});


SIGNUP_FORM.addEventListener('submit', async (event) => {
    // Se evita recargar la página web después de enviar el formulario.
    event.preventDefault();
    // Constante tipo objeto con los datos del formulario.
    const FORM = new FormData(SIGNUP_FORM);
    // Petición para registrar el primer usuario del sitio privado.
    const JSON = await dataFetch(CLIENTE_API, 'signup', FORM);
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
    if (JSON.status) {
        sweetAlert(1, JSON.message, true, 'login.html');
    } else if (JSON.recaptcha) {
        sweetAlert(2, JSON.exception, false, 'index.html');
    } else {
        sweetAlert(2, JSON.exception, false);
        
    }
});

/*
*   Función para obtener un token del reCAPTCHA y asignarlo al formulario.
*   Parámetros: ninguno.
*   Retorno: ninguno.
*/
// function reCAPTCHA() {
//     // Método para generar el token del reCAPTCHA.
//     grecaptcha.ready(() => {
//         // Constante para guardar la llave pública del reCAPTCHA.
//         const PUBLIC_KEY = '6LdBzLQUAAAAAJvH-aCUUJgliLOjLcmrHN06RFXT';
//         // Se obtiene un token para la página web mediante la llave pública.
//         grecaptcha.execute(PUBLIC_KEY, { action: 'homepage' }).then((token) => {
//             // Se asigna el valor del token al campo oculto del formulario
//             document.getElementById('g-recaptcha-response').value = token;
//         });
//     });
// }