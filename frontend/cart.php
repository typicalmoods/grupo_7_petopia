<?php include 'includes/header.php'; ?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Carrito - Petopia</title>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"/>
  <!-- Tu CSS personalizado -->
  <link rel="stylesheet" href="css/style.css"/>
</head>
<body>
  

  <main class="container my-5">
    <div class="row">
      <!-- Columna Izquierda: Lista del carrito -->
      <div class="col-lg-8 mb-4 h-100">
        <h2 class="mb-4">Tu Carrito</h2>
        <div id="carrito-lista" class="list-group">
        </div>
        <div id="carrito-vacio" class="text-center" style="display: none;">
          <img src="assets/img/gatocarrito.webp" alt="Carrito vacío" class="img-fluid mb-3" style="max-width: 200px;">
          <h4>Tu carrito está vacío</h4>
          <p>Explora nuestra tienda y añade productos a tu carrito.</p>
          <a href="index.php" class="btn btn-primary">Volver a la tienda</a>
        </div>
      </div>

      <!-- Columna Derecha: Resumen del pedido -->
      <div class="col-lg-4">
        <div class="card shadow-sm">
          <div class="card-body">
            <h4 class="card-title mb-4">Resumen de mi pedido</h4>

            <div class="mb-3">
              <label for="cupon" class="form-label">¿Tienes un cupón?</label>
              <div class="input-group">
                <input type="text" id="cupon" class="form-control" placeholder="Introduce tu cupón"/>
                <button class="btn btn-outline-secondary">Aplicar</button>
              </div>
            </div>
            <div id="mensaje-cupon" class="mt-2"></div>

            <hr />

            <div class="d-flex justify-content-between">
              <span>Subtotal</span>
              <strong id="subtotal">0,00€</strong> 
            </div>
            <div class="d-flex justify-content-between mt-2">
              <span>Gastos de envío</span>
              <strong id="envio">3,99€</strong>
            </div>
            <hr />
            <div class="d-flex justify-content-between fs-5">
              <span>Total</span>
              <strong id="total">3,99€</strong>
            </div>
            <div id="descuento-cupon"></div>

            <div class="mt-4">
              <?php if (isset($_SESSION["usuario"])): ?>
                  <a href="pago.php" class="btn btn-primary w-100">Acceder al pago</a>
              <?php else: ?>
                  <button class="btn btn-primary w-100" disabled>Acceder al pago</button>
                  <div class="alert alert-warning mt-2 text-center">
                      Debes iniciar sesión para continuar con el pago.
                  </div>
              <?php endif; ?>
            </div>

            <div class="text-center mt-3">
              <div class="mt-2">
                <i class="bi bi-shield-lock-fill"></i> Pago seguro
                <div class="mt-3">
                  <small>Formas de pago aceptadas</small>
                </div>
                <!-- Contenedor de iconos -->
                <div class="d-flex justify-content-center align-items-center gap-3 mt-2">
                  <img src="assets/icons/visa.svg" alt="Visa" style="height:24px;"> 
                  <img src="assets/icons/paypal.svg" alt="PayPal" style="height:24px;">
                  <img src="assets/icons/mastercard.svg" alt="MasterCard" style="height:24px;">
                </div>
              </div>
            </div>

          </div>
        </div>
      </div>
    </div>
     
  </main>

    <section class="animales contenedor">
              <h3>Categorías destacadas</h3>
              <div id="secciones-container"></div>
    </section>

  <?php include 'includes/footer.php'; ?>
  <?php include 'includes/modals.php'; ?>

  <!-- Bootstrap Bundle JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    // Definición de cupones válidos y sus descuentos
    const cupones = {
      "DESCUENTO10": { tipo: "porcentaje", valor: 10 },      // 10% de descuento
      "ENVIOGRATIS": { tipo: "envio", valor: 3.99 },         // Envío gratis (3.99€)
      "5OFF":        { tipo: "porcentaje", valor: 50 }        // 50% de descuento
    };

    let cuponAplicado = null;

    // Función para cargar el carrito desde localStorage
    function cargarCarrito() {
      const carrito = JSON.parse(localStorage.getItem("carrito")) || [];
      const carritoLista = document.getElementById("carrito-lista");
      const carritoVacio = document.getElementById("carrito-vacio");
      const subtotalElement = document.getElementById("subtotal");
      const totalElement = document.getElementById("total");
      const envioElement = document.getElementById("envio");
      let envio = 3.99; // Gastos de envío iniciales

      carritoLista.innerHTML = ""; // Limpiar la lista del carrito
      let subtotal = 0;
      let descuento = 0;

      if (carrito.length === 0) {
        carritoVacio.style.display = "block";
        subtotalElement.textContent = "0,00€";
        totalElement.textContent = "0,00€";
        envioElement.textContent = "0,00€";
        return;
      } else {
        carritoVacio.style.display = "none";
      }

      carrito.forEach((producto, index) => {
        const item = document.createElement("div");
        item.classList.add("list-group-item", "d-flex", "align-items-center");

        item.innerHTML = `
          <img src="${producto.url_image || producto.image || '/assets/img/default.jpg'}" alt="${producto.description}" class="me-3 rounded" style="width:30%;">
          <div class="flex-grow-1">
            <h5 class="mb-1">${producto.name}</h5>
            <p class="mb-1">${producto.description}</p>
            <div class="d-flex align-items-center">
              <small class="me-2">Cantidad:</small>
              <select class="form-select form-select-sm quantity-select" style="width: 80px;" data-index="${index}">
                ${[...Array(10).keys()].map(i => `<option value="${i + 1}" ${producto.cantidad === i + 1 ? "selected" : ""}>${i + 1}</option>`).join("")}
              </select>
            </div>
          </div>
          <div class="ms-3"><strong>${(producto.price * producto.cantidad).toFixed(2)}€</strong></div>
          <button type="button" class="btn btn-outline-danger btn-sm ms-3 remove-item" data-index="${index}">
            <i class="bi bi-trash"></i>
          </button>
        `;

        subtotal += producto.price * producto.cantidad;
        carritoLista.appendChild(item);
      });

      // Aplicar cupón si existe
      if (cuponAplicado && cupones[cuponAplicado]) {
        const cup = cupones[cuponAplicado];
        if (cup.tipo === "porcentaje") {
          descuento = subtotal * (cup.valor / 100);
        } else if (cup.tipo === "envio") {
          envio = 0;
        }
      }

      // Actualizar el coste de envío si el subtotal supera los 30€
      if (subtotal >= 30) {
        envio = 0;
        envioElement.textContent = "Gratis";
      } else {
        envioElement.textContent = envio === 0 ? "Gratis" : `${envio.toFixed(2)}€`;
      }

      // Mostrar descuento si hay
      const descuentoDiv = document.getElementById("descuento-cupon");
      if (descuento > 0) {
        descuentoDiv.innerHTML = `
          <div class="d-flex justify-content-between fs-5 text-success">
            <span>Descuento cupón</span>
            <strong>- ${descuento.toFixed(2)}€</strong>
          </div>
        `;
      } else {
        descuentoDiv.innerHTML = "";
      }

      // Actualizar subtotal y total
      subtotalElement.textContent = `${subtotal.toFixed(2)}€`;
      totalElement.textContent = `${(subtotal - descuento + envio).toFixed(2)}€`;

      // Agregar eventos a los selectores de cantidad y botones de eliminar
      document.querySelectorAll(".quantity-select").forEach(select => {
        select.addEventListener("change", (e) => actualizarCantidad(e.target.dataset.index, e.target.value));
      });

      document.querySelectorAll(".remove-item").forEach(button => {
        button.addEventListener("click", (e) => eliminarProducto(e.target.dataset.index));
      });
    }

    // Función para actualizar la cantidad de un producto
    function actualizarCantidad(index, cantidad) {
      const carrito = JSON.parse(localStorage.getItem("carrito")) || [];
      carrito[index].cantidad = parseInt(cantidad);
      localStorage.setItem("carrito", JSON.stringify(carrito));
      cargarCarrito();
    }

    // Función para eliminar un producto del carrito
    function eliminarProducto(index) {
      const carrito = JSON.parse(localStorage.getItem("carrito")) || [];
      carrito.splice(index, 1);
      localStorage.setItem("carrito", JSON.stringify(carrito));
      cargarCarrito();
    }

    document.addEventListener("DOMContentLoaded", function() {
      cargarCarrito();

      document.querySelector('.btn-outline-secondary').addEventListener('click', function() {
        const input = document.getElementById("cupon");
        const codigo = input.value.trim().toUpperCase();
        const mensaje = document.getElementById("mensaje-cupon") || crearMensajeCupon();

        if (cupones[codigo]) {
          cuponAplicado = codigo;
          mensaje.textContent = "¡Cupón aplicado correctamente!";
          mensaje.className = "text-success mt-2";
          cargarCarrito();
        } else {
          cuponAplicado = null;
          mensaje.textContent = "Cupón no válido.";
          mensaje.className = "text-danger mt-2";
          cargarCarrito();
        }
      });
    });

    // Crea el mensaje debajo del input si no existe
    function crearMensajeCupon() {
      const input = document.getElementById("cupon");
      const mensaje = document.createElement("div");
      mensaje.id = "mensaje-cupon";
      input.parentNode.appendChild(mensaje);
      return mensaje;
    }
  </script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/main.js"></script>
</body>
</html>