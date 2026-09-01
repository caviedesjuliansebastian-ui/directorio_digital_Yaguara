<?php
require_once __DIR__ . '/../config/database.php';
$db = (new Database())->getConnection();

// 1. Crear tabla mensajes_chat
$db->exec("
CREATE TABLE IF NOT EXISTS mensajes_chat (
    id INT AUTO_INCREMENT PRIMARY KEY,
    emisor_id INT NOT NULL,
    receptor_id INT NOT NULL,
    negocio_id INT NOT NULL,
    mensaje TEXT NOT NULL,
    leido BOOLEAN DEFAULT FALSE,
    fecha_envio DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (emisor_id) REFERENCES usuarios(id) ON DELETE CASCADE,
    FOREIGN KEY (receptor_id) REFERENCES usuarios(id) ON DELETE CASCADE,
    FOREIGN KEY (negocio_id) REFERENCES negocios(id) ON DELETE CASCADE
);
");

// 2. Crear tabla tratos
$db->exec("
CREATE TABLE IF NOT EXISTS tratos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    cliente_id INT NOT NULL,
    negocio_id INT NOT NULL,
    concepto VARCHAR(255) NOT NULL,
    monto_total DECIMAL(10,2) NOT NULL,
    comision_plataforma DECIMAL(10,2) NOT NULL,
    estado ENUM('propuesto', 'cerrado', 'cancelado') DEFAULT 'propuesto',
    fecha_creacion DATETIME DEFAULT CURRENT_TIMESTAMP,
    fecha_cierre DATETIME NULL,
    FOREIGN KEY (cliente_id) REFERENCES usuarios(id) ON DELETE CASCADE,
    FOREIGN KEY (negocio_id) REFERENCES negocios(id) ON DELETE CASCADE
);
");

echo "Tablas mensajes_chat y tratos creadas exitosamente.\n";
