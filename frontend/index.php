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
            <h2>Petopia</h2>
        </section>

        <div class="grid-dos-imagenes contenedor">
            <img src="./assets/img/ofertas.png" alt="Imagen 1" />
            <img src="./assets/img/banner2.jpeg" alt="Imagen 2" />
        </div>
          
        <section class="destacados contenedor">
            <h3>Productos Destacados</h3>
            <div id="producto-container"></div>
        </section>
    </main>

    <?php include 'includes/footer.php'; ?>
    <?php include 'includes/modals.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/main.js"></script>
</body>

</html>
