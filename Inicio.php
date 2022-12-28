<?php
//Se inicia la sesion
session_start();
//Formula para que no se salten el login
if (!isset($_SESSION['usuario'])) {
  echo '
      <script>
        alert("Por favor debes iniciar sesion");
        window.location = "index.php";
      </script>
      ';
  //Se destruye la sesion
  session_destroy();
  //El codigo muere aqui si no se inicia sesion
  die();
}
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
  <meta charset="utf-8">
  <title> Menú </title>
  <!--Enlace de la hoja de estilo -->
  <link rel="stylesheet" href="css/sideBar.css">
  <!--Enlace de los iconos de Box icons-->
  <link href='https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css' rel='stylesheet'>
  <meta name="viewport" content="width = device-width,  initial-scale = 1">
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
      <!--Items de la Lista-->
      <li>
        <!--Inicio-->
        <a href="#">
          <!--Icono del item-->
          <i class='bx bxs-home-smile bx-tada'></i>
          <!--Resalta y ocupa un espacio segun el texto-->
          <span class="links_name">Inicio</span>
        </a>
        <span class="tooltip">Inicio</span>
      </li>
      <li>
        <!--User-->
        <a href="Usuarios.php">
          <!--Icono del item-->
          <i class='bx bxs-user bx-flashing'></i>
          <!--Resalta y ocupa un espacio segun el texto-->
          <span class="links_name">User</span>
        </a>
        <span class="tooltip">Usuarios</span>
      </li>
      <!--Mensajes-->
      <li>
        <!--Redirecion a otra pagina-->
        <a href="#">
          <!--Icono del item-->
          <i class='bx bx-chat bx-flashing'></i>
          <!--Resalta y ocupa un espacio segun el texto-->
          <span class="links_name">Mensajes</span>
        </a>
        <span class="tooltip">Mensaje</span>
      </li>
      <!--Administrador de archivos-->
      <li>
        <!--Redirecion a otra pagina-->
        <a href="#">
          <!--Icono del item-->
          <i class='bx bxs-folder-open bx-tada'></i>
          <!--Resalta y ocupa un espacio segun el texto-->
          <span class="links_name">Archivos</span>
        </a>
        <span class="tooltip">Archivos</span>
      </li>
      <!--Items de la Lista-->
      <li>
        <!--Configuracion-->
        <a href="#">
          <!--Icono del item-->
          <i class='bx bx-cog bx-spin'></i>
          <!--Resalta y ocupa un espacio segun el texto-->
          <span class="links_name">Configuracion</span>
        </a>
        <span class="tooltip">Configuracion</span>
      </li>
      <!--Items de la Lista-->
      <li>
        <!--Ayuda-->
        <a href="#">
          <!--Icono del item-->
          <i class='bx bxs-help-circle bx-spin'></i>
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
    <div class="text">Home content</div>

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