// Constante para completar la ruta de la API.
const PEDIDO_API = 'business/privado/pedido.php';

// Método manejador de eventos para cuando el documento ha cargado.
document.addEventListener('DOMContentLoaded', () => {
  
    graficoPastelEstadoPedido();
 
});


async function graficoPastelEstadoPedido() {
    // Petición para obtener los datos del gráfico.
    const JSON = await dataFetch(PEDIDO_API, 'cantidadEstadosPedidos');
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se remueve la etiqueta canvas.
    if (JSON.status) {
        // Se declaran los arreglos para guardar los datos a gráficar.
        let estado = [];
        let porcentaje = [];
        // Se recorre el conjunto de registros fila por fila a través del objeto row.
        JSON.dataset.forEach(row => {
            // Se agregan los datos a los arreglos.
            estado.push(row.estados_pedido);
            porcentaje.push(row.porcentaje);
        });
        // Llamada a la función que genera y muestra un gráfico de pastel. Se encuentra en el archivo components.js
        pieGraph('chart1', estado, porcentaje, 'Porcentaje de los estados de los pedidos');
    } else {
        document.getElementById('chart1').remove();
        console.log(JSON.exception);
    }
}

