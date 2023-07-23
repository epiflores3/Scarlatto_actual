

const HEADER = document.querySelector('header');
const NAV = document.querySelector('nav');
const FOOTER = document.querySelector('footer');

HEADER.innerHTML = `
<div class="col pb-4">
    <table class="table align-middle"> 
        <thead>
        <tr>
            <div>
                <td>
                    <img height="90px" width="90px" src="../../resources/img/logo.png" alt="logo">
                </td>
            </div>
            <td>
                <div class="rounded float-end">
                    <label class="text-end">¡Bienvenido!</label>
                    <p>Kenia Aparicio</p>
                </div>
            </td>
            <td>
                <img height="65px" width="65px" src="../../resources/img/fotosextra/usuario.png" alt="" />
            </td>
        </tr>
        </thead>
    </table>
</div>
`;

NAV.innerHTML = `
<div class="sliderbar-body">
    <!--Empieza la lista-->
    <ul class="navigation-list">
    <li class="navigation-list-item">
        <a class="navigation-link" href="dasbord.html">
        <div class="row">
            <div class="col-2">
            <i class="fa-sharp fa-solid fa-house"> </i>
            </div>
            <div class="col-10">Inicio</div>
        </div>
        </a>
    </li>
    <li class="navigation-list-item">
        <a class="navigation-link" href="usuario.html">
        <div class="row">
            <div class="col-2">
            <i class="fa-sharp fa-solid fa-user"></i>
            </div>
            <div class="col-10">Usuarios</div>
        </div>
        </a>
    </li>
    <li class="navigation-list-item">
        <a class="navigation-link" href="cliente.html">
        <div class="row">
            <div class="col-2">
            <i class="fa-solid fa-people-group"></i>
            </div>
            <div class="col-10">Clientes</div>
        </div>
        </a>
    </li>
    <li class="navigation-list-item">
        <a class="navigation-link" href="producto.html">
        <div class="row">
            <div class="col-2">
            <i class="fa-solid fa-gem"></i>
            </div>
            <div class="col-10">Producto</div>
        </div>
        </a>
    </li>
    <li class="navigation-list-item">
        <a class="navigation-link" href="detalle_producto.html">
        <div class="row">
            <div class="col-2">
            <i class="fa-solid fa-file-circle-exclamation"></i>
            </div>
            <div class="col-10">Detalles productos</div>
        </div>
        </a>
    </li>
    <li class="navigation-list-item">
        <a class="navigation-link" href="pedido.html">
        <div class="row">
            <div class="col-2">
            <i class="fa-solid fa-credit-card"></i>
            </div>
            <div class="col-10">Pedidos</div>
        </div>
        </a>
    </li>
    <hr style="margin-top: 30px" />
    <li class="navigation-list-item">
        <a class="navigation-link" href="categoria_producto.html">
        <div class="row">
            <div class="col-2">
            <i class="fa-solid fa-gem"></i>
            </div>
            <div class="col-10">Categorías productos</div>
        </div>
        </a>
    </li>
    <li class="navigation-list-item">
        <a class="navigation-link" href="talla.html">
        <div class="row">
            <div class="col-2">
            <i class="fa-solid fa-gear"></i>
            </div>
            <div class="col-10">Tallas</div>
        </div>
        </a>
    </li>
    <li class="navigation-list-item">
        <a class="navigation-link" href="material.html">
        <div class="row">
            <div class="col-2">
            <i class="fa-sharp fa-solid fa-recycle"></i>
            </div>
            <div class="col-10">Materiales</div>
        </div>
        </a>
    </li>
    <li class="navigation-list-item">
        <a class="navigation-link" href="marca.html">
        <div class="row">
            <div class="col-2">
            <i class="fa-sharp fa-regular fa-copyright"></i>
            </div>
            <div class="col-10">Marcas</div>
        </div>
        </a>
    </li>
    <br /><br /><br /><br /><br /><br />
    <li class="navigation-list-item">
        <a class="navigation-link" onclick="logOut()">
        <div class="row">
            <div class="col-2">
            </div>
            <div class="col-10">Salir</div>
        </div>
        </a>
    </li>
    </ul>
</div>
`;

FOOTER.innerHTML = `
<div class="row">

<div class="col">
    <div class="text-center">
        <hr> <button type="button" class="btn"><img src="../../resources/img/fotesfooter/facebook.png" height="30px" width="30px"
                  class="rounded" alt="face">
          </button>
          <button type="button" class="btn"><img src="../../resources/img/fotesfooter/insta.png" height="30px" width="30px"
                  class="rounded" alt="insta">
          </button>
          <button type="button" class="btn"><img src="../../resources/img/fotesfooter/youtube.png" height="30px" width="30px"
                  class="rounded" alt="youtube">
          </button>
          <button type="button" class="btn"><img src="../../resources/img/fotesfooter/twitter.png" height="30px" width="30px"
                  class="rounded" alt="twitter">
          </button>
          <button type="button" class="btn"><img src="../../resources/img/fotesfooter/google.png" height="30px" width="30px"
                  class="rounded" alt="google">
          </button><hr> 
          <h2 class="text-center">Scarlatto</h2>
          <br>
          <p>Copyright © 2023 Scarlatto, Inc.</p>
          <br>
          <a href="../publico/cuenta.html" class="text-dark">Mi cuenta</a> | <a href="../publico/index.html" class="text-dark">Sitio público</a>
      </div>
      <br>
  </div>

</div>

`;