<?php
session_start();
if (!isset($_SESSION['usuario'])) {
  echo '
      <script>
        alert("Por favor debes iniciar sesion");
        window.location = "index.php";
      </script>
      ';
  session_destroy();
  die();
}

include("php/conexion_be.php");

if (isset($_POST['enviar'])) {
    $id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $usuario = $_POST['usuario'];
    $correo = $_POST['correo'];

    $sql = "update usuario set nombreCompleto='".$nombre.
      "', usuario='".$usuario."', correoElectronico='".$correo."' where id='".$id."'";
    $resultado = mysqli_query($conexion, $sql);
    
    if ($resultado) {
      echo "<script language='JavaScript'>
                alert('Los datos se actualizaron correctamente');
                location.assign('Usuarios.php');
                </script>";
    } else {
      echo "<script language='JavaScript'>
                alert('Los datos no se actualizaron correctamente');
                location.assign('Usuarios.php');
                </script>";
    }
    mysqli_close($conexion);
} else {
    $id = $_GET['id'];
    $sql = "select * from usuario where id='".$id."'";
    $resultado = mysqli_query($conexion, $sql);

    $fila = mysqli_fetch_assoc($resultado);
    $nombre = $fila["nombreCompleto"];
    $usuario = $fila["usuario"];
    $correo = $fila["correoElectronico"];

    mysqli_close($conexion);
?>
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="utf-8">
  <title>Editar usuario | Treyak</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  
  <!-- Enlaces CSS -->
  <link rel="stylesheet" href="css/sideBar.css">
  <link rel="stylesheet" href="css/HomeContenido.css">
  <link rel="stylesheet" href="css/FooterStyle.css">
  <link rel="stylesheet" href="css/EditarUsuario.css">
  <link href='https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css' rel='stylesheet'>
</head>

<body>
  <!-- Sidebar (se mantiene igual) -->
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

  <!-- Contenido principal -->
  <div class="home_contenido">
    <div class="Gestion">
    <h1>Editar Usuario</h1>
    </div>
    
    <div class="edit-form">
      <form action="<?= $_SERVER['PHP_SELF'] ?>" method="post">
        <div class="form-group">
          <label for="nombre">Nombre Completo:</label>
          <input type="text" name="nombre" id="nombre" value="<?php echo htmlspecialchars($nombre); ?>" required>
        </div>
        
        <div class="form-group">
          <label for="usuario">Nombre de Usuario:</label>
          <input type="text" name="usuario" id="usuario" value="<?php echo htmlspecialchars($usuario); ?>" required>
        </div>
        
        <div class="form-group">
          <label for="correo">Correo Electrónico:</label>
          <input type="email" name="correo" id="correo" value="<?php echo htmlspecialchars($correo); ?>" required>
        </div>
        
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($id); ?>">
        
        <div class="form-actions">
          <a href="Usuarios.php" class="btn btn-cancel">Cancelar</a>
          <button type="submit" name="enviar" class="btn btn-submit">Guardar Cambios</button>
        </div>
      </form>
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
    // Script para el sidebar (se mantiene igual)
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
<?php } ?>