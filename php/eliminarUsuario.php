<?php
    $id=$_GET['id'];
    include("conexion_be.php");
    /* Delete from usuario where id=#$id */
    $sql="delete from usuario where id='".$id."'";
    $resultado=mysqli_query($conexion,$sql);
    /* Mensaje que confirma si se realizo la eliminacion o no */
    if ($resultado) {
        echo "<script language='JavaScript'>
            alert('Los datos se eliminaron correctamente de la BD');
            location.assign('../index.php');
            </script>";
    } else {
        echo "<script language='JavaScript'>
            alert('Los datos no se eliminaron correctamente de la BD');
            location.assign('../index.php');
            </script>";
    }
?>