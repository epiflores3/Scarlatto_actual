// Constante para completar la ruta de la API.
const PEDIDOS_API = 'business/privado/pedido.php';
const SAVE_FORM = document.getElementById('save-form');

// Método manejador de eventos para cuando el documento ha cargado.
document.addEventListener('DOMContentLoaded', () => {


});

SAVE_FORM.addEventListener('submit', async (event) => {
    // Se evita recargar la página web después de enviar el formulario.
    event.preventDefault();
    // Se verifica la acción a realizar.

    // Constante tipo objeto con los datos del formulario.
    const FORM = new FormData(SAVE_FORM);
    // Petición para guardar los datos del formulario.
    const JSON = await dataFetch(PEDIDOS_API, 'cantidadDePedidosMasSolicitados', FORM);
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
    if (JSON.status) {
        // Se declaran los arreglos para guardar los datos a gráficar.
        let fechas = [];
        let pedidos = [];
        // Se recorre el conjunto de registros fila por fila a través del objeto row.
        JSON.dataset.forEach(row => {
            // Se agregan los datos a los arreglos.
            fechas.push(row.fecha_pedido);
            pedidos.push(row.pedidos);
        });
        document.getElementById('grafico').innerHTML = '<canvas id="chart2"></canvas>';
        // Llamada a la función que genera y muestra un gráfico de pastel. Se encuentra en el archivo components.js
        lineGraph('chart2', fechas, pedidos, 'Cantidad de pedidos', 'Top 5 de fechas con mas pedidos' );
        sweetAlert(1, JSON.message, true);

    } else {
        sweetAlert(2, JSON.exception, false);
        document.getElementById('chart2').remove();
    }
});

