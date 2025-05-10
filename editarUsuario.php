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
  <title> Editar usuario </title>
  <!--Enlace de la hoja de estilo menu -->
  <link rel="stylesheet" href="css/sideBar.css">
  <link rel="stylesheet" href="css/HomeContenido.css">
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
        <a href="Documentos.php">
          <!--Icono del item-->
          <i class='bx bxs-folder-open'></i>
          <!--Resalta y ocupa un espacio segun el texto-->
          <span class="links_name">Archivos</span>
        </a>
        <span class="tooltip">Archivos</span>
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
  <!-- Aqui se encuentra el script que permite que al clickear el boton del menu o el de buscar
        se expanda la barra lateral -->
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

  <?php
  include("php/conexion_be.php");
  ?>
  <?php
  if (isset($_POST['enviar'])) {
    /* Aqui entra cuando se presiona el boton de enviar */
    $id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $usuario = $_POST['usuario'];
    $correo = $_POST['correo'];

    /* Update usuarios set */
    $sql = "update usuario set nombreCompleto='" . $nombre .
      "', usuario='" . $usuario . "', correoElectronico='" . $correo . "' where id='" . $id . "'";
    $resultado = mysqli_query($conexion, $sql);
    /* Aqui se comprueba que la query se haya ejecutado correctamente o no */
    if ($resultado) {
      echo "<script language='JavaScript'>
                alert('Los datos se actualizaron correctamente');
                location.assign('index.php');
                </script>";
    } else {
      echo "<script language='JavaScript'>
                alert('Los datos no se actualizaron correctamente');
                location.assign('index.php');
                </script>";
    }
    mysqli_close($conexion);
  } else {
    /* Aqui entra si no se ha presionado el boton enviar */
    $id = $_GET['id'];
    $sql = "select * from usuario where id='" . $id . "'";
    $resultado = mysqli_query($conexion, $sql);

    $fila = mysqli_fetch_assoc($resultado);
    $nombre = $fila["nombreCompleto"];
    $usuario = $fila["usuario"];
    $correo = $fila["correoElectronico"];

    mysqli_close($conexion);
  ?>
    <!--Aqui ya comienza el segmento de la pagina-->
    <div class="home_contenido">
      <h1>Editar usuario</h1>
      <form action="<?= $_SERVER['PHP_SELF'] ?>" method="post">
        <!-- input nombre -->
        <label for="nombre" class="formulario_label">Nombre: </label>
        <input type="text" class="formulario_input" name="nombre" id="nombre" value="<?php echo $nombre; ?>">
        <!-- input usuario -->
        <label for="usuario" class="formulario_label">Usuario: </label>
        <input type="text" class="formulario_input" name="usuario" id="usuario" value="<?php echo $usuario; ?>">
        <!-- input  correo-->
        <label for="correo" class="formulario_label">Correo Electronico: </label></td>
        <input type="email" class="formulario_input" name="correo" id="correo" value="<?php echo $correo; ?>">

        <input type="hidden" name="id" value="<?php echo $id; ?>">
        <input type="submit" name="enviar" value="enviar">
      </form>
    </div>
  <?php
  }
  ?>
</body>

</html>