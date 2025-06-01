<?php
// session_start() debe ser lo primero
session_start();

// Incluir conexión
require 'conexion_be.php';

// Verificar método POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  header("Location: ../index.php?error=metodo_no_permitido");
  exit;
}

// Validar entradas (versión compatible)
$usuario = trim($_POST['usuario'] ?? '');
$llave = $_POST['llave'] ?? '';

if (empty($usuario) || empty($llave)) {
  header("Location: ../index.php?error=campos_vacios");
  exit;
}

// Función segura para comparación de strings
if (!function_exists('hash_equals')) {
  function hash_equals($str1, $str2)
  {
    if (strlen($str1) != strlen($str2)) {
      return false;
    } else {
      $res = $str1 ^ $str2;
      $ret = 0;
      for ($i = strlen($res) - 1; $i >= 0; $i--) {
        $ret |= ord($res[$i]);
      }
      return !$ret;
    }
  }
}

try {
  // Consulta preparada segura
  $stmt = $conexion->prepare("SELECT id, nombreCompleto, correoElectronico, usuario, llave FROM usuario WHERE usuario = ? LIMIT 1");
  $stmt->bind_param("s", $usuario);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result->num_rows === 1) {
    $user = $result->fetch_assoc();

    // Verificar contraseña (SHA512)
    if (hash_equals(hash('sha512', $llave), $user['llave'])) {
      // Regenerar ID de sesión
      session_regenerate_id(true);

      // Datos de sesión esenciales
      $_SESSION = [
        'id' => $user['id'],
        'usuario' => $user['usuario'],
        'nombreCompleto' => $user['nombreCompleto'],
        'correoElectronico' => $user['correoElectronico'],
        'loggedin' => true, // Bandera adicional de seguridad
        'ip' => $_SERVER['REMOTE_ADDR']
      ];

      // Redirección con JavaScript como fallback
      echo '<script>window.location.href = "../Inicio.php";</script>';
      header("Location: ../Inicio.php");
      exit;
    }
  }
  // Credenciales inválidas
  sleep(1); // Pequeño retraso para seguridad
  header("Location: ../index.php?error=credenciales_invalidas");
  exit;
} catch (Exception $e) {
  // Log seguro sin mostrar detalles al usuario
  error_log("Login error: " . $e->getMessage());
  header("Location: ../index.php?error=error_servidor");
  exit;
}
