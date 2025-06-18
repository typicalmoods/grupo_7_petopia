<?php include 'includes/header.php'; ?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Pago - Petopia</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"/>
  <link rel="stylesheet" href="css/style.css"/>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <style>
    .seccion-form {
      border-bottom: 2px solid #eee;
      margin-bottom: 1.5rem;
      padding-bottom: 1.5rem;
    }
    .seccion-form:last-child {
      border-bottom: none;
      margin-bottom: 0;
      padding-bottom: 0;
    }
    .form-title {
      font-weight: 700;
      color: #444;
      letter-spacing: 1px;
      margin-bottom: 1rem;
      text-transform: uppercase;
    }
    .pedido-resumen {
      background: #fff;
      border-radius: 1rem;
      box-shadow: 0 2px 8px rgba(0,0,0,0.07);
      padding: 2rem 1.5rem;
      margin-top: 2rem;
    }
    .pedido-producto-img {
      width: 70px;
      height: 70px;
      object-fit: cover;
      border-radius: 10px;
      margin-right: 1rem;
    }
    .pedido-producto {
      border-bottom: 1px solid #eee;
      padding: 1rem 0;
      display: flex;
      align-items: center;
    }
    .pedido-producto:last-child {
      border-bottom: none;
    }
    .pedido-total {
      font-size: 1.3rem;
      font-weight: 700;
      color: #198754;
    }
    .pedido-modificar {
      font-size: 0.95em;
      text-decoration: underline;
      cursor: pointer;
      color: #222;
      font-weight: 500;
      margin-left: 8px;
    }
    @media (max-width: 991px) {
      .pedido-resumen {
        margin-top: 2rem;
      }
    }
  </style>
</head>
<body>
<main class="container my-5">
  <div class="row justify-content-center">
    <!-- Formulario de pasos -->
    <div class="col-lg-7 col-md-8">
      <form id="form-pasos">
        <!-- Contacto -->
        <div class="seccion-form" id="seccion-contacto">
          <div class="form-title">Contacto</div>
          <input type="email" class="form-control mb-3" id="emailContacto" placeholder="Correo electrónico *" required>
          <button type="button" class="btn btn-info text-white w-100 fw-semibold" id="btn-contacto">Continuar</button>
        </div>
        <!-- Dirección -->
        <div class="seccion-form" id="seccion-direccion" style="display:none;">
          <div class="form-title">Dirección</div>
          <input type="text" class="form-control mb-3" id="nombreEnvio" placeholder="Nombre completo *" required>
          <input type="text" class="form-control mb-3" id="direccionEnvio" placeholder="Dirección *" required>
          <input type="text" class="form-control mb-3" id="telefonoEnvio" placeholder="Teléfono *" required>
          <button type="button" class="btn btn-info text-white w-100 fw-semibold" id="btn-direccion">Continuar</button>
        </div>
        <!-- Opciones de entrega -->
        <div class="seccion-form" id="seccion-entrega" style="display:none;">
          <div class="form-title">Opciones de entrega</div>
          <select class="form-select mb-3" id="opcionEntrega">
            <option value="gratis">Entrega estándar - Gratis</option>
            <option value="express">Entrega express - 4,99 €</option>
          </select>
          <button type="button" class="btn btn-info text-white w-100 fw-semibold" id="btn-entrega">Continuar</button>
        </div>
        <!-- Pago -->
        <div class="seccion-form" id="seccion-pago" style="display:none;">
          <div class="form-title">Pago</div>
          <div class="input-group mb-3">
            <span class="input-group-text"><i class="bi bi-credit-card"></i></span>
            <input type="text" class="form-control" id="numeroTarjeta" maxlength="16" placeholder="Número de tarjeta" required>
          </div>
          <div class="input-group mb-3">
            <span class="input-group-text"><i class="bi bi-person-badge-fill"></i></span>
            <input type="text" class="form-control" id="nombreTitular" placeholder="Nombre del titular" required>
          </div>
          <div class="row">
            <div class="col-6 mb-3">
              <div class="input-group">
                <span class="input-group-text"><i class="bi bi-calendar-event"></i></span>
                <input type="text" class="form-control" id="caducidad" placeholder="MM/AA" maxlength="5" required>
              </div>
            </div>
            <div class="col-6 mb-3">
              <div class="input-group">
                <span class="input-group-text"><i class="bi bi-shield-lock-fill"></i></span>
                <input type="text" class="form-control" id="cvv" maxlength="3" placeholder="CVV" required>
              </div>
            </div>
          </div>
          <button type="submit" class="btn btn-success w-100 fw-semibold" id="btn-pagar">
            <i class="bi bi-bag-check-fill me-1"></i>Pagar
          </button>
        </div>
      </form>
      <div id="mensaje-pago" class="mt-3"></div>
    </div>
    <!-- Resumen de pedido -->
    <div class="col-lg-5 col-md-10">
      <div class="pedido-resumen" id="pedido-resumen">
        <!-- Aquí se inserta el resumen del pedido -->
      </div>
    </div>
  </div>
</main>
<?php include 'includes/footer.php'; ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
function renderResumenPedido() {
  const carrito = JSON.parse(localStorage.getItem("carrito")) || [];
  const resumenDiv = document.getElementById("pedido-resumen");
  if (!resumenDiv) return;

  if (carrito.length === 0) {
    resumenDiv.innerHTML = `<div class="alert alert-warning">Tu carrito está vacío.</div>`;
    return;
  }

  let total = 0;
  let productosHtml = "";
  carrito.forEach(prod => {
    const subtotal = (parseFloat(prod.price) * prod.cantidad);
    total += subtotal;
    productosHtml += `
      <div class="pedido-producto">
        <img src="${prod.image || 'assets/img/no-image.png'}" class="pedido-producto-img" alt="${prod.name}">
        <div>
          <div class="fw-semibold">${prod.name}</div>
          <div class="text-muted small">Cantidad: ${prod.cantidad}</div>
          <div class="fw-bold">${prod.price} €</div>
        </div>
      </div>
    `;
  });

  resumenDiv.innerHTML = `
    <div class="d-flex justify-content-between align-items-center mb-2">
      <div class="fw-bold fs-5">TU PEDIDO</div>
      <a href="cart.php" class="pedido-modificar">MODIFICAR</a>
    </div>
    <div class="mb-2 text-muted">${carrito.length} producto${carrito.length !== 1 ? 's' : ''}</div>
    <div>${productosHtml}</div>
    <div class="d-flex justify-content-between align-items-center mt-3">
      <span class="pedido-total">Total</span>
      <span class="pedido-total">${total.toFixed(2)} €</span>
    </div>
    <div class="text-muted small mt-1">(IVA incluido)</div>
       <div class="d-flex justify-content-center align-items-center gap-3 mt-2">
                  <img src="assets/icons/visa.svg" alt="Visa" style="height:24px;"> 
                  <img src="assets/icons/paypal.svg" alt="PayPal" style="height:24px;">
                  <img src="assets/icons/mastercard.svg" alt="MasterCard" style="height:24px;">
                </div>
  `;
}

// Mostrar siguiente sección al pulsar cada botón
document.getElementById("btn-contacto").onclick = function() {
  if (document.getElementById("emailContacto").checkValidity()) {
    document.getElementById("seccion-contacto").style.display = "none";
    document.getElementById("seccion-direccion").style.display = "block";
  } else {
    document.getElementById("emailContacto").reportValidity();
  }
};
document.getElementById("btn-direccion").onclick = function() {
  if (
    document.getElementById("nombreEnvio").checkValidity() &&
    document.getElementById("direccionEnvio").checkValidity() &&
    document.getElementById("telefonoEnvio").checkValidity()
  ) {
    document.getElementById("seccion-direccion").style.display = "none";
    document.getElementById("seccion-entrega").style.display = "block";
  } else {
    document.getElementById("nombreEnvio").reportValidity();
    document.getElementById("direccionEnvio").reportValidity();
    document.getElementById("telefonoEnvio").reportValidity();
  }
};
document.getElementById("btn-entrega").onclick = function() {
  document.getElementById("seccion-entrega").style.display = "none";
  document.getElementById("seccion-pago").style.display = "block";
};

// Pago ficticio
document.getElementById("form-pasos").addEventListener("submit", function(e) {
  e.preventDefault();

  // Recoge los datos de envío
  const email = document.getElementById("emailContacto").value;
  const nombre = document.getElementById("nombreEnvio").value;
  const direccion = document.getElementById("direccionEnvio").value;
  const telefono = document.getElementById("telefonoEnvio").value;
  const entrega = document.getElementById("opcionEntrega").value;

  // Recoge los productos del carrito
  const carrito = JSON.parse(localStorage.getItem("carrito")) || [];

  // Construye la tabla de productos
  let productosHtml = `
    <table class="table table-bordered mt-3">
      <thead>
        <tr>
          <th>Imagen</th>
          <th>Producto</th>
          <th>Cantidad</th>
          <th>Subtotal</th>
        </tr>
      </thead>
      <tbody>
  `;
  let total = 0;
  carrito.forEach(prod => {
    const subtotal = (parseFloat(prod.price) * prod.cantidad);
    total += subtotal;
    productosHtml += `
      <tr>
        <td><img src="${prod.image || 'assets/img/no-image.png'}" alt="${prod.name}" style="width:40px;height:40px;object-fit:cover;"></td>
        <td>${prod.name}</td>
        <td>${prod.cantidad}</td>
        <td>${subtotal.toFixed(2)} €</td>
      </tr>
    `;
  });
  productosHtml += `
      </tbody>
      <tfoot>
        <tr>
          <th colspan="3" class="text-end">Total</th>
          <th>${total.toFixed(2)} €</th>
        </tr>
      </tfoot>
    </table>
  `;

  // Muestra el resumen en el mensaje de pago, con los dos botones
  document.getElementById("mensaje-pago").innerHTML = `
    <div class="alert alert-success text-center">
      <i class="bi bi-check-circle-fill" style="font-size:2rem;color:#198754;"></i><br>
      ¡Pedido realizado correctamente!<br>
    </div>
    <h5 class="mt-4 mb-2 text-start">Datos de envío</h5>
    <ul class="list-group mb-3 text-start">
      <li class="list-group-item"><strong>Email:</strong> ${email}</li>
      <li class="list-group-item"><strong>Nombre:</strong> ${nombre}</li>
      <li class="list-group-item"><strong>Dirección:</strong> ${direccion}</li>
      <li class="list-group-item"><strong>Teléfono:</strong> ${telefono}</li>
      <li class="list-group-item"><strong>Entrega:</strong> ${entrega === "gratis" ? "Estándar (Gratis)" : "Express (4,99 €)"}</li>
    </ul>
    <h5 class="mb-2 text-start">Productos comprados</h5>
    ${productosHtml}
    <div class="d-flex flex-column flex-md-row gap-2 justify-content-center mt-3">
      <button id="btn-cancelar-pedido" class="btn btn-outline-danger">
        <i class="bi bi-x-circle me-1"></i>Cancelar pedido
      </button>
      <button id="btn-volver-menu" class="btn btn-outline-secondary">
        <i class="bi bi-house-door me-1"></i>Volver al menú principal
      </button>
    </div>
  `;

  // Al confirmar el pedido:
  let pedidos = JSON.parse(localStorage.getItem("pedidos")) || [];
  pedidos.push({
    hora: new Date().toLocaleString(),
    envio: { email, nombre, direccion, telefono, entrega },
    productos: carrito,
    estado: "pendiente"
  });
  localStorage.setItem("pedidos", JSON.stringify(pedidos));

  // Limpia el carrito
  localStorage.removeItem("carrito");

  // Oculta el formulario
  document.getElementById("form-pasos").style.display = "none";

  // Evento para cancelar pedido con confirmación visual (modal)
  document.getElementById("btn-cancelar-pedido").addEventListener("click", function() {
    if (confirm("¿Seguro que quieres cancelar tu pedido? Esta acción no se puede deshacer.")) {
      document.getElementById("mensaje-pago").innerHTML = `
        <div class="alert alert-warning text-center">
          <i class="bi bi-x-circle-fill" style="font-size:2rem;color:#dc3545;"></i><br>
          Pedido cancelado.
        </div>
        <div class="d-flex justify-content-center mt-3">
          <button id="btn-volver-menu2" class="btn btn-outline-secondary">
            <i class="bi bi-house-door me-1"></i>Volver al menú principal
          </button>
        </div>
      `;
      document.getElementById("btn-volver-menu2").addEventListener("click", function() {
        window.location.href = "index.php";
      });
    }
  });

  // Evento para volver al menú principal tras compra
  document.getElementById("btn-volver-menu").addEventListener("click", function() {
    window.location.href = "index.php";
  });
});

renderResumenPedido();
</script>
</body>
</html>