<?php
// ============================================================
// Directorio Digital Yaguará — Front Controller
// ============================================================

// 1. Iniciar sesión para el manejo de usuarios y alertas
session_start();

// 2. Cargar archivos base de configuración
require_once __DIR__ . '/config/config.php';
require_once __DIR__ . '/config/database.php';

// 3. Cargar el núcleo MVC (Modelo - Vista - Controlador - Enrutador)
require_once __DIR__ . '/core/Router.php';
require_once __DIR__ . '/core/Controller.php';
require_once __DIR__ . '/core/Model.php';

// 4. Instanciar y ejecutar el enrutador
$router = new Router();
$router->run();
