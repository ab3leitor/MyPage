<?php
// Iniciar sesión y configurar headers de seguridad
session_start();
include("php/conexion_be.php");

// Verificar autenticación
if (!isset($_SESSION['usuario'])) {
    header('Location: index.php');
    exit();
}

// Obtener ID del hilo desde la URL
$threadId = isset($_GET['id']) ? intval($_GET['id']) : 0;
if ($threadId <= 0) {
    header('Location: Foro.php');
    exit();
}

// Registrar vista del hilo (si no la ha visto antes)
if (isset($_SESSION['id'])) {
    $userId = $_SESSION['id'];
    $query = "INSERT IGNORE INTO thread_views (thread_id, user_id) VALUES (?, ?)";
    $stmt = mysqli_prepare($conexion, $query);
    mysqli_stmt_bind_param($stmt, "ii", $threadId, $userId);
    mysqli_stmt_execute($stmt);
}

// Obtener información del hilo
$query = "SELECT ft.*, u.nombreCompleto as creator_name 
          FROM forum_threads ft
          JOIN usuario u ON ft.creator_id = u.id
          WHERE ft.id = ?";
$stmt = mysqli_prepare($conexion, $query);
mysqli_stmt_bind_param($stmt, "i", $threadId);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$thread = mysqli_fetch_assoc($result);

if (!$thread) {
    header('Location: Foro.php');
    exit();
}

// Obtener mensajes del hilo
$query = "SELECT fm.*, u.nombreCompleto as author_name 
          FROM forum_messages fm
          JOIN usuario u ON fm.sender_id = u.id
          WHERE fm.thread_id = ?
          ORDER BY fm.created_at ASC";
$stmt = mysqli_prepare($conexion, $query);
mysqli_stmt_bind_param($stmt, "i", $threadId);
mysqli_stmt_execute($stmt);
$messages = mysqli_stmt_get_result($stmt);

// El nombre completo ya está disponible desde el login
$nombreCompleto_db = $_SESSION['nombreCompleto'];
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= htmlspecialchars($thread['title']) ?> - Foro Treyak</title>
  <link rel="stylesheet" href="css/sideBar.css">
  <link rel="stylesheet" href="css/HomeContenido.css">
  <link rel="stylesheet" href="css/hiloStyle.css">
  <link rel="stylesheet" href="css/FooterStyle.css">
  <link href='https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css' rel='stylesheet'>
  <style>
    /* Estilos específicos para la vista de hilo */
    .thread-container {
      background-color: white;
      border-radius: 8px;
      box-shadow: 0 2px 5px rgba(0,0,0,0.1);
      margin-bottom: 20px;
    }
    
    .thread-header {
      padding: 20px;
      border-bottom: 1px solid #eee;
      background-color: #f9f9f9;
      border-radius: 8px 8px 0 0;
    }
    
    .thread-title {
      margin: 0;
      color: #2c3e50;
      font-size: 1.5rem;
    }
    
    .thread-meta {
      margin-top: 10px;
      color: #7f8c8d;
      font-size: 14px;
    }
    
    .message-list {
      list-style: none;
      padding: 0;
      margin: 0;
    }
    
    .message-item {
      padding: 20px;
      border-bottom: 1px solid #eee;
    }
    
    .message-header {
      display: flex;
      justify-content: space-between;
      margin-bottom: 15px;
    }
    
    .message-author {
      font-weight: bold;
      color: #2c3e50;
    }
    
    .message-time {
      color: #7f8c8d;
      font-size: 13px;
    }
    
    .message-content {
      color: #34495e;
      line-height: 1.6;
      white-space: pre-wrap;
    }
    
    .reply-form {
      padding: 20px;
      background-color: #f9f9f9;
      border-radius: 0 0 8px 8px;
    }
    
    .reply-textarea {
      width: 100%;
      min-height: 100px;
      padding: 10px;
      border: 1px solid #ddd;
      border-radius: 4px;
      resize: vertical;
      margin-bottom: 10px;
    }
    
    .btn-reply {
      background-color: #3498db;
      color: white;
      border: none;
      padding: 8px 16px;
      border-radius: 4px;
      cursor: pointer;
    }
    
    .btn-reply:hover {
      background-color: #2980b9;
    }
    
    .back-link {
      display: inline-block;
      margin-top: 15px;
      color: #3498db;
      text-decoration: none;
      margin-bottom: 20px;
    }
    
    .back-link:hover {
      text-decoration: underline;
    }
    
    .first-message {
      background-color: #f0f8ff;
      border-left: 4px solid #3498db;
    }
  </style>
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
            <div class="name"><?= htmlspecialchars($nombreCompleto_db) ?></div>
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
    <div class="contenido">
      <a href="Foro.php" class="back-link">← Volver al listado de hilos</a>
      
      <div class="thread-container">
        <div class="thread-header">
          <h1 class="thread-title"><?= htmlspecialchars($thread['title']) ?></h1>
          <div class="thread-meta">
            Creado por <?= htmlspecialchars($thread['creator_name']) ?> • 
            <?= date('d/m/Y H:i', strtotime($thread['created_at'])) ?> •
            <?= $thread['is_closed'] ? '🔒 Cerrado' : '📢 Abierto' ?>
            <?= $thread['is_pinned'] ? '📌 Fijado' : '' ?>
          </div>
        </div>
        
        <ul class="message-list">
          <?php while ($message = mysqli_fetch_assoc($messages)): ?>
            <li class="message-item <?= $message['is_first_message'] ? 'first-message' : '' ?>">
              <div class="message-header">
                <span class="message-author"><?= htmlspecialchars($message['author_name']) ?></span>
                <span class="message-time">
                  <?= date('d/m/Y H:i', strtotime($message['created_at'])) ?>
                  <?= $message['is_first_message'] ? '(Mensaje inicial)' : '' ?>
                </span>
              </div>
              <div class="message-content"><?= nl2br(htmlspecialchars($message['content'])) ?></div>
            </li>
          <?php endwhile; ?>
        </ul>
        
        <?php if (!$thread['is_closed']): ?>
        <div class="reply-form">
          <h3>Responder al hilo</h3>
          <form id="replyForm">
            <input type="hidden" name="thread_id" value="<?= $threadId ?>">
            <textarea class="reply-textarea" name="content" required placeholder="Escribe tu respuesta aquí..."></textarea>
            <button type="submit" class="btn-reply">Enviar Respuesta</button>
          </form>
        </div>
        <?php endif; ?>
      </div>
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

        <p class="footer-copyright">© 2023 Treyak. Todos los derechos reservados.</p>
      </div>
    </footer>
  </div>
  
  <script>
    // Script para el sidebar
    let btn = document.querySelector("#btn");
    let sidebar = document.querySelector(".sidebar");
    let searchBtn = document.querySelector(".bx-search");

    btn.onclick = function() {
      sidebar.classList.toggle("active");
    }
    searchBtn.onclick = function() {
      sidebar.classList.toggle("active");
    }

    // Script para enviar respuestas
    document.getElementById('replyForm').addEventListener('submit', function(e) {
      e.preventDefault();
      
      const formData = new FormData(this);
      formData.append('sender_id', <?= $_SESSION['id'] ?>);
      
      fetch('php/EnviarRespuestaForo.php', {
        method: 'POST',
        body: formData
      })
      .then(response => response.json())
      .then(data => {
        if (data.success) {
          // Recargar la página para mostrar la nueva respuesta
          window.location.reload();
        } else {
          alert('Error al enviar la respuesta: ' + (data.message || 'Error desconocido'));
        }
      })
      .catch(error => {
        console.error('Error:', error);
        alert('Error al enviar la respuesta');
      });
    });
  </script>
</body>
</html>