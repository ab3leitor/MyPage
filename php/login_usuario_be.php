<?php
//Siempre que se trabaje con sesiones de debe inicializar esta
session_start();
//Se llama a conexion_be.php para realizar la conexion con la base de datos
include 'conexion_be.php';
//Variables donde se guardan el correo y la llave
$usuario = $_POST['usuario'];
$llave = $_POST['llave'];

//Desencriptacion de la contraseña
$llave = hash('sha512', $llave);

//validar el usuario y contraseña

$validar_login = mysqli_query($conexion, "SELECT * FROM usuario WHERE usuario = '$usuario' and llave= '$llave'");

//Formula si el usuario y la contraseña son validos
if (mysqli_num_rows($validar_login) > 0) {
  $_SESSION['usuario'] = $usuario;
  header("location: ../Inicio.php");
  $stmt = $conexion->prepare("SELECT id, nombreCompleto, correoElectronico, usuario FROM usuario WHERE usuario = ?");
  $stmt->bind_param("s", $usuario);
  $stmt->execute();
  $stmt->bind_result($id_db, $nombreCompleto_db, $correoElectronico_db, $usuario_db);
  $stmt->fetch();
  $stmt->close();

  // Guarda TODOS los datos necesarios en la sesión
  $_SESSION['id'] = $id_db;
  $_SESSION['usuario'] = $usuario_db;
  $_SESSION['nombreCompleto'] = $nombreCompleto_db;
  $_session['correoElectronico'] = $correoElectronico_db;

  header("Location: ../Inicio.php");
  exit;
}
//Formula si los datos No son invalidos
else {
  echo '
      <script>
        alert ("Usuario no existe, por favor verifique los datos introducidos")
        window.location = "../index.php" ;
      </script>
    ';
  exit;
}
