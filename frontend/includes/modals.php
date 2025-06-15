<!-- Modal de Login -->
<div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content p-4 position-relative">
      
      <!-- Botón de cierre -->
      <button type="button" class="btn-close position-absolute top-0 end-0 m-3" 
              data-bs-dismiss="modal" aria-label="Cerrar"></button>

      <div class="modal-body">
        <div class="text-center fs-3 fw-bold mb-3">Iniciar Sesión</div>
        <div id="login-mensaje"></div>

        <!-- Formulario de Login -->
        <form id="form-login" method="POST" action="login.php">
          <div class="input-group mb-3">
              <span class="input-group-text bg-info text-white">
                <i class="bi bi-envelope-fill"></i>
              </span>
              <input type="text" class="form-control bg-light" placeholder="Usuario" name="username" required>
            </div>

          <div class="input-group mb-3">
            <span class="input-group-text bg-info text-white">
              <i class="bi bi-lock-fill"></i>
            </span>
<input type="password" class="form-control bg-light" placeholder="Contraseña" name="password" required>
          </div>

          <div class="d-flex justify-content-between mb-3">
            
            <a href="#" class="text-info fst-italic">¿Olvidaste tu contraseña?</a>
          </div>

          <button type="submit" class="btn btn-info w-100 text-white fw-semibold mb-2">
            Iniciar sesión
          </button>
        </form>

        <div class="text-center">
          <small>¿No tienes cuenta? 
            <a href="#" class="text-info"
               data-bs-toggle="modal" data-bs-target="#registerModal" data-bs-dismiss="modal">
              Regístrate
            </a>
          </small>
        </div>

        <div class="border-bottom my-3 text-center">
        </div>

        
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
        <div id="register-mensaje"></div>
        <!-- Formulario de Registro -->
        <form method="POST" action="register.php">
          <div class="input-group mb-3">
            <span class="input-group-text bg-info text-white">
              <i class="bi bi-person-fill"></i>
            </span>
            <input type="text" class="form-control bg-light" placeholder="Nombre de usuario" name="username" required>
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
          <div class="input-group mb-3">
            <span class="input-group-text bg-info text-white">
              <i class="bi bi-telephone-fill"></i>
            </span>
            <input type="text" class="form-control bg-light" placeholder="Teléfono" name="phone" required>
          </div>
          <div class="input-group mb-3">
            <span class="input-group-text bg-info text-white">
              <i class="bi bi-geo-alt-fill"></i>
            </span>
            <input type="text" class="form-control bg-light" placeholder="Dirección" name="address" required>
          </div>
          <div class="input-group mb-3">
            <span class="input-group-text bg-info text-white">
              <i class="bi bi-calendar-date"></i>
            </span>
            <input type="date" class="form-control bg-light" placeholder="Fecha de nacimiento" name="birthdate" required>
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
  // Evento modal de favoritos
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

  document.addEventListener("DOMContentLoaded", function() {
  const formLogin = document.getElementById("form-login");
  const loginMensaje = document.getElementById("login-mensaje");

  if (formLogin) {
    formLogin.addEventListener("submit", async function(e) {
      e.preventDefault();
      loginMensaje.innerHTML = "";

      const datos = {
        username: formLogin.username.value,
        password: formLogin.password.value
      };

      try {
        const response = await fetch("login.php", {
          method: "POST",
          headers: { "Content-Type": "application/json" },
          body: JSON.stringify(datos)
        });
        const data = await response.json();

        if (response.ok && data.success) {
          loginMensaje.innerHTML = `
            <div class="alert alert-success text-center">
              <i class="bi bi-check-circle-fill" style="font-size:2rem;color:#198754;"></i><br>
              ¡Inicio de sesión correcto!<br>
              Redirigiendo a la página principal...
            </div>
          `;
          setTimeout(() => {
            window.location.href = "index.php";
          }, 1500);
        } else {
          loginMensaje.innerHTML = `
            <div class="alert alert-danger text-center">
              ${data.error || "Usuario o contraseña incorrectos."}
            </div>
          `;
        }
      } catch (err) {
        loginMensaje.innerHTML = `
          <div class="alert alert-danger text-center">
            Error de conexión con el servidor.
          </div>
        `;
      }
    });
  }

  // Registro con mensaje en el modal
  const formRegister = document.querySelector("#registerModal form");
  const registerMensaje = document.getElementById("register-mensaje");

  if (formRegister) {
    formRegister.addEventListener("submit", async function(e) {
      e.preventDefault();
      registerMensaje.innerHTML = ""; // Limpia mensajes anteriores

      // Recoge los datos del formulario
      const formData = new FormData(formRegister);
      const datos = {};
      formData.forEach((value, key) => {
        datos[key] = value;
      });

      // Validación simple de contraseñas iguales
      const passwordInputs = formRegister.querySelectorAll('input[type="password"]');
      if (passwordInputs.length === 2 && passwordInputs[0].value !== passwordInputs[1].value) {
        registerMensaje.innerHTML = `
          <div class="alert alert-danger text-center">
            Las contraseñas no coinciden.
          </div>
        `;
        return;
      }

      try {
        const response = await fetch("register.php", {
          method: "POST",
          body: formData
        });
        const data = await response.json();

        if (response.ok && data.success) {
          registerMensaje.innerHTML = `
            <div class="alert alert-success text-center">
              <i class="bi bi-check-circle-fill" style="font-size:2rem;color:#198754;"></i><br>
              ¡Registro exitoso!<br>
              Ahora puedes iniciar sesión.
            </div>
          `;
          setTimeout(() => {
            // Cierra el modal de registro y abre el de login
            const registerModal = bootstrap.Modal.getInstance(document.getElementById('registerModal'));
            registerModal.hide();
            document.getElementById("register-mensaje").innerHTML = "";
            new bootstrap.Modal(document.getElementById('loginModal')).show();
          }, 1800);
        } else {
          registerMensaje.innerHTML = `
            <div class="alert alert-danger text-center">
              ${data.error || "Error en el registro."}
            </div>
          `;
        }
      } catch (err) {
        registerMensaje.innerHTML = `
          <div class="alert alert-danger text-center">
            Error de conexión con el servidor.
          </div>
        `;
      }
    });
  }
});
</script>
