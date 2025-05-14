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
              <i class='bx bxl-facebook' style='color:#fffafa'  ></i>
            </a>
            <a href="#" class="social-icon" title="Twitter">
              <i class='bx bxl-twitter' style='color:#fffafa' ></i>
            </a>
            <a href="#" class="social-icon" title="Instagram">
              <i class='bx bxl-instagram' style='color:#fffafa' ></i>
            </a>
            <a href="#" class="social-icon" title="LinkedIn">
              <i class='bx bxl-linkedin' style='color:#fffafa' ></i>
            </a>
            <a href="#" class="social-icon" title="Whatsapp">
              <i class='bx bxl-whatsapp' style='color:#fffafa' ></i>
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