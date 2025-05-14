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
$sql = "select * from usuario";
$resultado = mysqli_query($conexion, $sql);
?>

<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="utf-8">
  <title>Lista de usuarios | Treyak</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Enlaces CSS -->
  <link rel="stylesheet" href="css/sideBar.css">
  <link rel="stylesheet" href="css/HomeContenido.css">
  <link rel="stylesheet" href="css/FooterStyle.css">
  <link rel="stylesheet" href="css/UsuariosStyle.css">
  <link href='https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css' rel='stylesheet'>


  <script type="text/javascript">
    function confirmar() {
      return confirm('¿Estás seguro de eliminar este usuario? Esta acción no se puede deshacer.');
    }

    // Función para expandir/contraer texto largo
    function toggleText(element) {
      element.classList.toggle('long-text');
    }
  </script>
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

  <!-- Contenido principal - Diseño mejorado -->
  <div class="home_contenido">
    <div class="Gestion">
      <h1>Gestión de Usuarios</h1>
    </div>
    <div class="users-grid">
      <?php while ($filas = mysqli_fetch_assoc($resultado)): ?>
        <div class="user-card">
          <div class="user-info">
            <div>
              <i class='bx bx-id-card'></i>
              <span><strong>ID:</strong> <?php echo htmlspecialchars($filas['id']); ?></span>
            </div>
            <div>
              <i class='bx bx-user'></i>
              <span><strong>Nombre:</strong> <?php echo htmlspecialchars($filas['nombreCompleto']); ?></span>
            </div>
            <div>
              <i class='bx bx-at'></i>
              <span><strong>Usuario:</strong> <?php echo htmlspecialchars($filas['usuario']); ?></span>
            </div>
            <div>
              <i class='bx bx-envelope'></i>
              <span class="long-text" onclick="toggleText(this)" title="Click para expandir/contraer">
                <strong>Email:</strong> <?php echo htmlspecialchars($filas['correoElectronico']); ?>
              </span>
            </div>
          </div>

          <div class="user-actions">
            <a href="editarUsuario.php?id=<?php echo $filas['id']; ?>" class="btn-action btn-edit">
              <i class='bx bx-edit'></i> Editar
            </a>
            <a href="php/eliminarUsuario.php?id=<?php echo $filas['id']; ?>" class="btn-action btn-delete" onclick="return confirmar()">
              <i class='bx bx-trash'></i> Eliminar
            </a>
          </div>
        </div>
      <?php endwhile; ?>
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
              <i class='bx bxl-facebook' style='color:#fffafa'  ></i>
            </a>
            <a href="#" class="social-icon" title="Twitter">
              <i class='bx bxl-twitter' style='color:#fffafa' ></i>
            </a>
            <a href="https://www.instagram.com/abelardoahhaaha/" class="social-icon" title="Instagram">
              <i class='bx bxl-instagram' style='color:#fffafa' ></i>
            </a>
            <a href="https://cl.linkedin.com/in/abel-arriagada-urriola-9aaa19287" class="social-icon" title="LinkedIn">
              <i class='bx bxl-linkedin' style='color:#fffafa' ></i>
            </a>
            <a href="https://wa.me/<+56956025318>?text=<Hola muy buenas, vengo a saludar>" class="social-icon" title="Whatsapp">
              <i class='bx bxl-whatsapp' style='color:#fffafa' ></i>
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