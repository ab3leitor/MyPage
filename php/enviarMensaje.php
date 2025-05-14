<?php
session_start();
require 'conexion_be.php';

if (!isset($_SESSION['usuario'])) {
    header('Location: index.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $sender_id = $_POST['sender_id'];
    $receiver_id = $_POST['receiver_id'];
    $content = trim($_POST['content']);

    // Validaciones básicas
    if (empty($content) || !is_numeric($sender_id) || !is_numeric($receiver_id)) {
        http_response_code(400);
        echo "Datos inválidos";
        exit();
    }

    // Insertar mensaje en la base de datos
    $query = "INSERT INTO messages (sender_id, receiver_id, content) VALUES (?, ?, ?)";
    $stmt = $conexion->prepare($query);
    $stmt->bind_param("iis", $sender_id, $receiver_id, $content);
    
    if ($stmt->execute()) {
        echo "Mensaje enviado";
    } else {
        http_response_code(500);
        echo "Error al enviar el mensaje";
    }
    
    $stmt->close();
} else {
    http_response_code(405);
    echo "Método no permitido";
}
?>