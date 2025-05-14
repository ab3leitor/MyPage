<?php
session_start();
require 'conexion_be.php';

// Verificar autenticación
if (!isset($_SESSION['id'])) {
    header('HTTP/1.1 401 Unauthorized');
    exit();
}

// Obtener parámetros de manera segura
$documentId = isset($_GET['id']) ? intval($_GET['id']) : 0;
$fileName = isset($_GET['file']) ? basename($_GET['file']) : '';

// Validaciones básicas
if ($documentId <= 0 || empty($fileName)) {
    header('HTTP/1.1 400 Bad Request');
    exit();
}

// Verificar permisos (tu consulta actual está bien)
$query = "SELECT m.* FROM messages m WHERE m.id = ? AND (m.sender_id = ? OR m.receiver_id = ?) AND m.is_document = 1";
$stmt = $conexion->prepare($query);
$stmt->bind_param("iii", $documentId, $_SESSION['id'], $_SESSION['id']);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    header('HTTP/1.1 403 Forbidden');
    exit();
}

$documentData = $result->fetch_assoc();

try {
    $fileInfo = json_decode($documentData['content'], true, 512, JSON_THROW_ON_ERROR);
    if ($fileInfo['fileName'] !== $fileName) {
        throw new Exception('Nombre de archivo no coincide');
    }
} catch (Exception $e) {
    header('HTTP/1.1 500 Internal Server Error');
    exit();
}

$filePath = __DIR__ . '/uploads/' . $fileName;

if (!file_exists($filePath)) {
    header('HTTP/1.1 404 Not Found');
    exit();
}

// Registrar la descarga
$updateQuery = "UPDATE messages SET download_count = download_count + 1 WHERE id = ?";
$updateStmt = $conexion->prepare($updateQuery);
$updateStmt->bind_param("i", $documentId);
$updateStmt->execute();

// Obtener tipo MIME real
$finfo = finfo_open(FILEINFO_MIME_TYPE);
$mimeType = finfo_file($finfo, $filePath);
finfo_close($finfo);

// Forzar descarga
header('Content-Description: File Transfer');
header('Content-Type: ' . $mimeType);
header('Content-Disposition: attachment; filename="' . $fileInfo['originalName'] . '"');
header('Content-Length: ' . filesize($filePath));
header('Expires: 0');
header('Cache-Control: must-revalidate');
header('Pragma: public');

// Limpiar buffers y enviar archivo
ob_clean();
flush();
readfile($filePath);
exit;
?>