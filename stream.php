<?php
/**
 * Stream de Videos Protegido y Optimizado
 * Protege videos contra descarga y streaming no autorizado
 * Optimizado para rendimiento y seguridad
 */
// 3. Headers CRÍTICOS para iOS
header('Content-Type: video/mp4');
header('Accept-Ranges: bytes');
header('Cache-Control: no-cache, no-store');
header('Pragma: no-cache');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Range');
header('Access-Control-Expose-Headers: Content-Range, Content-Length');

// 4. Manejo de byte ranges (ESENCIAL para iOS)
$size = filesize($videoPath);
$start = 0;
$end = $size - 1;
$length = $size;

if (isset($_SERVER['HTTP_RANGE'])) {
    $range = $_SERVER['HTTP_RANGE'];
    if (preg_match('/bytes=(\d+)-(\d+)?/', $range, $matches)) {
        $start = (int)$matches[1];
        $end = isset($matches[2]) ? (int)$matches[2] : $size - 1;
        $length = $end - $start + 1;
        
        header('HTTP/1.1 206 Partial Content');
        header("Content-Range: bytes $start-$end/$size");
    }
}

header('Content-Length: ' . $length);

// Iniciar sesión
session_start();

// Configuración de errores (desactivar en producción)
error_reporting(E_ALL);
ini_set('display_errors', 0);

// Configuración
define('VIDEO_DIR', __DIR__ . '/videos/online/');
define('SECRET_KEY', '887319b0c6904b38b20d3b1dd2f147f44b4bec85119e1ab6e6db226eac56e8a1');
define('MAX_CHUNK_SIZE', 2097152); // 2MB máximo por chunk
define('BUFFER_SIZE', 65536); // 64KB buffer
define('TOKEN_DURATION', 3600); // 1 hora de validez del token

/**
 * Función para logging de seguridad
 */
function logSecurityEvent($event, $details = []) {
    $log_entry = [
        'timestamp' => date('Y-m-d H:i:s'),
        'ip' => $_SERVER['REMOTE_ADDR'] ?? 'unknown',
        'user_agent' => $_SERVER['HTTP_USER_AGENT'] ?? 'unknown',
        'event' => $event,
        'details' => $details
    ];
    
    // En producción, guardar en archivo de log o base de datos
    error_log("SECURITY: " . json_encode($log_entry));
}

/**
 * Validar autenticación del usuario
 */
function validateAuthentication() {
    if (!isset($_SESSION['idUser']) || empty($_SESSION['idUser'])) {
        logSecurityEvent('unauthorized_access', ['reason' => 'no_session']);
        http_response_code(403);
        exit("Acceso denegado - Usuario no autenticado");
    }
    
    // Verificar si la sesión ha expirado
    if (isset($_SESSION['last_activity']) && 
        (time() - $_SESSION['last_activity']) > TOKEN_DURATION) {
        logSecurityEvent('session_expired', ['user_id' => $_SESSION['idUser']]);
        session_destroy();
        http_response_code(403);
        exit("Sesión expirada");
    }
    
    $_SESSION['last_activity'] = time();
}

/**
 * Validar referer para prevenir hotlinking
 */
function validateReferer() {
    $allowed_domains = [
        'localhost',
        '127.0.0.1',
        'tudominio.com',
        'www.tudominio.com'
        // Agregar tus dominios permitidos aquí
    ];
    
    $referer = $_SERVER['HTTP_REFERER'] ?? '';
    
    // Si no hay referer, rechazar (opcional - puedes comentar esta línea)
    if (empty($referer)) {
        logSecurityEvent('missing_referer');
        http_response_code(403);
        exit("Acceso denegado - Referer requerido");
    }
    
    $referer_host = parse_url($referer, PHP_URL_HOST);
    
    $valid_referer = false;
    foreach ($allowed_domains as $domain) {
        if ($referer_host === $domain || 
            substr($referer_host, -strlen($domain) - 1) === '.' . $domain) {
            $valid_referer = true;
            break;
        }
    }
    
    if (!$valid_referer) {
        logSecurityEvent('invalid_referer', ['referer' => $referer]);
        http_response_code(403);
        exit("Acceso denegado - Referer no válido");
    }
}

/**
 * Generar y validar token de seguridad
 */
function validateSecurityToken() {
    $token = $_GET['token'] ?? '';
    
    if (empty($token)) {
        logSecurityEvent('missing_token');
        http_response_code(403);
        exit("Token requerido");
    }
    
    // Generar token esperado basado en sesión y timestamp
    $user_id = $_SESSION['idUser'];
    $timestamp = floor(time() / TOKEN_DURATION);
    $expected_token = hash_hmac('sha256', $user_id . $timestamp, SECRET_KEY);
    
    // También verificar token del período anterior (para transiciones)
    $previous_timestamp = $timestamp - 1;
    $previous_token = hash_hmac('sha256', $user_id . $previous_timestamp, SECRET_KEY);
    
    if (!hash_equals($expected_token, $token) && !hash_equals($previous_token, $token)) {
        logSecurityEvent('invalid_token', ['user_id' => $user_id]);
        http_response_code(403);
        exit("Token inválido o expirado");
    }
}

/**
 * Validar y sanitizar ID del video
 */
function getVideoFile() {
    $video_id = $_GET['id'] ?? '';
    
    // Sanitizar ID del video
    $video_id = preg_replace('/[^a-zA-Z0-9_-]/', '', $video_id);
    
    if (empty($video_id)) {
        logSecurityEvent('missing_video_id');
        http_response_code(400);
        exit("ID de video requerido");
    }
    
    // Construir ruta del archivo
    $file_path = VIDEO_DIR . $video_id . '.mp4';
    
    // Verificar que el archivo existe y está dentro del directorio permitido
    $real_path = realpath($file_path);
    $real_video_dir = realpath(VIDEO_DIR);
    
    if (!$real_path || strpos($real_path, $real_video_dir) !== 0) {
        logSecurityEvent('path_traversal_attempt', ['video_id' => $video_id]);
        http_response_code(404);
        exit("Video no encontrado" . $video_id );
    }
    
    if (!file_exists($real_path) || !is_readable($real_path)) {
        logSecurityEvent('video_not_found', ['video_id' => $video_id]);
        http_response_code(404);
        exit("Video no encontrado o no legible");
    }
    
    return $real_path;
}

/**
 * Configurar headers de seguridad
 */
function setSecurityHeaders() {
    // Headers básicos de streaming
    header("Content-Type: video/mp4");
    header("Accept-Ranges: bytes");
    
    // Headers de seguridad
    header("X-Content-Type-Options: nosniff");
    header("X-Frame-Options: SAMEORIGIN");
    header("X-XSS-Protection: 1; mode=block");
    header("Referrer-Policy: strict-origin-when-cross-origin");
    header("Content-Security-Policy: default-src 'self'");
    
    // Headers de cache (sin cache para mayor seguridad)
    header("Cache-Control: private, no-cache, no-store, must-revalidate, max-age=0");
    header("Pragma: no-cache");
    header("Expires: Thu, 01 Jan 1970 00:00:00 GMT");
    
    // Headers personalizados para protección
    header("X-Video-Protection: enabled");
    header("X-Content-Video-Options: no-download");
}

/**
 * Procesar Range requests para streaming eficiente
 */
function processRangeRequest($file_path, $file_size) {
    $start = 0;
    $end = $file_size - 1;
    $length = $file_size;
    $partial_content = false;
    
    if (isset($_SERVER['HTTP_RANGE'])) {
        $range_header = $_SERVER['HTTP_RANGE'];
        
        // Validar formato del Range header
        if (preg_match('/bytes=(\d+)-(\d*)/', $range_header, $matches)) {
            $start = intval($matches[1]);
            
            if (!empty($matches[2])) {
                $end = intval($matches[2]);
            }
            
            // Validar que el rango sea válido
            if ($start >= $file_size || $end >= $file_size || $start > $end) {
                http_response_code(416);
                header("Content-Range: bytes */$file_size");
                exit("Rango solicitado no válido");
            }
            
            // Limitar el tamaño del chunk para evitar timeouts
            if (($end - $start + 1) > MAX_CHUNK_SIZE) {
                $end = $start + MAX_CHUNK_SIZE - 1;
            }
            
            $length = $end - $start + 1;
            $partial_content = true;
        } else {
            // Range header malformado
            http_response_code(416);
            header("Content-Range: bytes */$file_size");
            exit("Range header malformado");
        }
    }
    
    // Configurar headers de respuesta
    if ($partial_content) {
        http_response_code(206);
        header("Content-Range: bytes $start-$end/$file_size");
    }
    
    header("Content-Length: $length");
    
    return [$start, $end, $length];
}

/**
 * Streaming optimizado del archivo
 */
function streamVideo($file_path, $start, $end, $length) {
    $fp = fopen($file_path, 'rb');
    
    if (!$fp) {
        http_response_code(500);
        exit("Error al abrir el archivo");
    }
    
    // Posicionarse al inicio del rango
    fseek($fp, $start);
    
    $bytes_sent = 0;
    
    // Leer y enviar datos en chunks
    while (!feof($fp) && $bytes_sent < $length && connection_status() == 0) {
        $bytes_to_read = min(BUFFER_SIZE, $length - $bytes_sent);
        $data = fread($fp, $bytes_to_read);
        
        if ($data === false) {
            break;
        }
        
        echo $data;
        flush();
        
        $bytes_sent += strlen($data);
        
        // Verificar si el cliente sigue conectado
        if (connection_aborted()) {
            logSecurityEvent('connection_aborted', [
                'user_id' => $_SESSION['idUser'],
                'bytes_sent' => $bytes_sent,
                'total_length' => $length
            ]);
            break;
        }
    }
    
    fclose($fp);
    
    // Log del streaming completado
    logSecurityEvent('video_streamed', [
        'user_id' => $_SESSION['idUser'],
        'video_id' => $_GET['id'],
        'bytes_sent' => $bytes_sent,
        'range' => "$start-$end",
        'completed' => ($bytes_sent >= $length)
    ]);
}

// === EJECUCIÓN PRINCIPAL ===

try {
    // Validaciones de seguridad
    validateAuthentication();
    validateReferer();
    validateSecurityToken();
    
    // Obtener archivo de video
    $file_path = getVideoFile();
    $file_size = filesize($file_path);
    
    // Configurar headers
    setSecurityHeaders();
    
    // Procesar Range request
    list($start, $end, $length) = processRangeRequest($file_path, $file_size);
    
    // Streaming del video
    streamVideo($file_path, $start, $end, $length);
    
} catch (Exception $e) {
    logSecurityEvent('streaming_error', ['error' => $e->getMessage()]);
    http_response_code(500);
    exit("Error interno del servidor");
}

exit;
?>