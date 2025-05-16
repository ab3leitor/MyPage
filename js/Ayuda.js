

// Funcionalidad para las preguntas frecuentes
document.querySelectorAll('.faq-pregunta').forEach(item => {
    item.addEventListener('click', () => {
        const faqItem = item.parentElement;
        faqItem.classList.toggle('active');

        // Cambiar ícono
        const icon = item.querySelector('i');
        if (faqItem.classList.contains('active')) {
            icon.classList.remove('bx-chevron-down');
            icon.classList.add('bx-chevron-up');
        } else {
            icon.classList.remove('bx-chevron-up');
            icon.classList.add('bx-chevron-down');
        }
    });
});

// Simular envío de formulario
document.getElementById('form-contacto').addEventListener('submit', function (e) {
    e.preventDefault();
    alert('Gracias por tu mensaje. Nos pondremos en contacto contigo pronto.');
    this.reset();
});

// Simular acciones de botones
document.querySelectorAll('.btn-ver').forEach(btn => {
    btn.addEventListener('click', () => {
        alert('Esta funcionalidad estará disponible próximamente.');
    });
});