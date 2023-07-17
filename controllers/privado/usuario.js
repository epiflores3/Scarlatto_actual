// Constante que cnecta php con javaScript
const USUARIO_API = 'business/privado/usuario.php';
const TIPOUS_API ='business/privado/tipo_usuario.php';
const ESTADO_API ='business/privado/estado_usuario.php';

const MODAL_TITLE = document.getElementById('modal-title');

const SAVE_MODAL = new bootstrap.Modal(document.getElementById('agregarusuario'));

const SAVE_FORM = document.getElementById('save-form');

const SEARCH_FORM = document.getElementById('search-form');
// Constantes para cuerpo de la tabla
const TBODY_ROWS = document.getElementById('tbody-rows');

const RECORDS = document.getElementById('records');


document.addEventListener('DOMContentLoaded', () => {
    // llama a la tabla
    fillTable();
});

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
    const JSON = await dataFetch(USUARIO_API, action, FORM);
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
    const JSON = await dataFetch(USUARIO_API, action, form);
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
    if (JSON.status) {
        // Se recorre el conjunto de registros fila por fila.
        JSON.dataset.forEach(row => {
            
            // Se crean y concatenan las filas de la tabla con los datos de cada registro.
            TBODY_ROWS.innerHTML += `
            <tr>
                <td>${row.nombre_usuario}</td>
                <td>${row.apellido_usuario}</td>
                <td>${row.correo_usuario}</td>
                <td>${row.alias_usuario}</td>
                <td>${row.tipo_usuario}</td>
                <td>${row.estado_usuario}</td>
                <td>

                    <button onclick="openReport(${row.id_usuario})" type="button" class="btn btn-success">
                        <img height="20px" width="20px" src="../../resources/img/imgtablas/ojo.png" alt="ver">
                    </button>

                    <button onclick="openUpdate(${row.id_usuario})" type="button" class="btn btn-info" data-bs-toggle="modal"
                        data-bs-target="#editartalla"><img height="20px" width="20px" src="../../resources/img/imgtablas/update.png"
                            alt="actualizar">
                    </button>

                    <button onclick="openDelete(${row.id_usuario})" class="btn btn-danger"><img height="20px"
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
    MODAL_TITLE.textContent = 'Crear Usuario';
   // cargar cmb
    fillSelect(TIPOUS_API, 'readAll', 'tipousuario');
    fillSelect(ESTADO_API, 'readAll', 'estadous');

}

async function openUpdate(id) {
    // Se define una constante tipo objeto con los datos del registro seleccionado.
    const FORM = new FormData();
    FORM.append('id_usuario', id);
    // Petición para obtener los datos del registro solicitado.
    const JSON = await dataFetch(USUARIO_API, 'readOne', FORM);
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
    if (JSON.status) {
        SAVE_MODAL.show();
        // Se asigna título para la caja de diálogo.
        MODAL_TITLE.textContent = 'Actualizar usuario';
        // Se inicializan los campos del formulario.
        document.getElementById('id').value = JSON.dataset.id_usuario;
        document.getElementById('nombreus').value = JSON.dataset.nombre_usuario;
        document.getElementById('apellidous').value = JSON.dataset.apellido_usuario;
        document.getElementById('correous').value = JSON.dataset.correo_usuario;
        document.getElementById('aliasus').value = JSON.dataset.alias_usuario;
        document.getElementById('claveus').value = JSON.dataset.clave_usuario;
        fillSelect(TIPOUS_API, 'readAll', 'tipousuario', JSON.dataset.id_tipo_usuario);
        fillSelect(ESTADO_API, 'readAll', 'estadous', JSON.dataset.id_estado_usuario);
    } else {
        sweetAlert(2, JSON.exception, false);
    }
}


async function openDelete(id) {
    // Llamada a la función para mostrar un mensaje de confirmación, capturando la respuesta en una constante.
    const RESPONSE = await confirmAction('¿Desea eliminar la categoría de forma permanente?');
    // Se verifica la respuesta del mensaje.
    if (RESPONSE) {
        // Se define una constante tipo objeto con los datos del registro seleccionado.
        const FORM = new FormData();
        FORM.append('id_usuario', id);
        // Petición para eliminar el registro seleccionado.
        const JSON = await dataFetch(USUARIO_API, 'delete', FORM);
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
