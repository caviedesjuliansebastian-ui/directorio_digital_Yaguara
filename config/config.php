<?php
// ============================================================
// Directorio Digital Yaguará — Configuración Global
// ============================================================

// Información de la aplicación
define('APP_NAME', 'Directorio Digital Yaguará');
define('APP_VERSION', '2.0');
define('APP_DESCRIPTION', 'Encuentra y conecta con los negocios y servicios de Yaguará, Huila.');

// Detección automática de BASE_URL
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
$host = $_SERVER['HTTP_HOST'] ?? 'localhost';
$scriptDir = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\');
define('BASE_URL', $protocol . '://' . $host . $scriptDir . '/');

// Rutas del sistema
define('ROOT_PATH', dirname(__DIR__) . DIRECTORY_SEPARATOR);
define('UPLOADS_DIR', ROOT_PATH . 'uploads' . DIRECTORY_SEPARATOR);
define('UPLOADS_URL', BASE_URL . 'uploads/');

// Configuración de subida de archivos
define('MAX_UPLOAD_SIZE', 5 * 1024 * 1024); // 5 MB
define('ALLOWED_IMAGE_TYPES', ['jpg', 'jpeg', 'png', 'webp', 'gif']);

// Paginación
define('ITEMS_PER_PAGE', 12);

// Coordenadas de Yaguará para mapas
define('YAGUARA_LAT', 2.6633);
define('YAGUARA_LNG', -75.5225);
define('YAGUARA_ZOOM', 15);

// Zona horaria
date_default_timezone_set('America/Bogota');

// Autoload universal para Modelos, Core y Controladores
spl_autoload_register(function ($class) {
    $filePaths = [
        ROOT_PATH . 'models/' . $class . '.php',
        ROOT_PATH . 'core/' . $class . '.php',
        ROOT_PATH . 'controllers/' . $class . '.php'
    ];
    foreach ($filePaths as $file) {
        if (file_exists($file)) {
            require_once $file;
            return;
        }
    }
});
