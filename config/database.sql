-- Script de Base de Datos para Directorio Digital (100% Español)

CREATE DATABASE IF NOT EXISTS directorio_digital;
USE directorio_digital;

-- Tabla de Usuarios (Administradores, Proveedores y Consumidores)
CREATE TABLE IF NOT EXISTS usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    correo VARCHAR(100) UNIQUE NOT NULL,
    celular VARCHAR(20),
    contrasena VARCHAR(255) NOT NULL,
    rol ENUM('administrador', 'proveedor', 'consumidor') NOT NULL DEFAULT 'consumidor',
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabla de Categorías Principales
CREATE TABLE IF NOT EXISTS categorias (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    icono VARCHAR(50) DEFAULT 'fas fa-store', -- Para usar con FontAwesome u otros
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Perfiles de Proveedores (Comercios, Técnicos, Independientes)
CREATE TABLE IF NOT EXISTS perfiles_proveedor (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT NOT NULL,
    nombre_negocio VARCHAR(150) NOT NULL,
    descripcion TEXT,
    categoria_id INT,
    direccion VARCHAR(255),
    latitud DECIMAL(10, 8),
    longitud DECIMAL(11, 8),
    whatsapp VARCHAR(20),
    celular_contacto VARCHAR(20),
    esta_verificado BOOLEAN DEFAULT FALSE,
    estado ENUM('activo', 'inactivo', 'pendiente') DEFAULT 'pendiente',
    imagen_perfil TEXT,
    imagen_portada TEXT,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE,
    FOREIGN KEY (categoria_id) REFERENCES categorias(id) ON DELETE SET NULL
);

-- Horarios de Atención del Proveedor
CREATE TABLE IF NOT EXISTS horarios_proveedor (
    id INT AUTO_INCREMENT PRIMARY KEY,
    proveedor_id INT NOT NULL,
    dia_semana ENUM('Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado', 'Domingo') NOT NULL,
    hora_apertura TIME,
    hora_cierre TIME,
    esta_cerrado BOOLEAN DEFAULT FALSE,
    FOREIGN KEY (proveedor_id) REFERENCES perfiles_proveedor(id) ON DELETE CASCADE
);

-- Portafolio de Evidencias (Fotos de trabajos)
CREATE TABLE IF NOT EXISTS portafolio_proveedor (
    id INT AUTO_INCREMENT PRIMARY KEY,
    proveedor_id INT NOT NULL,
    url_imagen VARCHAR(255) NOT NULL,
    descripcion VARCHAR(255),
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (proveedor_id) REFERENCES perfiles_proveedor(id) ON DELETE CASCADE
);

-- Catálogo de Productos / Servicios (Menús, Precios)
CREATE TABLE IF NOT EXISTS productos_servicios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    proveedor_id INT NOT NULL,
    nombre VARCHAR(150) NOT NULL,
    descripcion TEXT,
    precio DECIMAL(10, 2),
    esta_disponible BOOLEAN DEFAULT TRUE,
    url_imagen VARCHAR(255),
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (proveedor_id) REFERENCES perfiles_proveedor(id) ON DELETE CASCADE
);

-- Sistema de Reseñas y Calificaciones
CREATE TABLE IF NOT EXISTS resenas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    proveedor_id INT NOT NULL,
    usuario_id INT NOT NULL, -- El consumidor que deja la reseña
    calificacion INT NOT NULL CHECK (calificacion >= 1 AND calificacion <= 5),
    comentario TEXT,
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (proveedor_id) REFERENCES perfiles_proveedor(id) ON DELETE CASCADE,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE
);

-- Gestión de Favoritos
CREATE TABLE IF NOT EXISTS favoritos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT NOT NULL,
    proveedor_id INT NOT NULL,
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE,
    FOREIGN KEY (proveedor_id) REFERENCES perfiles_proveedor(id) ON DELETE CASCADE,
    UNIQUE(usuario_id, proveedor_id) -- Un usuario no puede guardar al mismo proveedor dos veces
);

-- Insertar un usuario administrador por defecto (password es 'admin123' hasheado con BCRYPT)
INSERT INTO usuarios (nombre, correo, celular, contrasena, rol) VALUES 
('Administrador', 'admin@directorio.com', '0000000000', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'administrador');

-- Insertar algunas categorías básicas
INSERT INTO categorias (nombre, icono) VALUES 
('Gastronomía y Restaurantes', 'fas fa-utensils'),
('Salud y Belleza', 'fas fa-spa'),
('Oficios y Técnicos', 'fas fa-tools'),
('Transporte y Domicilios', 'fas fa-motorcycle'),
('Tiendas y Minimercados', 'fas fa-shopping-basket');
