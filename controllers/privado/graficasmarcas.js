// Constante para completar la ruta de la API.
const PRODUCTO_API = 'business/privado/detalle_producto.php';

// Método manejador de eventos para cuando el documento ha cargado.
document.addEventListener('DOMContentLoaded', () => {
  
    graficoPastelCategorias();
 
});


async function graficoPastelCategorias() {
    // Petición para obtener los datos del gráfico.
    const JSON = await dataFetch(PRODUCTO_API, 'cantidadProductosMarcas');
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se remueve la etiqueta canvas.
    if (JSON.status) {
        // Se declaran los arreglos para guardar los datos a gráficar.
        let marcas = [];
        let porcentaje = [];
        // Se recorre el conjunto de registros fila por fila a través del objeto row.
        JSON.dataset.forEach(row => {
            // Se agregan los datos a los arreglos.
            marcas.push(row.marca);
            porcentaje.push(row.porcentaje);
        });
        // Llamada a la función que genera y muestra un gráfico de pastel. Se encuentra en el archivo components.js
        pieGraph('chart2', marcas, porcentaje, 'Porcentaje de las marcas mas vendidas');
    } else {
        document.getElementById('chart2').remove();
        console.log(JSON.exception);
    }
}

