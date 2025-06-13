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
              <button class="btn" style="background:#cb333b;color:#fff;font-weight:600;font-size:1.1rem;padding:12px 32px;border-radius:8px;">
                Añadir al carrito
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
</body>
</html>
<?php include 'includes/modals.php'; ?>