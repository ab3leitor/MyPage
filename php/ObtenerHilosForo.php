<?php
session_start();
require 'conexion_be.php';

if (!isset($_SESSION['usuario'])) {
    header('HTTP/1.1 401 Unauthorized');
    exit();
}

$query = "SELECT 
            ft.id, 
            ft.title, 
            ft.created_at, 
            ft.updated_at, 
            ft.is_pinned, 
            ft.is_closed,
            u.nombreCompleto as creator_name,
            COUNT(fm.id) - 1 as reply_count,
            (SELECT COUNT(*) FROM thread_views WHERE thread_id = ft.id) as view_count,
            (SELECT MAX(created_at) FROM forum_messages WHERE thread_id = ft.id) as last_reply,
            (SELECT u2.nombreCompleto FROM forum_messages fm2 
             JOIN usuario u2 ON fm2.sender_id = u2.id 
             WHERE fm2.thread_id = ft.id 
             ORDER BY fm2.created_at DESC LIMIT 1) as last_reply_author
          FROM forum_threads ft
          JOIN usuario u ON ft.creator_id = u.id
          JOIN forum_messages fm ON fm.thread_id = ft.id
          GROUP BY ft.id
          ORDER BY ft.is_pinned DESC, ft.updated_at DESC";

$result = mysqli_query($conexion, $query);

$threads = [];
while ($row = mysqli_fetch_assoc($result)) {
    $threads[] = $row;
}

header('Content-Type: application/json');
echo json_encode($threads);
?>