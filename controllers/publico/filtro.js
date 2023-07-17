// Constante para completar la ruta de la API.
const FILTRO_API = 'business/publico/filtro.php';
// Constante para establecer el contenedor de categorías.
const FILTRO = document.getElementById('anillos');
// Constante tipo objeto para establecer las opciones del componente Slider.
const OPTIONS = {
    height: 300
}
// Se inicializa el componente Slider para que funcione el carrusel de imágenes.
// M.Slider.init(document.querySelectorAll('.slider'), OPTIONS);

// Método manejador de eventos para cuando el documento ha cargado.
document.addEventListener('DOMContentLoaded', async () => {
    // Petición para obtener las categorías disponibles.
    const JSON = await dataFetch(FILTRO_API, 'readAll');
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
    if (JSON.status) {
        // Se inicializa el contenedor de categorías.
        FILTRO.innerHTML = '';
        // Se recorre el conjunto de registros fila por fila a través del objeto row.
        JSON.dataset.forEach(row => {
            // Se establece la página web de destino con los parámetros.
            url = `producto.html?id=${row.nombre_producto}&nombre=${row.nombre_categoria}`;
            // Se crean y concatenan las tarjetas con los datos de cada categoría.
            FILTRO.innerHTML += `
           
            <div class="col s12 m6 l4">
            <div class="card hoverable">
                <div class="card-image waves-effect waves-block waves-light">
                    
                </div>
                <div class="card-content">
                    <span class="card-title activator grey-text text-darken-4">
                        <b>${row.nombre_categoria}</b>
                        <i class="material-icons right tooltipped" data-tooltip="Descripción">more_vert</i>
                    </span>
                    <p class="center">
                        <a href="${url}" class="tooltipped" data-tooltip="Ver productos">
                            <i class="material-icons">local_cafe</i>
                        </a>
                    </p>
                </div>
                
                  
                </div>
            </div>
        </div>
            `;
        });
        // Se inicializa el componente Tooltip para que funcionen las sugerencias textuales.
        // M.Tooltip.init(document.querySelectorAll('.tooltipped'));
    } else {
        // Se asigna al título del contenido de la excepción cuando no existen datos para mostrar.
        document.getElementById('title').textContent = JSON.exception;
    }
});