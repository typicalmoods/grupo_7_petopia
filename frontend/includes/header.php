<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Mi Sitio</title>
  <!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<!-- Bootstrap Icons -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

  <link rel="stylesheet" href="/css/style.css">
</head>
<body>
<header>
        <div class="header-top ">
            <!-- Logo -->
            <div class="logo">
                <img src="./assets/img/" alt="Logo de la marca">
            </div>

            <!-- Buscador -->
            <div class="search-container">
                <input type="text" class="barraBusqueda" placeholder="Buscar productos">
                <button class="search-btn">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#ccc" class="bi bi-search"
                        viewBox="0 0 16 16">
                        <path
                            d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0" />
                    </svg>
                </button>
            </div>


            <!-- Carrito, Login y Favoritos-->
            <div class="user-cart">
                <a  href="#" data-bs-toggle="modal" data-bs-target="#loginModal" title="Iniciar Sesión">
                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor"
                        class="bi bi-person" viewBox="0 0 16 16">
                        <path
                            d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6m2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0m4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4m-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10s-3.516.68-4.168 1.332c-.678.678-.83 1.418-.832 1.664z" />
                    </svg>
                </a>
                  <!-- Icono de favoritos (corazón) -->
                <a href="/favoritos" title="Favoritos">
                    <i class="bi bi-bookmark-heart" style="font-size: 28px;"></i>
                </a>
                <div class="carrito-container position-relative">
                <a href="cart.php">
                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor"
                        class="bi bi-cart2" viewBox="0 0 16 16">
                        <path
                            d="M0 2.5A.5.5 0 0 1 .5 2H2a.5.5 0 0 1 .485.379L2.89 4H14.5a.5.5 0 0 1 .485.621l-1.5 6A.5.5 0 0 1 13 11H4a.5.5 0 0 1-.485-.379L1.61 3H.5a.5.5 0 0 1-.5-.5M3.14 5l1.25 5h8.22l1.25-5zM5 13a1 1 0 1 0 0 2 1 1 0 0 0 0-2m-2 1a2 2 0 1 1 4 0 2 2 0 0 1-4 0m9-1a1 1 0 1 0 0 2 1 1 0 0 0 0-2m-2 1a2 2 0 1 1 4 0 2 2 0 0 1-4 0" />
                    </svg>
                    <span id="carrito-contador">0</span>
                </a>
                     <!-- Mini Carrito: se muestra al hacer hover o clic (según tu preferencia) -->
                <div id="mini-carrito" class="position-absolute end-0 p-3 bg-white border rounded shadow" style="width: 280px; z-index: 1000; display: none; top: calc(100% + 0.5rem);">
                <h6 class="mb-3">Tu Carrito</h6>
                <ul id="lista-mini-carrito" class="list-group list-group-flush">
                  
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                    <span class="item-name">Producto 1</span>
                    <div class="btn-group btn-group-sm" role="group" aria-label="Ajustar cantidad">
                        <button type="button" class="btn btn-outline-secondary minus-btn">–</button>
                        <span class="mx-2 item-qty">1</span>
                        <button type="button" class="btn btn-outline-secondary plus-btn">+</button>
                    </div>
                    </li>
                </ul>
                <a href="checkout.php" class="btn btn-primary btn-sm w-100 mt-3">Ver Carrito</a>
                </div>

                </div>

                </div>

            </div>
        </div>



        <!-- Navegación -->
        <nav class="bg-dark">
            <ul>
                <li><a href="index.php">Inicio</a></li>
                <li><a href="#">Perro</a></li>
                <li><a href="#">Gatos</a></li>
                <li><a href="#">Pájaros</a></li>
                <li><a href="#">Cuidados</a></li>
                <li><a href="#">Marcas</a></li>
                <li><a href="#">Ofertas</a></li>
                <li><a href="#">Servicios</a></li>
            </ul>
        </nav>
    </header>


