<!-- Modal de Login -->
<div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content p-4 position-relative">
      
      <!-- Botón de cierre -->
      <button type="button" class="btn-close position-absolute top-0 end-0 m-3" 
              data-bs-dismiss="modal" aria-label="Cerrar"></button>

      <div class="modal-body">
        <div class="text-center fs-3 fw-bold mb-3">Iniciar Sesión</div>

        <div class="input-group mb-3">
            <span class="input-group-text bg-info text-white">
              <i class="bi bi-envelope-fill"></i>
            </span>
            <input type="email" class="form-control bg-light" placeholder="Correo electrónico" required>
          </div>

        <div class="input-group mb-3">
          <span class="input-group-text bg-info text-white">
            <i class="bi bi-lock-fill"></i>
          </span>
          <input type="password" class="form-control bg-light" placeholder="Contraseña">
        </div>

        <div class="d-flex justify-content-between mb-3">
          <div class="form-check">
            <input class="form-check-input" type="checkbox" id="rememberMe">
            <label class="form-check-label" for="rememberMe">Recuérdame</label>
          </div>
          <a href="#" class="text-info fst-italic">¿Olvidaste tu contraseña?</a>
        </div>

        <button class="btn btn-info w-100 text-white fw-semibold mb-2">
          Iniciar sesión
        </button>

        <div class="text-center">
          <small>¿No tienes cuenta? 
            <a href="#" class="text-info"
               data-bs-toggle="modal" data-bs-target="#registerModal" data-bs-dismiss="modal">
              Regístrate
            </a>
          </small>
        </div>

        <div class="border-bottom my-3 text-center">
          <span class="bg-white px-2">o</span>
        </div>

        <button class="btn btn-outline-secondary w-100 d-flex justify-content-center align-items-center gap-2">
          <i class="bi bi-google"></i>
          Continuar con Google
        </button>
      </div>
    </div>
  </div>
</div>

<!-- Modal de Registro -->
<div class="modal fade" id="registerModal" tabindex="-1" aria-labelledby="registerModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content p-4 position-relative">
      
      <!-- Botón de cierre -->
      <button type="button" class="btn-close position-absolute top-0 end-0 m-3" 
              data-bs-dismiss="modal" aria-label="Cerrar"></button>

      <div class="modal-body">
        <div class="text-center fs-3 fw-bold mb-3">Regístrate</div>
        <form>
          <div class="input-group mb-3">
            <span class="input-group-text bg-info text-white">
              <i class="bi bi-person-fill"></i>
            </span>
            <input type="text" class="form-control bg-light" placeholder="Nombre" name="username" required>
          </div>
            <div class="input-group mb-3">
          <span class="input-group-text bg-info text-white">
            <i class="bi bi-person-fill"></i>
          </span>
          <input type="text" class="form-control bg-light" placeholder="Apellidos" name="lastname">
        </div>
          <div class="input-group mb-3">
            <span class="input-group-text bg-info text-white">
              <i class="bi bi-envelope-fill"></i>
            </span>
            <input type="email" class="form-control bg-light" placeholder="Correo electrónico" name="email" required>
          </div>
          <div class="input-group mb-3">
            <span class="input-group-text bg-info text-white">
              <i class="bi bi-lock-fill"></i>
            </span>
            <input type="password" class="form-control bg-light" placeholder="Contraseña" name="password" required>
          </div>
          <div class="input-group mb-3">
            <span class="input-group-text bg-info text-white">
              <i class="bi bi-lock-fill"></i>
            </span>
            <input type="password" class="form-control bg-light" placeholder="Confirmar contraseña" required>
          </div>
          <button type="submit" class="btn btn-info w-100 text-white fw-semibold mb-2">
            Registrarse
          </button>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Modal de Favoritos -->
<div class="modal fade" id="favoritesModal" tabindex="-1" aria-labelledby="favoritesModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl modal-dialog-centered"> <!-- Cambiado a modal-xl para ocupar el 80% -->
    <div class="modal-content" style="font-size: 1.25rem;"> <!-- Texto más grande -->
      <!-- Encabezado del modal -->
      <div class="modal-header">
        <h2 class="modal-title mx-auto fw-bold" id="favoritesModalLabel">Mis Favoritos</h2> <!-- Título más grande -->
      </div>
      <!-- Cuerpo del modal -->
      <div class="modal-body">
        <div id="favoritesList" class="list-group">
          <!-- Los productos favoritos se cargarán dinámicamente aquí -->
        </div>
        <div id="noFavorites" class="text-center text-muted" style="display: none;">
          <p>No tienes productos en tu lista de favoritos.</p>
        </div>
      </div>
      <!-- Pie del modal -->
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>

<script>
  document.querySelector("#registerModal form").addEventListener("submit", (e) => {
    e.preventDefault();
    const datosUsuario = {
      username: e.target.querySelector("input[name='username']").value,
      password: e.target.querySelector("input[name='password']").value,
      email: e.target.querySelector("input[name='email']").value,
    };
    registrarUsuario(datosUsuario);
  });

  // Suponiendo que tienes una función para cargar los favoritos
  function cargarFavoritos(favoritos) {
    const favoritesList = document.getElementById("favoritesList");
    const noFavorites = document.getElementById("noFavorites");
    favoritesList.innerHTML = ""; // Limpiar lista existente

    if (favoritos.length === 0) {
      noFavorites.style.display = "block";
    } else {
      noFavorites.style.display = "none";
      favoritos.forEach((producto, index) => {
        const item = document.createElement("div");
        item.className = "list-group-item d-flex justify-content-between align-items-center";
        // Modal de favoritos
        item.innerHTML = `
          <div class="d-flex align-items-center">
            <img src="${producto.image || producto.url_image || '/assets/img/default.jpg'}" alt="${producto.name}" class="me-3 rounded" style="width: 50px; height: 50px; object-fit: cover;">
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
    }
  }
</script>
