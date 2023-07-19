// Constante para completar la ruta de la API.
const DETALLEPRODUCTO_API = 'business/privado/detalle_producto.php';

// Método manejador de eventos para cuando el documento ha cargado.
document.addEventListener('DOMContentLoaded', () => {
 
    // Se manda a llamar a la función para que se muestre el gráfico.
    graficoDoughnutProducto();
});

//Se crea la función de que hara toda la gráfica funcione 
async function graficoDoughnutProducto() {
    // Petición para obtener los datos del gráfico.
    const JSON = await dataFetch(DETALLEPRODUCTO_API, 'porcentajeProducto');
    // Se comprueba si hay una respuesta, de lo contrario se quita la etiqueta canvas.
    if (JSON.status) {
        // Se declaran los arreglos para guardar la información y despues graficarlos.
        let productos = [];
        let porcentajes = [];
        // Se recorre el conjunto de registros fila a fila a través row.
        JSON.dataset.forEach(row => {
            // Se agregan los datos a los arreglos, que tienen que ir como están en la base.
            productos.push(row.nombre_producto);
            porcentajes.push(row.porcentaje);
        });
        // Llamada a la función que genera gráfico de porcentaje. Se encuentra en el archivo components.js
        doughnutGraph('chart2', productos, porcentajes, 'Top 6 de productos con más detalles');
    } else {
        document.getElementById('chart2').remove();
        console.log(JSON.exception);
    }
}