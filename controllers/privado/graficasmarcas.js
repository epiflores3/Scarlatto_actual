// Constante para acceder a la ruta de API.
const PRODUCTO_API = 'business/privado/detalle_producto.php';

//Método que se utiliza cuando el mantenimiento leer ha cargado
document.addEventListener('DOMContentLoaded', () => {
    //Se manda a llamar al metodo, para cargarlo 
    graficoPastelCategorias();
});

//Se crea la función de que hará que la gráfica funcione 
async function graficoPastelCategorias() {
    // Solicitar la informarcion del gráfico.
    const JSON = await dataFetch(PRODUCTO_API, 'cantidadProductosMarcas');
    // Se comprueba si hay una respuesta a lo solicitado, sino se quita la etiqueta canvas.
    if (JSON.status) {
        // Se declaran los arreglos para guardar la información y luego graficarlos.
        let marcas = [];
        let porcentaje = [];
        // Se recorre el conjunto de registro dato a dato a través row.
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

