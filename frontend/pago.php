<?php include 'includes/header.php'; ?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Pago - Petopia</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"/>
  <link rel="stylesheet" href="css/style.css"/>
</head>
<body>
  <main class="container my-5">
    <div class="row justify-content-center">
      <div class="col-md-6">
        <div class="card shadow">
          <div class="card-body text-center">
            <h2 class="mb-4">Pago ficticio</h2>
            <div id="paso1">
              <p>Introduce tus datos para el envío:</p>
              <form id="form-datos-envio">
                <div class="mb-3">
                  <label for="nombreEnvio" class="form-label">Nombre completo</label>
                  <input type="text" class="form-control" id="nombreEnvio" required>
                </div>
                <div class="mb-3">
                  <label for="direccionEnvio" class="form-label">Dirección</label>
                  <input type="text" class="form-control" id="direccionEnvio" required>
                </div>
                <div class="mb-3">
                  <label for="telefonoEnvio" class="form-label">Teléfono</label>
                  <input type="text" class="form-control" id="telefonoEnvio" required>
                </div>
                <div class="mb-3">
                  <label for="emailEnvio" class="form-label">Correo electrónico</label>
                  <input type="email" class="form-control" id="emailEnvio" required>
                </div>
                <button type="submit" class="btn btn-info w-100">Siguiente</button>
              </form>
            </div>
            <div id="paso2" style="display:none;">
              <p>Introduce los datos de tu tarjeta para simular el pago.</p>
              <form id="form-pago">
                <div class="mb-3">
                  <label for="numeroTarjeta" class="form-label">Número de tarjeta</label>
                  <input type="text" class="form-control" id="numeroTarjeta" maxlength="16" required>
                </div>
                <div class="mb-3">
                  <label for="nombreTitular" class="form-label">Nombre del titular</label>
                  <input type="text" class="form-control" id="nombreTitular" required>
                </div>
                <div class="row">
                  <div class="col-6 mb-3">
                    <label for="caducidad" class="form-label">Caducidad</label>
                    <input type="text" class="form-control" id="caducidad" placeholder="MM/AA" maxlength="5" required>
                  </div>
                  <div class="col-6 mb-3">
                    <label for="cvv" class="form-label">CVV</label>
                    <input type="text" class="form-control" id="cvv" maxlength="3" required>
                  </div>
                </div>
                <button type="submit" class="btn btn-success w-100">Pagar</button>
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
    // Paso 1: Datos de envío
    document.getElementById("form-datos-envio").addEventListener("submit", function(e) {
      e.preventDefault();
      document.getElementById("paso1").style.display = "none";
      document.getElementById("paso2").style.display = "block";
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
              ¡Pago realizado con éxito!<br>Gracias por tu compra.
            </div>
          `;
          localStorage.removeItem("carrito");
          setTimeout(() => {
            window.location.href = "index.php";
          }, 2000);
        } else {
          document.getElementById("mensaje-pago").innerHTML = `
            <div class="alert alert-danger text-center">
              Error al guardar el pedido: ${data.error || "Inténtalo de nuevo"}
            </div>
          `;
        }
      } catch (err) {
        document.getElementById("mensaje-pago").innerHTML = `
          <div class="alert alert-danger text-center">
            Error de conexión con el servidor.
          </div>
        `;
      }
    });
  </script>
</body>
</html>