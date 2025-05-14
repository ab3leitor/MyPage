<?php
// Iniciar buffer de salida al principio del script
ob_start();

session_start();
header('Content-Type: application/json');
require 'conexion_be.php';

$allowedTypes = [
    'image/jpeg',
    'image/png',
    'image/gif',
    'application/pdf',
    'application/msword',
    'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
    'application/vnd.ms-excel',
    'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
    'application/vnd.ms-powerpoint',
    'application/vnd.openxmlformats-officedocument.presentationml.presentation',
    'text/plain',
    'application/zip',
    'application/x-rar-compressed'
];
// Aumentar el límite de tamaño si es necesario
$maxFileSize = 10 * 1024 * 1024; // 10MB

// Verificar el directorio de subidas
$uploadDir = __DIR__ . '/uploads/'; // Ruta absoluta
if (!file_exists($uploadDir)) {
    if (!mkdir($uploadDir, 0755, true)) {
        echo json_encode(['success' => false, 'error' => 'No se pudo crear directorio uploads']);
        exit();
    }
}
// Verificar y crear directorio uploads si no existe
if (!file_exists($uploadDir)) {
    if (!mkdir($uploadDir, 0755, true)) {
        ob_clean();
        header('HTTP/1.1 500 Internal Server Error');
        echo json_encode(['success' => false, 'error' => 'No se pudo crear directorio uploads']);
        ob_end_flush();
        exit();
    }
}

if (!isset($_SESSION['usuario'])) {
    ob_clean();
    header('HTTP/1.1 401 Unauthorized');
    echo json_encode(['success' => false, 'error' => 'No autorizado']);
    ob_end_flush();
    exit();
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    ob_clean();
    header('HTTP/1.1 405 Method Not Allowed');
    echo json_encode(['success' => false, 'error' => 'Método no permitido']);
    ob_end_flush();
    exit();
}

if (!isset($_FILES['file']) || !isset($_POST['sender_id']) || !isset($_POST['receiver_id'])) {
    ob_clean();
    header('HTTP/1.1 400 Bad Request');
    echo json_encode(['success' => false, 'error' => 'Faltan datos']);
    ob_end_flush();
    exit();
}

$senderId = intval($_POST['sender_id']);
$receiverId = intval($_POST['receiver_id']);
$file = $_FILES['file'];

// Validaciones básicas
if ($file['error'] !== UPLOAD_ERR_OK) {
    $errorMsg = match ($file['error']) {
        UPLOAD_ERR_INI_SIZE => 'El archivo excede el tamaño permitido por el servidor',
        UPLOAD_ERR_FORM_SIZE => 'El archivo excede el tamaño permitido por el formulario',
        UPLOAD_ERR_PARTIAL => 'El archivo fue subido parcialmente',
        UPLOAD_ERR_NO_FILE => 'No se subió ningún archivo',
        UPLOAD_ERR_NO_TMP_DIR => 'Falta el directorio temporal',
        UPLOAD_ERR_CANT_WRITE => 'Error al escribir el archivo en el disco',
        UPLOAD_ERR_EXTENSION => 'Subida detenida por la extensión',
        default => 'Error desconocido al subir el archivo',
    };
    ob_clean();
    header('HTTP/1.1 400 Bad Request');
    echo json_encode(['success' => false, 'error' => $errorMsg]);
    ob_end_flush();
    exit();
}

// Validar tipo de archivo
if (!in_array($file['type'], $allowedTypes)) {
    ob_clean();
    header('HTTP/1.1 400 Bad Request');
    echo json_encode(['success' => false, 'error' => 'Tipo de archivo no permitido']);
    ob_end_flush();
    exit();
}

// Validar tamaño
if ($file['size'] > $maxFileSize) {
    ob_clean();
    header('HTTP/1.1 400 Bad Request');
    echo json_encode(['success' => false, 'error' => 'El archivo excede el tamaño máximo permitido (5MB)']);
    ob_end_flush();
    exit();
}

// Validar nombre de archivo
$originalName = basename($file['name']);
if (!preg_match('/^[a-zA-Z0-9_\-\.]+$/', $originalName)) {
    ob_clean();
    header('HTTP/1.1 400 Bad Request');
    echo json_encode(['success' => false, 'error' => 'Nombre de archivo no válido']);
    ob_end_flush();
    exit();
}

// Generar nombre único y seguro para el archivo
$fileExt = pathinfo($file['name'], PATHINFO_EXTENSION);
$fileName = uniqid() . '.' . $fileExt;
$safeFileName = basename($fileName);
$filePath = $uploadDir . $safeFileName;

try {
    // Mover el archivo
    if (!move_uploaded_file($file['tmp_name'], $filePath)) {
        throw new Exception('Error al guardar el archivo');
    }
    if (!file_exists($filePath)) {
        echo json_encode(['success' => false, 'error' => 'El archivo no se subió correctamente']);
        exit();
    }
    // Insertar en la base de datos
    $query = "INSERT INTO messages (sender_id, receiver_id, content, is_document) 
              VALUES (?, ?, ?, 1)";
    $stmt = mysqli_prepare($conexion, $query);
    if (!$stmt) {
        throw new Exception("Error al preparar la consulta: " . mysqli_error($conexion));
    }

    $content = json_encode([
        'fileName' => $safeFileName,
        'originalName' => $originalName,
        'fileType' => $file['type']
    ]);
    mysqli_stmt_bind_param($stmt, "iis", $senderId, $receiverId, $content);
    if (!mysqli_stmt_execute($stmt)) {
        throw new Exception("Error al ejecutar la consulta: " . mysqli_stmt_error($stmt));
    }

    ob_clean();
    echo json_encode([
        'success' => true,
        'fileName' => $safeFileName,
        'fileType' => $file['type']
    ]);
    ob_end_flush();
} catch (Exception $e) {
    // Manejo de errores
    error_log("Error en SubirDocumentos.php: " . $e->getMessage());
    ob_clean();
    header('HTTP/1.1 500 Internal Server Error');
    echo json_encode(['success' => false, 'error' => 'Error: ' . $e->getMessage()]);
    ob_end_flush();
} finally {
    if (isset($stmt)) {
        mysqli_stmt_close($stmt);
    }
    // Cierre de conexión opcional (depende de tu implementación de conexion_be.php)
    // if (isset($conexion)) mysqli_close($conexion);
}
