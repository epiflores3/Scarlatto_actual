// Constante para completar la ruta de la API.
const PEDIDOS_API = 'business/privado/pedido.php';
const SAVE_FORM = document.getElementById('save-form');

//Método que se ejecuta al cargar la página
document.addEventListener('DOMContentLoaded', () => {


});

SAVE_FORM.addEventListener('submit', async (event) => {
    // Evita cargar la pagina despues de enviar el formulario
    event.preventDefault();
    // Verifica la acción que se hara

    // Se declara una constante de tipo FORM.
    const FORM = new FormData(SAVE_FORM);
    // Pide guardar los datos del formulario
    const JSON = await dataFetch(PEDIDOS_API, 'cantidadDePedidosMasSolicitados', FORM);
    // Se comprubea si se hizo la acción.
    if (JSON.status) {
        // Se declaran arreglos para guardar los datos.
        let fechas = [];
        let pedidos = [];
        // Se recorren las filas una por una
        JSON.dataset.forEach(row => {
            // Se agregan los datos a los arreglos.
            fechas.push(row.fecha_pedido);
            pedidos.push(row.pedidos);
        });
        document.getElementById('grafico').innerHTML = '<canvas id="chart2"></canvas>';
        // Llamada a la función que genera y muestra un gráfico 
        lineGraph('chart2', fechas, pedidos, 'Cantidad de pedidos', 'Top 5 de fechas con mas pedidos' );
        sweetAlert(1, JSON.message, true);

    } else {
        sweetAlert(2, JSON.exception, false);
        document.getElementById('chart2').remove();
    }
});

