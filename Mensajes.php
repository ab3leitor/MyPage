<?php
// Iniciar sesión y configurar headers de seguridad
session_start();
require 'php/conexion_be.php';

if (!isset($_SESSION['usuario'])) {
  header('Location: index.php');
  exit();
}

?>

<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Menú - Treyak</title>
  <link rel="stylesheet" href="css/sideBar.css">
  <link rel="stylesheet" href="css/HomeContenido.css">
  <link rel="stylesheet" href="css/MensajesStyle.css">
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
      <div class="chat-container">
        <!-- Barra lateral de conversaciones -->
        <div class="conversation-list">
          <div class="search-bar">
            <i class='bx bx-search'></i>
            <input
              type="text"
              id="searchConversations"
              placeholder="Buscar palabra clave..."
              autocomplete="off">
          </div>
          <div id="conversations">
            <!-- Las conversaciones se cargarán aquí con JavaScript -->
          </div>
        </div>

        <!-- Área principal del chat -->
        <div class="chat-area">
          <div class="chat-header">
            <h2 id="current-chat-name">Selecciona una conversación</h2>
          </div>

          <div id="messagesList" class="messages-list">
            <div class="empty-state">
              <i class='bx bx-conversation'></i>
              <p>Selecciona una conversación para comenzar</p>
            </div>
          </div>

          <form id="messageForm" style="display: none;">
            <input type="hidden" id="senderId" value="<?php echo $_SESSION['id']; ?>">
            <input type="hidden" id="receiverId">
            <textarea id="content" placeholder="Escribe un mensaje..." rows="1"></textarea>

            <!-- Botón para subir documentos -->
            <div class="message-actions">
              <label for="fileUpload" class="upload-btn">
                <i class='bx bx-paperclip'></i>
                <input type="file" id="fileUpload" style="display: none;">
              </label>
              <button type="submit"><i class='bx bx-send'></i></button>
            </div>
          </form>

          <!-- Botón flotante para abrir el foro -->
          <button id="openForumBtn" class="floating-forum-btn">
            <i class='bx bx-message-rounded-dots'></i> Foro
          </button>
        </div>
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

        <p class="footer-copyright">© 2023 NombreApp. Todos los derechos reservados.</p>
      </div>
    </footer>
  </div>
  <script>
    document.addEventListener('DOMContentLoaded', () => {
      const userId = <?php echo $_SESSION['id']; ?>;
      let currentChat = null;
      let currentFile = null; // Para almacenar el archivo seleccionado
      const searchInput = document.getElementById('searchConversations');
      let allConversations = [];

      // Función de notificación
      function showNotification(message, isError = true) {
        const notification = document.createElement('div');
        notification.className = `notification ${isError ? 'error' : 'success'}`;
        notification.textContent = message;
        document.body.appendChild(notification);

        setTimeout(() => {
          notification.classList.add('fade-out');
          notification.addEventListener('animationend', () => {
            notification.remove();
          });
        }, 4500);
      }

      // Función para mostrar notificación de descarga
      window.showDownloadNotification = function(filename) {
        const notification = document.createElement('div');
        notification.className = 'download-notification';
        notification.innerHTML = `
            <i class='bx bx-check-circle'></i>
            <span>Documento descargado: <strong>${filename}</strong></span>
        `;
        document.body.appendChild(notification);

        setTimeout(() => {
          notification.classList.add('fade-out');
          notification.addEventListener('animationend', () => {
            notification.remove();
          });
        }, 3000);
      };

      // Función auxiliar para escapar regex
      const escapeRegExp = (string) => {
        return string.replace(/[.*+?^${}()|[\]\\]/g, '\\$&');
      };

      // Función para resaltar texto
      const highlightText = (text, searchTerm) => {
        if (!text || !searchTerm) return text || '';
        const textStr = text.toString();
        const searchStr = searchTerm.toString();

        const regex = new RegExp(`(${escapeRegExp(searchStr)})`, 'gi');
        return textStr.replace(regex, '<span class="highlight">$1</span>');
      };

      // Función auxiliar para colores de avatar
      const getRandomColor = () => {
        const colors = ['#3498db', '#2ecc71', '#9b59b6', '#f1c40f', '#1abc9c'];
        return colors[Math.floor(Math.random() * colors.length)];
      };

      // 1. Cargar conversaciones al iniciar
      const loadConversations = async () => {
        try {
          const response = await fetch('php/ObtenerConversaciones.php');
          if (!response.ok) throw new Error('Error en la respuesta del servidor');

          allConversations = await response.json();
          if (!Array.isArray(allConversations)) {
            throw new Error('Formato de datos inválido');
          }

          renderConversations(allConversations);
        } catch (error) {
          console.error("Error:", error);
          document.getElementById('conversations').innerHTML = `
          <div class="error-state">
            <i class='bx bx-error-circle'></i>
            <p>Error al cargar conversaciones</p>
          </div>`;
        }
      };

      // 2. Función para renderizar conversaciones
      const renderConversations = (conversations) => {
        const container = document.getElementById('conversations');

        if (conversations.length === 0) {
          container.innerHTML = `
      <div class="empty-search">
        <i class='bx bx-search-alt'></i>
        <p>No se encontraron conversaciones</p>
      </div>`;
          return;
        }

        container.innerHTML = conversations.map(conv => `
    <div class="conversation-item" data-id="${conv.user_id}">
      <div class="conversation-avatar" style="background: ${getRandomColor()}">
        ${conv.name?.charAt(0)?.toUpperCase() || ''}
      </div>
      <div class="conversation-info">
        <div class="conversation-name">${highlightText(conv.name, searchInput.value)}</div>
        <div class="conversation-preview">
          ${highlightText(conv.last_message || 'Nuevo chat', searchInput.value)}
        </div>
      </div>
    </div>
  `).join('');

        // Re-asignar eventos de clic
        container.querySelectorAll('.conversation-item').forEach(item => {
          item.addEventListener('click', () => {
            const contactId = item.getAttribute('data-id');
            const contactName = item.querySelector('.conversation-name').textContent;
            selectConversation(contactId, contactName);
          });
        });
      };

      // 3. Seleccionar conversación
      const selectConversation = (contactId, contactName) => {
        currentChat = contactId;

        // Actualizar UI
        document.querySelectorAll('.conversation-item').forEach(item => {
          item.classList.remove('active');
          if (item.getAttribute('data-id') === contactId) {
            item.classList.add('active');
          }
        });

        document.getElementById('current-chat-name').textContent = contactName;
        document.getElementById('messageForm').style.display = 'flex';
        document.getElementById('receiverId').value = contactId;

        loadMessages(contactId);
      };

      // 4. Cargar mensajes de una conversación (versión corregida)
      const loadMessages = async (contactId) => {
        try {
          document.getElementById('messagesList').innerHTML = '<div class="loading-spinner"><i class="bx bx-loader-circle bx-spin"></i></div>';
          const response = await fetch(`php/ObtenerMensajesPorContacto.php?contact_id=${contactId}`);
          if (!response.ok) throw new Error('Error en la respuesta del servidor');

          const messages = await response.json();
          let html = '';
          let lastMessage = null;

          if (messages.length > 0) {
            messages.forEach(msg => {
              const isSender = msg.sender_id == userId;
              const time = new Date(msg.created_at).toLocaleTimeString([], {
                hour: '2-digit',
                minute: '2-digit'
              });

              // Escapar contenido para prevenir XSS
              const escapeHtml = (unsafe) => {
                return unsafe
                  .replace(/&/g, "&amp;")
                  .replace(/</g, "&lt;")
                  .replace(/>/g, "&gt;")
                  .replace(/"/g, "&quot;")
                  .replace(/'/g, "&#039;");
              };

              if (msg.is_document) {
                try {
                  const fileData = JSON.parse(msg.content);
                  html += `
                <div class="message ${isSender ? 'sent' : 'received'}">
                  <div class="message-file">
                    <i class='bx bxs-file-${getFileIcon(fileData.fileType)}'></i>
                    <a href="uploads/${escapeHtml(fileData.fileName)}" download 
                      onclick="showDownloadNotification('${escapeHtml(fileData.originalName)}')">
                      ${escapeHtml(fileData.originalName)}
                    </a>
                  </div>
                  <div class="message-info">
                    <span>${time}</span>
                    ${isSender ? '<i class="bx bx-check-double"></i>' : ''}
                  </div>
                </div>
              `;
                } catch (e) {
                  console.error("Error parsing file data:", e);
                }
              } else {
                html += `
            <div class="message ${isSender ? 'sent' : 'received'}">
              <div class="message-text">${escapeHtml(msg.content)}</div>
              <div class="message-info">
                <span>${time}</span>
                ${isSender ? '<i class="bx bx-check-double"></i>' : ''}
              </div>
            </div>`;
              }

              // Guardar el último mensaje
              lastMessage = msg.is_document ? "Archivo enviado" : msg.content;
            });
          } else {
            html = '<div class="empty-state"><p>No hay mensajes en esta conversación</p></div>';
          }
          // Agrega esta nueva función al script:
          function showDownloadNotification(filename) {
            // Notificación elegante con temporizador
            const notification = document.createElement('div');
            notification.className = 'download-notification';
            notification.innerHTML = `
          <i class='bx bx-check-circle'></i>
          <span>Documento descargado: <strong>${filename}</strong></span>
          `;

            document.body.appendChild(notification);

            // Desaparece después de 3 segundos
            setTimeout(() => {
              notification.classList.add('fade-out');
              notification.addEventListener('animationend', () => {
                notification.remove();
              });
            }, 3000);
          }

          document.getElementById('messagesList').innerHTML = html;
          document.getElementById('messagesList').scrollTop = document.getElementById('messagesList').scrollHeight;

          // Actualizar el último mensaje en la lista de conversaciones
          if (lastMessage) {
            updateLastMessageInConversations(contactId, lastMessage);
          }

          return lastMessage;
        } catch (error) {
          console.error("Error cargando mensajes:", error);
          document.getElementById('messagesList').innerHTML = `
      <div class="error-state">
        <i class='bx bx-error-circle'></i>
        <p>Error al cargar mensajes</p>
      </div>`;
          return null;
        }
      };

      // 5.Función para filtrar conversaciones con búsqueda en servidor
      const filterConversations = async (searchTerm) => {
        const container = document.getElementById('conversations');

        if (searchTerm.trim() === '') {
          renderConversations(allConversations);
          return;
        }

        // Mostrar spinner
        container.innerHTML = '<div class="loading-spinner"><i class="bx bx-loader-circle bx-spin"></i></div>';

        try {
          const response = await fetch(`php/BuscarMensajes.php?q=${encodeURIComponent(searchTerm)}`);
          const filtered = await response.json();
          renderConversations(filtered);
        } catch (error) {
          console.error("Error en búsqueda:", error);
          container.innerHTML = `
      <div class="error-state">
        <i class='bx bx-error-circle'></i>
        <p>Error al buscar conversaciones</p>
      </div>`;
        }
      };

      // Función para actualizar el último mensaje en la lista de conversaciones
      const updateLastMessageInConversations = (contactId, lastMessage) => {
        allConversations = allConversations.map(conv => {
          if (conv.user_id == contactId) {
            return {
              ...conv,
              last_message: lastMessage
            };
          }
          return conv;
        });

        // Si hay un término de búsqueda activo, volver a filtrar
        if (searchInput.value.trim()) {
          filterConversations(searchInput.value.trim());
        }
      };

      // Evento de búsqueda
      let searchTimeout;
      const performSearch = (term) => {
        filterConversations(term);
      };

      searchInput.addEventListener('input', (e) => {
        clearTimeout(searchTimeout);
        const searchTerm = e.target.value.trim();

        if (searchTerm === '') {
          performSearch('');
          return;
        }

        searchTimeout = setTimeout(() => {
          performSearch(searchTerm);
        }, 300);
      });

      // Botón para limpiar búsqueda
      const clearSearch = document.createElement('i');
      clearSearch.className = 'bx bx-x clear-search';
      clearSearch.addEventListener('click', () => {
        searchInput.value = '';
        filterConversations('');
        searchInput.focus();
      });
      document.querySelector('.search-bar').appendChild(clearSearch);

      // 6. Función para enviar mensajes (corregida)
      const setupMessageForm = () => {
        const messageForm = document.getElementById('messageForm');
        const contentInput = document.getElementById('content');
        const senderIdInput = document.getElementById('senderId');
        const receiverIdInput = document.getElementById('receiverId');
        const fileUpload = document.getElementById('fileUpload');

        messageForm.addEventListener('submit', async (e) => {
          e.preventDefault();

          if (!currentChat || (!contentInput.value.trim() && !currentFile)) {
            showNotification('Escribe un mensaje o selecciona un archivo');
            return;
          }

          try {
            const formData = new FormData();

            // Agregar texto si existe
            if (contentInput.value.trim()) {
              formData.append('content', contentInput.value.trim());
            }

            // Agregar archivo si existe
            if (currentFile) {
              formData.append('file', currentFile);
            }

            formData.append('sender_id', senderIdInput.value);
            formData.append('receiver_id', receiverIdInput.value);

            // Mostrar indicador de carga
            const submitBtn = messageForm.querySelector('button[type="submit"]');
            const originalBtnContent = submitBtn.innerHTML;
            submitBtn.innerHTML = '<i class="bx bx-loader-circle bx-spin"></i>';
            submitBtn.disabled = true;

            const response = await fetch('php/enviarMensaje.php', {
              method: 'POST',
              body: formData
            });

            if (!response.ok) {
              const errorData = await response.text();
              throw new Error(errorData || 'Error al enviar el mensaje');
            }

            // Limpiar campos
            contentInput.value = '';
            currentFile = null;
            fileUpload.value = '';

            // Recargar mensajes
            await loadMessages(currentChat);
          } catch (error) {
            console.error("Error al enviar mensaje:", error);
            showNotification(error.message || "Ocurrió un error al enviar el mensaje");
          } finally {
            // Restaurar botón
            const submitBtn = messageForm.querySelector('button[type="submit"]');
            submitBtn.innerHTML = originalBtnContent;
            submitBtn.disabled = false;
          }
        });

        // Autoajustar altura del textarea
        contentInput.addEventListener('input', () => {
          contentInput.style.height = 'auto';
          contentInput.style.height = (contentInput.scrollHeight) + 'px';
        });
      };
      // 7. Función para manejar la subida de archivos
      // Corrige la función setupFileUpload()
      const setupFileUpload = () => {
        const fileUpload = document.getElementById('fileUpload');

        fileUpload.addEventListener('change', async (e) => {
          if (!currentChat) {
            showNotification('Selecciona una conversacion primero');
            return;
          }

          const file = e.target.files[0];
          if (!file) return;

          // Mostrar indicador de carga
          const uploadIndicator = document.createElement('div');
          uploadIndicator.className = 'upload-indicator';
          uploadIndicator.innerHTML = '<i class="bx bx-loader-circle bx-spin"></i> Subiendo archivo...';
          document.getElementById('messageForm').appendChild(uploadIndicator);

          try {
            const formData = new FormData();
            formData.append('file', file);
            formData.append('sender_id', document.getElementById('senderId').value);
            formData.append('receiver_id', document.getElementById('receiverId').value);

            // Solo una llamada fetch con manejo adecuado
            const response = await fetch('php/SubirDocumentos.php', {
              method: 'POST',
              body: formData
            });

            // Verificar si la respuesta es JSON
            const contentType = response.headers.get('content-type');
            if (!contentType || !contentType.includes('application/json')) {
              const text = await response.text();
              throw new Error(`Respuesta inesperada: ${text.substring(0, 100)}`);
            }

            const result = await response.json();

            if (!response.ok || !result.success) {
              throw new Error(result.error || 'Error al subir el archivo');
            }

            // Recargar mensajes después de subir
            await loadMessages(currentChat);
          } catch (error) {
            console.error("Error al subir archivo:", error);
            showNotification("Error al subir el archivo");
          } finally {
            uploadIndicator.remove();
            fileUpload.value = '';
          }
        });
      };

      const getFileIcon = (fileType) => {
        if (fileType.includes('image')) return 'image';
        if (fileType.includes('pdf')) return 'pdf';
        if (fileType.includes('word')) return 'doc';
        if (fileType.includes('excel')) return 'xls';
        if (fileType.includes('powerpoint')) return 'ppt';
        if (fileType.includes('zip') || fileType.includes('rar')) return 'zip';
        return 'blank';
      };

      // Iniciar todo
      setupMessageForm();
      setupFileUpload();
      loadConversations();
    });
  </script>
</body>
</html>