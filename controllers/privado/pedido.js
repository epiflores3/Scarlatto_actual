// Constante para completar la ruta de la API.
const PEDIDO_API = 'business/privado/pedido.php';
const CLIENTE_API = 'business/privado/cliente.php';
//Constante para cambiarle el titulo a el modal
const DETALLE_MODAL = new bootstrap.Modal(document.getElementById('detallepedido'));
const MODAL_TITLE = document.getElementById('modal-title');
const SAVE_MODAL = new bootstrap.Modal(document.getElementById('agregarpedido'));
// // Constante para establecer el formulario de buscar.
const SEARCH_FORM = document.getElementById('search-form');
// Constantes para cuerpo de la tabla
const TBODYDETALLE_ROWS = document.getElementById('tbody-rowsdt');
const RECORDSDETALLE = document.getElementById('recordsDetalle');
const TBODY_ROWS = document.getElementById('tbody-rows');
const RECORDS = document.getElementById('records');
const SAVE_FORM = document.getElementById('save-form');
const microfono = document.querySelector('microfono');
const popup = document.querySelector('popup');

//Método para que cargue graficamente la tabla
document.addEventListener('DOMContentLoaded', () => {
    // Llamada a la función para llenar la tabla con los registros disponibles.
    fillTable();
});

// Método manejador de eventos para cuando se envía el formulario de buscar.
SEARCH_FORM.addEventListener('submit', (event) => {
    // Se evita recargar la página web después de enviar el formulario.
    event.preventDefault();
    // Constante tipo objeto con los datos del formulario.
    const FORM = new FormData(SEARCH_FORM);
    // Llamada a la función para llenar la tabla con los resultados de la búsqueda.
    fillTable(FORM);
});

// microfono.addEventListener('click', ()=>{
//     const recognition = new webkitSpeechRecognitio();
//     recognition.lang = 'es-Es';
//     recognition.start();

//     recognition.onstart = ()=>{
//         popup.classList.add('popup--dinamico');
//     }

// })



SAVE_FORM.addEventListener('submit', async (event) => {
    // Se evita recargar la página web después de enviar el formulario.
    event.preventDefault();
    // Se verifica la acción a realizar.
    (document.getElementById('id').value) ? action = 'update' : action = 'create';
    // Constante tipo objeto con los datos del formulario.
    const FORM = new FormData(SAVE_FORM);
    // Petición para guardar los datos del formulario.
    const JSON = await dataFetch(PEDIDO_API, action, FORM);
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
    if (JSON.status) {
        SAVE_MODAL.hide();
        // Se carga nuevamente la tabla para visualizar los cambios.
        fillTable();
        sweetAlert(1, JSON.message, true);
    } else {
        sweetAlert(2, JSON.exception, false);
    }
});

async function fillTable(form = null) {
    // Se inicializa el contenido de la tabla.
    TBODY_ROWS.innerHTML = '';
    RECORDS.textContent = '';
    // Se verifica la acción a realizar.
    (form) ? action = 'search' : action = 'readAll';
    // Petición para obtener los registros disponibles.
    const JSON = await dataFetch(PEDIDO_API, action, form);
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
    if (JSON.status) {
        // Se recorre el conjunto de registros fila por fila.
        JSON.dataset.forEach(row => {

            
            // Se crean y concatenan las filas de la tabla con los datos de cada registro.
            TBODY_ROWS.innerHTML += `
            <tr>
                <td>${row.nombre_cliente}</td>
                <td>${row.fecha_pedido}</td>
                <td>${row.direccion_pedido}</td>
                <td>${row.estados_pedido}</td>
                <td>

                    <button onclick="openReport(${row.id_pedido})" type="button" class="btn btn-warning">
                        <img height="20px" width="20px" src="../../resources/img/imgtablas/cuaderno.png" alt="ver">
                    </button>

                    <button type="button" class="btn btn-primary" onclick="fillTableDetalle(${row.id_pedido})"><img
                    height="20px" width="20px" src="../../resources/img/imgtablas/ojo.png" alt="ver">

                    <button type="button" class="btn btn-info" onclick="openUpdate(${row.id_pedido})">
                        <img height="20px" width="20px" src="../../resources/img/imgtablas/update.png" alt="actualizar">
                    </button>

                    <button onclick="openDelete(${row.id_pedido})" class="btn btn-danger"><img height="20px" width="20px"
                                src="../../resources/img/imgtablas/delete.png" alt="eliminar">
                    </button>
 

                </td>
            </tr>
            `;
        });

        RECORDS.textContent = JSON.message;
    } else {
        sweetAlert(4, JSON.exception, true);
    }
}

function openCreate() {

    SAVE_FORM.reset();
    // Se asigna título a la caja de diálogo.
    MODAL_TITLE.textContent = 'Crear pedido';
    fillSelect(CLIENTE_API, 'readAll', 'cliente');
    fillSelect(PEDIDO_API, 'readEstadoPedido', 'estado');
}

async function openUpdate(id) {
    // Se define una constante tipo objeto con los datos del registro seleccionado.
    const FORM = new FormData();
    FORM.append('id_pedido', id);
    // Petición para obtener los datos del registro solicitado.
    const JSON = await dataFetch(PEDIDO_API, 'readOne', FORM);
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
    if (JSON.status) {
        SAVE_MODAL.show();
        // Se asigna título para la caja de diálogo.
        MODAL_TITLE.textContent = 'Actualizar pedido';
        // Se inicializan los campos del formulario.
        document.getElementById('id').value = JSON.dataset.id_pedido;
        document.getElementById('fecha').value = JSON.dataset.fecha_pedido;
        
        document.getElementById('direccion').value = JSON.dataset.direccion_pedido;
        fillSelect (CLIENTE_API, 'readAll', 'cliente', JSON.dataset.id_cliente);
        fillSelect(PEDIDO_API, 'readEstadoPedido', 'estado', JSON.dataset.estados_pedido);
    
    } else {
        sweetAlert(2, JSON.exception, false);
    }
}

async function openDelete(id) {
    // Llamada a la función para mostrar un mensaje de confirmación, capturando la respuesta en una constante.
    const RESPONSE = await confirmAction('¿Desea eliminar el pedido de forma permanente?');
    // Se verifica la respuesta del mensaje.
    if (RESPONSE) {
        // Se define una constante tipo objeto con los datos del registro seleccionado.
        const FORM = new FormData();
        FORM.append('id_pedido', id);
        // Petición para eliminar el registro seleccionado.
        const JSON = await dataFetch(PEDIDO_API, 'delete', FORM);
        // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
        if (JSON.status) {
            // Se carga nuevamente la tabla para visualizar los cambios.
            fillTable();
            // Se muestra un mensaje de éxito.
            sweetAlert(1, JSON.message, true);
        } else {
            sweetAlert(2, JSON.exception, false);
        }
    }
}

async function fillTableDetalle(id) {
    // Se inicializa el contenido de la tabla.
    TBODYDETALLE_ROWS.innerHTML = '';
    RECORDSDETALLE.textContent = '';
    const FORM = new FormData();
    FORM.append('id_pedido', id);
    // Petición para obtener los registros disponibles.
    const JSON = await dataFetch(PEDIDO_API, 'readAllDetallePedido', FORM);
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
    if (JSON.status) {
        DETALLE_MODAL.show();
        // Se recorre el conjunto de registros fila por fila.
        JSON.dataset.forEach(row => {

            // Se crean y concatenan las filas de la tabla con los datos de cada registro.
            TBODYDETALLE_ROWS.innerHTML += `
            <tr>
                <td>${row.nombre_producto}</td>
                <td>${row.cantidad_producto}</td>
                <td>${row.precio_producto}</td>
                <td>${row.id_pedido}</td>
                <td>
                   


                    <button onclick="deleteDetalle(${row.id_detalle_pedido})" class="btn btn-danger"><img height="20px"
                            width="20px" src="../../resources/img/imgtablas/delete.png" alt="eliminar">
                    </button>
                </td>
            </tr>
            `;
        });

        RECORDSDETALLE.textContent = JSON.message;
    } else {
        sweetAlert(4, JSON.exception, true); 
    }
}
