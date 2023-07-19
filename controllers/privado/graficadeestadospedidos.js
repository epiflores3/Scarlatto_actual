// Constante para completar la ruta de la API.
const PEDIDO_API = 'business/privado/pedido.php';

// Método manejador de eventos para cuando el documento ha cargado.
document.addEventListener('DOMContentLoaded', () => {
  
    //Se manda a llamar al metodo, para cargarlo
    graficoPastelEstadoPedido();
 
});

//Se crea la función de que hara toda la gráfica funcione 
async function graficoPastelEstadoPedido() {
    // Petición para obtener la informarcion del gráfico.
    const JSON = await dataFetch(PEDIDO_API, 'cantidadEstadosPedidos');
    // Se comprueba si hay una respuesta, de lo contrario se quita la etiqueta canvas.
    if (JSON.status) {
        // Se declaran los arreglos para guardar la información y despues graficarlos.
        let estado = [];
        let porcentaje = [];
        // Se recorre el conjunto de registros fila a fila a través row.
        JSON.dataset.forEach(row => {
            // Se agregan los datos a los arreglos, que tienen que ir como están en la base.
            estado.push(row.estados_pedido);
            porcentaje.push(row.porcentaje);
        });
        // Llamada a la función que genera gráfico de pastel. Se encuentra en el archivo components.js
        pieGraph('chart1', estado, porcentaje, 'Porcentaje de pedidos por estado');
    } else {
        document.getElementById('chart1').remove();
        console.log(JSON.exception);
    }
}


