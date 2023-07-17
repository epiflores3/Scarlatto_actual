const PEDIDO_API = 'business/publico/pedido.php';
const VALO_API = 'business/publico/valoracion.php';

const PARAMS = new URLSearchParams(location.search);

const TITULO = document.getElementById('title');
const VERCOMPRA = document.getElementById('vercompra');

const SAVE_FORM = document.getElementById('save-form');
const SAVE_MODAL = new bootstrap.Modal(document.getElementById('agregarvalo'));


document.addEventListener('DOMContentLoaded', async () => {
// Se define un objeto con los datos de la categoría seleccionada.
const FORM = new FormData();
FORM.append('id_pedido', PARAMS.get('id'));

ProductosCompra(FORM);

});

    async function ProductosCompra(form) {
    const JSON = await dataFetch(PEDIDO_API, 'cargarVerCompra', form);
    if (JSON.status) {
    JSON.dataset.forEach(async (row) => {

    const FORM = new FormData();
    FORM.append('id_detallepedido', row.id_detalle_pedido);

    const JSONDP = await dataFetch(VALO_API, 'validarComentarios', FORM);
    if (row.estados_pedido == 'Finalizado') {
    if (JSONDP.dataset === false) {

        VERCOMPRA.innerHTML += `
        <div class="card my-5 ">
            <div class="card-img">
                <img src="${SERVER_URL}imagenes/productos/${row.imagen_principal}">
            </div>
            <div class="card-title">
                <h3>${row.nombre_producto}</h3>
                <p>${row.descripcion_producto}</p>
            </div>
            <div class="card-details">
                <div class="volume">
                    <span>Catidad pedida</span>
                    <p>${row.cantidad_producto}</p>
                    <span>Precio producto</span>
                    <p>${row.precio_producto}</p>
                </div>
            </div>
            <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#agregarvalo"
                onclick="openCreate(${row.id_pedido}, ${row.id_detalle_pedido})"> Comentar
            </button>
        </div>

        `;

    }else{
        VERCOMPRA.innerHTML += `
        <div class="card my-5 ">
            <div class="card-img">
                <img src="${SERVER_URL}imagenes/productos/${row.imagen_principal}">
            </div>
            <div class="card-title">
                <h3>${row.nombre_producto}</h3>
                <p>${row.descripcion_producto}</p>
            </div>
            <div class="card-details">
                <div class="volume">
                    <span>Catidad pedida</span>
                    <p>${row.cantidad_producto}</p>
                    <span>Precio producto</span>
                    <p>${row.precio_producto}</p>
                </div>
            </div>
            <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#agregarvalo"
                onclick="openCreate(${row.id_pedido}, ${row.id_detalle_pedido})"> Comentado
            </button>

        </div>

        `;
    }

    }
    else {
        VERCOMPRA.innerHTML += `
        <div class="card my-5">
            <div class="card-img">
                <img src="${SERVER_URL}imagenes/productos/${row.imagen_principal}">
            </div>
            <div class="card-title">
                <h3>${row.nombre_producto}</h3>
                <p>${row.descripcion_producto}</p>
            </div>
            <div class="card-details">
                <div class="volume">
                    <span>Catidad pedida</span>
                    <p>${row.cantidad_producto}</p>
                    <span>Precio producto</span>
                    <p>${row.precio_producto}</p>
                </div>
            </div>

        </div>
        `;
    }
    })
    }
    }

SAVE_FORM.addEventListener('submit', async (event) => {
// Se evita recargar la página web después de enviar el formulario.
event.preventDefault();
// Constante tipo objeto con los datos del formulario.
const FORM = new FormData(SAVE_FORM);
// Petición para guardar los datos del formulario.
const JSON = await dataFetch(VALO_API, 'createValoComentario', FORM);
// Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
if (JSON.status) {
// Se cierra la caja de diálogo.
SAVE_MODAL.hide();

// Se muestra un mensaje de éxito.
sweetAlert(1, JSON.message, true);
} else {
sweetAlert(2, JSON.exception, false);
}
});

function openCreate(id_pedido, id_detalle_pedido) {

SAVE_MODAL.show();
document.getElementById('id').value = id_pedido;
document.getElementById('iddetallepedido').value = id_detalle_pedido;

}