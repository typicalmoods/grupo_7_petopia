<?php if (session_status() === PHP_SESSION_NONE) session_start(); ?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Petopia</title>
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
            <a href="index.php">
                <img src="./assets/img/logoPetopia.png" alt="Logo de la marca">
            </a>
            <?php if (isset($_SESSION["is_admin"]) && $_SESSION["is_admin"]): ?>
<a class="btn" style="background-color: rgb(52, 58, 64); color: white; padding: 4px 8px; font-size: 12px; border-radius: 4px; text-decoration: none;" href="../admin.php">Administración</a>
            <?php endif; ?>
        </div>

        <!-- Buscador -->
        <div class="search-container">
            <input type="text" class="barraBusqueda form-control" placeholder="Buscar productos">
            <button class="search-btn btn">
                <i class="bi bi-search"></i>
            </button>
        </div>

        <!-- Carrito, Login y Favoritos-->
        <div class="user-cart">
            <?php if (isset($_SESSION["usuario"])): ?>
                <a href="logout.php" class="cerrar-sesion">
                    <i class="bi bi-power"></i> <?= htmlspecialchars($_SESSION["usuario"]) ?>
                </a>
            <?php else: ?>
                <a href="#" data-bs-toggle="modal" data-bs-target="#loginModal" title="Iniciar Sesión">
                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor"
                        class="bi bi-person" viewBox="0 0 16 16">
                        <path
                            d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6m2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0m4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4m-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10s-3.516.68-4.168 1.332c-.678.678-.83 1.418-.832 1.664z" />
                    </svg>
                </a>
            <?php endif; ?>

            <!-- Icono de favoritos (corazón) -->
            <a href="#" data-bs-toggle="modal" data-bs-target="#favoritesModal" title="Favoritos">
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
            </div>
        </div>
    </div>

    <!-- Botón hamburguesa -->
    <button id="menu-hamburguesa" class="menu-hamburguesa" aria-label="Abrir menú">
        <span></span>
        <span></span>
        <span></span>
    </button>

    <!-- Menú de navegación -->
    <ul class="nav-menu" id="nav-secciones">
        <!-- Aquí van los <li> de las secciones -->
    </ul>
</header>



