<?php
function obtenerImagenProducto($producto) {
    switch ($producto['id']) {
        case 1: return "https://famouspets.com.cy/1191-medium_default/royal-canin-medium-sterilized-adult-dry-dog-food.jpg";
        case 2: return "https://m.media-amazon.com/images/I/61E-7oEzeoS.jpg";
        case 3: return "https://aller-petfood.com/wp-content/uploads/2017/09/ALL_Puppies.jpg";
        case 4: return "https://shop.smucker.com/cdn/shop/files/wcwst1hk2xnhx9tonxm9.jpg?v=1702052831&width=1920";
        case 5: return "https://m.media-amazon.com/images/I/612z2jEDFTL.jpg";
        case 6: return "https://www.pawsomecouture.com/cdn/shop/products/magicalmice.jpg?v=1599542929";
        case 7: return "https://m.media-amazon.com/images/I/61hJF6WtWTL.jpg";
        case 8: return "https://catfriendly.com/wp-content/uploads/2021/07/scratching-post.jpg";
        case 9: return "https://assets.petco.com/petco/image/upload/c_pad,dpr_1.0,f_auto,q_auto,h_636,w_636/c_pad,h_636,w_636/1056794-left-2";
        case 10: return "https://m.media-amazon.com/images/I/615Ccf+wziL.jpg";
        case 11: return "https://cdn.reddingo.es/media/mf_webp/jpg/media/catalog/product/cache/c242852b69642886958102ebeb0e83fa/DH-PH-GY.webp";
        case 12: return "https://m.media-amazon.com/images/I/71hdYWVr9tL._AC_UF1000,1000_QL80_.jpg";
        default: return "/assets/img/default.jpg";
    }
}

$id = $_GET['id'] ?? null;
$producto = null;

if ($id) {
    $apiUrl = "http://backend:5000/api/v1/products/$id";
    $response = @file_get_contents($apiUrl);
    if ($response !== false) {
        $producto = json_decode($response, true);
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Detalle del producto</title>
  <link rel="stylesheet" href="css/style.css">
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
  <?php include 'includes/header.php'; ?>

  <main>
    <div id="detalle-producto" class="contenedor my-5">
      <?php if ($producto): ?>
        <div class="container py-4">
          <div class="row align-items-center bg-white rounded shadow p-4">
            <div class="col-md-5 text-center mb-3 mb-md-0">
              <img src="<?php echo htmlspecialchars(obtenerImagenProducto($producto)); ?>" 
                   alt="<?php echo htmlspecialchars($producto['name'] ?? 'Producto'); ?>" 
                   class="img-fluid rounded" 
                   style="max-height:340px;object-fit:cover;background:#f8f8f8;">
            </div>
            <div class="col-md-7">
              <h2 class="fw-bold mb-3" style="color:#343a40"><?php echo htmlspecialchars($producto['name']); ?></h2>
              <p class="mb-3" style="color:#555;"><?php echo htmlspecialchars($producto['description']); ?></p>
              <p class="fs-4 fw-bold mb-4" style="color:#cb333b;"><?php echo htmlspecialchars($producto['price']); ?> €</p>
              <button class="agregarAlCarrito btn btn-primary w-50">
                Añadir al carrito
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-cart2" viewBox="0 0 16 16" style="vertical-align:middle;margin-left:6px;">
                  <path d="M0 2.5A.5.5 0 0 1 .5 2H2a.5.5 0 0 1 .485.379L2.89 4H14.5a.5.5 0 0 1 .485.621l-1.5 6A.5.5 0 0 1 13 11H4a.5.5 0 0 1-.485-.379L1.61 3H.5a.5.5 0 0 1-.5-.5M3.14 5l1.25 5h8.22l1.25-5zM5 13a1 1 0 1 0 0 2 1 1 0 0 0 0-2m-2 1a2 2 0 1 1 4 0 2 2 0 0 1-4 0m9-1a1 1 0 1 0 0 2 1 1 0 0 0 0-2m-2 1a2 2 0 1 1 4 0 2 2 0 0 1-4 0"/>
                </svg>
              </button>
            </div>
          </div>
        </div>
      <?php else: ?>
        <div class="alert alert-danger">Producto no encontrado.</div>
      <?php endif; ?>
    </div>
  </main>

  <?php include 'includes/footer.php'; ?>

  <!-- Toast de Bootstrap para notificaciones -->
  <div class="toast-container position-fixed bottom-0 end-0 p-3" style="z-index: 9999">
    <div id="toastCarrito" class="toast align-items-center text-bg-success border-0" role="alert" aria-live="assertive" aria-atomic="true">
      <div class="d-flex">
        <div class="toast-body">
          Producto añadido al carrito
        </div>
        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Cerrar"></button>
      </div>
    </div>
  </div>

  <?php include 'includes/modals.php'; ?>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script>
  function actualizarContadorCarrito() {
    const carrito = JSON.parse(localStorage.getItem("carrito")) || [];
    const contador = document.getElementById("carrito-contador");
    if (contador) contador.textContent = carrito.reduce((acc, p) => acc + (p.cantidad || 1), 0);
  }

  document.addEventListener("DOMContentLoaded", function() {
    actualizarContadorCarrito();

    const btn = document.querySelector(".agregarAlCarrito");
    if (!btn) return;

    btn.addEventListener("click", function() {
      // Obtén los datos del producto desde el HTML/PHP
      const id = "<?php echo htmlspecialchars($producto['id']); ?>";
      const name = "<?php echo htmlspecialchars($producto['name']); ?>";
      const description = "<?php echo htmlspecialchars($producto['description']); ?>";
      const price = "<?php echo htmlspecialchars($producto['price']); ?>";
      const image = "<?php echo htmlspecialchars(obtenerImagenProducto($producto)); ?>";

      let carrito = JSON.parse(localStorage.getItem("carrito")) || [];
      const existente = carrito.find(p => p.id == id);
      if (existente) {
        existente.cantidad += 1;
      } else {
        carrito.push({
          id,
          name,
          description,
          price,
          image,
          cantidad: 1
        });
      }
      localStorage.setItem("carrito", JSON.stringify(carrito));

      // Actualiza el contador
      actualizarContadorCarrito();

      // Muestra el toast de Bootstrap
      const toastEl = document.getElementById('toastCarrito');
      if (toastEl && window.bootstrap) {
        const toast = new bootstrap.Toast(toastEl);
        toast.show();
      }
    });
  });
  </script>
</body>
</html>