<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../core/Model.php';
require_once __DIR__ . '/../models/Usuario.php';

session_start();
$usuarioModel = new Usuario();
$resultado = $usuarioModel->login('admin@directorio.com', '12345678');

echo "Resultado del login:\n";
print_r($resultado);
