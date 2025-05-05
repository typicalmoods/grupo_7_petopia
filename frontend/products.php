<?php include 'includes/header.php'; ?>

<main class="container my-5">
    <div class="row">
        <!-- Columna Izquierda: Imagen y Descripción del Producto -->
        <div class="col-lg-7">
            <div class="card">
                <img src="./assets/img/producto-ejemplo.jpg" alt="Producto Ejemplo" class="card-img-top img-fluid">
                <div class="card-body">
                    <h3 class="card-title">Nombre del Producto</h3>
                    <p class="card-text">
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin ac neque nec justo tincidunt
                        tincidunt. Suspendisse potenti. Fusce vel magna id libero tincidunt fermentum. Curabitur
                        vehicula, justo a tincidunt tincidunt, eros lorem tincidunt lorem, nec tincidunt lorem eros
                        tincidunt lorem.
                    </p>
                </div>
            </div>
        </div>

        <!-- Columna Derecha: Precio, Cantidad y Botón -->
        <div class="col-lg-5">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h4 class="card-title">Precio</h4>
                    <p class="fs-4"><strong>19,99€</strong></p> <!-- Precio en color negro -->
                    <hr>
                    <div class="d-flex align-items-center mb-3">
                        <label for="cantidad" class="me-3">Cantidad:</label>
                        <select id="cantidad" class="form-select w-auto">
                            <?php for ($i = 1; $i <= 10; $i++): ?>
                                <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                            <?php endfor; ?>
                        </select>
                    </div>
                    <button id="addToCart" class="btn btn-primary w-100">
                        Añadir al Carrito <i class="bi bi-cart-plus"></i> <!-- Ícono después del texto -->
                    </button>
                </div>
            </div>
        </div>
    </div>
</main>

<?php include 'includes/footer.php'; ?>
<?php include 'includes/modals.php'; ?>

<script>
    // Lógica para añadir al carrito
    document.getElementById('addToCart').addEventListener('click', () => {
        const cantidad = parseInt(document.getElementById('cantidad').value);
        const producto = {
            imagen: './assets/img/producto-ejemplo.jpg',
            nombre: 'Nombre del Producto',
            descripcion: 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
            precio: 19.99,
            cantidad: cantidad
        };

        // Obtener carrito del localStorage
        const carrito = JSON.parse(localStorage.getItem('carrito')) || [];

        // Verificar si el producto ya está en el carrito
        const existente = carrito.find(item => item.nombre === producto.nombre);
        if (existente) {
            existente.cantidad += cantidad;
        } else {
            carrito.push(producto);
        }

        // Guardar carrito actualizado en localStorage
        localStorage.setItem('carrito', JSON.stringify(carrito));

        // Mostrar mensaje de éxito
        alert('Producto añadido al carrito');
    });
</script>