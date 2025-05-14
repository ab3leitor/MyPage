<?php
session_start();
require 'conexion_be.php';

if (!isset($_SESSION['usuario'])) {
    header('HTTP/1.1 401 Unauthorized');
    exit();
}

// Necesitarás un JOIN con la tabla usuario para obtener el nombre del autor
$query = "SELECT fm.*, u.nombreCompleto as author_name 
          FROM forum_messages fm
          JOIN usuario u ON fm.sender_id = u.id
          ORDER BY fm.created_at ASC";
$result = mysqli_query($conexion, $query);

$messages = [];
while ($row = mysqli_fetch_assoc($result)) {
    $messages[] = $row;
}

header('Content-Type: application/json');
echo json_encode($messages);
?>