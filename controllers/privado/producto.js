const PRODUCTO_API = 'business/privado/producto.php';

const CATEGP_API = 'business/privado/categoriap.php';

const USUARIOP_API = 'business/privado/usuario.php';
// Constante para cambiarle el titulo a el modal
const MODAL_TITLE = document.getElementById('modal-title');

const SAVE_MODAL = new bootstrap.Modal(document.getElementById('agregarproducto'));


const VALO_MODAL = new bootstrap.Modal(document.getElementById('lascalificaciones'));


// Constantes para cuerpo de la tabla
const TBODY_ROWS = document.getElementById('tbody-rows');
//VALO
const TBODYVALO_ROWS = document.getElementById('tbody-rowsv');
const RECORDSVALO = document.getElementById('recordsv');

const RECORDS = document.getElementById('records');

const SAVE_FORM = document.getElementById('save-form');

const SEARCH_FORM = document.getElementById('search-form');

document.addEventListener('DOMContentLoaded', () => {
    // Llamada a la función para llenar la tabla con los registros disponibles.
    fillTable();
});




 // <td><img src="${SERVER_URL}imagenes/productos/${row.imagen_principal}" class="materialboxed" height="100"></td>
            // <td><i class="material-icons">${icon}</i></td>
         //   (row.estado_producto) ? icon = 'visibility' : icon = 'visibility_off';
            
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
    const JSON = await dataFetch(PRODUCTO_API, action, FORM);
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
    if (JSON.status) {
        // Se cierra la caja de diálogo.
        SAVE_MODAL.hide();
        // Se carga nuevamente la tabla para visualizar los cambios.
        fillTable();

        // Se muestra un mensaje de éxito.
        sweetAlert(1, JSON.message, true);
    } else {
        sweetAlert(2, JSON.exception, false);
    }
});

function openCreate() {

    SAVE_MODAL.show();
    SAVE_FORM.reset();
    fillSelect(CATEGP_API, 'readAll', 'catgp');
    fillSelect(USUARIOP_API, 'readAll', 'usuap');
    // Se asigna título a la caja de diálogo.
    MODAL_TITLE.textContent = 'Crear producto';

}

async function fillTable(form = null) {
    // Se inicializa el contenido de la tabla.
    TBODY_ROWS.innerHTML = '';
    RECORDS.textContent = '';
    // Se verifica la acción a realizar.
    (form) ? action = 'search' : action = 'readAll';
    // Petición para obtener los registros disponibles.
    const JSON = await dataFetch(PRODUCTO_API, action, form);
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
    if (JSON.status) {
        // Se recorre el conjunto de registros fila por fila.
        JSON.dataset.forEach(row => {

          (row.estado_producto) ? icon = 'visibility' : icon = 'visibility_off';
            // Se crean y concatenan las filas de la tabla con los datos de cada registro.
            TBODY_ROWS.innerHTML += `
            <tr>

            <td><img src="${SERVER_URL}imagenes/productos/${row.imagen_principal}" class="materialboxed" height="100"></td>
                <td>${row.nombre_producto}</td>
                <td>${row.descripcion_producto}</td>
                <td>${row.descuento_producto}</td>
                <td>${row.nombre_usuario}</td>
                <td>${row.nombre_categoria}</td>
                <td><i class="material-icons">${icon}</i></td>
                <td>

                   
                    <button type="button" class="btn btn-info" onclick="openUpdate(${row.id_producto})">
                        <img height="20px" width="20px" src="../../resources/img/imgtablas/update.png" alt="actualizar">
                    </button>

                    <button onclick="openDelete(${row.id_producto})" class="btn btn-danger"><img height="20px" width="20px"
                            src="../../resources/img/imgtablas/delete.png" alt="eliminar">
                    </button>

                    <button onclick="openReport(${row.id_producto})" type="button" class="btn btn-warning">
                    <img height="20px" width="20px" src="../../resources/img/imgtablas/cuaderno.png" alt="ver">
                    </button>

                    <!-- Modal Trigger las calificaciones-->

                    <button type="button" class="btn btn-primary"  onclick="fillTableValoracion(${row.id_producto})"><img
                            height="20px" width="20px" src="../../resources/img/imgtablas/buena-valoracion.png"
                            alt="buena-valoracion">
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

async function openUpdate(id) {
    // Se define un objeto con los datos del registro seleccionado.
    const FORM = new FormData();
    FORM.append('id', id);
    // console.log(id);
    // Petición para obtener los datos del registro solicitado.
    const JSON = await dataFetch(PRODUCTO_API, 'readOne', FORM);

    // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
    if (JSON.status) {

        // Se abre la caja de diálogo que contiene el formulario.
        SAVE_MODAL.show();
        SAVE_FORM.reset();
        // Se asigna el título para la caja de diálogo (modal).
        MODAL_TITLE.textContent = 'Actualizar producto';
        // Se establece el campo de archivo como opcional.
        document.getElementById('archivo').required = false;
        // Se inicializan los campos del formulario.
        document.getElementById('id').value = JSON.dataset.id_producto;
        document.getElementById('nombrep').value = JSON.dataset.nombre_producto;
        document.getElementById('descrip').value = JSON.dataset.descripcion_producto;
        document.getElementById('descp').value = JSON.dataset.descuento_producto;
        fillSelect(CATEGP_API, 'readAll', 'catgp', JSON.dataset.id_categoria_producto);
        fillSelect(USUARIOP_API, 'readAll', 'usuap', JSON.dataset.id_usuario);
        if (JSON.dataset.estado_producto) {
            document.getElementById('estado').checked = true;
        } else {
            document.getElementById('estado').checked = false;
        }
    } else {
        sweetAlert(2, JSON.exception, false);
    }
}



async function openDelete(id) {
    // Llamada a la función para mostrar un mensaje de confirmación, capturando la respuesta en una constante.
    const RESPONSE = await confirmAction('¿Desea eliminar el producto de forma permanente?');
    // Se verifica la respuesta del mensaje.
    if (RESPONSE) {
        // Se define una constante tipo objeto con los datos del registro seleccionado.
        const FORM = new FormData();
        FORM.append('id_producto', id);
        // Petición para eliminar el registro seleccionado.
        const JSON = await dataFetch(PRODUCTO_API, 'delete', FORM);
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


// document.querySelector('.custom-file-input').addEventListener('change', function (e) { 
//    var name = document.getElementById("archivo").files[0].name; 
//    var nextSibling = e.target.nextElementSibling ;
//    nextSibling.innerText = name });

// Metdodo para valoracion
async function fillTableValoracion(id) {
    // Se inicializa el contenido de la tabla.
    TBODYVALO_ROWS.innerHTML = '';
    RECORDSVALO.textContent = '';
    const FORM = new FormData();
    FORM.append('id_producto', id);
    // Petición para obtener los registros disponibles.
    const JSON = await dataFetch(PRODUCTO_API, 'readAllValoracion', FORM);
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
    if (JSON.status) {
        VALO_MODAL.show();
        // Se recorre el conjunto de registros fila por fila.
        JSON.dataset.forEach(row => {
            (row.estado_comentario) ? icon = 'visibility' : icon = 'visibility_off';

            // Se crean y concatenan las filas de la tabla con los datos de cada registro.
            TBODYVALO_ROWS.innerHTML += `
            <tr>
                <td>${row.calificacion_producto}</td>
                <td>${row.fecha_comentario}</td>
                <td>${row.comentario_producto}</td>
                <td><i class="material-icons">${icon}</i></td>
                <td>
                   

                    <button type="button" class="btn btn-info" onclick="openUpdate(${row.id_valoracion})">
                        <img height="20px" width="20px" src="../../resources/img/imgtablas/update.png" alt="actualizar">
                    </button>

                    <button onclick="openDeleteValo(${row.id_valoracion})" class="btn btn-danger"><img height="20px"
                            width="20px" src="../../resources/img/imgtablas/delete.png" alt="eliminar">
                    </button>
                </td>
            </tr>
            `;
        });

        RECORDSVALO.textContent = JSON.message;
    } else {
        sweetAlert(4, JSON.exception, true);
    }
}


async function openDeleteValo(id) {
    console.log(id);
    // Llamada a la función para mostrar un mensaje de confirmación, capturando la respuesta en una constante.
    const RESPONSE = await confirmAction('¿Desea cambiar el estado de la valoracion?');
    // Se verifica la respuesta del mensaje.
    if (RESPONSE) {
        // Se define una constante tipo objeto con los datos del registro seleccionado.
        const FORM = new FormData();
        FORM.append('id_valoracion', id);
        // Petición para eliminar el registro seleccionado.
        const JSON = await dataFetch(PRODUCTO_API, 'deleteValo', FORM);
        // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
        if (JSON.status) {
            // Se carga nuevamente la tabla para visualizar los cambios.
            fillTableValoracion(id);
            // Se muestra un mensaje de éxito.
            sweetAlert(1, JSON.message, true);
        } else {
            sweetAlert(2, JSON.exception, false);
        }
    }
}

function openReportProductoPorMaterial() {
    // Se declara una constante tipo objeto con la ruta específica del reporte en el servidor.
    const PATH = new URL(`${SERVER_URL}reports/privado/producto_material.php`);
    // Se abre el reporte en una nueva pestaña del navegador web.
    window.open(PATH.href);
}

function openReportProductoPorMarcas() {
    // Se declara una constante tipo objeto con la ruta específica del reporte en el servidor.
    const PATH = new URL(`${SERVER_URL}reports/privado/producto_marca.php`);
    // Se abre el reporte en una nueva pestaña del navegador web.
    window.open(PATH.href);
}

function openReportTallaPorProducto() {
    // Se declara una constante tipo objeto con la ruta específica del reporte en el servidor.
    const PATH = new URL(`${SERVER_URL}reports/privado/producto_talla.php`);
    // Se abre el reporte en una nueva pestaña del navegador web.
    window.open(PATH.href);
}