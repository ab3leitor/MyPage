<?php

 $conexion = mysqli_connect("localhost", "root", "", "login-register-db");

 if($conexion === false){
     die("ERROR EN LA CONEXION" . mysqli_connect_error());
     echo '
     <script>
        window.location = "../index.php";
     </script>
     ';
     
 }

?>   