-- ============================================================
-- Directorio Digital Yaguará — Schema + Seeds
-- Versión 2.0
-- ============================================================

CREATE DATABASE IF NOT EXISTS directorio_yaguara CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE directorio_yaguara;

-- ============================================================
-- TABLA: usuarios
-- ============================================================
CREATE TABLE IF NOT EXISTS usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    correo VARCHAR(100) UNIQUE NOT NULL,
    celular VARCHAR(20),
    contrasena VARCHAR(255) NOT NULL,
    rol ENUM('administrador', 'usuario') NOT NULL DEFAULT 'usuario',
    foto_perfil VARCHAR(255) DEFAULT NULL,
    activo BOOLEAN DEFAULT TRUE,
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    fecha_actualizacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- ============================================================
-- TABLA: categorias
-- ============================================================
CREATE TABLE IF NOT EXISTS categorias (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    slug VARCHAR(120) UNIQUE NOT NULL,
    icono VARCHAR(50) DEFAULT 'fas fa-store',
    descripcion TEXT,
    color VARCHAR(7) DEFAULT '#059669',
    orden INT DEFAULT 0,
    activo BOOLEAN DEFAULT TRUE,
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- ============================================================
-- TABLA: sectores
-- ============================================================
CREATE TABLE IF NOT EXISTS sectores (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    slug VARCHAR(120) UNIQUE NOT NULL,
    descripcion TEXT,
    latitud DECIMAL(10, 8) DEFAULT NULL,
    longitud DECIMAL(11, 8) DEFAULT NULL,
    activo BOOLEAN DEFAULT TRUE,
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- ============================================================
-- TABLA: negocios
-- ============================================================
CREATE TABLE IF NOT EXISTS negocios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT NOT NULL,
    categoria_id INT DEFAULT NULL,
    sector_id INT DEFAULT NULL,
    nombre VARCHAR(150) NOT NULL,
    slug VARCHAR(170) UNIQUE NOT NULL,
    descripcion TEXT,
    direccion VARCHAR(255),
    telefono VARCHAR(20),
    whatsapp VARCHAR(20),
    email VARCHAR(100),
    sitio_web VARCHAR(255),
    facebook VARCHAR(255),
    instagram VARCHAR(255),
    latitud DECIMAL(10, 8) DEFAULT NULL,
    longitud DECIMAL(11, 8) DEFAULT NULL,
    logo VARCHAR(255) DEFAULT NULL,
    imagen_portada VARCHAR(255) DEFAULT NULL,
    estado ENUM('activo', 'pendiente', 'inactivo', 'rechazado') DEFAULT 'pendiente',
    verificado BOOLEAN DEFAULT FALSE,
    destacado BOOLEAN DEFAULT FALSE,
    visitas INT DEFAULT 0,
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    fecha_actualizacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE,
    FOREIGN KEY (categoria_id) REFERENCES categorias(id) ON DELETE SET NULL,
    FOREIGN KEY (sector_id) REFERENCES sectores(id) ON DELETE SET NULL,
    INDEX idx_estado (estado),
    INDEX idx_categoria (categoria_id),
    INDEX idx_sector (sector_id),
    INDEX idx_slug (slug)
) ENGINE=InnoDB;

-- ============================================================
-- TABLA: horarios
-- ============================================================
CREATE TABLE IF NOT EXISTS horarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    negocio_id INT NOT NULL,
    dia_semana TINYINT NOT NULL COMMENT '0=Domingo, 1=Lunes ... 6=Sábado',
    hora_apertura TIME DEFAULT NULL,
    hora_cierre TIME DEFAULT NULL,
    cerrado BOOLEAN DEFAULT FALSE,
    FOREIGN KEY (negocio_id) REFERENCES negocios(id) ON DELETE CASCADE,
    INDEX idx_negocio (negocio_id)
) ENGINE=InnoDB;

-- ============================================================
-- TABLA: imagenes_negocio
-- ============================================================
CREATE TABLE IF NOT EXISTS imagenes_negocio (
    id INT AUTO_INCREMENT PRIMARY KEY,
    negocio_id INT NOT NULL,
    url_imagen VARCHAR(255) NOT NULL,
    descripcion VARCHAR(255) DEFAULT NULL,
    orden INT DEFAULT 0,
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (negocio_id) REFERENCES negocios(id) ON DELETE CASCADE,
    INDEX idx_negocio (negocio_id)
) ENGINE=InnoDB;

-- ============================================================
-- TABLA: resenas
-- ============================================================
CREATE TABLE IF NOT EXISTS resenas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    negocio_id INT NOT NULL,
    usuario_id INT NOT NULL,
    calificacion TINYINT NOT NULL CHECK (calificacion >= 1 AND calificacion <= 5),
    comentario TEXT,
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (negocio_id) REFERENCES negocios(id) ON DELETE CASCADE,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE,
    INDEX idx_negocio (negocio_id)
) ENGINE=InnoDB;

-- ============================================================
-- TABLA: reportes
-- ============================================================
CREATE TABLE IF NOT EXISTS reportes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    negocio_id INT NOT NULL,
    usuario_id INT DEFAULT NULL,
    motivo VARCHAR(100) NOT NULL,
    descripcion TEXT,
    estado ENUM('pendiente', 'revisado', 'resuelto') DEFAULT 'pendiente',
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (negocio_id) REFERENCES negocios(id) ON DELETE CASCADE,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE SET NULL,
    INDEX idx_estado (estado)
) ENGINE=InnoDB;

-- ============================================================
-- TABLA: favoritos
-- ============================================================
CREATE TABLE IF NOT EXISTS favoritos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT NOT NULL,
    negocio_id INT NOT NULL,
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE,
    FOREIGN KEY (negocio_id) REFERENCES negocios(id) ON DELETE CASCADE,
    UNIQUE KEY uk_usuario_negocio (usuario_id, negocio_id)
) ENGINE=InnoDB;


-- ============================================================
-- SEEDS
-- ============================================================

-- Usuario administrador (contraseña: admin123)
INSERT INTO usuarios (nombre, correo, celular, contrasena, rol) VALUES
('Administrador', 'admin@yaguara.gov.co', '3100000000', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'administrador');

-- Usuarios demo
INSERT INTO usuarios (nombre, correo, celular, contrasena, rol) VALUES
('María García', 'maria@correo.com', '3151234567', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'usuario'),
('Carlos Pérez', 'carlos@correo.com', '3209876543', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'usuario'),
('Ana Rodríguez', 'ana@correo.com', '3001112233', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'usuario'),
('Pedro López', 'pedro@correo.com', '3114445566', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'usuario');

-- Categorías de Yaguará
INSERT INTO categorias (nombre, slug, icono, descripcion, color, orden) VALUES
('Restaurantes y Comidas', 'restaurantes-comidas', 'fas fa-utensils', 'Restaurantes, asaderos, comidas rápidas, panaderías y cafeterías', '#ef4444', 1),
('Tiendas y Minimercados', 'tiendas-minimercados', 'fas fa-shopping-basket', 'Tiendas de barrio, minimercados, supermercados y abarrotes', '#f97316', 2),
('Salud y Bienestar', 'salud-bienestar', 'fas fa-heartbeat', 'Farmacias, consultorios, odontología, veterinarias', '#06b6d4', 3),
('Belleza y Estética', 'belleza-estetica', 'fas fa-spa', 'Peluquerías, barberías, salones de belleza, spa', '#ec4899', 4),
('Servicios Técnicos', 'servicios-tecnicos', 'fas fa-tools', 'Electricistas, plomeros, cerrajeros, mecánicos, reparaciones', '#8b5cf6', 5),
('Transporte', 'transporte', 'fas fa-motorcycle', 'Mototaxis, domicilios, fletes y transporte intermunicipal', '#14b8a6', 6),
('Educación y Cultura', 'educacion-cultura', 'fas fa-graduation-cap', 'Colegios, academias, clases particulares, bibliotecas', '#3b82f6', 7),
('Turismo y Hospedaje', 'turismo-hospedaje', 'fas fa-hotel', 'Hoteles, fincas turísticas, guías, planes al embalse', '#0ea5e9', 8),
('Agropecuario', 'agropecuario', 'fas fa-tractor', 'Almacenes agropecuarios, veterinarias, insumos agrícolas', '#22c55e', 9),
('Tecnología y Comunicaciones', 'tecnologia-comunicaciones', 'fas fa-laptop', 'Papelerías, cafés internet, reparación de celulares, recargas', '#6366f1', 10),
('Ropa y Calzado', 'ropa-calzado', 'fas fa-tshirt', 'Boutiques, almacenes de ropa, calzado y accesorios', '#f43f5e', 11),
('Ferretería y Construcción', 'ferreteria-construccion', 'fas fa-hard-hat', 'Ferreterías, materiales de construcción, pinturas', '#a3a3a3', 12);

-- Sectores de Yaguará
INSERT INTO sectores (nombre, slug, descripcion, latitud, longitud) VALUES
('Centro', 'centro', 'Zona céntrica alrededor del parque principal', 2.6633, -75.5225),
('La Playa', 'la-playa', 'Sector cercano al embalse de Betania', 2.6650, -75.5180),
('El Progreso', 'el-progreso', 'Barrio residencial al norte del casco urbano', 2.6660, -75.5240),
('Villa del Río', 'villa-del-rio', 'Sector residencial al oriente', 2.6620, -75.5200),
('San José', 'san-jose', 'Barrio tradicional del municipio', 2.6640, -75.5260),
('La Esperanza', 'la-esperanza', 'Sector en desarrollo al sur', 2.6610, -75.5230),
('Zona Rural', 'zona-rural', 'Veredas y zonas rurales del municipio', 2.6500, -75.5300),
('Vía al Embalse', 'via-al-embalse', 'Corredor turístico hacia el embalse de Betania', 2.6700, -75.5100);

-- Negocios demo
INSERT INTO negocios (usuario_id, categoria_id, sector_id, nombre, slug, descripcion, direccion, telefono, whatsapp, email, latitud, longitud, estado, verificado, destacado, visitas) VALUES
(2, 1, 1, 'Restaurante El Embalse', 'restaurante-el-embalse', 'El mejor pescado fresco del embalse de Betania. Especialidad en mojarra, tilapia y bagre preparados con recetas tradicionales huilenses. Ambiente familiar con vista al municipio.', 'Calle 4 # 5-23, Centro', '3151234567', '3151234567', 'elembalse@correo.com', 2.6633, -75.5225, 'activo', TRUE, TRUE, 245),
(2, 1, 2, 'Asadero La Brasa Yaguareña', 'asadero-la-brasa-yaguarena', 'Pollo a la brasa, carnes asadas y acompañamientos criollos. El lugar favorito de Yaguará para reuniones familiares.', 'Carrera 6 # 3-15, La Playa', '3151234567', '3151234567', NULL, 2.6650, -75.5180, 'activo', TRUE, FALSE, 180),
(3, 2, 1, 'Minimercado Don Pedro', 'minimercado-don-pedro', 'Surtido completo en abarrotes, productos de aseo, frutas y verduras frescas. Atención todos los días del año.', 'Carrera 5 # 4-10, Centro', '3209876543', '3209876543', NULL, 2.6635, -75.5220, 'activo', TRUE, FALSE, 320),
(3, 3, 1, 'Droguería Salud Vital', 'drogueria-salud-vital', 'Medicamentos, productos de cuidado personal y asesoría farmacéutica. Servicio de inyectología y toma de presión arterial.', 'Calle 3 # 5-45, Centro', '3209876543', '3209876543', 'saludvital@correo.com', 2.6630, -75.5228, 'activo', TRUE, TRUE, 410),
(4, 4, 3, 'Peluquería Stilos', 'peluqueria-stilos', 'Cortes modernos, tintes, tratamientos capilares y manicure. El mejor estilo para hombres y mujeres en Yaguará.', 'Calle 6 # 7-12, El Progreso', '3001112233', '3001112233', NULL, 2.6660, -75.5240, 'activo', FALSE, FALSE, 95),
(4, 5, 4, 'Electri-Servicios Yaguará', 'electri-servicios-yaguara', 'Instalaciones eléctricas, reparaciones, cableado estructurado y mantenimiento preventivo. Más de 15 años de experiencia.', 'Carrera 8 # 2-30, Villa del Río', '3001112233', '3001112233', NULL, 2.6620, -75.5200, 'activo', TRUE, FALSE, 67),
(5, 6, 1, 'MotoExpress Yaguará', 'motoexpress-yaguara', 'Servicio de mototaxi y domicilios rápidos. Cobertura en todo el casco urbano y veredas cercanas. Llámenos y llegamos.', 'Centro, Parque Principal', '3114445566', '3114445566', NULL, 2.6633, -75.5225, 'activo', FALSE, FALSE, 150),
(5, 8, 8, 'Finca Hotel El Paraíso', 'finca-hotel-el-paraiso', 'Hospedaje campestre con piscina, zona BBQ y acceso al embalse de Betania. Planes familiares, pasadías y deportes acuáticos.', 'Km 3 Vía al Embalse', '3114445566', '3114445566', 'paraiso@correo.com', 2.6700, -75.5100, 'activo', TRUE, TRUE, 520),
(2, 7, 5, 'Academia de Música Yaguará', 'academia-musica-yaguara', 'Clases de guitarra, tiple, bandola y canto. Formación en música colombiana y folclor huilense. Todas las edades.', 'Calle 5 # 6-18, San José', '3151234567', '3151234567', NULL, 2.6640, -75.5260, 'activo', FALSE, FALSE, 43),
(3, 9, 7, 'Agro-Insumos del Huila', 'agro-insumos-del-huila', 'Semillas, fertilizantes, herramientas agrícolas y concentrados para animales. Asesoría técnica agropecuaria gratuita.', 'Vereda El Viso', '3209876543', '3209876543', NULL, 2.6500, -75.5300, 'activo', TRUE, FALSE, 88),
(4, 10, 1, 'TecnoCell Yaguará', 'tecnocell-yaguara', 'Reparación de celulares, tablets y computadores. Venta de accesorios y recargas de todas las operadoras.', 'Carrera 5 # 3-22, Centro', '3001112233', '3001112233', NULL, 2.6632, -75.5223, 'activo', FALSE, FALSE, 175),
(5, 11, 1, 'Boutique María Bonita', 'boutique-maria-bonita', 'Ropa femenina, masculina e infantil. Las mejores marcas a precios accesibles. Moda para toda la familia yaguareña.', 'Calle 4 # 5-08, Centro', '3114445566', '3114445566', NULL, 2.6634, -75.5226, 'activo', FALSE, FALSE, 130),
(2, 12, 6, 'Ferretería El Constructor', 'ferreteria-el-constructor', 'Materiales de construcción, pinturas, herramientas y asesoría para tus proyectos. Servicio a domicilio en Yaguará.', 'Carrera 7 # 1-45, La Esperanza', '3151234567', '3151234567', NULL, 2.6610, -75.5230, 'activo', TRUE, FALSE, 200),
(3, 1, 1, 'Heladería y Frutería Tropical', 'heladeria-fruteria-tropical', 'Helados artesanales, jugos naturales, ensaladas de frutas y postres. El punto de encuentro más refrescante de Yaguará.', 'Parque Principal, Centro', '3209876543', '3209876543', NULL, 2.6633, -75.5224, 'activo', FALSE, TRUE, 290),
(4, 2, 3, 'Tienda La Economía', 'tienda-la-economia', 'Todo lo que necesitas para tu hogar a los mejores precios. Frutas, verduras, lácteos y productos de la canasta familiar.', 'Calle 7 # 8-05, El Progreso', '3001112233', '3001112233', NULL, 2.6658, -75.5242, 'activo', FALSE, FALSE, 110),
-- Negocios pendientes de aprobación
(5, 3, 1, 'Consultorio Dental Sonrisas', 'consultorio-dental-sonrisas', 'Odontología general, ortodoncia, blanqueamiento y limpieza dental. Atención personalizada con tecnología moderna.', 'Calle 3 # 4-30, Centro', '3114445566', '3114445566', NULL, 2.6631, -75.5227, 'pendiente', FALSE, FALSE, 0),
(2, 5, 4, 'Cerrajería Rápida', 'cerrajeria-rapida', 'Apertura de puertas, duplicado de llaves, instalación de cerraduras de seguridad. Servicio 24 horas.', 'Villa del Río', '3151234567', '3151234567', NULL, 2.6618, -75.5198, 'pendiente', FALSE, FALSE, 0);

-- Horarios demo (para los primeros 5 negocios)
INSERT INTO horarios (negocio_id, dia_semana, hora_apertura, hora_cierre, cerrado) VALUES
-- Restaurante El Embalse (negocio 1)
(1, 1, '07:00', '21:00', FALSE), (1, 2, '07:00', '21:00', FALSE), (1, 3, '07:00', '21:00', FALSE),
(1, 4, '07:00', '21:00', FALSE), (1, 5, '07:00', '22:00', FALSE), (1, 6, '07:00', '22:00', FALSE),
(1, 0, '08:00', '15:00', FALSE),
-- Minimercado Don Pedro (negocio 3)
(3, 1, '06:00', '20:00', FALSE), (3, 2, '06:00', '20:00', FALSE), (3, 3, '06:00', '20:00', FALSE),
(3, 4, '06:00', '20:00', FALSE), (3, 5, '06:00', '20:00', FALSE), (3, 6, '06:00', '21:00', FALSE),
(3, 0, '07:00', '13:00', FALSE),
-- Droguería Salud Vital (negocio 4)
(4, 1, '07:00', '20:00', FALSE), (4, 2, '07:00', '20:00', FALSE), (4, 3, '07:00', '20:00', FALSE),
(4, 4, '07:00', '20:00', FALSE), (4, 5, '07:00', '20:00', FALSE), (4, 6, '08:00', '18:00', FALSE),
(4, 0, NULL, NULL, TRUE);

-- Reseñas demo
INSERT INTO resenas (negocio_id, usuario_id, calificacion, comentario) VALUES
(1, 3, 5, '¡Excelente mojarra! El mejor restaurante de pescado en Yaguará. Muy recomendado.'),
(1, 4, 4, 'Buena comida y buen servicio. A veces hay que esperar un poco pero vale la pena.'),
(1, 5, 5, 'Siempre venimos en familia los domingos. La tilapia es espectacular.'),
(4, 2, 5, 'Muy buena atención, siempre tienen todo lo que necesito. Recomendada.'),
(4, 5, 4, 'Buen surtido de medicamentos y buena asesoría.'),
(8, 2, 5, 'Un lugar mágico para descansar. La vista al embalse es increíble.'),
(8, 3, 5, '¡Perfecto para ir con la familia! Los niños disfrutaron mucho la piscina.'),
(8, 4, 4, 'Muy bonito lugar, solo falta mejorar un poco la señalización para llegar.'),
(14, 2, 5, 'Los mejores helados de Yaguará, sin duda. El de cholupa es imperdible.'),
(14, 5, 4, 'Delicioso y fresco. Perfecto para el calor de Yaguará.');

-- Favoritos demo
INSERT INTO favoritos (usuario_id, negocio_id) VALUES
(2, 1), (2, 8), (2, 14),
(3, 4), (3, 8), (3, 1),
(4, 14), (4, 1),
(5, 8), (5, 3);
