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

// Variables globales
let carrito = JSON.parse(localStorage.getItem("carrito")) || [];
const productContainer = document.getElementById("producto-container");
const carritoContador = document.getElementById("carrito-contador");
const inputBusqueda = document.querySelector(".barraBusqueda");
const botonBuscar = document.querySelector(".search-btn");

// 🎯 Contenedor de sugerencias
const sugerenciasContainer = document.createElement("div");
sugerenciasContainer.id = "sugerencias";
sugerenciasContainer.classList.add("sugerencias-container");
inputBusqueda.parentNode.appendChild(sugerenciasContainer);

// Función para mostrar productos
function mostrarProductos(lista) {
  const productContainer = document.getElementById("producto-container");

  // Verificar si el contenedor existe
  if (!productContainer) {
    console.error("El contenedor 'producto-container' no existe en el DOM.");
    return;
  }

  productContainer.innerHTML = ""; // Limpiar el contenedor antes de agregar productos

  lista.forEach((producto) => {
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
        <button class="agregarAlCarrito">
          Añadir al carrito
          <span>
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-cart2" viewBox="0 0 16 16">
              <path d="M0 2.5A.5.5 0 0 1 .5 2H2a.5.5 0 0 1 .485.379L2.89 4H14.5a.5.5 0 0 1 .485.621l-1.5 6A.5.5 0 0 1 13 11H4a.5.5 0 0 1-.485-.379L1.61 3H.5a.5.5 0 0 1-.5-.5M3.14 5l1.25 5h8.22l1.25-5zM5 13a1 1 0 1 0 0 2 1 1 0 0 0 0-2m-2 1a2 2 0 1 1 4 0 2 2 0 0 1-4 0m9-1a1 1 0 1 0 0 2 1 1 0 0 0 0-2m-2 1a2 2 0 1 1 4 0 2 2 0 0 1-4 0" />
            </svg>
          </span>
        </button>
      </div>
    `;

    // Evento para cambiar estado favorito
    const favoritoIcono = productCard.querySelector(".favorite-icon");
    favoritoIcono.addEventListener("click", () => {
      favoritoIcono.classList.toggle("favorited");
    });

    // Evento para agregar producto al carrito
    const agregarAlCarrito = productCard.querySelector(".agregarAlCarrito");
    agregarAlCarrito.addEventListener("click", () => {
      agregarProductoAlCarrito(producto);
    });

    productContainer.appendChild(productCard);
  });
}

// Función para agregar producto al carrito
function agregarProductoAlCarrito(producto) {
  const existe = carrito.find(
    (item) =>
      item.marca === producto.marca && item.description === producto.description
  );

  if (existe) {
    existe.cantidad++;
  } else {
    carrito.push({
      imagen: producto.imagen,
      marca: producto.marca,
      description: producto.description,
      precio: parseFloat(producto.precio.replace("€", "")),
      cantidad: 1,
    });
  }

  localStorage.setItem("carrito", JSON.stringify(carrito));
  carritoContador.textContent = carrito.reduce((sum, p) => sum + p.cantidad, 0);
}

// Función para filtrar productos
function filtrarProductos() {
  const texto = inputBusqueda.value.toLowerCase();

  const productosFiltrados = productos.filter(
    (producto) =>
      producto.description.toLowerCase().includes(texto) ||
      producto.marca.toLowerCase().includes(texto)
  );

  mostrarProductos(productosFiltrados);
}

// Función para mostrar sugerencias
function mostrarSugerencias() {
  const texto = inputBusqueda.value.toLowerCase();
  sugerenciasContainer.innerHTML = "";

  if (texto.length === 0) {
    sugerenciasContainer.style.display = "none";
    return;
  }

  const productosFiltrados = productos.filter(
    (producto) =>
      producto.description.toLowerCase().includes(texto) ||
      producto.marca.toLowerCase().includes(texto)
  );

  if (productosFiltrados.length > 0) {
    productosFiltrados.forEach((producto) => {
      const item = document.createElement("div");
      item.classList.add("sugerencia-item");
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
  } else {
    sugerenciasContainer.style.display = "none";
  }
}

// Listeners
inputBusqueda.addEventListener("input", () => {
  filtrarProductos();
  mostrarSugerencias();
});

botonBuscar.addEventListener("click", filtrarProductos);

// Verificar si el contenedor existe antes de llamar a la función
document.addEventListener("DOMContentLoaded", () => {
  const productContainer = document.getElementById("producto-container");
  if (!productContainer) {
    console.warn(
      "El contenedor 'producto-container' no está presente en esta página."
    );
    return;
  }

  // Mostrar todos los productos al inicio
  mostrarProductos(productos);
  carritoContador.textContent = carrito.reduce((sum, p) => sum + p.cantidad, 0);
});

// Cargar el carrito en la página de carrito
document.addEventListener("DOMContentLoaded", () => {
  const carritoLista = document.getElementById("carrito-lista");
  if (!carritoLista) return;

  carritoLista.innerHTML = "";

  if (carrito.length === 0) {
    carritoLista.innerHTML = "<p>El carrito está vacío.</p>";
    return;
  }

  carrito.forEach((producto) => {
    const productoDiv = document.createElement("div");
    productoDiv.classList.add("producto-carrito");
    productoDiv.innerHTML = `
      <div class="producto-img">
        <img src="${producto.imagen}" alt="${producto.marca}">
      </div>
      <div class="producto-info">
        <h4>${producto.marca}</h4>
        <p>Precio: $${producto.precio}</p>
        <p>Cantidad: ${producto.cantidad}</p>
      </div>
      <div class="producto-eliminar">
        <button class="eliminar-producto" data-id="${producto.marca}">Eliminar</button>
      </div>
    `;
    carritoLista.appendChild(productoDiv);
  });

  // Agregar eventos para eliminar productos
  const botonesEliminar = document.querySelectorAll(".eliminar-producto");
  botonesEliminar.forEach((boton) => {
    boton.addEventListener("click", eliminarProductoDelCarrito);
  });
});

// Eliminar producto del carrito
function eliminarProductoDelCarrito(event) {
  const idProducto = event.target.getAttribute("data-id");
  carrito = carrito.filter((producto) => producto.marca !== idProducto);
  localStorage.setItem("carrito", JSON.stringify(carrito));
  cargarCarrito();
}

// Función para recargar carrito
function cargarCarrito() {
  const carritoLista = document.getElementById("carrito-lista");
  if (!carritoLista) return;

  carritoLista.innerHTML = "";

  if (carrito.length === 0) {
    carritoLista.innerHTML = "<p>El carrito está vacío.</p>";
    return;
  }

  carrito.forEach((producto) => {
    const productoDiv = document.createElement("div");
    productoDiv.classList.add("producto-carrito");
    productoDiv.innerHTML = `
      <div class="producto-img">
        <img src="${producto.imagen}" alt="${producto.marca}">
      </div>
      <div class="producto-info">
        <h4>${producto.marca}</h4>
        <p>Precio: $${producto.precio}</p>
        <p>Cantidad: ${producto.cantidad}</p>
      </div>
      <div class="producto-eliminar">
        <button class="eliminar-producto" data-id="${producto.marca}">Eliminar</button>
      </div>
    `;
    carritoLista.appendChild(productoDiv);
  });
}
