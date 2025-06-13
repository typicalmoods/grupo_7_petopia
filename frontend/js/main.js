console.log("main.js cargado");
// ----------------- Variables -----------------
let carrito = JSON.parse(localStorage.getItem("carrito")) || [];
let favoritos = JSON.parse(localStorage.getItem("favoritos")) || [];
const productContainer = document.querySelector(".producto-container");
const carritoContador = document.getElementById("carrito-contador");
const favoritesList = document.getElementById("favoritesList");
const noFavorites = document.getElementById("noFavorites");
const inputBusqueda = document.querySelector(".barraBusqueda");
const botonBuscar = document.querySelector(".search-btn");
let productosAPI = window.productosAPI || [];

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
    card.style.cursor = "pointer";
    card.setAttribute("data-id", producto.id);

    card.innerHTML = `
      <div class="producto-imagen-container">
        <img src="${producto.image}" alt="${producto.name}" class="producto-imagen" />
      </div>
      <div class="producto-details">
        <h3 class="producto-marca">${producto.name}</h3>
        <p class="producto-description">${producto.description}</p>
        <div class="precio-favorito">
          <span class="producto-precio">${producto.price} €</span>
          <button class="agregarAlCarrito">Añadir al carrito</button>
        </div>
      </div>
    `;

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
    favoritos.push(producto);
  }
  localStorage.setItem("favoritos", JSON.stringify(favoritos));
}

function esFavorito(producto) {
  return favoritos.some(item => item.id == producto.id);
}

// ----------------- Modal de Favoritos -----------------
function cargarFavoritosModal() {
  const favoritos = JSON.parse(localStorage.getItem("favoritos")) || [];
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
          <img src="${producto.image}" alt="${producto.name}" class="me-3 rounded" style="width: 50px; height: 50px; object-fit: cover;">
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

    document.querySelectorAll(".remove-favorite").forEach(button => {
      button.addEventListener("click", (e) => {
        const index = e.target.closest("button").dataset.index;
        eliminarFavorito(index);
        cargarFavoritosModal();
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
  const texto = inputBusqueda.value.trim().toLowerCase();
  if (!texto) {
    mostrarProductos(productosAPI);
    return;
  }
  const resultados = productosAPI.filter(producto =>
    producto.name.toLowerCase().includes(texto) ||
    producto.description.toLowerCase().includes(texto)
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

  const coincidencias = productosAPI.filter(
    (p) =>
      p.name.toLowerCase().includes(texto) ||
      p.description.toLowerCase().includes(texto)
  );

  coincidencias.forEach((producto) => {
    const item = document.createElement("div");
    item.className = "sugerencia-item";
    item.innerHTML = `
      <img src="${producto.image}" alt="${producto.name}" style="width:32px;height:32px;object-fit:cover;margin-right:8px;">
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
    imagenAnimal: "./assets/img/dog.webp",
    titulo: "Perros",
  },
  {
    imagenAnimal: "./assets/img/cat.webp",
    titulo: "Gatos",
  },
  {
    imagenAnimal: "./assets/img/bird.webp",
    titulo: "Pájaros",
  },
  {
    imagenAnimal: "./assets/img/otrosAnimales.webp",
    titulo: "Otros Animales",
  },
];

// ----------------- Mostrar secciones -----------------
function mostrarSecciones() {
   console.log("mostrarSecciones ejecutada");
  const seccionesContainer = document.getElementById("secciones-container");
  if (!seccionesContainer) return;

  seccionesContainer.innerHTML = "";

  secciones.forEach((seccion) => {
    const card = document.createElement("div");
    card.className = "seccion-card";

    card.innerHTML = `
      <a class="seccion-imagen-container">
        <img src="${seccion.imagenAnimal}" alt="${seccion.titulo}" class="seccion-imagen" />
      <h4 class="seccion-titulo">${seccion.titulo}</h4>
      </a>
    `;

    seccionesContainer.appendChild(card);
  });
}



// ----------------- Inicialización -----------------
document.addEventListener("DOMContentLoaded", () => {
  
  mostrarSecciones();
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
});

// ----------------- Delegación de eventos para "Añadir al carrito" -----------------
document.addEventListener("DOMContentLoaded", function() {
  const contenedor = document.querySelector(".producto-container");
  if (!contenedor) return;
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
    if (typeof actualizarContadorCarrito === "function") actualizarContadorCarrito();
    // Muestra el toast de Bootstrap
    const toastEl = document.getElementById('toastCarrito');
    if (toastEl) {
      const toast = new bootstrap.Toast(toastEl);
      toast.show();
    }
  });
});

// ----------------- Registro de Usuario (opcional) -----------------
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

