const PEDIDO_API= 'business/publico/pedido.php';

const PARAMS = new URLSearchParams(location.search);
const PEDIDOS = document.getElementById('pedidos');

document.addEventListener('DOMContentLoaded', async () => {
    // Se define un objeto con los datos de la categoría seleccionada.
    const FORM = new FormData();
    FORM.append('id_pedido', PARAMS.get('id'));
    // Petición para solicitar los productos de la categoría seleccionada.
    const JSON = await dataFetch(PEDIDO_API, 'cargarHistorial',  FORM);
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
    if (JSON.status) {
        // Se inicializa el contenedor de productos.
        PEDIDOS.innerHTML = '';
        // Se recorre el conjunto de registros fila por fila a través del objeto row.
        JSON.dataset.forEach(row => {
            
                 // Se crean y concatenan las tarjetas con los datos de cada producto.
                 PEDIDOS.innerHTML += `
                 <div class="card my-2">
                 <h5 class="card-header">Fecha: ${row.fecha_pedido}</h5>
                 <div class="card-body">
                     <h5 class="card-title">Pedido: ${row.estados_pedido}</h5>
                     <p class="card-text">Direccion: ${row.direccion_pedido}</p>
                    
                     <a class="buttonpre" href="detalle_compra.html?id=${row.id_pedido}">Ver compra</a>
                 </div>
             </div>
        `;
        });
    } 
});