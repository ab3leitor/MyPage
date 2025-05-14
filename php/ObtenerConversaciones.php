<?php
header('Content-Type: application/json');
require 'conexion_be.php';

session_start();
if (!isset($_SESSION['id'])) {
    echo json_encode(['error' => 'No autenticado']);
    exit;
}

$userId = $_SESSION['id'];

// Consulta optimizada
$query = "SELECT 
    u.id as user_id,
    u.usuario as name,
    (SELECT content FROM messages 
     WHERE (sender_id = u.id AND receiver_id = $userId)
     OR (sender_id = $userId AND receiver_id = u.id)
     ORDER BY created_at DESC LIMIT 1) as last_message
FROM usuario u
WHERE u.id != $userId
ORDER BY (SELECT created_at FROM messages 
          WHERE (sender_id = u.id AND receiver_id = $userId)
          OR (sender_id = $userId AND receiver_id = u.id)
          ORDER BY created_at DESC LIMIT 1) DESC";

$result = mysqli_query($conexion, $query);
$conversations = [];

while ($row = mysqli_fetch_assoc($result)) {
    $conversations[] = $row;
}

echo json_encode($conversations);
mysqli_close($conexion);
?>