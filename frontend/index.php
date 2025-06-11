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
                $apiUrl = "http://backend:5000/api/v1/products";
                $response = file_get_contents($apiUrl);
                $productos = json_decode($response, true);
                foreach ($productos as $producto): ?>
                    <div class="producto-card">
                        <div class="producto-imagen-container">
                            <img src="<?php echo htmlspecialchars(obtenerImagenProducto($producto)); ?>" alt="<?php echo htmlspecialchars($producto['name']); ?>" class="producto-imagen" />
                        </div>
                        <div class="producto-details">
                            <h3 class="producto-marca"><?php echo htmlspecialchars($producto['name']); ?></h3>
                            <p class="producto-description"><?php echo htmlspecialchars($producto['description']); ?></p>
                            <div class="precio-favorito">
                                <span class="producto-precio"><?php echo htmlspecialchars($producto['price']); ?> €</span>
                                <span class="favorite-icon">
                                    <!-- icono corazón -->
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                        class="bi bi-heart-fill" viewBox="0 0 16 16">
                                        <path fill-rule="evenodd"
                                            d="M8 1.314C12.438-3.248 23.534 4.735 8 15-7.534 4.736 3.562-3.248 8 1.314" />
                                    </svg>
                                </span>
                            </div>
                            <button class="agregarAlCarrito">Añadir al carrito
                                <span>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                        class="bi bi-cart2" viewBox="0 0 16 16">
                                        <path
                                            d="M0 2.5A.5.5 0 0 1 .5 2H2a.5.5 0 0 1 .485.379L2.89 4H14.5a.5.5 0 0 1 .485.621l-1.5 6A.5.5 0 0 1 13 11H4a.5.5 0 0 1-.485-.379L1.61 3H.5a.5.5 0 0 1-.5-.5zM3.14 5l1.25 5h8.22l1.25-5zM5 13a1 1 0 1 0 0 2 1 1 0 0 0 0-2zM3 14a2 2 0 1 1 4 0 2 2 0 0 1-4 0zM12 13a1 1 0 1 0 0 2 1 1 0 0 0 0-2zM10 14a2 2 0 1 1 4 0 2 2 0 0 1-4 0z" />
                                    </svg>
                                </span>
                            </button>
                            <a href="detalle.php?id=<?php echo $producto['id']; ?>">Ver más</a>
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/main.js"></script>

    <?php
    function obtenerImagenProducto($producto) {
        switch ($producto['id']) {
            case 1: return "/assets/img/comida.jpg";
            case 2: return "/assets/img/comida.jpg";
            case 3: return "/assets/img/bird.webp";
            case 4: return "/assets/img/comida_gato.jpg";
            case 5: return "/assets/img/juguete1.jpg";
            case 6: return "/assets/img/juguete2.jpg";
            case 7: return "/assets/img/accesorio.jpg";
            case 8: return "/assets/img/accesorio.jpg";
            case 9: return "/assets/img/juguete1.jpg";
            case 10: return "/assets/img/juguete2.jpg";
            case 11: return "/assets/img/accesorio.jpg";
            case 12: return "/assets/img/accesorio.jpg";
            default: return "/assets/img/default.jpg";
        }
    }
    ?>
</body>

</html>
