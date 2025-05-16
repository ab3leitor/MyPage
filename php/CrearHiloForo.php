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

$data = json_decode(file_get_contents('php://input'), true);

if (!isset($data['title']) || !isset($data['content']) || !isset($data['creator_id'])) {
    header('HTTP/1.1 400 Bad Request');
    exit();
}

$title = trim($data['title']);
$content = trim($data['content']);
$creatorId = intval($data['creator_id']);

if (empty($title) || empty($content)) {
    header('HTTP/1.1 400 Bad Request');
    exit();
}

// Iniciar transacción
mysqli_begin_transaction($conexion);

try {
    // Insertar el hilo
    $query = "INSERT INTO forum_threads (title, creator_id) VALUES (?, ?)";
    $stmt = mysqli_prepare($conexion, $query);
    mysqli_stmt_bind_param($stmt, "si", $title, $creatorId);
    mysqli_stmt_execute($stmt);
    $threadId = mysqli_insert_id($conexion);
    
    // Insertar el primer mensaje (que es el contenido inicial del hilo)
    $query = "INSERT INTO forum_messages (thread_id, sender_id, content, is_first_message) VALUES (?, ?, ?, 1)";
    $stmt = mysqli_prepare($conexion, $query);
    mysqli_stmt_bind_param($stmt, "iis", $threadId, $creatorId, $content);
    mysqli_stmt_execute($stmt);
    
    // Registrar la vista del creador
    $query = "INSERT INTO thread_views (thread_id, user_id) VALUES (?, ?)";
    $stmt = mysqli_prepare($conexion, $query);
    mysqli_stmt_bind_param($stmt, "ii", $threadId, $creatorId);
    mysqli_stmt_execute($stmt);
    
    // Confirmar transacción
    mysqli_commit($conexion);
    
    header('Content-Type: application/json');
    echo json_encode(['success' => true, 'thread_id' => $threadId]);
} catch (Exception $e) {
    // Revertir transacción en caso de error
    mysqli_rollback($conexion);
    
    header('HTTP/1.1 500 Internal Server Error');
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
?>