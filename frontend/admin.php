<?php
session_start();
if (!isset($_SESSION["is_admin"]) || !$_SESSION["is_admin"]) {
    header("Location: index.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Administración de Pedidos</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background: #f8f9fa;
      font-family: 'Segoe UI', Arial, sans-serif;
    }
    h2 {
      margin-top: 30px;
      margin-bottom: 30px;
      letter-spacing: 1px;
      font-weight: 700;
    }
    .table {
      background: #fff;
      border-radius: 10px;
      overflow: hidden;
      box-shadow: 0 2px 8px rgba(0,0,0,0.07);
    }
    th {
      background: #198754;
      color: #fff;
      text-align: center;
      vertical-align: middle;
    }
    td {
      vertical-align: middle;
      text-align: center;
    }
    ul {
      padding-left: 1.2em;
      margin: 0;
      text-align: left;
    }
    .form-select {
      min-width: 120px;
      border-radius: 20px;
      border-color: #198754;
      background: #e9f7ef;
      color: #198754;
      font-weight: 500;
      transition: border-color 0.2s;
    }
    .form-select:focus {
      border-color: #145c32;
      box-shadow: 0 0 0 0.2rem rgba(25,135,84,.15);
    }
    .estado-pedido option[value="pendiente"] { color: #ffc107; }
    .estado-pedido option[value="enviado"] { color: #0dcaf0; }
    .estado-pedido option[value="finalizado"] { color: #198754; }
    .estado-pedido option[value="cancelado"] { color: #dc3545; }
    .badge-estado {
      border-radius: 12px;
      padding: 0.3em 0.8em;
      font-size: 0.95em;
      font-weight: 500;
    }
    .btn-salir {
      position: fixed;
      top: 24px;
      right: 32px;
      z-index: 1000;
      border-radius: 30px;
      font-weight: 500;
      box-shadow: 0 2px 8px rgba(25,135,84,0.08);
      transition: background 0.2s, color 0.2s;
    }
    .btn-salir:hover {
      background: #145c32 !important;
      color: #fff !important;
    }
    @media (max-width: 900px) {
      .table-responsive { font-size: 0.95em; }
      th, td { padding: 0.5em !important; }
      .btn-salir { top: 12px; right: 12px; }
    }
  </style>
</head>
<body>
<a href="index.php" class="btn btn-outline-success btn-salir">
  <i class="bi bi-box-arrow-right me-1"></i>Salir
</a>
<div class="container py-4">
  <h2>Gestión de pedidos</h2>
  <div class="table-responsive">
    <table class="table table-bordered" id="tabla-pedidos">
      <thead>
        <tr>
          <th>Hora</th>
          <th>Nombre</th>
          <th>Dirección</th>
          <th>Teléfono</th>
          <th>Email</th>
          <th>Productos</th>
          <th>Total (€)</th>
          <th>Estado</th>
          <th>Acciones</th>
        </tr>
      </thead>
      <tbody>
        <!-- Aquí se insertan los pedidos -->
      </tbody>
    </table>
  </div>
</div>

<!-- Bootstrap Icons para el icono de salir -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

<script>
// Simulación: obtener pedidos de localStorage
let pedidos = JSON.parse(localStorage.getItem("pedidos")) || [];

// Renderiza la tabla de pedidos
function renderPedidos() {
  const tbody = document.querySelector("#tabla-pedidos tbody");
  tbody.innerHTML = "";
  pedidos.forEach((pedido, idx) => {
    let productosHtml = "<ul>";
    let total = 0;
    let totalProductos = 0;
    pedido.productos.forEach(prod => {
      productosHtml += `<li>${prod.name} x${prod.cantidad} <span class="text-secondary">(${prod.price}€)</span></li>`;
      total += parseFloat(prod.price) * prod.cantidad;
      totalProductos += prod.cantidad;
    });
    productosHtml += "</ul>";

    // Badge visual para el estado actual
    let badge = "";
    switch (pedido.estado) {
      case "pendiente":
        badge = '<span class="badge bg-warning text-dark badge-estado">Pendiente</span>'; break;
      case "enviado":
        badge = '<span class="badge bg-info text-dark badge-estado">Enviado</span>'; break;
      case "finalizado":
        badge = '<span class="badge bg-success badge-estado">Finalizado</span>'; break;
      case "cancelado":
        badge = '<span class="badge bg-danger badge-estado">Cancelado</span>'; break;
      default:
        badge = "";
    }

    tbody.innerHTML += `
      <tr>
        <td>${pedido.hora || "-"}</td>
        <td>${pedido.envio?.nombre || "-"}</td>
        <td>${pedido.envio?.direccion || "-"}</td>
        <td>${pedido.envio?.telefono || "-"}</td>
        <td>${pedido.envio?.email || "-"}</td>
        <td>${productosHtml}</td>
        <td>
          <span class="fw-bold">${total.toFixed(2)} €</span>
          <br><small class="text-muted">${totalProductos} prod.</small>
        </td>
        <td>
          <div class="mb-1">${badge}</div>
          <select class="form-select estado-pedido" data-idx="${idx}">
            <option value="pendiente" ${pedido.estado === "pendiente" ? "selected" : ""}>Pendiente</option>
            <option value="enviado" ${pedido.estado === "enviado" ? "selected" : ""}>Enviado</option>
            <option value="finalizado" ${pedido.estado === "finalizado" ? "selected" : ""}>Finalizado</option>
            <option value="cancelado" ${pedido.estado === "cancelado" ? "selected" : ""}>Cancelado</option>
          </select>
        </td>
        <td>
          <button class="btn btn-sm btn-outline-danger borrar-pedido" data-idx="${idx}" title="Borrar pedido">
            <i class="bi bi-trash"></i>
          </button>
        </td>
      </tr>
    `;
  });

  // Añade eventos a los select para cambiar el estado
  document.querySelectorAll(".estado-pedido").forEach(select => {
    select.addEventListener("change", function() {
      const idx = this.dataset.idx;
      pedidos[idx].estado = this.value;
      localStorage.setItem("pedidos", JSON.stringify(pedidos));
      renderPedidos(); // Para actualizar el badge visual
    });
  });

  // Añade evento a los botones de borrar
  document.querySelectorAll(".borrar-pedido").forEach(btn => {
    btn.addEventListener("click", function() {
      const idx = this.dataset.idx;
      if (confirm("¿Seguro que quieres borrar este pedido?")) {
        pedidos.splice(idx, 1);
        localStorage.setItem("pedidos", JSON.stringify(pedidos));
        renderPedidos();
      }
    });
  });
}

// Llama a renderPedidos al cargar
renderPedidos();
</script>
</body>
</html>