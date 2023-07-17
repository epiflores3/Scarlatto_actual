// Constante para completar la ruta de la API.
const PRODUCTO_API = 'business/publico/producto.php';
// Constante tipo objeto para obtener los parámetros disponibles en la URL.
const PARAMS = new URLSearchParams(location.search);
// Constantes para establecer el contenido principal de la página web.
const TITULO = document.getElementById('title');
const PRODUCTOS = document.getElementById('productos');
const PRODUCTOSV = document.getElementById('productosmasvendidos');
/*Todos los productos*/
// Método manejador de eventos para cuando el documento ha cargado.
document.addEventListener('DOMContentLoaded', async () => {
    // Se define un objeto con los datos de la categoría seleccionada.
    const FORM = new FormData();
    FORM.append('id_producto', PARAMS.get('id'));
    // Petición para solicitar los productos de la categoría seleccionada.
    const JSON = await dataFetch(PRODUCTO_API, 'readProductosCatalogo', FORM);
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
    if (JSON.status) {
        // Se inicializa el contenedor de productos.
        PRODUCTOS.innerHTML = '';
        // Se recorre el conjunto de registros fila por fila a través del objeto row.
        JSON.dataset.forEach(row => {
            // Se crean y concatenan las tarjetas con los datos de cada producto.
            PRODUCTOS.innerHTML += `

            <div class="card col-5 my-5">
            <div class="card-img">
                <img src="${SERVER_URL}imagenes/productos/${row.imagen_principal}">
            </div>
            <div class="card-title">
                <h3>${row.nombre_producto}</h3>
                <p>${row.nombre_categoria}</p>
            </div>
            <div class="card-details">
                <div class="volume">
                    <span>Material</span>
                    <p>${row.nombre_material}</p>
                </div>
                <div class="volume">
                <span>Marca</span>
                    <p>${row.marca}</p>
                </div>
            </div>
            <a class="buttonpre" href="detalle_producto.html?id=${row.id_producto}">Ver detalle</a>
        </div>

            `;  
        });
        // Se asigna como título la categoría de los productos.
        // TITULO.textContent = PARAMS.get('nombre');
    } else {
        // Se presenta un mensaje de error cuando no existen datos para mostrar.
        TITULO.textContent = JSON.exception;
    }
});

/*Lo mas comprado */
// Método manejador de eventos para cuando el documento ha cargado.
// document.addEventListener('DOMContentLoaded', async () => {
//     // Se define un objeto con los datos de la categoría seleccionada.
//     const FORM = new FormData();
//     FORM.append('id_producto', PARAMS.get('id'));
//     // Petición para solicitar los productos de la categoría seleccionada.
//     const JSON = await dataFetch(PRODUCTO_API, 'readProductosMasVendidos', FORM);
//     // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
//     if (JSON.status) {
//         // Se inicializa el contenedor de productos.
//         PRODUCTOSV.innerHTML = '';
//         // Se recorre el conjunto de registros fila por fila a través del objeto row.
//         JSON.dataset.forEach(row => {
//             // Se crean y concatenan las tarjetas con los datos de cada producto.
//             PRODUCTOSV.innerHTML += `
           
//                     <div class="card col">
//                     <div class="card-img">
//                         <img src="${SERVER_URL}imagenes/productos/${row.imagen_principal}">
//                     </div>
//                     <div class="card-title">
//                         <h3>${row.nombre_producto}</h3>
//                         <p>${row.nombre_categoria}</p>
//                     </div>
//                     <div class="card-details">
//                         <div class="price">
//                             <span>Precio</span>
//                             <p>$${row.precio_producto}</p>
//                         </div>
//                         <div class="volume">
//                             <span>Material</span>
//                             <p>${row.nombre_material}</p>
//                         </div>
//                     </div>
//                     <a class="buttonpre" href="detalle_producto.html?id=${row.id_producto}">Ver detalle</a>
//                 </div>
//             `;  
//         });
//         // Se asigna como título la categoría de los productos.
//         TITULO.textContent = PARAMS.get('nombre');
//     } else {
//         // Se presenta un mensaje de error cuando no existen datos para mostrar.
//         TITULO.textContent = JSON.exception;
//     }
// });

