<?php
header('Content-Type: application/json');
require 'conexion_be.php';

session_start();
if (!isset($_SESSION['id'])) {
    echo json_encode(['error' => 'No autenticado']);
    exit;
}

$userId = $_SESSION['id'];
$contactId = intval($_GET['contact_id']);

$query = "
    SELECT m.*, 
           u1.usuario as sender_name,
           u2.usuario as receiver_name
    FROM messages m
    JOIN usuario u1 ON m.sender_id = u1.id
    JOIN usuario u2 ON m.receiver_id = u2.id
    WHERE (m.sender_id = ? AND m.receiver_id = ?)
       OR (m.sender_id = ? AND m.receiver_id = ?)
    ORDER BY m.created_at ASC
";

$stmt = $conexion->prepare($query);
$stmt->bind_param("iiii", $userId, $contactId, $contactId, $userId);
$stmt->execute();
$result = $stmt->get_result();

$messages = [];
while ($row = $result->fetch_assoc()) {
    $messages[] = $row;
}

echo json_encode($messages);
$stmt->close();
$conexion->close();
?>