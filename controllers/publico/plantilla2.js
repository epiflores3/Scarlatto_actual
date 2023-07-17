// Constante para completar la ruta de la API.
const USER_API = 'business/publico/cliente.php';


const NAV = document.querySelector('nav');
const FOOTER = document.querySelector('footer');

document.addEventListener('DOMContentLoaded', async () => {
// Petición para obtener en nombre del usuario que ha iniciado sesión.
// const JSON = await dataFetch(USER_API, 'getUser');

const JSON = await dataFetch(USER_API, 'getUser');
  
// Se comprueba si el usuario está autenticado para establecer el encabezado respectivo.
if (JSON.session) {
  url = `historial_de_compra.html?id=${JSON.id}&username=${JSON.username}`;
NAV.innerHTML = `
<div class="rowprin">
      <div class="row">
        <div class="logo"><img height="110px" width="110px" src="../../resources/img/logoScarlatto3.png" alt=""></div>
      </div>
      <div class="row2">
        <div class="wrapper">
          <ul class="nav-links">
            <li>
              <a href="index.html">Inicio</a>
            </li>
            <li>
              <a href="producto.html">Productos</a>
              <div class="mega-box">
                <div class="content">
                  <div class="row">
                    <img src="../../resources/img/fotosextra/brillianty-dragocennosti.jpg" alt="">
                  </div>
                  <div class="row">
                    <header>Pulseras</header>
                    <ul class="mega-links">
                      <li><a href="#">Todas las opciones</a></li>
                      <li><a href="#">Pulseras rigidas</a></li>
                      <li><a href="#">Pulseras de cuero</a></li>
                      <li><a href="#">Pulseras de reflexion</a></li>
                      <li><a href="#">Pulseras de escalonadas</a></li>
                    </ul>
                  </div>
                  <div class="row">
                    <header>Anillos</header>
                    <ul class="mega-links">
                      <li><a href="#">Todas las opciones</a></li>
                      <li><a href="#">Anillos combinados</a></li>
                      <li><a href="#">Anillos llamativos</a></li>
                      <li><a href="#">Anillos de compromiso</a></li>
                      <li><a href="#">Conjunto de anillos</a></li>
                    </ul>
                  </div>
                  <div class="row">
                    <header>Collares</header>
                    <ul class="mega-links">
                      <li><a href="#">Todas las opciones</a></li>
                      <li><a href="#">Collar de varias cuerdas</a></li>
                      <li><a href="#">Gargantillas</a></li>
                      <li><a href="#">Colgantes</a></li>
                      <li><a href="#">Cadenas</a></li>
                    </ul>
                  </div>
                  <div class="row">
                    <header>Pendientes</header>
                    <ul class="mega-links">
                      <li><a href="#">Todas las opciones</a></li>
                      <li><a href="#">Pendientes de aro</a></li>
                      <li><a href="#">Pedientes de boton</a></li>
                      <li><a href="#">Pendientes largos</a></li>
                    </ul>
                  </div>
                </div>
              </div>
            </li>
            <li>
              <a href="#">Servicios</a>
              <ul class="drop-menu">
                <li><a href="pagina_info.html">Sobre nosotros</a></li>
                <li><a href="seccion_noticias.html">Noticias</a></li>
              </ul>
            </li>
            <li>
            <a href="#">Mi perfil</a>
            <ul class="drop-menu">
            <li><a href="cuenta.html">Mi cuenta</a></li>
              <li><a href="${url}">Historial compra</a></li>
            </ul>
          </li>
            <li><a href="mi_cesta.html">Carrito</a></li>
            <li><a onclick="logOut('login.html')"><img height="20px" width="20px" src="../../resources/img/logouticon.png"></a></li>
            
          </ul>
        </div>
      </div>
</div>
`;
} else {
NAV.innerHTML = `
<div class="rowprin">
      <div class="row">
        <div class="logo"><img height="110px" width="110px" src="../../resources/img/logoScarlatto3.png" alt=""></div>
      </div>
      <div class="row2">
        <div class="wrapper">
          <ul class="nav-links">
            <li>
              <a href="index.html">Inicio</a>
            </li>
            <li>
              <a href="producto.html">Productos</a>
              <div class="mega-box">
                <div class="content">
                  <div class="row">
                    <img src="../../resources/img/fotosextra/brillianty-dragocennosti.jpg" alt="">
                  </div>
                  <div class="row">
                    <header>Pulseras</header>
                    <ul class="mega-links">
                      <li><a href="#">Todas las opciones</a></li>
                      <li><a href="#">Pulseras rigidas</a></li>
                      <li><a href="#">Pulseras de cuero</a></li>
                      <li><a href="#">Pulseras de reflexion</a></li>
                      <li><a href="#">Pulseras de escalonadas</a></li>
                    </ul>
                  </div>
                  <div class="row">
                    <header>Anillos</header>
                    <ul class="mega-links">
                      <li><a href="#">Todas las opciones</a></li>
                      <li><a href="#">Anillos combinados</a></li>
                      <li><a href="#">Anillos llamativos</a></li>
                      <li><a href="#">Anillos de compromiso</a></li>
                      <li><a href="#">Conjunto de anillos</a></li>
                    </ul>
                  </div>
                  <div class="row">
                    <header>Collares</header>
                    <ul class="mega-links">
                      <li><a href="#">Todas las opciones</a></li>
                      <li><a href="#">Collar de varias cuerdas</a></li>
                      <li><a href="#">Gargantillas</a></li>
                      <li><a href="#">Colgantes</a></li>
                      <li><a href="#">Cadenas</a></li>
                    </ul>
                  </div>
                  <div class="row">
                    <header>Pendientes</header>
                    <ul class="mega-links">
                      <li><a href="#">Todas las opciones</a></li>
                      <li><a href="#">Pendientes de aro</a></li>
                      <li><a href="#">Pedientes de boton</a></li>
                      <li><a href="#">Pendientes largos</a></li>
                    </ul>
                  </div>
                </div>
              </div>
            </li>
            <li>
              <a href="#">Servicios</a>
              <ul class="drop-menu">
                <li><a href="pagina_info.html">Sobre nosotros</a></li>
                <li><a href="seccion_noticias.html">Noticias</a></li>
              </ul>
            <li><a href="mi_cesta.html">Carrito</a></li>
            <li><a href="login.html">Iniciar sesión</a></li>
            <hr>
          </ul>
        </div>
      </div>
</div>
`;
}

FOOTER.innerHTML = `
    <div class="row">
      <div class="col">
        <h5 class="text-dark">Dashboard</h5>
        <p>
          <a href="#" class="text-dark" style="text-decoration: none">Ayuda</a>
        </p>
      </div>
      <div class="col">
        <h5 class="text-dark">Explorar</h5>
        <p>
          <a href="#" class="text-dark" style="text-decoration: none">Joyas</a>
        </p>
        <p>
          <a href="#" class="text-dark" style="text-decoration: none">Guía de tallas de anillos</a>
        </p>
        <p>
          <a href="#" class="text-dark" style="text-decoration: none">Guía de tallas de pulseras</a>
        </p>
        <p>
          <a href="#" class="text-dark" style="text-decoration: none">Mapa del sitio</a>
        </p>
      </div>
      <div class="col">
        <h5 class="text-dark">Gestionar</h5>
        <p>
          <a href="cuenta.html" class="text-dark" style="text-decoration: none">Mis datos</a>
        </p>
        <p>
          <a href="#" class="text-dark" style="text-decoration: none">Mi carrito de compra</a>
        </p>
      </div>
      <div class="col">
        <h5 class="text-dark">Sobre nosotros</h5>
        <p>
          <a href="quienes_somos.html" class="text-dark" style="text-decoration: none">¿Quiénes somos?</a>
        </p>
      </div>
      <div class="col">
        <h5 class="text-dark">Contacto</h5>
        <p class="text-dark">Teléfono: 5678-0978</p>
        <p class="text-dark">Correo: Scarlatto@gmail.com</p>
        <p class="text-dark">Facebook: Scarlatto_Shopsv</p>
        <p class="text-dark">Instagram: Scarlatto_Shopsv</p>
        <p class="text-dark">Twitter: Scarlatto_Shopsv</p>
        <p>
          <a href="#" class="text-dark">Contáctanos</a>
        </p>
      </div>
    </div>
`;

});

// NAV.innerHTML = `
// <div class="wrapper">
  // <div class="logo"><img height="45px" width="45px" src="../../resources/img/logo.png" alt=""><a
      // href="index.html">Scarlatto</a></div>
  // <ul class="nav-links">
    // <li>
      // <a href="producto.html">Productos</a>
      // <div class="mega-box">
        // <div class="content">
          // <div class="row">
            // <img src="../../resources/img/fotosextra/brillianty-dragocennosti.jpg" alt="">
            // </div>
          // <div class="row">
            // <header>Pulseras</header>
            // <ul class="mega-links">
              // <li><a href="#">Todas las opciones</a></li>
              // <li><a href="#">Pulseras rigidas</a></li>
              // <li><a href="#">Pulseras de cuero</a></li>
              // <li><a href="#">Pulseras de reflexion</a></li>
              // <li><a href="#">Pulseras de escalonadas</a></li>
              // </ul>
            // </div>
          // <div class="row">
            // <header>Anillos</header>
            // <ul class="mega-links">
              // <li><a href="#">Todas las opciones</a></li>
              // <li><a href="#">Anillos combinados</a></li>
              // <li><a href="#">Anillos llamativos</a></li>
              // <li><a href="#">Anillos de compromiso</a></li>
              // <li><a href="#">Conjunto de anillos</a></li>
              // </ul>
            // </div>
          // <div class="row">
            // <header>Collares</header>
            // <ul class="mega-links">
              // <li><a href="#">Todas las opciones</a></li>
              // <li><a href="#">Collar de varias cuerdas</a></li>
              // <li><a href="#">Gargantillas</a></li>
              // <li><a href="#">Colgantes</a></li>
              // <li><a href="#">Cadenas</a></li>
              // </ul>
            // </div>
          // <div class="row">
            // <header>Pendientes</header>
            // <ul class="mega-links">
              // <li><a href="#">Todas las opciones</a></li>
              // <li><a href="#">Pendientes de aro</a></li>
              // <li><a href="#">Pedientes de boton</a></li>
              // <li><a href="#">Pendientes largos</a></li>
              // </ul>
            // </div>
          // </div>
        // </div>
      // </li>
    // <li>
      // <a href="#">Servicios</a>
      // <ul class="drop-menu">
        // <li><a href="pagina_info.html">Sobre nosotros</a></li>
        // <li><a href="seccion_noticias.html">Noticias</a></li>
        // </ul>
      // </li>
    // <li><a href="cuenta.html">Mi cuenta</a></li>
    // <li><a href="mi_cesta.html">Carrito</a></li>
    // <li><a onclick="logOut()">Cerrar sesion</a></li>
    // </ul>
  // </div>
// `;