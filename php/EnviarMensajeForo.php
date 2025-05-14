<?php
session_start();
require 'conexion_be.php';

if (!isset($_SESSION['usuario'])) {
    header('HTTP/1.1 401 Unauthorized');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('HTTP/1.1 405 Method Not Allowed');
    exit();
}

if (!isset($_POST['sender_id']) || !isset($_POST['content'])) {
    header('HTTP/1.1 400 Bad Request');
    exit();
}

$senderId = intval($_POST['sender_id']);
$content = trim($_POST['content']);

if (empty($content)) {
    header('HTTP/1.1 400 Bad Request');
    exit();
}

// Necesitarás crear una tabla 'forum_messages' con campos:
// id, sender_id, content, created_at
$query = "INSERT INTO forum_messages (sender_id, content) VALUES (?, ?)";
$stmt = mysqli_prepare($conexion, $query);
mysqli_stmt_bind_param($stmt, "is", $senderId, $content);
mysqli_stmt_execute($stmt);

header('Content-Type: application/json');
echo json_encode(['success' => true]);
?>