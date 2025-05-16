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

if (!isset($_POST['thread_id']) || !isset($_POST['sender_id']) || !isset($_POST['content'])) {
    header('HTTP/1.1 400 Bad Request');
    exit();
}

$threadId = intval($_POST['thread_id']);
$senderId = intval($_POST['sender_id']);
$content = trim($_POST['content']);

if (empty($content) || $threadId <= 0 || $senderId <= 0) {
    header('HTTP/1.1 400 Bad Request');
    exit();
}

// Verificar que el hilo existe y no está cerrado
$query = "SELECT is_closed FROM forum_threads WHERE id = ?";
$stmt = mysqli_prepare($conexion, $query);
mysqli_stmt_bind_param($stmt, "i", $threadId);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt); // Obtener el resultado primero
$thread = mysqli_fetch_assoc($result);   // Luego usar fetch_assoc con el resultado

if (!$thread || $thread['is_closed']) {
    header('HTTP/1.1 400 Bad Request');
    echo json_encode(['success' => false, 'message' => 'El hilo no existe o está cerrado']);
    exit();
}

// Insertar la respuesta
$query = "INSERT INTO forum_messages (thread_id, sender_id, content) VALUES (?, ?, ?)";
$stmt = mysqli_prepare($conexion, $query);
mysqli_stmt_bind_param($stmt, "iis", $threadId, $senderId, $content);
mysqli_stmt_execute($stmt);

// Actualizar la fecha de última actualización del hilo
$query = "UPDATE forum_threads SET updated_at = NOW() WHERE id = ?";
$stmt = mysqli_prepare($conexion, $query);
mysqli_stmt_bind_param($stmt, "i", $threadId);
mysqli_stmt_execute($stmt);

header('Content-Type: application/json');
echo json_encode(['success' => true]);
?>