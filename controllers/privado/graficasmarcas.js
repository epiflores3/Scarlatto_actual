// Constante para completar la ruta de la API.
const PRODUCTO_API = 'business/privado/detalle_producto.php';

// Método manejador de eventos para cuando el documento ha cargado.
document.addEventListener('DOMContentLoaded', () => {
  
    // Se manda a llamar a la función para que se muestre el gráfico.
    graficoPastelCategorias();
 
});

//Se crea la función de que hara toda la gráfica funcione 
async function graficoPastelCategorias() {
    // Petición para obtener los datos del gráfico.
    const JSON = await dataFetch(PRODUCTO_API, 'cantidadProductosMarcas');
    // Se comprueba si hay una respuesta, de lo contrario se quita la etiqueta canvas.
    if (JSON.status) {
        // Se declaran los arreglos para guardar la información y despues graficarlos.
        let marcas = [];
        let porcentaje = [];
        // Se recorre el conjunto de registros fila a fila a través row.
        JSON.dataset.forEach(row => {
            // Se agregan los datos a los arreglos, que tienen que ir como están en la base.
            marcas.push(row.marca);
            porcentaje.push(row.porcentaje);
        });
        // Llamada a la función que genera gráfico de pastel. Se encuentra en el archivo components.js
        pieGraph('chart2', marcas, porcentaje, 'Porcentaje de productos por marca');
    } else {
        document.getElementById('chart2').remove();
        console.log(JSON.exception);
    }
}

