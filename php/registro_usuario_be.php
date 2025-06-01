<?php
include 'conexion_be.php';

// Obtener datos del formulario
$nombreCompleto = $_POST['nombreCompleto'];
$correo = $_POST['correo'];
$usuario = $_POST['usuario'];
$llave = hash('sha512', $_POST['llave']);
$avatar = $_POST['avatar'] ?? 'default.png'; // Valor por defecto

// Verificar correo
$verificar_correo = mysqli_query($conexion, "SELECT * FROM usuario WHERE correoElectronico = '$correo'");
if(mysqli_num_rows($verificar_correo) > 0) {
    header("Location: ../index.php?error=correo_existente");
    exit();
}

// Verificar usuario
$verificar_usuario = mysqli_query($conexion, "SELECT * FROM usuario WHERE usuario = '$usuario'");
if(mysqli_num_rows($verificar_usuario) > 0) {
    header("Location: ../index.php?error=usuario_existente");
    exit();
}

// Insertar nuevo usuario
$query = "INSERT INTO usuario(nombreCompleto, correoElectronico, usuario, llave, avatar) 
          VALUES('$nombreCompleto', '$correo', '$usuario', '$llave', '$avatar')";

if(mysqli_query($conexion, $query)) {
    header("Location: ../index.php?success=registro_exitoso");
} else {
    header("Location: ../index.php?error=registro_fallido");
}

mysqli_close($conexion);
?>