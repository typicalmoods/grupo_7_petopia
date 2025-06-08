<?php
include 'includes/header.php';
include 'includes/conexion.php';

$id = $_GET['id'] ?? null;

if (!$id) {
    echo "<div class='container my-5'><h2>Producto no encontrado</h2></div>";
    include 'includes/footer.php';
    exit;
}

$query = "SELECT * FROM productos WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $id);
$stmt->execute();
$resultado = $stmt->get_result();
$producto = $resultado->fetch_assoc();

if (!$producto) {
    echo "<div class='container my-5'><h2>Producto no encontrado</h2></div>";
    include 'includes/footer.php';
    exit;
}
?>

<main class="container my-5">
    <div class="row">
        <div class="col-md-6">
            <img src="<?= $producto['imagen'] ?>" class="img-fluid" alt="<?= $producto['nombre'] ?>">
        </div>
        <div class="col-md-6">
            <h2><?= $producto['nombre'] ?></h2>
            <p><?= $producto['descripcion'] ?></p>
            <p class="fw-bold fs-4"><?= number_format($producto['precio'], 2) ?>€</p>
            <!-- Botón para comprar o añadir al carrito -->
            <form action="carrito.php" method="post">
                <input type="hidden" name="producto_id" value="<?= $producto['id'] ?>">
                <button type="submit" class="btn btn-success">Añadir al carrito</button>
            </form>
            <a href="products.php?categoria=<?= urlencode($producto['categoria']) ?>" class="btn btn-secondary mt-3">Volver a productos</a>
        </div>
    </div>
</main>

<?php include 'includes/footer.php'; ?>