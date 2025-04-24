<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Carrito - Tienda de Animales</title>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"/>
  <!-- Tu CSS personalizado -->
  <link rel="stylesheet" href="css/style.css"/>
</head>
<body>
  <?php include 'includes/header.php'; ?>

  <main class="container my-5">
    <div class="row">
      <!-- Columna Izquierda: Lista del carrito -->
      <div class="col-lg-8 mb-4 h-100">
        <h2 class="mb-4">Tu Carrito</h2>
        <div class="list-group">

          <!-- Producto 1 -->
          <div class="list-group-item d-flex align-items-center">
            <img src="./assets/img/comida.jpg" alt="Producto 1" class="me-3 rounded" style="width:30%;">
            <div class="flex-grow-1">
              <h5 class="mb-1">Producto 1</h5>
              <p class="mb-1">Comida para perro adulto sabor pollo.</p>
              <div class="d-flex align-items-center">
                <small class="me-2">Cantidad:</small>
                <select class="form-select form-select-sm quantity-select" style="width: 80px;">
                  <option value="1" selected>1</option>
                  <!-- otras opciones -->
                </select>
              </div>
            </div>
            <div class="ms-3"><strong>19,99€</strong></div>
            <button type="button" class="btn btn-outline-danger btn-sm ms-3 remove-item">
              <i class="bi bi-trash"></i>
            </button>
          </div>

          <!-- Producto 2 -->
          <div class="list-group-item d-flex align-items-center">
            <img src="./assets/img/comida.jpg" alt="Producto 2" class="me-3 rounded" style="width:30%;">
            <div class="flex-grow-1">
              <h5 class="mb-1">Producto 2</h5>
              <p class="mb-1">Snacks naturales para perros medianos.</p>
              <div class="d-flex align-items-center">
                <small class="me-2">Cantidad:</small>
                <select class="form-select form-select-sm quantity-select" style="width: 80px;">
                  <option value="1" selected>1</option>
                </select>
              </div>
            </div>
            <div class="ms-3"><strong>7,50€</strong></div>
            <button type="button" class="btn btn-outline-danger btn-sm ms-3 remove-item">
              <i class="bi bi-trash"></i>
            </button>
          </div>

          <!-- Producto 3 -->
          <div class="list-group-item d-flex align-items-center">
            <img src="./assets/img/comida.jpg" alt="Producto 3" class="me-3 rounded" style="width:30%;">
            <div class="flex-grow-1">
              <h5 class="mb-1">Producto 3</h5>
              <p class="mb-1">Barritas dentales para higiene oral canina.</p>
              <div class="d-flex align-items-center">
                <small class="me-2">Cantidad:</small>
                <select class="form-select form-select-sm quantity-select" style="width: 80px;">
                  <option value="1" selected>1</option>
                </select>
              </div>
            </div>
            <div class="ms-3"><strong>9,99€</strong></div>
            <button type="button" class="btn btn-outline-danger btn-sm ms-3 remove-item">
              <i class="bi bi-trash"></i>
            </button>
          </div>

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

            <hr />

            <div class="d-flex justify-content-between">
              <span>Subtotal (3 productos)</span>
              <strong>37,48€</strong> 
            </div>
            <div class="d-flex justify-content-between mt-2">
              <span>Gastos de envío</span>
              <strong>3,99€</strong>
            </div>
            <hr />
            <div class="d-flex justify-content-between fs-5">
              <span>Total</span>
              <strong>41,47€</strong>
            </div>

            <div class="mt-4">
              <a href="pago.php" class="btn btn-primary w-100 ">Acceder al pago</a>
            </div>

            <div class="text-center mt-3">
              <div class="mt-2">
                <i class="bi bi-shield-lock-fill"></i> Pago seguro
                <div class="mt-3">
                <small >Formas de pago aceptadas</small>
                </div>
                <!-- Contenedor de iconos -->
                <div class="d-flex justify-content-center align-items-center gap-3 mt-2">
                    <!-- Puedes usar imágenes o SVGs inline. Aquí se usan <img> como ejemplo -->
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

  <?php include 'includes/footer.php'; ?>
  <?php include 'includes/modals.php'; ?>

  <!-- Bootstrap Bundle JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="js/main.js"></script>
</body>
</html>
