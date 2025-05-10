document.addEventListener('DOMContentLoaded', function() {
    // Simular carga de datos del usuario
    setTimeout(() => {
        const username = localStorage.getItem('username') || 'Usuario';
        document.getElementById('username').textContent = username;
    }, 500);
    
    // Manejar notificaciones
    const notificationBtn = document.querySelector('.notification-btn');
    const notificationBadge = document.querySelector('.notification-badge');
    
    notificationBtn.addEventListener('click', function() {
        // Marcar notificaciones como leídas
        document.querySelectorAll('.notification-item.unread').forEach(item => {
            item.classList.remove('unread');
        });
        notificationBadge.style.display = 'none';
    });
    
    // Manejar clic en cursos
    document.querySelectorAll('.continue-btn').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            const courseTitle = this.closest('.course-item').querySelector('h4').textContent;
            alert(`Continuar con el curso: ${courseTitle}`);
            // Aquí normalmente redirigirías a la página del curso
        });
    });
    
    // Manejar navegación inferior
    document.querySelectorAll('.nav-item').forEach(item => {
        item.addEventListener('click', function(e) {
            e.preventDefault();
            document.querySelectorAll('.nav-item').forEach(i => i.classList.remove('active'));
            this.classList.add('active');
            // Aquí normalmente cargarías el contenido correspondiente
        });
    });
});