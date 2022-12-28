<?php
  //Se inicializa la sesion
  session_start();
  //Se destruye la sesion
  session_destroy();
  //Se redirige al index (Login)
  header("location: ../index.php");
?>
