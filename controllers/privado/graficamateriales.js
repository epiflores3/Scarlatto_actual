// Constante para completar la ruta de la API.
const MATERIAL_API = 'business/privado/material.php';

// Método manejador de eventos para cuando el documento ha cargado.
document.addEventListener('DOMContentLoaded', () => {
  
    graficoBarrasCategorias();
 
});


async function graficoBarrasCategorias() {
    // Petición para obtener los datos del gráfico.
    const JSON = await dataFetch(MATERIAL_API, 'cantidadProductosMaterial');
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se remueve la etiqueta canvas.
    if (JSON.status) {
        // Se declaran los arreglos para guardar los datos a graficar.
        let material = [];
        let cantidades = [];
        // Se recorre el conjunto de registros fila por fila a través del objeto row.
        JSON.dataset.forEach(row => {
            // Se agregan los datos a los arreglos.
            material.push(row.nombre_material);
            cantidades.push(row.cantidad);
        });
        // Llamada a la función que genera y muestra un gráfico de barras. Se encuentra en el archivo components.js
        barGraph('chart1', material, cantidades, 'Cantidad de productos', 'Cantidad de productos por material');
    } else {
        document.getElementById('chart1').remove();
        console.log(JSON.exception);
    }
}

