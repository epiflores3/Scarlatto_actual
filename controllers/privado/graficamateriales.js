// Constante para completar la ruta de la API.
const MATERIAL_API = 'business/privado/material.php';

// Método manejador de eventos para cuando el documento ha cargado.
document.addEventListener('DOMContentLoaded', () => {
  
    // Se manda a llamar a la función para que se muestre el gráfico.
    graficoBarrasCategorias();
 
});

//Se crea la función de que hara toda la gráfica funcione 
async function graficoBarrasCategorias() {
    // Petición para obtener los datos del gráfico.
    const JSON = await dataFetch(MATERIAL_API, 'cantidadProductosMaterial');
    // Se comprueba si hay una respuesta, de lo contrario se quita la etiqueta canvas.
    if (JSON.status) {
        // Se declaran los arreglos para guardar la información y despues graficarlos.
        let material = [];
        let cantidades = [];
        // Se recorre el conjunto de registros fila a fila a través row.
        JSON.dataset.forEach(row => {
            // Se agregan los datos a los arreglos, que tienen que ir como están en la base.
            material.push(row.nombre_material);
            cantidades.push(row.cantidad);
        });
        // Llamada a la función que genera gráfico de barra. Se encuentra en el archivo components.js
        barGraph('chart1', material, cantidades, 'Cantidad de productos', 'Cantidad de productos por material');
    } else {
        document.getElementById('chart1').remove();
        console.log(JSON.exception);
    }
}

