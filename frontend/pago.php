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
    .input-group-text {
      background: #17a2b8;
      color: #fff;
      border: none;
    }
    .form-control:focus {
      box-shadow: 0 0 0 0.2rem rgba(23,162,184,.25);
      border-color: #17a2b8;
    }
    .card {
      border-radius: 1rem;
    }
    .btn-info, .btn-success {
      font-weight: 600;
      letter-spacing: 1px;
    }
  </style>
</head>
<body>
  <main class="container my-5">
    <div class="row justify-content-center">
      <div class="col-md-7 col-lg-6">
        <div class="card shadow">
          <div class="card-body text-center">
            <h2 class="mb-4"><i class="bi bi-credit-card-2-front-fill me-2"></i>Completar pedido</h2>
            <div id="paso1">
              <p class="mb-4">Introduce tus datos para el envío:</p>
              <form id="form-datos-envio">
                <div class="input-group mb-3">
                  <span class="input-group-text bg-info text-white">
                    <i class="bi bi-person-fill"></i>
                  </span>
                  <input type="text" class="form-control bg-light" id="nombreEnvio" placeholder="Nombre completo" required>
                </div>
                <div class="input-group mb-3">
                  <span class="input-group-text bg-info text-white">
                    <i class="bi bi-geo-alt-fill"></i>
                  </span>
                  <input type="text" class="form-control bg-light" id="direccionEnvio" placeholder="Dirección" required>
                </div>
                <div class="input-group mb-3">
                  <span class="input-group-text bg-info text-white">
                    <i class="bi bi-telephone-fill"></i>
                  </span>
                  <input type="text" class="form-control bg-light" id="telefonoEnvio" placeholder="Teléfono" required>
                </div>
                <div class="input-group mb-3">
                  <span class="input-group-text bg-info text-white">
                    <i class="bi bi-envelope-fill"></i>
                  </span>
                  <input type="email" class="form-control bg-light" id="emailEnvio" placeholder="Correo electrónico" required>
                </div>
                <button type="submit" class="btn btn-info w-100 mb-2 text-white fw-semibold">
                  Siguiente <i class="bi bi-arrow-right-circle ms-1"></i>
                </button>
              </form>
            </div>
            <div id="paso2" style="display:none;">
              <p class="mb-4">Introduce los datos de tu tarjeta para simular el pago.</p>
              <div id="resumen-carrito" class="mb-4"></div>
              <form id="form-pago">
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
                <button type="submit" class="btn btn-success w-100">
                  <i class="bi bi-bag-check-fill me-1"></i>Pagar
                </button>
              </form>
            </div>
            <div id="mensaje-pago" class="mt-3"></div>
          </div>
        </div>
      </div>
    </div>
  </main>
  <?php include 'includes/footer.php'; ?>

  <script>
    function mostrarResumenCarrito() {
      const carrito = JSON.parse(localStorage.getItem("carrito")) || [];
      const resumenDiv = document.getElementById("resumen-carrito");
      if (!resumenDiv) return;

      if (carrito.length === 0) {
        resumenDiv.innerHTML = `<div class="alert alert-warning">Tu carrito está vacío.</div>`;
        return;
      }

      let html = `
        <h5 class="mb-3"><i class="bi bi-bag"></i> Productos en tu pedido</h5>
        <ul class="list-group mb-2">
      `;
      let total = 0;
      carrito.forEach(prod => {
        const subtotal = (parseFloat(prod.price) * prod.cantidad);
        total += subtotal;
        html += `
          <li class="list-group-item d-flex align-items-center">
            <img src="${prod.image || 'assets/img/no-image.png'}" alt="${prod.name}" style="width:48px;height:48px;object-fit:cover;border-radius:8px;margin-right:12px;">
            <div class="flex-grow-1 text-start">
              <strong>${prod.name}</strong>
              <div class="text-muted small">x${prod.cantidad}</div>
            </div>
            <span class="fw-semibold">${subtotal.toFixed(2)} €</span>
          </li>
        `;
      });
      html += `</ul>
        <div class="d-flex justify-content-between fs-5">
          <span>Total</span>
          <strong>${total.toFixed(2)} €</strong>
        </div>
      `;
      resumenDiv.innerHTML = html;
    }

    // Paso 1: Datos de envío
    document.getElementById("form-datos-envio").addEventListener("submit", function(e) {
      e.preventDefault();
      document.getElementById("paso1").style.display = "none";
      document.getElementById("paso2").style.display = "block";
      mostrarResumenCarrito(); // <-- Añade esta línea
    });

    // Paso 2: Pago
    document.getElementById("form-pago").addEventListener("submit", async function(e) {
      e.preventDefault();

      // Recoge los productos del carrito
      const carrito = JSON.parse(localStorage.getItem("carrito")) || [];

      // Prepara los datos para el backend
      const productos = carrito.map(p => ({
        product_id: p.id,
        quantity: p.cantidad
      }));

      // Envía el pedido al backend
      try {
        const response = await fetch("http://localhost:5051/api/v1/carts/", {
          method: "POST",
          headers: {
            "Content-Type": "application/json"
          },
          credentials: "include", // Para enviar la cookie de sesión
          body: JSON.stringify({ products: productos })
        });

        const data = await response.json();

        if (response.ok) {
          document.getElementById("mensaje-pago").innerHTML = `
            <div class="alert alert-success text-center">
              <i class="bi bi-check-circle-fill" style="font-size:2rem;color:#198754;"></i><br>
              ¡Pago realizado correctamente!<br>Serás redirigido en unos segundos...
            </div>
          `;
          localStorage.removeItem("carrito");
          setTimeout(() => {
            window.location.href = "index.php";
          }, 2000);
        } else {
          document.getElementById("mensaje-pago").innerHTML = `
            <div class="alert alert-danger text-center">
              <i class="bi bi-x-circle-fill" style="font-size:2rem;color:#dc3545;"></i><br>
              Error al guardar el pedido: ${data.error || "Inténtalo de nuevo"}
            </div>
          `;
        }
      } catch (err) {
        document.getElementById("mensaje-pago").innerHTML = `
          <div class="alert alert-danger text-center">
            <i class="bi bi-x-circle-fill" style="font-size:2rem;color:#dc3545;"></i><br>
            Error de conexión con el servidor.
          </div>
        `;
      }
    });
  </script>
</body>
</html>