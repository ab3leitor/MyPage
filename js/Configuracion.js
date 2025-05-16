// Previsualización de imagen al seleccionar un archivo
document.getElementById('foto-input').addEventListener('change', function (e) {
    const file = e.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function (event) {
            document.getElementById('foto-preview').src = event.target.result;
        };
        reader.readAsDataURL(file);
    }
});

// Simulación de guardado de cambios
document.querySelector('.btn-guardar').addEventListener('click', function () {
    alert('Configuración guardada correctamente');
});

document.querySelector('.btn-cerrar-sesion').addEventListener('click', function () {
    window.location.href = 'php/cerrar_sesion.php';
});