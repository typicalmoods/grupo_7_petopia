<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Petopia</title>
    <link rel="stylesheet" href="css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
</head>

<body>
    <?php include 'includes/header.php'; ?>

    <!-- BANNER -->
    <div class="slider">
        <div class="slider-track">  
            <img src="./assets/img/banner1.jpg" alt="Imagen 1">
            <img src="./assets/img/banner2.jpg" alt="Imagen 2">
            <img src="./assets/img/banner3.jpg" alt="Imagen 3">
        </div>
    </div>

    <main>
        <section class="banner contenedor">
            <h3>¡Bienvenido a Petopia! Tu tienda de confianza para mascotas</h3>
        </section>

        <div class="principal">
            <img src="./assets/img/principal.webp" alt="Imagen 1" />
            <img src="./assets/img/principal2.webp" alt="Imagen 2">
        </div>
          
        <section class="destacados contenedor">
            <h3>Productos Destacados</h3>
            <div class="producto-container">
               <?php
                // Aquí se hace la petición a la API para obtener los productos
                $apiUrl = "http://backend:5000/api/v1/products/";
                $response = file_get_contents($apiUrl);
                $productos = json_decode($response, true);
                foreach ($productos as $producto): ?>
                    <div class="producto-card" 
                         data-id="<?php echo $producto['id']; ?>" 
                         data-image="<?php echo htmlspecialchars(obtenerImagenProducto($producto)); ?>">
                        <div class="producto-imagen-container">
                            <img src="<?php echo htmlspecialchars(obtenerImagenProducto($producto)); ?>"
                                 alt="<?php echo htmlspecialchars($producto['name']); ?>"
                                 class="producto-imagen" />
                        </div>
                        <div class="producto-details">
                            <h3 class="producto-marca"><?php echo htmlspecialchars($producto['name']); ?></h3>
                            <p class="producto-description"><?php echo htmlspecialchars($producto['description']); ?></p>
                            <div class="precio-favorito">
                                <span class="producto-precio"><?php echo htmlspecialchars($producto['price']); ?> €</span>
                                <span class="favorite-icon" data-id="<?php echo $producto['id']; ?>">
                                  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                      class="bi bi-heart-fill" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd"
                                        d="M8 1.314C12.438-3.248 23.534 4.735 8 15-7.534 4.736 3.562-3.248 8 1.314" />
                                  </svg>
                                </span>
                            </div>
                            <button class="agregarAlCarrito btn btn-primary">
                              Añadir al carrito
                              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-cart2" viewBox="0 0 16 16" style="vertical-align:middle;margin-left:6px;">
                                <path d="M0 2.5A.5.5 0 0 1 .5 2H2a.5.5 0 0 1 .485.379L2.89 4H14.5a.5.5 0 0 1 .485.621l-1.5 6A.5.5 0 0 1 13 11H4a.5.5 0 0 1-.485-.379L1.61 3H.5a.5.5 0 0 1-.5-.5M3.14 5l1.25 5h8.22l1.25-5zM5 13a1 1 0 1 0 0 2 1 1 0 0 0 0-2m-2 1a2 2 0 1 1 4 0 2 2 0 0 1-4 0m9-1a1 1 0 1 0 0 2 1 1 0 0 0 0-2m-2 1a2 2 0 1 1 4 0 2 2 0 0 1-4 0"/>
                              </svg>
                            </button>
                            <!-- El enlace "Ver más" ha sido eliminado -->
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </section>
        <section class="animales contenedor">
            <h3>Categorías destacadas</h3>
            <div id="secciones-container"></div>
        </section>
    </main>

    <?php include 'includes/footer.php'; ?>
    <?php include 'includes/modals.php'; ?>

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

    <script>
    // Hace clicable toda la tarjeta menos el corazón y el botón de carrito
    document.addEventListener("DOMContentLoaded", function() {
      document.querySelectorAll('.producto-card').forEach(card => {
        card.addEventListener('click', function(e) {
          if (
            e.target.closest('.favorite-icon') ||
            e.target.closest('.agregarAlCarrito')
          ) return;
          const id = card.getAttribute('data-id');
          window.location.href = `detalle.php?id=${id}`;
        });
      });
    });
    </script>
    <script>
    window.productosAPI = <?php
      // Mapea cada producto para añadir el campo image usando tu función PHP
      $productosConImagen = array_map(function($p) {
          $p['image'] = obtenerImagenProducto($p);
          return $p;
      }, $productos);
      echo json_encode($productosConImagen, JSON_UNESCAPED_UNICODE);
    ?>;
    </script>


    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/main.js"></script>
</body>
</html>

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
?>
