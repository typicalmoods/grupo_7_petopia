// Array de productos
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

// Carrito global
let carrito = [];

const productContainer = document.getElementById("producto-container");
const carritoContador = document.getElementById("carrito-contador");

// Función que muestra un array de productos
function mostrarProductos(lista) {
  productContainer.innerHTML = "";

  lista.forEach((producto) => {
    // Crear el elemento de la tarjeta
    const productCard = document.createElement("div");
    productCard.classList.add("producto-card");

    productCard.innerHTML = `
      <div class="producto-imagen-container">
        <img src="${producto.imagen}" alt="${producto.marca}" class="producto-imagen" />
      </div>
      <div class="producto-details">
        <h3 class="producto-marca">${producto.marca}</h3>
        <p class="producto-description">${producto.description}</p>
        <div class="precio-favorito">
          <span class="producto-precio">${producto.precio}</span>
          <span class="favorite-icon">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-heart-fill" viewBox="0 0 16 16">
              <path fill-rule="evenodd" d="M8 1.314C12.438-3.248 23.534 4.735 8 15-7.534 4.736 3.562-3.248 8 1.314"/>
            </svg>
          </span>
        </div>
        <button class="agregarAlCarrito ">
          Añadir al carrito
          <span>
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-cart2" viewBox="0 0 16 16">
              <path d="M0 2.5A.5.5 0 0 1 .5 2H2a.5.5 0 0 1 .485.379L2.89 4H14.5a.5.5 0 0 1 .485.621l-1.5 6A.5.5 0 0 1 13 11H4a.5.5 0 0 1-.485-.379L1.61 3H.5a.5.5 0 0 1-.5-.5M3.14 5l1.25 5h8.22l1.25-5zM5 13a1 1 0 1 0 0 2 1 1 0 0 0 0-2m-2 1a2 2 0 1 1 4 0 2 2 0 0 1-4 0m9-1a1 1 0 1 0 0 2 1 1 0 0 0 0-2m-2 1a2 2 0 1 1 4 0 2 2 0 0 1-4 0" />
            </svg>
          </span>
        </button>
      </div>
    `;

    // Evento para cambiar el estado del ícono favorito
    const favoritoIcono = productCard.querySelector(".favorite-icon");
    favoritoIcono.addEventListener("click", () => {
      favoritoIcono.classList.toggle("favorited");
    });

    // Evento para agregar producto al carrito
    const agregarAlCarrito = productCard.querySelector(".agregarAlCarrito");
    agregarAlCarrito.addEventListener("click", () => {
      carrito.push(producto);
      carritoContador.textContent = carrito.length;
    });

    productContainer.appendChild(productCard);
  });
}

// Función para filtrar productos
const inputBusqueda = document.querySelector(".barraBusqueda");
const botonBuscar = document.querySelector(".search-btn");

function filtrarProductos() {
  const texto = inputBusqueda.value.toLowerCase();

  const productosFiltrados = productos.filter(
    (producto) =>
      producto.description.toLowerCase().includes(texto) ||
      producto.marca.toLowerCase().includes(texto)
  );

  mostrarProductos(productosFiltrados);
}

inputBusqueda.addEventListener("input", filtrarProductos);
botonBuscar.addEventListener("click", filtrarProductos);

mostrarProductos(productos);



// BANNER
const sliderTrack = document.querySelector(".slider-track");
const totalSlides = 3;
let currentSlide = 0;

setInterval(() => {
  currentSlide = (currentSlide + 1) % totalSlides;
  sliderTrack.style.transform = `translateX(-${currentSlide * 100}%)`;
}, 6000);
