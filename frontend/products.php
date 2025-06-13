<?php
include 'includes/header.php';
include 'includes/conexion.php'; // Asegúrate de tener tu conexión aquí

$categoria = $_GET['categoria'] ?? 'todos';

if ($categoria === 'todos') {
    $query = "SELECT * FROM productos";
    $resultado = $conn->query($query);
} else {
    $query = "SELECT * FROM productos WHERE categoria = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $categoria);
    $stmt->execute();
    $resultado = $stmt->get_result();
}
?>

<main class="container my-5">
    <h2 class="mb-4 text-capitalize"><?= htmlspecialchars($categoria) ?></h2>
    <div class="row row-cols-1 row-cols-md-3 g-4">
        <?php while ($producto = $resultado->fetch_assoc()): ?>
            <div class="col">
                <div class="card h-100">
                    <a href="detalle.php?id=<?= $producto['id'] ?>">
                        <img src="<?= $producto['imagen'] ?>" class="card-img-top" alt="<?= $producto['nombre'] ?>">
                    </a>
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title"><?= $producto['nombre'] ?></h5>
                        <p class="card-text"><?= substr($producto['descripcion'], 0, 100) ?>...</p>
                        <p class="text-dark fw-bold mt-auto"><?= number_format($producto['precio'], 2) ?>€</p>
                        <a href="detalle.php?id=<?= $producto['id'] ?>" class="btn btn-primary mt-2">Ver más</a>
                    </div>
                </div>
            </div>
        <?php endwhile; ?>
    </div>
</main>

<?php include 'includes/footer.php'; ?>

