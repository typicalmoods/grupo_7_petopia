console.log("main.js cargado");

// ----------------- Variables globales -----------------
let carrito = JSON.parse(localStorage.getItem("carrito")) || [];
let favoritos = JSON.parse(localStorage.getItem("favoritos")) || [];
let productosAPI = []; // Solo usamos esta variable

const productContainer = document.querySelector(".producto-container");
const carritoContador = document.getElementById("carrito-contador");
const favoritesList = document.getElementById("favoritesList");
const noFavorites = document.getElementById("noFavorites");
const inputBusqueda = document.querySelector(".barraBusqueda");
const botonBuscar = document.querySelector(".search-btn");

// Sugerencias para el buscador
const sugerenciasContainer = document.createElement("div");
sugerenciasContainer.id = "sugerencias";
sugerenciasContainer.classList.add("sugerencias-container");
inputBusqueda?.parentNode?.appendChild(sugerenciasContainer);

// ----------------- Utilidades -----------------
/** Devuelve la mejor imagen disponible para un producto */
function getImagenProducto(producto) {
  return producto.url_image || producto.image || '/assets/img/default.jpg';
}

/** Actualiza la variable global y localStorage de favoritos */
function guardarFavoritos() {
  localStorage.setItem("favoritos", JSON.stringify(favoritos));
}

/** Recarga favoritos desde localStorage */
function cargarFavoritos() {
  favoritos = JSON.parse(localStorage.getItem("favoritos")) || [];
}

// ----------------- Mostrar productos -----------------
function mostrarProductos(lista) {
  if (!productContainer) return;
  productContainer.innerHTML = "";

  lista.forEach((producto) => {
    const imageUrl = getImagenProducto(producto);
    const card = document.createElement("div");
    card.className = "producto-card";
    card.style.cursor = "pointer";
    card.setAttribute("data-id", producto.id);
    card.setAttribute("data-image", imageUrl);

    card.innerHTML = `
      <div class="producto-imagen-container">
        <img src="${imageUrl}" alt="${producto.name}" class="producto-imagen" />
      </div>
      <div class="producto-details">
        <h3 class="producto-marca">${producto.name}</h3>
        <p class="producto-description">${producto.brand}</p>
        <div class="precio-favorito">
          <span class="producto-precio">${producto.price} €</span>
          <span class="favorite-icon" data-id="${producto.id}">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                class="bi bi-heart-fill" viewBox="0 0 16 16">
              <path fill-rule="evenodd"
                  d="M8 1.314C12.438-3.248 23.534 4.735 8 15-7.534 4.736 3.562-3.248 8 1.314" />
            </svg>
          </span>
        </div>
        <button class="agregarAlCarrito">
          Añadir al carrito
          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
        class="bi bi-cart2" viewBox="0 0 16 16" style="vertical-align:middle;margin-left:6px;">
        <path d="M0 2.5A.5.5 0 0 1 .5 2H2a.5.5 0 0 1 .485.379L2.89 4H14.5a.5.5 0 0 1 .485.621l-1.5 6A.5.5 0 0 1 13 11H4a.5.5 0 0 1-.485-.379L1.61 3H.5a.5.5 0 0 1-.5-.5M3.14 5l1.25 5h8.22l1.25-5zM5 13a1 1 0 1 0 0 2 1 1 0 0 0 0-2m-2 1a2 2 0 1 1 4 0 2 2 0 0 1-4 0m9-1a1 1 0 1 0 0 2 1 1 0 0 0 0-2m-2 1a2 2 0 1 1 4 0 2 2 0 0 1-4 0"/>
      </svg>
        </button>
      </div>
    `;

    // Click en la tarjeta: ir al detalle (excepto si es botón de carrito o favorito)
    card.addEventListener("click", function(e) {
      if (e.target.closest(".agregarAlCarrito") || e.target.closest(".favorite-icon")) return;
      window.location.href = `detalle.php?id=${producto.id}`;
    });

    productContainer.appendChild(card);
  });
}

// ----------------- Contador de carrito -----------------
function actualizarContadorCarrito() {
  if (carritoContador)
    carritoContador.textContent = carrito.reduce(
      (total, p) => total + (p.cantidad || 1),
      0
    );
}

// ----------------- Favoritos -----------------
function toggleFavorito(producto) {
  const existente = favoritos.find(item => item.id == producto.id);
  if (existente) {
    favoritos = favoritos.filter(item => item.id != producto.id);
  } else {
    favoritos.push({
      ...producto,
      image: getImagenProducto(producto)
    });
  }
  guardarFavoritos();
}

function esFavorito(producto) {
  return favoritos.some(item => item.id == producto.id);
}

// ----------------- Modal de Favoritos -----------------
function cargarFavoritosModal() {
  cargarFavoritos();
  favoritesList.innerHTML = "";

  if (favoritos.length === 0) {
    noFavorites.style.display = "block";
    favoritesList.style.display = "none";
  } else {
    noFavorites.style.display = "none";
    favoritesList.style.display = "block";

    favoritos.forEach((producto, index) => {
      const item = document.createElement("div");
      item.classList.add("list-group-item", "d-flex", "align-items-center", "justify-content-between");

      item.innerHTML = `
        <div class="d-flex align-items-center">
          <img src="${getImagenProducto(producto)}" alt="${producto.name}" class="me-3 rounded" style="width: 50px; height: 50px; object-fit: cover;">
          <div>
            <h6 class="mb-0">${producto.name}</h6>
            <small class="text-muted">${producto.description}</small>
          </div>
        </div>
        <div>
          <span class="text-primary fw-bold">${producto.price} €</span>
          <button class="btn btn-danger btn-sm ms-3 remove-favorite" data-index="${index}">
            <i class="bi bi-trash"></i>
          </button>
        </div>
      `;

      favoritesList.appendChild(item);
    });

    favoritesList.querySelectorAll(".remove-favorite").forEach(button => {
      button.addEventListener("click", (e) => {
        const index = e.target.closest("button").dataset.index;
        favoritos.splice(index, 1);
        guardarFavoritos();
        cargarFavoritosModal();
        pintarCorazones();
      });
    });
  }
}

// ----------------- Buscar y sugerencias -----------------
function quitarTildes(texto) {
  return texto.normalize("NFD").replace(/[\u0300-\u036f]/g, "");
}

function filtrarProductos() {
  const texto = quitarTildes(inputBusqueda.value.trim().toLowerCase());
  if (!texto) {
    mostrarProductos(productosAPI);
    return;
  }
  const resultados = productosAPI.filter(producto =>
    quitarTildes(producto.name.toLowerCase()).includes(texto) ||
    quitarTildes(producto.description.toLowerCase()).includes(texto)
  );
  mostrarProductos(resultados);
}

function mostrarSugerencias() {
  const texto = quitarTildes(inputBusqueda.value.toLowerCase());
  sugerenciasContainer.innerHTML = "";

  if (!texto) {
    sugerenciasContainer.style.display = "none";
    return;
  }

  const coincidencias = productosAPI.filter(
    (p) =>
      quitarTildes(p.name.toLowerCase()).includes(texto) ||
      quitarTildes(p.description.toLowerCase()).includes(texto)
  );

  coincidencias.forEach((producto) => {
    const item = document.createElement("div");
    item.className = "sugerencia-item";
    item.innerHTML = `
      <img src="${getImagenProducto(producto)}" alt="${producto.name}" style="width:32px;height:32px;object-fit:cover;margin-right:8px;">
      <span>${producto.name}</span>
    `;
    item.style.cursor = "pointer";
    item.style.display = "flex";
    item.style.alignItems = "center";
    item.style.padding = "6px 10px";
    item.addEventListener("click", () => {
      window.location.href = `detalle.php?id=${producto.id}`;
    });
    sugerenciasContainer.appendChild(item);
  });

  sugerenciasContainer.style.display = coincidencias.length ? "block" : "none";
}

// ----------------- Slider automático -----------------
function iniciarSlider() {
  const track = document.querySelector(".slider-track");
  if (!track) return;

  let index = 0;
  let direction = 1;
  const totalSlides = track.children.length;

  setInterval(() => {
    index += direction;
    if (index >= totalSlides - 1 || index <= 0) {
      direction *= -1;
    }
    const offset = index * 100;
    track.style.transform = `translateX(-${offset}%)`;
  }, 5000);
}

// ----------------- Datos de las secciones -----------------
const secciones = [
  {
    titulo: "Perros",
    imagenAnimal: "./assets/img/dog.webp",
    filtro: "Perro",
    tipo: "animal"
  },
  {
    titulo: "Gatos",
    imagenAnimal: "./assets/img/cat.webp",
    filtro: "Gato",
    tipo: "animal"
  },
  {
    titulo: "Pájaros",
    imagenAnimal: "./assets/img/bird.webp",
    filtro: "Pájaro",
    tipo: "animal"
  },
  {
    titulo: "Otros Animales",
    imagenAnimal: "./assets/img/otrosAnimales.webp",
    filtro: "otrosAnimales",
    tipo: "animal"
  },
  {
    titulo: "Juguetes",
    imagenAnimal: "./assets/img/juguetes.png",
    filtro: "Toys",
    tipo: "categoria"
  },
  {
    titulo: "Ofertas",
    imagenAnimal: "./assets/img/categoriaOfertas.png",
    ruta: "ofertas.php"
  }
];

// ----------------- Mostrar secciones -----------------
function mostrarSecciones() {
  const seccionesContainer = document.getElementById("secciones-container");
  if (!seccionesContainer) return;

  seccionesContainer.innerHTML = "";

  secciones.forEach((seccion) => {
    const card = document.createElement("div");
    card.className = "seccion-card";
    const href = seccion.ruta ? seccion.ruta : `index.php?filtro=${encodeURIComponent(seccion.filtro)}`;

    card.innerHTML = `
      <a class="seccion-imagen-container" href="${href}">
        <img src="${seccion.imagenAnimal}" alt="${seccion.titulo}" class="seccion-imagen" />
        <h4 class="seccion-titulo">${seccion.titulo}</h4>
      </a>
    `;

    seccionesContainer.appendChild(card);
  });
}

function mostrarSeccionesNav() {
  const navSecciones = document.getElementById("nav-secciones");
  if (!navSecciones) return;
  navSecciones.innerHTML = "";

  secciones.forEach((seccion) => {
    const li = document.createElement("li");
    li.className = "nav-item";
    const href = seccion.ruta ? seccion.ruta : `index.php?filtro=${encodeURIComponent(seccion.filtro)}`;
    li.innerHTML = `
      <a href="${href}" class="nav-link d-flex align-items-center">
        <img src="${seccion.imagenAnimal}" alt="${seccion.titulo}" style="max-width: 40px;object-fit:cover;margin-right:8px;">
        <span>${seccion.titulo}</span>
      </a>
    `;
    navSecciones.appendChild(li);
  });
}

// ----------------- Inicialización principal -----------------
function inicializarApp() {
  // --- Filtro por parámetro en la URL ---
  function getParam(name) {
    const url = new URL(window.location.href);
    return url.searchParams.get(name);
  }

  const filtro = getParam('filtro');
  if (filtro) {
    let productosFiltrados = [];
    if (["Toys", "Food", "Accessories"].includes(filtro)) {
      productosFiltrados = productosAPI.filter(p => p.category === filtro);
    } else if (["Perro", "Gato", "Pájaro"].includes(filtro)) {
      productosFiltrados = productosAPI.filter(p => p.animal_species === filtro);
    } else if (filtro === "otrosAnimales") {
      const especiesOtros = ["Hámster", "Reptil", "Cobaya", "Roedor"];
      productosFiltrados = productosAPI.filter(p => especiesOtros.includes(p.animal_species));
    }
    mostrarProductos(productosFiltrados);

    document.querySelectorAll('.slider, .banner, .principal').forEach(el => el.style.display = "none");
    const titulo = document.querySelector(".destacados h3");
    if (titulo) titulo.textContent = filtro;
  } else {
    mostrarProductos(productosAPI);
  }

  mostrarSecciones();
  mostrarSeccionesNav();
  actualizarContadorCarrito();
  cargarFavoritosModal();

  if (document.querySelector(".slider-track")) {
    iniciarSlider();
  }

  if (inputBusqueda) {
    inputBusqueda.addEventListener("input", () => {
      filtrarProductos();
      mostrarSugerencias();
    });
  }

  if (botonBuscar) {
    botonBuscar.addEventListener("click", filtrarProductos);
  }

  // Delegación de eventos para "Añadir al carrito"
  const contenedor = document.querySelector(".producto-container");
  if (contenedor) {
    contenedor.addEventListener("click", function(e) {
      const btn = e.target.closest(".agregarAlCarrito");
      if (!btn) return;
      const card = btn.closest(".producto-card");
      if (!card) return;

      const id = card.getAttribute('data-id');
      const name = card.querySelector('.producto-marca').textContent;
      const description = card.querySelector('.producto-description').textContent;
      const price = card.querySelector('.producto-precio').textContent.replace(' €','');
      const image = card.querySelector('.producto-imagen').getAttribute('src');

      const existente = carrito.find(p => p.id == id);
      if (existente) {
        existente.cantidad += 1;
      } else {
        carrito.push({
          id,
          name,
          description,
          price,
          image,
          cantidad: 1
        });
      }
      localStorage.setItem("carrito", JSON.stringify(carrito));
      actualizarContadorCarrito();
      // Muestra el toast de Bootstrap
      const toastEl = document.getElementById('toastCarrito');
      if (toastEl) {
        const toast = new bootstrap.Toast(toastEl);
        toast.show();
      }
    });
  }

  // Favoritos con corazones
  function pintarCorazones() {
    cargarFavoritos();
    document.querySelectorAll('.favorite-icon').forEach(icon => {
      const id = parseInt(icon.dataset.id);
      if (favoritos.some(item => item.id == id)) {
        icon.classList.add('favorito');
      } else {
        icon.classList.remove('favorito');
      }
    });
  }

  document.querySelectorAll('.favorite-icon').forEach(icon => {
    icon.addEventListener('click', function(e) {
      e.stopPropagation();
      const id = parseInt(this.dataset.id);
      const producto = productosAPI.find(p => p.id == id);
      if (!producto) return;
      toggleFavorito(producto);
      pintarCorazones();
      cargarFavoritosModal();
    });
  });

  pintarCorazones();

  // Menú: redirige siempre a index.php con el filtro
  const btnJuguetes = document.getElementById("ver-juguetes");
  if (btnJuguetes) {
    btnJuguetes.addEventListener("click", function(e) {
      e.preventDefault();
      window.location.href = "index.php?filtro=Toys";
    });
  }

  const btnPerros = document.getElementById("ver-perros");
  if (btnPerros) {
    btnPerros.addEventListener("click", function(e) {
      e.preventDefault();
      window.location.href = "index.php?filtro=Dog";
    });
  }

  const btnGatos = document.getElementById("ver-gatos");
  if (btnGatos) {
    btnGatos.addEventListener("click", function(e) {
      e.preventDefault();
      window.location.href = "index.php?filtro=Cat";
    });
  }

  // Menú hamburguesa para móvil
  const btnHamburguesa = document.getElementById("menu-hamburguesa");
  const navMenu = document.getElementById("nav-secciones");

  if (btnHamburguesa && navMenu) {
    btnHamburguesa.addEventListener("click", function() {
      navMenu.classList.toggle("menu-abierto");
    });

    // Cerrar el menú al hacer click fuera
    document.addEventListener("click", function(e) {
      if (
        navMenu.classList.contains("menu-abierto") &&
        !navMenu.contains(e.target) &&
        !btnHamburguesa.contains(e.target)
      ) {
        navMenu.classList.remove("menu-abierto");
      }
    });
  }

  // Formulario de contacto
  const formContacto = document.getElementById("form-contacto");
  const mensajeContacto = document.getElementById("mensaje-contacto");
  if (formContacto) {
    formContacto.addEventListener("submit", function(e) {
      e.preventDefault();
      mensajeContacto.innerHTML = `
        <div class="alert alert-success text-center">
          ¡Tu consulta ha sido enviada!<br>Gracias por contactarnos.
        </div>
      `;
      formContacto.reset();
    });
  }
}

// ----------------- Carga de productos y arranque de la app -----------------
document.addEventListener("DOMContentLoaded", function() {
  // Si los productos no están cargados, haz fetch y luego inicializa la app
  if (!window.productosAPI || window.productosAPI.length === 0) {
    fetch("http://localhost:5051/api/v1/products")
      .then(res => res.json())
      .then(data => {
        window.productosAPI = data;
        productosAPI = data;
        inicializarApp();
      });
  } else {
    productosAPI = window.productosAPI;
    inicializarApp();
  }
});