// Constante para completar la ruta de la API.
const DETALLEPRODUCTO_API = 'business/privado/detalle_producto.php';

// Método manejador de eventos para cuando el documento ha cargado.
document.addEventListener('DOMContentLoaded', () => {
 
    graficoDoughnutProducto();
});


async function graficoDoughnutProducto() {
    // Petición para obtener los datos del gráfico.
    const JSON = await dataFetch(DETALLEPRODUCTO_API, 'porcentajeProducto');
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se remueve la etiqueta canvas.
    if (JSON.status) {
        // Se declaran los arreglos para guardar los datos a gráficar.
        let productos = [];
        let porcentajes = [];
        // Se recorre el conjunto de registros fila por fila a través del objeto row.
        JSON.dataset.forEach(row => {
            // Se agregan los datos a los arreglos.
            productos.push(row.nombre_producto);
            porcentajes.push(row.porcentaje);
        });
        // Llamada a la función que genera y muestra un gráfico de pastel. Se encuentra en el archivo components.js
        doughnutGraph('chart2', productos, porcentajes, 'Top 6 de productos con más detalles');
    } else {
        document.getElementById('chart2').remove();
        console.log(JSON.exception);
    }
}