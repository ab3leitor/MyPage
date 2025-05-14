<?php
header('Content-Type: application/json');
require 'conexion_be.php';

session_start();
if (!isset($_SESSION['id'])) {
    echo json_encode(['error' => 'No autenticado']);
    exit;
}

$userId = $_SESSION['id'];
$searchTerm = isset($_GET['q']) ? trim($_GET['q']) : '';

if (empty($searchTerm)) {
    echo json_encode([]);
    exit;
}

$searchTerm = "%$searchTerm%";

$query = "SELECT DISTINCT u.id as user_id, u.usuario as name
          FROM usuario u
          JOIN messages m ON (m.sender_id = u.id OR m.receiver_id = u.id)
          WHERE u.id != ? AND 
                ((m.sender_id = ? AND m.receiver_id = u.id) OR 
                 (m.sender_id = u.id AND m.receiver_id = ?)) AND
                m.content LIKE ?
          ORDER BY u.usuario";

$stmt = $conexion->prepare($query);
$stmt->bind_param("iiis", $userId, $userId, $userId, $searchTerm);
$stmt->execute();
$result = $stmt->get_result();

$conversations = [];
while ($row = $result->fetch_assoc()) {
    $conversations[] = $row;
}

echo json_encode($conversations);
$stmt->close();
$conexion->close();
?>