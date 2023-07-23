// Constante para dirgirse a la ruta de API.
const MATERIAL_API = 'business/privado/material.php';

//Método que se utiliza cuando el mantenimiento leer ha cargado
document.addEventListener('DOMContentLoaded', () => {
  //Se manda a llamar al metodo, para cargarlo 
  graficoBarrasCategorias();
});

//Se crea la función de que hará que la gráfica funcione 
async function graficoBarrasCategorias() {
    // Solicitar la informarcion del gráfico.
    const JSON = await dataFetch(MATERIAL_API, 'cantidadProductosMaterial');
    // Se comprueba si hay una respuesta a lo solicitado, sino se quita la etiqueta canvas.
    if (JSON.status) {
        // Se declaran los arreglos para guardar la información y luego graficarlos.
        let material = [];
        let cantidades = [];
        // Se recorre el conjunto de registros fila a fila a través row.
        JSON.dataset.forEach(row => {
            // Se agregan los datos a los arreglos, que tienen que ir como están en la base.
            material.push(row.nombre_material);
            cantidades.push(row.cantidad);
        });
        // Llamada a la función que genera gráfico de bsrrs. Se encuentra en el archivo components.js
        barGraph('chart1', material, cantidades, 'Cantidad de productos', 'Cantidad de productos por material');
    } else {
        document.getElementById('chart1').remove();
        console.log(JSON.exception);
    }
}

