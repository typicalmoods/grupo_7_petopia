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
    <div id="detalle-producto" class="contenedor my-5"></div>
  </main>

  <?php include 'includes/footer.php'; ?>

  <script>
    const API_BASE = 'http://localhost:5050/api/v1';
    const params = new URLSearchParams(window.location.search);
    const id = params.get('id');

    function obtenerImagenProducto(producto) {
      switch (producto.id) {
        case 1: return "/assets/img/comida.jpg";
        case 2: return "/assets/img/comida.jpg";
        case 3: return "/assets/img/bird.webp";
        case 4: return "/assets/img/pienso_gato.jpg";
        case 5: return "/assets/img/juguete1.jpg";
        case 6: return "/assets/img/juguete2.jpg";
        // ...añade más casos según tus productos
        default: return "/assets/img/default.jpg";
      }
    }

    async function obtenerDetalleProducto() {
      try {
        const resp = await fetch(`${API_BASE}/products/${id}`);
        if (!resp.ok) throw new Error('Producto no encontrado');
        const producto = await resp.json();

        const contenedor = document.getElementById('detalle-producto');
        const imagen = obtenerImagenProducto(producto);

        contenedor.innerHTML = `
          <div class="container py-4">
            <div class="row align-items-center bg-white rounded shadow p-4">
              <div class="col-md-5 text-center mb-3 mb-md-0">
                <img src="${imagen}" alt="${producto.name}" class="img-fluid rounded" style="max-height:340px;object-fit:cover;background:#f8f8f8;">
              </div>
              <div class="col-md-7">
                <h2 class="fw-bold mb-3" style="color:#343a40">${producto.name}</h2>
                <p class="mb-3" style="color:#555;">${producto.description}</p>
                <p class="fs-4 fw-bold mb-4" style="color:#cb333b;">${producto.price} €</p>
                <button class="btn" style="background:#cb333b;color:#fff;font-weight:600;font-size:1.1rem;padding:12px 32px;border-radius:8px;">
                  Añadir al carrito
                </button>
              </div>
            </div>
          </div>
        `;
      } catch (error) {
        document.getElementById('detalle-producto').textContent = error.message;
      }
    }

    window.onload = obtenerDetalleProducto;
  </script>
</body>
</html>
<?php include 'includes/modals.php'; ?>