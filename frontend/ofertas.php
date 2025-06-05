<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    
<?php include 'includes/header.php'; ?>

<main>
    <section class="cupones-container">
        <h1>Ofertas y Cupones</h1>
        <div class="cupones-grid">
            <!-- Cupón 1 -->
            <div class="cupon">
                <div class="cupon-inner">
                    <div class="cupon-front">
                        <img src="./assets/img/cupon1.jpg" alt="Cupón 1">
                    </div>
                    <div class="cupon-back">
                        <p>¡Usa el código <strong>DESCUENTO10</strong> para un 10% de descuento!</p>
                    </div>
                </div>
            </div>
            <!-- Cupón 2 -->
            <div class="cupon">
                <div class="cupon-inner">
                    <div class="cupon-front">
                        <img src="./assets/img/cuponGratis.webp" alt="Cupón 2">
                    </div>
                    <div class="cupon-back">
                        <p>¡Usa el código <strong>ENVIOGRATIS</strong> para envío gratuito!</p>
                    </div>
                </div>
            </div>
            <!-- Cupón 3 -->
            <div class="cupon">
                <div class="cupon-inner">
                    <div class="cupon-front">
                        <img src="./assets/img/50off.webp" alt="Cupón 3">
                    </div>
                    <div class="cupon-back">
                        <p>¡Usa el código <strong>5OFF</strong> para un 50% de descuento!</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<?php include 'includes/footer.php'; ?>
<?php include 'includes/modals.php'; ?>

</body>
</html>
