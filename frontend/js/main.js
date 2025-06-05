// ----------------- Productos -----------------
const productos = [
  {
    imagen: "./assets/img/comida.jpg",
    marca: "Marca A",
    description: "Comida para perro adulto sabor pollo",
    precio: "19.99€",
  },
  {
    imagen: "./assets/img/comida.jpg",
    marca: "Marca B",
    description: "Comida húmeda para gato con salmón",
    precio: "14.95€",
  },
  {
    imagen: "./assets/img/comida.jpg",
    marca: "Marca C",
    description: "Snacks naturales para perros medianos",
    precio: "7.50€",
  },
  {
    imagen: "./assets/img/comida.jpg",
    marca: "Marca D",
    description: "Pienso premium para gatos esterilizados",
    precio: "21.30€",
  },
  {
    imagen: "./assets/img/comida.jpg",
    marca: "Marca E",
    description: "Alimento para cachorro con cordero",
    precio: "18.25€",
  },
  {
    imagen: "./assets/img/comida.jpg",
    marca: "Marca F",
    description: "Barritas dentales para higiene oral canina",
    precio: "9.99€",
  },
];


// ----------------- Variables -----------------
let carrito = JSON.parse(localStorage.getItem("carrito")) || [];
let favoritos = JSON.parse(localStorage.getItem("favoritos")) || [];
const productContainer = document.getElementById("producto-container");
const carritoContador = document.getElementById("carrito-contador");
const favoritesList = document.getElementById("favoritesList");
const noFavorites = document.getElementById("noFavorites");
const inputBusqueda = document.querySelector(".barraBusqueda");
const botonBuscar = document.querySelector(".search-btn");

// Sugerencias
const sugerenciasContainer = document.createElement("div");
sugerenciasContainer.id = "sugerencias";
sugerenciasContainer.classList.add("sugerencias-container");
inputBusqueda?.parentNode?.appendChild(sugerenciasContainer);

// ----------------- Mostrar productos -----------------
function mostrarProductos(lista) {
  if (!productContainer) return;
  productContainer.innerHTML = "";

  lista.forEach((producto) => {
    const card = document.createElement("div");
    card.className = "producto-card";

    card.innerHTML = `
      <div class="producto-imagen-container">
        <img src="${producto.imagen}" alt="${producto.marca}" class="producto-imagen" />
      </div>
      <div class="producto-details">
        <h3 class="producto-marca">${producto.marca}</h3>
        <p class="producto-description">${producto.description}</p>
        <div class="precio-favorito">
          <span class="producto-precio">${producto.precio}</span>
          <span class="favorite-icon ${esFavorito(producto) ? "favorited" : ""}">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
              class="bi bi-heart-fill" viewBox="0 0 16 16">
              <path fill-rule="evenodd"
                d="M8 1.314C12.438-3.248 23.534 4.735 8 15-7.534 4.736 3.562-3.248 8 1.314" />
            </svg>
          </span>
        </div>
        <button class="agregarAlCarrito">Añadir al carrito
          <span>
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
              class="bi bi-cart2" viewBox="0 0 16 16">
              <path
                d="M0 2.5A.5.5 0 0 1 .5 2H2a.5.5 0 0 1 .485.379L2.89 4H14.5a.5.5 0 0 1 .485.621l-1.5 6A.5.5 0 0 1 13 11H4a.5.5 0 0 1-.485-.379L1.61 3H.5a.5.5 0 0 1-.5-.5zM3.14 5l1.25 5h8.22l1.25-5zM5 13a1 1 0 1 0 0 2 1 1 0 0 0 0-2zM3 14a2 2 0 1 1 4 0 2 2 0 0 1-4 0zM12 13a1 1 0 1 0 0 2 1 1 0 0 0 0-2zM10 14a2 2 0 1 1 4 0 2 2 0 0 1-4 0z" />
            </svg>
          </span>
        </button>
      </div>
    `;

    // Evento para añadir o quitar de favoritos
    card.querySelector(".favorite-icon").addEventListener("click", (e) => {
      e.currentTarget.classList.toggle("favorited");
      toggleFavorito(producto);
      cargarFavoritosModal(); // Actualizar el modal de favoritos
    });

    // Evento para añadir al carrito
    card.querySelector(".agregarAlCarrito").addEventListener("click", () => {
      agregarProductoAlCarrito(producto);
    });

    productContainer.appendChild(card);
  });
}

// ----------------- Agregar al carrito -----------------
function agregarProductoAlCarrito(producto) {
  const existente = carrito.find(
    (item) =>
      item.marca === producto.marca && item.description === producto.description
  );

  if (existente) {
    existente.cantidad++;
  } else {
    carrito.push({
      ...producto,
      precio: parseFloat(producto.precio.replace("€", "")),
      cantidad: 1,
    });
  }

  localStorage.setItem("carrito", JSON.stringify(carrito));
  actualizarContadorCarrito();
}

function actualizarContadorCarrito() {
  if (carritoContador)
    carritoContador.textContent = carrito.reduce(
      (total, p) => total + p.cantidad,
      0
    );
}

// ----------------- Favoritos -----------------
function toggleFavorito(producto) {
  const existente = favoritos.find(
    (item) =>
      item.marca === producto.marca && item.description === producto.description
  );

  if (existente) {
    // Si ya está en favoritos, eliminarlo
    favoritos = favoritos.filter(
      (item) =>
        item.marca !== producto.marca || item.description !== producto.description
    );
  } else {
    // Si no está en favoritos, añadirlo
    favoritos.push(producto);
  }

  localStorage.setItem("favoritos", JSON.stringify(favoritos));
}

function esFavorito(producto) {
  return favoritos.some(
    (item) =>
      item.marca === producto.marca && item.description === producto.description
  );
}

// ----------------- Modal de Favoritos -----------------
function cargarFavoritosModal() {
  const favoritos = JSON.parse(localStorage.getItem("favoritos")) || [];

  // Limpiar la lista de favoritos
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
          <img src="${producto.imagen}" alt="${producto.nombre}" class="me-3 rounded" style="width: 50px; height: 50px; object-fit: cover;">
          <div>
            <h6 class="mb-0">${producto.marca}</h6>
            <small class="text-muted">${producto.description}</small>
          </div>
        </div>
        <div>
          <span class="text-primary fw-bold">${producto.precio}</span>
          <button class="btn btn-danger btn-sm ms-3 remove-favorite" data-index="${index}">
            <i class="bi bi-trash"></i>
          </button>
        </div>
      `;

      favoritesList.appendChild(item);
    });

    // Agregar eventos para eliminar favoritos
    document.querySelectorAll(".remove-favorite").forEach(button => {
      button.addEventListener("click", (e) => {
        const index = e.target.closest("button").dataset.index;
        eliminarFavorito(index);
        cargarFavoritosModal(); // Actualizar el modal después de eliminar
      });
    });
  }
}

function eliminarFavorito(index) {
  favoritos.splice(index, 1);
  localStorage.setItem("favoritos", JSON.stringify(favoritos));
}

// ----------------- Buscar y sugerencias -----------------
function filtrarProductos() {
  const texto = inputBusqueda.value.toLowerCase();
  const resultados = productos.filter(
    (p) =>
      p.marca.toLowerCase().includes(texto) ||
      p.description.toLowerCase().includes(texto)
  );
  mostrarProductos(resultados);
}

function mostrarSugerencias() {
  const texto = inputBusqueda.value.toLowerCase();
  sugerenciasContainer.innerHTML = "";

  if (!texto) {
    sugerenciasContainer.style.display = "none";
    return;
  }

  const coincidencias = productos.filter(
    (p) =>
      p.marca.toLowerCase().includes(texto) ||
      p.description.toLowerCase().includes(texto)
  );

  coincidencias.forEach((producto) => {
    const item = document.createElement("div");
    item.className = "sugerencia-item";
    item.innerHTML = `
      <img src="${producto.imagen}" alt="${producto.marca}">
      <span>${producto.marca} - ${producto.description}</span>
    `;
    item.addEventListener("click", () => {
      inputBusqueda.value = producto.marca;
      mostrarProductos([producto]);
      sugerenciasContainer.style.display = "none";
    });
    sugerenciasContainer.appendChild(item);
  });

  sugerenciasContainer.style.display = "block";
}

// ----------------- Slider automático -----------------
function iniciarSlider() {
  const track = document.querySelector(".slider-track");
  if (!track) return;

  let index = 0;
  let direction = 1; // 1 para avanzar, -1 para retroceder
  const totalSlides = track.children.length;

  setInterval(() => {
    index += direction;

    if (index >= totalSlides - 1 || index <= 0) {
      direction *= -1; // Cambiar dirección
    }

    const offset = index * 100;
    track.style.transform = `translateX(-${offset}%)`;
  }, 5000);
}

// ----------------- Datos de las secciones -----------------
const secciones = [
  {
    imagen: "./assets/img/perros.jpg",
    titulo: "Perros",
  },
  {
    imagen: "./assets/img/gatos.jpg",
    titulo: "Gatos",
  },
  {
    imagen: "./assets/img/pajaros.jpg",
    titulo: "Pájaros",
  },
  {
    imagen: "./assets/img/otros.jpg",
    titulo: "Otros Animales",
  },
];

// ----------------- Mostrar secciones -----------------
function mostrarSecciones() {
  const seccionesContainer = document.getElementById("secciones-container");
  if (!seccionesContainer) return;

  seccionesContainer.innerHTML = ""; // Limpiar el contenedor

  secciones.forEach((seccion) => {
    const card = document.createElement("div");
    card.className = "seccion-card";

    card.innerHTML = `
      <div class="seccion-imagen-container">
        <img src="${seccion.imagen}" alt="${seccion.titulo}" class="seccion-imagen" />
      </div>
      <h4 class="seccion-titulo">${seccion.titulo}</h4>
    `;

    seccionesContainer.appendChild(card);
  });
}

// ----------------- Inicialización -----------------
document.addEventListener("DOMContentLoaded", () => {
  if (productContainer) {
    mostrarProductos(productos);
    actualizarContadorCarrito();
    cargarFavoritosModal(); // Cargar favoritos en el modal al inicio
  }

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

  mostrarSecciones(); // Generar las tarjetas de secciones
});

// ----------------- Registro de Usuario -----------------
const API_BASE_URL = "https://api.example.com"; // Reemplaza con tu URL base

async function registrarUsuario(datosUsuario) {
  try {
    const response = await fetch(`${API_BASE_URL}/users/register`, {
      method: "POST",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify(datosUsuario),
    });
    const data = await response.json();
    if (response.ok) {
      alert("Usuario registrado con éxito");
    } else {
      alert(`Error: ${data.message}`);
    }
  } catch (error) {
    console.error("Error:", error);
  }
}
