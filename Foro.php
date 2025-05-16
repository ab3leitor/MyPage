<?php
// Iniciar sesión y configurar headers de seguridad
session_start();
// Verificar autenticación
if (!isset($_SESSION['usuario'])) {
  header('Location: index.php');
  exit();
}

// El nombre completo ya está disponible desde el login
$nombreCompleto_db = $_SESSION['nombreCompleto'];
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Menú - Treyak</title>
  <link rel="stylesheet" href="css/sideBar.css">
  <link rel="stylesheet" href="css/HomeContenido.css">
  <link rel="stylesheet" href="css/foroStyle.css">
  <link rel="stylesheet" href="css/FooterStyle.css">
  <link href='https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css' rel='stylesheet'>
</head>

<body>
  <!--Div que contiene el sidebar-->
  <div class="sidebar">
    <!--Div que contiene la parte del logo-->
    <div class="logo_content">
      <div class="logo">
        <!--Icono de la empresa-->
        <i class='bx bx-joystick-alt'></i>
        <div class="logo_name">Treyak</div>
      </div>
      <!--Icono del menu-->
      <i class='bx bx-menu' id="btn"></i>
    </div>
    <!--Lista no ordenada-->
    <ul>
      <!--Items de la Lista-->
      <li>
        <!--Buscar-->
        <!--Icono del item-->
        <i class='bx bx-search'></i>
        <!--Icono del item-->
        <input type="text" placeholder="Search..." name="" value="">
        <span class="tooltipSearch">Search</span>
      </li>
      <div class="divider"></div>
      <!--Items de la Lista-->
      <li>
        <!--Inicio-->
        <a href="Inicio.php">
          <!--Icono del item-->
          <i class='bx bxs-home-smile'></i>
          <!--Resalta y ocupa un espacio segun el texto-->
          <span class="links_name">Inicio</span>
        </a>
        <span class="tooltip">Inicio</span>
      </li>
      <li>
        <!--User-->
        <a href="Usuarios.php">
          <!--Icono del item-->
          <i class='bx bxs-user'></i>
          <!--Resalta y ocupa un espacio segun el texto-->
          <span class="links_name">User</span>
        </a>
        <span class="tooltip">Usuarios</span>
      </li>
      <!--Mensajes-->
      <li>
        <!--Redirecion a otra pagina-->
        <a href="Mensajes.php">
          <!--Icono del item-->
          <i class='bx bx-conversation'></i>
          <!--Resalta y ocupa un espacio segun el texto-->
          <span class="links_name">Mensajes</span>
        </a>
        <span class="tooltip">Mensaje</span>
      </li>
      <!--Administrador de archivos-->
      <li>
        <!--Redirecion a otra pagina-->
        <a href="Foro.php">
          <!--Icono del item-->
          <i class='bx bxs-folder-open'></i>
          <!--Resalta y ocupa un espacio segun el texto-->
          <span class="links_name">Archivos</span>
        </a>
        <span class="tooltip">Foro</span>
      </li>
      <!--Items de la Lista-->
      <li>
        <!--Configuracion-->
        <a href="Configuracion.php">
          <!--Icono del item-->
          <i class='bx bxs-cog'></i>
          <!--Resalta y ocupa un espacio segun el texto-->
          <span class="links_name">Configuracion</span>
        </a>
        <span class="tooltip">Configuracion</span>
      </li>
      <!--Items de la Lista-->
      <li>
        <!--Ayuda-->
        <a href="Ayuda.php">
          <!--Icono del item-->
          <i class='bx bxs-help-circle'></i>
          <!--Resalta y ocupa un espacio segun el texto-->
          <span class="links_name">Ayuda</span>
        </a>
        <span class="tooltip">Ayuda</span>
      </li>
    </ul>
    <div class="perfil_contenido">
      <div class="perfil">
        <div class="perfil_detalles">
          <img src="images/perfil.jpg" alt="">
          <div class="name_job">
            <div class="name">Abel Arriagada</div>
            <div class="job">Programador</div>
            <div class="log_out"></div>
          </div>
        </div>
        <!--Icono del item-->
        <div>
          <a href="php/cerrar_sesion.php"><i class='bx bx-log-out' id="log_out"></i></a>

        </div>
      </div>
    </div>
  </div>
  <!--Aqui ya comienza el segmento de la pagina-->
  <div class="home_contenido">
    <div class="contenido">
      <div class="foro-container">
        <div class="foro-header">
          <h2 class="foro-title">Foro de Discusión</h2>
          <a href="#" class="btn-nuevo-hilo" id="newThreadBtn">Nuevo Hilo</a>
        </div>

        <ul class="hilo-list" id="threadList">
          <!-- Los hilos se cargarán aquí dinámicamente -->
        </ul>

        <div class="foro-footer">
          <span id="threadCount">0 hilos</span>
        </div>
      </div>

      <!-- Modal para nuevo hilo -->
      <div class="modal" id="newThreadModal">
        <div class="modal-content">
          <div class="modal-header">
            <h3 class="modal-title">Crear nuevo hilo</h3>
            <span class="close-modal">&times;</span>
          </div>
          <form id="newThreadForm">
            <div class="form-group">
              <label for="threadTitle" class="form-label">Título</label>
              <input type="text" id="threadTitle" class="form-input" required>
            </div>
            <div class="form-group">
              <label for="threadContent" class="form-label">Contenido</label>
              <textarea id="threadContent" class="form-textarea" required></textarea>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" id="cancelThreadBtn">Cancelar</button>
              <button type="submit" class="btn btn-primary">Crear Hilo</button>
            </div>
          </form>
        </div>
      </div>

      <script>
        // Función para cargar los hilos
        async function loadThreads() {
          try {
            const response = await fetch('php/ObtenerHilosForo.php');
            const threads = await response.json();

            const threadList = document.getElementById('threadList');
            threadList.innerHTML = '';

            threads.forEach(thread => {
              const threadItem = document.createElement('li');
              threadItem.className = 'hilo-item';

              const iconClass = thread.is_pinned ? 'hilo-icon pinned' : 'hilo-icon';
              const icon = thread.is_pinned ? '📌' : '💬';

              const lastReplyDate = thread.last_reply ? new Date(thread.last_reply) : null;
              const formattedLastReply = lastReplyDate ? lastReplyDate.toLocaleString('es-ES', {
                day: '2-digit',
                month: '2-digit',
                year: 'numeric',
                hour: '2-digit',
                minute: '2-digit'
              }) : 'Sin respuestas';

              threadItem.innerHTML = `
                        <div class="${iconClass}">${icon}</div>
                        <div class="hilo-content">
                            <h3 class="hilo-title">
                                <a href="verHilo.php?id=${thread.id}">${thread.title}</a>
                                ${thread.is_closed ? ' [Cerrado]' : ''}
                            </h3>
                            <div class="hilo-meta">
                                Creado por <a href="#">${thread.creator_name}</a> • 
                                ${new Date(thread.created_at).toLocaleString('es-ES', {
                                    day: '2-digit',
                                    month: '2-digit',
                                    year: 'numeric'
                                })}
                            </div>
                            ${thread.last_reply_author ? `
                            <div class="hilo-last-reply">
                                Última respuesta: ${thread.last_reply_author} • ${formattedLastReply}
                            </div>
                            ` : ''}
                        </div>
                        <div class="hilo-stats">
                            <span class="hilo-replies">${thread.reply_count} respuestas</span>
                            <span class="hilo-views">${thread.view_count} vistas</span>
                        </div>
                    `;

              threadList.appendChild(threadItem);
            });

            document.getElementById('threadCount').textContent = `${threads.length} hilos`;
          } catch (error) {
            console.error('Error al cargar hilos:', error);
          }
        }

        // Mostrar/ocultar modal
        const modal = document.getElementById('newThreadModal');
        const newThreadBtn = document.getElementById('newThreadBtn');
        const closeModal = document.querySelector('.close-modal');
        const cancelBtn = document.getElementById('cancelThreadBtn');

        newThreadBtn.addEventListener('click', () => {
          modal.style.display = 'block';
        });

        closeModal.addEventListener('click', () => {
          modal.style.display = 'none';
        });

        cancelBtn.addEventListener('click', () => {
          modal.style.display = 'none';
        });

        window.addEventListener('click', (event) => {
          if (event.target === modal) {
            modal.style.display = 'none';
          }
        });

        // Enviar nuevo hilo
        document.getElementById('newThreadForm').addEventListener('submit', async (e) => {
          e.preventDefault();

          const title = document.getElementById('threadTitle').value.trim();
          const content = document.getElementById('threadContent').value.trim();
          const creatorId = <?php echo isset($_SESSION['id']) ? $_SESSION['id'] : 'null'; ?>;

          if (!title || !content || !creatorId) {
            alert('Por favor completa todos los campos');
            return;
          }

          try {
            const response = await fetch('php/CrearHiloForo.php', {
              method: 'POST',
              headers: {
                'Content-Type': 'application/json',
              },
              body: JSON.stringify({
                title,
                content,
                creator_id: creatorId
              })
            });

            const result = await response.json();

            if (result.success) {
              modal.style.display = 'none';
              document.getElementById('threadTitle').value = '';
              document.getElementById('threadContent').value = '';
              loadThreads();
            } else {
              alert('Error al crear el hilo: ' + (result.message || 'Error desconocido'));
            }
          } catch (error) {
            console.error('Error:', error);
            alert('Error al crear el hilo');
          }
        });

        // Cargar hilos al iniciar
        loadThreads();
      </script>
    </div>
    <footer class="user-footer">
      <div class="footer-content">
        <div class="footer-links">
          <a href="#" class="footer-link">Inicio</a>
          <a href="#" class="footer-link">Términos</a>
          <a href="#" class="footer-link">Privacidad</a>
          <a href="#" class="footer-link">Contacto</a>
        </div>

        <div class="footer-social">
          <a href="#" class="social-icon" title="Facebook">
            <i class='bx bxl-facebook' style='color:#fffafa'></i>
          </a>
          <a href="#" class="social-icon" title="Twitter">
            <i class='bx bxl-twitter' style='color:#fffafa'></i>
          </a>
          <a href="#" class="social-icon" title="Instagram">
            <i class='bx bxl-instagram' style='color:#fffafa'></i>
          </a>
          <a href="#" class="social-icon" title="LinkedIn">
            <i class='bx bxl-linkedin' style='color:#fffafa'></i>
          </a>
          <a href="#" class="social-icon" title="Whatsapp">
            <i class='bx bxl-whatsapp' style='color:#fffafa'></i>
          </a>
        </div>

        <p class="footer-copyright">© 2023 NombreApp. Todos los derechos reservados.</p>
      </div>
    </footer>
  </div>
  <script>
    let btn = document.querySelector("#btn");
    let sidebar = document.querySelector(".sidebar");
    let searchBtn = document.querySelector(".bx-search");

    btn.onclick = function() {
      sidebar.classList.toggle("active");
    }
    searchBtn.onclick = function() {
      sidebar.classList.toggle("active");
    }
  </script>
</body>


</html>