-- ============================================================
-- VECIRED / SERVI-GO — ESQUEMA RELACIONAL DE BASE DE DATOS
-- ============================================================

CREATE DATABASE IF NOT EXISTS directorio_yaguara CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE directorio_yaguara;

-- 1. Tabla: Roles y Usuarios
CREATE TABLE IF NOT EXISTS usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    correo VARCHAR(150) UNIQUE NOT NULL,
    celular VARCHAR(20),
    contrasena VARCHAR(255) NOT NULL,
    rol ENUM('usuario', 'proveedor', 'administrador') DEFAULT 'usuario',
    foto_perfil VARCHAR(255),
    activo BOOLEAN DEFAULT TRUE,
    fecha_creacion DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- 2. Tabla: Categorías de Comercios y Servicios
CREATE TABLE IF NOT EXISTS categorias (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    slug VARCHAR(120) UNIQUE NOT NULL,
    icono VARCHAR(50) DEFAULT 'fas fa-store',
    tipo ENUM('comercio', 'servicio') DEFAULT 'comercio',
    orden INT DEFAULT 0
) ENGINE=InnoDB;

-- 3. Tabla: Sectores / Barrios / Municipios
CREATE TABLE IF NOT EXISTS sectores (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    municipio VARCHAR(100) DEFAULT 'Yaguará',
    departamento VARCHAR(100) DEFAULT 'Huila'
) ENGINE=InnoDB;

-- 4. Tabla: Negocios / Proveedores
CREATE TABLE IF NOT EXISTS negocios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT NOT NULL,
    categoria_id INT,
    sector_id INT,
    nombre VARCHAR(150) NOT NULL,
    slug VARCHAR(180) UNIQUE NOT NULL,
    descripcion TEXT,
    direccion VARCHAR(255),
    telefono VARCHAR(50),
    whatsapp VARCHAR(50),
    verificado BOOLEAN DEFAULT FALSE,
    destacado BOOLEAN DEFAULT FALSE,
    visitas INT DEFAULT 0,
    latitud VARCHAR(30) DEFAULT '2.6630',
    longitud VARCHAR(30) DEFAULT '-75.5210',
    logo VARCHAR(255),
    imagen_portada VARCHAR(255),
    estado ENUM('pendiente', 'activo', 'inactivo', 'rechazado') DEFAULT 'pendiente',
    fecha_creacion DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE,
    FOREIGN KEY (categoria_id) REFERENCES categorias(id) ON DELETE SET NULL,
    FOREIGN KEY (sector_id) REFERENCES sectores(id) ON DELETE SET NULL
) ENGINE=InnoDB;

-- 5. Tabla: Catálogo de Productos y Servicios
CREATE TABLE IF NOT EXISTS productos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    negocio_id INT NOT NULL,
    nombre VARCHAR(100) NOT NULL,
    descripcion TEXT,
    precio DECIMAL(10,2) NOT NULL,
    unidad_medida VARCHAR(20) DEFAULT 'Unidad',
    foto VARCHAR(255),
    disponible BOOLEAN DEFAULT TRUE,
    fecha_creacion DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (negocio_id) REFERENCES negocios(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- 6. Tabla: Mensajes de Chat (Bidireccional Seguro)
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
) ENGINE=InnoDB;

-- 7. Tabla: Tratos, Acuerdos y Cotizaciones
CREATE TABLE IF NOT EXISTS tratos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    cliente_id INT NOT NULL,
    negocio_id INT NOT NULL,
    concepto VARCHAR(255) NOT NULL,
    monto_total DECIMAL(10,2) NOT NULL,
    comision_plataforma DECIMAL(10,2) NOT NULL, -- 5%
    estado ENUM('propuesto', 'cerrado', 'cancelado') DEFAULT 'propuesto',
    fecha_creacion DATETIME DEFAULT CURRENT_TIMESTAMP,
    fecha_cierre DATETIME NULL,
    FOREIGN KEY (cliente_id) REFERENCES usuarios(id) ON DELETE CASCADE,
    FOREIGN KEY (negocio_id) REFERENCES negocios(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- 8. Tabla: Reseñas y Calificaciones
CREATE TABLE IF NOT EXISTS resenas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    negocio_id INT NOT NULL,
    usuario_id INT NOT NULL,
    calificacion INT NOT NULL CHECK (calificacion BETWEEN 1 AND 5),
    comentario TEXT,
    fecha_creacion DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (negocio_id) REFERENCES negocios(id) ON DELETE CASCADE,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- 9. Tabla: Favoritos
CREATE TABLE IF NOT EXISTS favoritos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT NOT NULL,
    negocio_id INT NOT NULL,
    fecha_creacion DATETIME DEFAULT CURRENT_TIMESTAMP,
    UNIQUE KEY (usuario_id, negocio_id),
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE,
    FOREIGN KEY (negocio_id) REFERENCES negocios(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- 10. Tabla: Documentos de Verificación de Identidad
CREATE TABLE IF NOT EXISTS verificaciones (
    id INT AUTO_INCREMENT PRIMARY KEY,
    negocio_id INT NOT NULL,
    tipo_documento VARCHAR(50) DEFAULT 'Cédula & RUT',
    archivo_adjunto VARCHAR(255),
    nota_auditoria TEXT,
    estado ENUM('pendiente', 'aprobado', 'rechazado', 'en_espera') DEFAULT 'pendiente',
    fecha_solicitud DATETIME DEFAULT CURRENT_TIMESTAMP,
    fecha_revision DATETIME NULL,
    FOREIGN KEY (negocio_id) REFERENCES negocios(id) ON DELETE CASCADE
) ENGINE=InnoDB;
