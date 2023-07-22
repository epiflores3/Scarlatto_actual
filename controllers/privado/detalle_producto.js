// Constante para dirgirse a la ruta de API.
const DETALLE_PRODUCTO_API = 'business/privado/detalle_producto.php';
// Constante para obtener los datos del archivo a utilizar y poder realizar el combobox
const PRODUCTO_API = 'business/privado/producto.php';
// Constante para obtener los datos del archivo a utilizar y poder realizar el combobox
const MATERIAL_API = 'business/privado/material.php';
// Constante para obtener los datos del archivo a utilizar y poder realizar el combobox
const TALLA_API = 'business/privado/talla.php';
// Constante para obtener los datos del archivo a utilizar y poder realizar el combobox
const MARCA_API = 'business/privado/marca.php';
// Constante para obtener los datos del archivo a utilizar y poder realizar el combobox
const MODAL_TITLE = document.getElementById('modal-title');
//Constante para poder guardar los datos del modal
const SAVE_MODAL = new bootstrap.Modal(document.getElementById('agregar_detalle_producto'));
// Constante para poder hacer uso del formulario de buscar.
const SEARCH_FORM = document.getElementById('search-form');
// Constantes para cuerpo de la tabla
const TBODY_ROWS = document.getElementById('tbody-rows');
const RECORDS = document.getElementById('records');
//Constante para poder guardar los datos del formulario
const SAVE_FORM = document.getElementById('save-form');

//Método que se utiliza cuando el mantenimiento leer ha cargado
document.addEventListener('DOMContentLoaded', () => {
    // Llena la tabla con los registros que existan.
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

SAVE_FORM.addEventListener('submit', async (event) => {
    // Se evita recargar la página web después de enviar el formulario.
    event.preventDefault();
    // Se verifica la acción a realizar.
    (document.getElementById('id').value) ? action = 'update' : action = 'create';
    // Constante tipo objeto con los datos del formulario.
    const FORM = new FormData(SAVE_FORM);
    // Petición para guardar los datos del formulario.
    const JSON = await dataFetch(DETALLE_PRODUCTO_API, action, FORM);
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
    const JSON = await dataFetch(DETALLE_PRODUCTO_API, action, form);
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
    if (JSON.status) {
        // Se recorre el conjunto de registros fila por fila.
        JSON.dataset.forEach(row => {
            // Se crean y concatenan las filas de la tabla con los datos de cada registro.
            TBODY_ROWS.innerHTML += `
            <tr>

                <td>${row.existencia}</td>
                <td>${row.nombre_producto}</td>
                <td>${row.marca}</td>
                <td>${row.nombre_material}</td>
                <td>${row.talla}</td>
                <td>

                    <button onclick="openReport(${row.id_detalle_producto})" type="button" class="btn btn-success">
                        <img height="20px" width="20px" src="../../resources/img/imgtablas/ojo.png" alt="ver">
                    </button>

                    <button onclick="openUpdate(${row.id_detalle_producto})" type="button" class="btn btn-info" data-bs-toggle="modal"
                        data-bs-target="#editartalla"><img height="20px" width="20px" src="../../resources/img/imgtablas/update.png"
                            alt="actualizar">
                    </button>

                    <button onclick="openDelete(${row.id_detalle_producto})" type="button" class="btn btn-danger"><img height="20px"
                            width="20px" src="../../resources/img/imgtablas/delete.png" alt="eliminar">
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
    MODAL_TITLE.textContent = 'Crear detalle del pedido';
    fillSelect(PRODUCTO_API, 'readAll', 'producto');
    fillSelect(MATERIAL_API, 'readAll', 'material');
    fillSelect(TALLA_API, 'readAll', 'talla');
    fillSelect(MARCA_API, 'readAll', 'marca');
}

async function openUpdate(id) {
    // Se define una constante tipo objeto con los datos del registro seleccionado.
    const FORM = new FormData();
    FORM.append('id_detalle_producto', id);
    // Petición para obtener los datos del registro solicitado.
    const JSON = await dataFetch(DETALLE_PRODUCTO_API, 'readOne', FORM);
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
    if (JSON.status) {
        SAVE_MODAL.show();
        // Se asigna título para la caja de diálogo.
        MODAL_TITLE.textContent = 'Actualizar detalle del producto';
        // Se inicializan los campos del formulario.
        document.getElementById('id').value = JSON.dataset.id_detalle_producto;
        document.getElementById('existencia').value = JSON.dataset.existencia;
        fillSelect(PRODUCTO_API, 'readAll', 'producto', JSON.dataset.id_producto);
        fillSelect(MATERIAL_API, 'readAll', 'material', JSON.dataset.id_material);
        fillSelect(TALLA_API, 'readAll', 'talla', JSON.dataset.id_talla);
        fillSelect(MARCA_API, 'readAll', 'marca', JSON.dataset.id_marca);

    } else {
        sweetAlert(2, JSON.exception, false);
    }
}

async function openDelete(id) {
    // Llamada a la función para mostrar un mensaje de confirmación, capturando la respuesta en una constante.
    const RESPONSE = await confirmAction('¿Desea eliminar el detalle del producto de forma permanente?');
    // Se verifica la respuesta del mensaje.
    if (RESPONSE) {
        // Se define una constante tipo objeto con los datos del registro seleccionado.
        const FORM = new FormData();
        FORM.append('id_detalle_producto', id);
        // Petición para eliminar el registro seleccionado.
        const JSON = await dataFetch(DETALLE_PRODUCTO_API, 'delete', FORM);
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


function openReportTallaPorMaterial() {
    // Se declara una constante tipo objeto con la ruta específica del reporte en el servidor.
    const PATH = new URL(`${SERVER_URL}reports/privado/detalle_productos.php`);
    // Se abre el reporte en una nueva pestaña del navegador web.
    window.open(PATH.href);
}

function openReportProductosPorMaterial() {
    // Se declara una constante tipo objeto con la ruta específica del reporte en el servidor.
    const PATH = new URL(`${SERVER_URL}reports/privado/producto_material.php`);
    // Se abre el reporte en una nueva pestaña del navegador web.
    window.open(PATH.href);
}

function openReportTallaPorMarca() {
    // Se declara una constante tipo objeto con la ruta específica del reporte en el servidor.
    const PATH = new URL(`${SERVER_URL}reports/privado/talla_marca.php`);
    // Se abre el reporte en una nueva pestaña del navegador web.
    window.open(PATH.href);
}