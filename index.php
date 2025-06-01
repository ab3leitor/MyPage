<?php
session_start();
$_SESSION['csrf_token'] = bin2hex(random_bytes(32));
if (isset($_SESSION['usuario'])) {
    header("location: Inicio.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Página de inicio de sesión y registro">
    <title>Inicio de Sesión | Registro</title>

    <!-- Precarga de recursos -->
    <link rel="preload" href="css/index/indexStyle.css" as="style">
    <link rel="preload" href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;300;400;500;700;900&display=swap" as="font" crossorigin>
    <link rel="preload" href="js/animacionCajas.js" as="script">

    <!-- Fuente Google -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;300;400;500;700;900&display=swap" rel="stylesheet">

    <!-- CSS -->
    <link rel="stylesheet" href="css/index/indexStyle.css" media="print" onload="this.media='all'">
    <noscript>
        <link rel="stylesheet" href="css/index/indexStyle.css">
    </noscript>
</head>

<body>
    <main>
        <div class="contenedor__todo">
            <div class="caja__trasera">
                <div class="caja__trasera-login">
                    <h3>¿Ya tienes una cuenta?</h3>
                    <p>Inicia sesión para entrar en la página</p>
                    <button id="btn__iniciar-sesion" aria-label="Iniciar sesión">Iniciar Sesión</button>
                </div>
                <div class="caja__trasera-register">
                    <h3>¿Aún no tienes una cuenta?</h3>
                    <p>Regístrate para que puedas iniciar sesión</p>
                    <button id="btn__registrarse" aria-label="Registrarse">Regístrarse</button>
                </div>
            </div>

            <!-- Formularios -->
            <div class="contenedor__login-register">
                <!-- Login -->
                <form action="php/login_usuario_be.php" method="POST" class="formulario__login">
                    <h2>Iniciar Sesión</h2>
                    <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">

                    <div class="input-group">
                        <input type="text" placeholder="Usuario" name="usuario" required aria-label="Nombre de usuario">
                    </div>

                    <div class="input-group">
                        <input type="password" placeholder="Contraseña" name="llave" required aria-label="Contraseña">
                    </div>

                    <button type="submit">
                        Entrar
                        <div class="loader" style="display: none;">
                            <div class="spinner"></div>
                        </div>
                    </button>

                    <?php
                    // Mensajes de error
                    $error_messages = [
                        '1' => 'Método no permitido',
                        '2' => 'Por favor complete todos los campos',
                        'credenciales_invalidas' => 'Usuario o contraseña incorrectos',
                        '4' => 'Error en el servidor. Intente nuevamente',
                    ];

                    if (isset($_GET['error'])) {
                        $error_code = $_GET['error'];
                        $message = $error_messages[$error_code] ?? 'Error desconocido';
                        echo '<div class="error-message" role="alert">';
                        echo htmlspecialchars($message);
                        echo '</div>';
                    }
                    ?>
                </form>

                <!-- Register -->
                <form action="php/registro_usuario_be.php" method="POST" class="formulario__register">
                    <h2>Regístrarse</h2>

                    <div class="input-group">
                        <input type="text" placeholder="Nombre completo" name="nombreCompleto" required aria-label="Nombre completo">
                    </div>

                    <div class="input-group">
                        <input type="email" placeholder="Correo Electrónico" name="correo" required aria-label="Correo electrónico">
                    </div>

                    <div class="input-group">
                        <input type="text" placeholder="Usuario" name="usuario" required aria-label="Nombre de usuario">
                    </div>

                    <div class="input-group">
                        <input type="password" placeholder="Contraseña" name="llave" required aria-label="Contraseña">
                    </div>

                    <!-- Dentro del formulario de registro, antes del botón de submit -->
                    <div class="avatar-selection">
                        <h3>Selecciona tu avatar</h3>
                        <div class="avatar-options">
                            <label class="avatar-option">
                                <input type="radio" name="avatar" value="avatar1.png" checked>
                                <img src="images/index/4ce02b3685a1786ce1cb44c27a6b9174.webp" alt="Avatar 1">
                            </label>
                            <label class="avatar-option">
                                <input type="radio" name="avatar" value="avatar2.png">
                                <img src="images/index/5b452656f2b7552f4b960a89b523aea0.webp" alt="Avatar 2">
                            </label>
                            <label class="avatar-option">
                                <input type="radio" name="avatar" value="avatar3.png">
                                <img src="images/index/6feba6943fe8411bef9eb6f8bed350de.webp" alt="Avatar 3">
                            </label>
                            <label class="avatar-option">
                                <input type="radio" name="avatar" value="avatar4.png">
                                <img src="images/index/72976236f7a13f5076b620c02457a917.webp" alt="Avatar 3">
                            </label>
                        </div>
                    </div>

                    <button type="submit">
                        Registrarse
                        <div class="loader" style="display: none;">
                            <div class="spinner"></div>
                        </div>
                    </button>

                    <?php
                    // Mensajes de error
                    $error_messages = [
                        '1' => 'Método no permitido',
                        '2' => 'Por favor complete todos los campos',
                        'credenciales_invalidas' => 'Usuario o contraseña incorrectos',
                        '4' => 'Error en el servidor. Intente nuevamente',
                    ];

                    if (isset($_GET['error'])) {
                        $error_code = $_GET['error'];
                        $message = $error_messages[$error_code] ?? 'Error desconocido';
                        echo '<div class="error-message" role="alert">';
                        echo htmlspecialchars($message);
                        echo '</div>';
                    }
                    ?>

                </form>
            </div>
        </div>
    </main>

    <!-- Scripts -->
    <script>
        // Validación y manejo de formularios
        document.querySelectorAll('form').forEach(form => {
            form.addEventListener('submit', function(e) {
                const submitBtn = this.querySelector('button[type="submit"]');
                const loader = submitBtn.querySelector('.loader');
                const inputs = this.querySelectorAll('input[required]');
                let isValid = true;

                // Validar campos
                inputs.forEach(input => {
                    if (!input.value.trim()) {
                        isValid = false;
                        input.style.borderColor = '#ff6b6b';
                        setTimeout(() => input.style.borderColor = '', 2000);
                    }
                });

                if (!isValid) {
                    e.preventDefault();
                    return;
                }

                // Mostrar loader y deshabilitar botón
                submitBtn.disabled = true;
                loader.style.display = 'block';
            });
        });
    </script>
    <script src="js/animacionCajas.js" defer></script>
</body>

</html>