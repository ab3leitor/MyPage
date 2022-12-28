<?php

  include 'conexion_be.php';

  $nombreCompleto = $_POST['nombreCompleto'];
  $correo =  $_POST['correo'];
  $usuario = $_POST['usuario'];
  $llave =   $_POST['llave'];
  //Encriptar contraseña
  $llave = hash('sha512', $llave);

  $query =  "INSERT INTO usuario(nombreCompleto, correoElectronico, usuario, llave)
             VALUES('$nombreCompleto','$correo','$usuario','$llave')";



  //Verificar que el correo no se repita
  $verificar_correo = mysqli_query($conexion, "SELECT * FROM usuario WHERE correoElectronico = '$correo' ");
  if(mysqli_num_rows($verificar_correo) > 0 ) {
    echo'
      <script>
      alert("Este correo ya se encuentra registrado");
      window.location = "../index.php";
      </script>
    ';
    exit();
  }
  //Verificar que el usuario no se repita
  $verificar_usuario = mysqli_query($conexion, "SELECT * FROM usuario WHERE usuario ='$usuario'");
  if (mysqli_num_rows($verificar_usuario) > 0 ) {
    echo'
      <script>
      alert("Este usuario ya se encuentra registrado");
      window.location = "../index.php";
      </script>
    ';
    exit();
  }


  //Almacenar un usuario
  $ejecutar = mysqli_query($conexion, $query);

  if ($ejecutar) {
      echo '
      <script>
        alert("Usuario almacenado exitosamente");
        window.location = "../index.php";
      </script>
      ';
  }else {
    echo '
      <script>
        alert("Usuario no se ha podido almacenar exitosamente");
        window.location = "../index.php";
      </script>
    ';
    }
    mysqli_close($conexion);
?>
