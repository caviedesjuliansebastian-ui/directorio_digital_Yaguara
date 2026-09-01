-- Mock Data para Directorio Digital Yaguará
SET NAMES utf8mb4;
SET CHARACTER SET utf8mb4;
USE directorio_digital;

-- Limpiar tablas para evitar duplicados en reinserciones
DELETE FROM productos_servicios;
DELETE FROM perfiles_proveedor;
DELETE FROM categorias;
DELETE FROM usuarios WHERE rol = 'proveedor';

-- 1. Insertar Categorías Ampliadas
INSERT INTO categorias (id, nombre, icono) VALUES 
(1, 'Gastronomía y Restaurantes', 'fas fa-utensils'),
(2, 'Salud y Belleza', 'fas fa-spa'),
(3, 'Oficios y Técnicos', 'fas fa-tools'),
(4, 'Transporte y Acarreos', 'fas fa-truck'),
(5, 'Tecnología y Celulares', 'fas fa-mobile-alt'),
(6, 'Moda y Ropa', 'fas fa-tshirt'),
(7, 'Mascotas y Veterinaria', 'fas fa-paw'),
(8, 'Hospedaje y Turismo', 'fas fa-bed');

-- 2. Insertar Usuarios Proveedores (Contraseña '12345678')
INSERT INTO usuarios (id, nombre, correo, celular, contrasena, rol) VALUES 
(1001, 'Carlos Chef', 'carlos@burgers.com', '3201112233', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'proveedor'),
(1002, 'Ana Estilista', 'ana@salon.com', '3104445566', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'proveedor'),
(1003, 'Mario Plomero', 'mario@plomeria.com', '3157778899', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'proveedor'),
(1004, 'Tech Store', 'ventas@techstore.com', '3001234567', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'proveedor'),
(1005, 'Boutique Elegance', 'contacto@elegance.com', '3229876543', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'proveedor');

-- 3. Insertar Perfiles de Negocio (Con fotos de Unsplash)
INSERT INTO perfiles_proveedor (id, usuario_id, nombre_negocio, descripcion, categoria_id, direccion, celular_contacto, whatsapp, esta_verificado, estado, imagen_perfil, imagen_portada) VALUES 
(2001, 1001, 'La Parrilla del Gordo', 'Las mejores hamburguesas artesanales y cortes de carne asados al carbón en Yaguará. ¡Sabor inolvidable!', 1, 'Calle Principal #4-20', '3201112233', '3201112233', 1, 'activo', 'https://images.unsplash.com/photo-1555939594-58d7cb561ad1?w=400&q=80', 'https://images.unsplash.com/photo-1550547660-d9450f859349?w=1200&q=80'),
(2002, 1002, 'Ana Spa & Belleza', 'Cortes modernos, tintes, manicure y pedicure. Déjate consentir por profesionales de la belleza.', 2, 'Carrera 2 #10-15', '3104445566', '3104445566', 1, 'activo', 'https://images.unsplash.com/photo-1562322140-8baeececf3df?w=400&q=80', 'https://images.unsplash.com/photo-1521590832167-7bfcfaa6362f?w=1200&q=80'),
(2003, 1003, 'Plomería y Reparaciones Mario', 'Solución rápida a fugas de agua, destape de cañerías e instalación de grifería. Servicio 24/7.', 3, 'Barrio Centro', '3157778899', '3157778899', 1, 'activo', 'https://images.unsplash.com/photo-1581141849291-1125c7b692b5?w=400&q=80', 'https://images.unsplash.com/photo-1504328345606-18bbc8c9d7d1?w=1200&q=80'),
(2004, 1004, 'TechZone Accesorios', 'Venta y reparación de celulares. Estuches, cargadores originales, audífonos bluetooth y servicio técnico especializado.', 5, 'Centro Comercial Local 5', '3001234567', '3001234567', 1, 'activo', 'https://images.unsplash.com/photo-1512499617640-c74ae3a79d37?w=400&q=80', 'https://images.unsplash.com/photo-1556656793-08538906a9f8?w=1200&q=80'),
(2005, 1005, 'Boutique Elegance', 'La última moda para dama y caballero. Ropa casual, vestidos de noche y accesorios importados.', 6, 'Carrera 4 #8-22', '3229876543', '3229876543', 0, 'activo', 'https://images.unsplash.com/photo-1441986300917-64674bd600d8?w=400&q=80', 'https://images.unsplash.com/photo-1441984904996-e0b6ba687e04?w=1200&q=80');

-- 4. Insertar Productos y Servicios
INSERT INTO productos_servicios (proveedor_id, nombre, descripcion, precio, url_imagen) VALUES 
-- Productos Parrilla
(2001, 'Hamburguesa Doble Carne', 'Doble carne de res (200g), queso cheddar, tocineta crujiente, vegetales frescos.', 25000, 'https://images.unsplash.com/photo-1568901346375-23c9450c58cd?w=600&q=80'),
(2001, 'Costillas BBQ', 'Costillas de cerdo bañadas en salsa BBQ de la casa, acompañadas de papas rústicas.', 35000, 'https://images.unsplash.com/photo-1544025162-8315500e5720?w=600&q=80'),
-- Servicios Spa
(2002, 'Corte de Cabello Dama', 'Corte en tendencia incluye lavado y secado express.', 20000, 'https://images.unsplash.com/photo-1560066984-138dadb4c035?w=600&q=80'),
(2002, 'Manicure Semipermanente', 'Limpieza profunda y esmaltado semipermanente de larga duración.', 30000, 'https://images.unsplash.com/photo-1519014816548-bf5fe059e98b?w=600&q=80'),
-- Servicios Plomeria
(2003, 'Destape de Cañerías', 'Uso de sonda eléctrica para destapar sifones y tuberías.', 50000, 'https://images.unsplash.com/photo-1584622650111-993a426fbf0a?w=600&q=80'),
-- Productos Tech
(2004, 'Audífonos Inalámbricos Pro', 'Cancelación de ruido activa, 24 horas de batería.', 120000, 'https://images.unsplash.com/photo-1606220588913-b3aecb4b321a?w=600&q=80'),
(2004, 'Cambio de Pantalla (Genérico)', 'Reemplazo de display para pantallas rotas.', 150000, 'https://images.unsplash.com/photo-1511707171634-5f897ff02aa9?w=600&q=80'),
-- Productos Ropa
(2005, 'Vestido de Verano Floral', 'Vestido ligero en algodón, ideal para clima cálido.', 65000, 'https://images.unsplash.com/photo-1572804013309-59a88b7e92f1?w=600&q=80');
