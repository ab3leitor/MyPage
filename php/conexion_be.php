<?php

 $conexion = mysqli_connect("localhost", "root", "", "intranet v1.0");

 if($conexion === false){
     die("ERROR EN LA CONEXION" . mysqli_connect_error());
     echo '
     <script>
        window.location = "../index.php";
     </script>
     ';
     
 }

?>   