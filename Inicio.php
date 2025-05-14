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
  <link rel="stylesheet" href="css/InicioStyle.css">
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
        <span class="tooltip">Search</span>
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
      <div class="welcome">
        <h1>Bienvenido de vuelta,
          <?php echo isset($_SESSION['usuario']) ? $_SESSION['usuario'] : 'Invitado'; ?>
        </h1>
        <div class="Profile">
          <div class="textP">
            <?php echo htmlspecialchars($nombreCompleto_db); ?>
          </div>
          <div class="circleP">
            <img id="fotoP" src="images/ChatGPT Image 4 abr 2025, 17_29_47.png" alt="">
          </div>
        </div>
      </div>
      <div class="vistazo">
        <h3>Echa un vistazo al resumen de hoy: </h3>
      </div>

      <div class="user-grid-container">
        <!-- Tarjeta Resumen de Cuenta -->
        <div class="user-card account-summary">
          <div class="card-header">
            <h3>Resumen de Cuenta</h3>
            <i class="fas fa-user-circle"></i>
          </div>
          <div class="card-content">
            <div class="account-detail">
              <span class="detail-label">Plan Actual</span>
              <span class="detail-value premium">Premium</span>
            </div>
            <div class="account-detail">
              <span class="detail-label">Miembro desde</span>
              <span class="detail-value">Ene 2023</span>
            </div>
            <div class="account-detail">
              <span class="detail-label">Próxima renovación</span>
              <span class="detail-value">15 Jun 2023</span>
            </div>
            <button class="btn upgrade-btn">Mejorar Plan</button>
          </div>
        </div>

        <!-- Tarjeta Actividad Reciente -->
        <div class="user-card recent-activity">
          <div class="card-header">
            <h3>Mi Actividad</h3>
            <i class="fas fa-history"></i>
          </div>
          <div class="card-content">
            <ul class="activity-list">
              <li>
                <i class="fas fa-check-circle success"></i>
                <span>Completaste el curso "Introducción a JavaScript"</span>
                <span class="activity-time">Hoy, 10:45 AM</span>
              </li>
              <li>
                <i class="fas fa-bookmark warning"></i>
                <span>Guardaste "Diseño Web Avanzado" para después</span>
                <span class="activity-time">Ayer, 4:30 PM</span>
              </li>
              <li>
                <i class="fas fa-certificate primary"></i>
                <span>Obtuviste el badge "Estudiante Activo"</span>
                <span class="activity-time">2 días atrás</span>
              </li>
            </ul>
            <a href="#" class="view-all">Ver toda mi actividad</a>
          </div>
        </div>

        <!-- Tarjeta Progreso -->
        <div class="user-card progress-card">
          <div class="card-header">
            <h3>Mi Progreso</h3>
            <i class="fas fa-chart-line"></i>
          </div>
          <div class="card-content">
            <div class="progress-item">
              <div class="progress-info">
                <span>Cursos completados</span>
                <span>3/10</span>
              </div>
              <div class="progress-bar">
                <div class="progress-fill" style="width: 30%"></div>
              </div>
            </div>
            <div class="progress-item">
              <div class="progress-info">
                <span>Objetivos semanales</span>
                <span>2/5</span>
              </div>
              <div class="progress-bar">
                <div class="progress-fill" style="width: 40%"></div>
              </div>
            </div>
            <div class="progress-item">
              <div class="progress-info">
                <span>Horas de aprendizaje</span>
                <span>8.5/20</span>
              </div>
              <div class="progress-bar">
                <div class="progress-fill" style="width: 42.5%"></div>
              </div>
            </div>
          </div>
        </div>

        <!-- Tarjeta Cursos en Progreso -->
        <div class="user-card wide-card courses-card">
          <div class="card-header">
            <h3>Mis Cursos</h3>
            <button class="btn outline-btn">Explorar más cursos</button>
          </div>
          <div class="card-content">
            <div class="course-grid">
              <div class="course-item">
                <div class="course-thumbnail" style="background-color: #4e73df;"></div>
                <h4>JavaScript Avanzado</h4>
                <div class="course-progress">
                  <div class="progress-bar small">
                    <div class="progress-fill" style="width: 65%"></div>
                  </div>
                  <span>65%</span>
                </div>
                <button class="btn continue-btn">Continuar</button>
              </div>
              <div class="course-item">
                <div class="course-thumbnail" style="background-color: #1cc88a;"></div>
                <h4>Diseño UX/UI</h4>
                <div class="course-progress">
                  <div class="progress-bar small">
                    <div class="progress-fill" style="width: 30%"></div>
                  </div>
                  <span>30%</span>
                </div>
                <button class="btn continue-btn">Continuar</button>
              </div>
              <div class="course-item">
                <div class="course-thumbnail" style="background-color: #f6c23e;"></div>
                <h4>Introducción a Python</h4>
                <div class="course-progress">
                  <div class="progress-bar small">
                    <div class="progress-fill" style="width: 10%"></div>
                  </div>
                  <span>10%</span>
                </div>
                <button class="btn continue-btn">Comenzar</button>
              </div>
            </div>
          </div>
        </div>

        <!-- Tarjeta Notificaciones -->
        <div class="user-card notifications-card">
          <div class="card-header">
            <h3>Notificaciones</h3>
            <i class="fas fa-bell"></i>
          </div>
          <div class="card-content">
            <div class="notification-item unread">
              <div class="notification-icon">
                <i class="fas fa-users"></i>
              </div>
              <div class="notification-content">
                <p>Nuevo mensaje en el foro de JavaScript</p>
                <span class="notification-time">Hace 2 horas</span>
              </div>
            </div>
            <div class="notification-item">
              <div class="notification-icon">
                <i class="fas fa-calendar-alt"></i>
              </div>
              <div class="notification-content">
                <p>Recordatorio: Clase en vivo mañana a las 3 PM</p>
                <span class="notification-time">Hace 1 día</span>
              </div>
            </div>
            <div class="notification-item">
              <div class="notification-icon">
                <i class="fas fa-gift"></i>
              </div>
              <div class="notification-content">
                <p>Nuevo badge disponible: "Estudiante Destacado"</p>
                <span class="notification-time">Hace 3 días</span>
              </div>
            </div>
            <a href="#" class="view-all">Ver todas las notificaciones</a>
          </div>
        </div>
      </div>
    </div>
    <footer class="user-footer">
      <div class="footer-content">
        <div class="footer-links">
          <a href="#" class="footer-link">Términos</a>
          <a href="#" class="footer-link">Privacidad</a>
          <a href="#" class="footer-link">Contacto</a>
        </div>

        <div class="footer-social">
          <a href="https://www.facebook.com/abel.arriagadaurriola" class="social-icon" title="Facebook">
            <i class='bx bxl-facebook' style='color:#fffafa'></i>
          </a>
          <a href="#" class="social-icon" title="Twitter">
            <i class='bx bxl-twitter' style='color:#fffafa'></i>
          </a>
          <a href="https://www.instagram.com/abelardoahhaaha/" class="social-icon" title="Instagram">
            <i class='bx bxl-instagram' style='color:#fffafa'></i>
          </a>
          <a href="https://cl.linkedin.com/in/abel-arriagada-urriola-9aaa19287" class="social-icon" title="LinkedIn">
            <i class='bx bxl-linkedin' style='color:#fffafa'></i>
          </a>
          <a href="https://wa.me/<+56956025318>?text=<Hola muy buenas, vengo a saludar>" class="social-icon" title="Whatsapp">
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
  <script href="js/CargarDatos.js"></script>
</body>


</html>