-- ============================================================
-- VECIRED / SERVI-GO — SEED DATA REALISTA (YAGUARÁ, HUILA)
-- ============================================================

USE directorio_yaguara;

-- 1. Administrador Único y Usuarios Demo
INSERT INTO usuarios (id, nombre, correo, celular, contrasena, rol, activo) VALUES
(1, 'Administrador del Sistema', 'admin@directorio.com', '3100000000', '$2y$10$vNqj23Z6/7r7z9Lz1m.UbeUa1pC8Qo008xXFqGzS38xT5yKxGzBWy', 'administrador', 1),
(2, 'Pedro José Bahamón', 'pedro@yaguara.com', '3124567890', '$2y$10$vNqj23Z6/7r7z9Lz1m.UbeUa1pC8Qo008xXFqGzS38xT5yKxGzBWy', 'proveedor', 1),
(3, 'Vecino Consumidor', 'vecino@yaguara.com', '3151234567', '$2y$10$vNqj23Z6/7r7z9Lz1m.UbeUa1pC8Qo008xXFqGzS38xT5yKxGzBWy', 'usuario', 1)
ON DUPLICATE KEY UPDATE nombre=VALUES(nombre);

-- 2. Categorías
INSERT INTO categorias (id, nombre, slug, icono, tipo, orden) VALUES
(1, 'Comidas Típicas, Quesillos & Pescaderías', 'comidas-tipicas-quesillos-pescaderias', 'fas fa-utensils', 'comercio', 1),
(2, 'Bizcochería, Achiras y Panaderías', 'bizcocheria-achiras-panaderias', 'fas fa-bread-slice', 'comercio', 2),
(3, 'Tiendas de Barrio & Abarrotes', 'tiendas-de-barrio-abarrotes', 'fas fa-shopping-basket', 'comercio', 3),
(4, 'Droguerías & Farmacias', 'droguerias-farmacias', 'fas fa-pills', 'comercio', 4),
(5, 'Electricistas & Motobombas', 'electricistas-motobombas', 'fas fa-bolt', 'servicio', 5)
ON DUPLICATE KEY UPDATE nombre=VALUES(nombre);

-- 3. Sectores de Yaguará
INSERT INTO sectores (id, nombre, municipio, departamento) VALUES
(1, 'Centro', 'Yaguará', 'Huila'),
(2, 'Malecón Betania', 'Yaguará', 'Huila'),
(3, 'Las Ferias', 'Yaguará', 'Huila'),
(4, 'Barrio Upar', 'Yaguará', 'Huila'),
(5, 'El Triunfo', 'Yaguará', 'Huila')
ON DUPLICATE KEY UPDATE nombre=VALUES(nombre);

-- 4. Negocios Emblemáticos de Yaguará
INSERT INTO negocios (id, usuario_id, categoria_id, sector_id, nombre, slug, descripcion, direccion, telefono, whatsapp, verificado, destacado, visitas, latitud, longitud, logo, imagen_portada, estado) VALUES
(1, 1, 1, 1, 'Quesillos y Tradición Yaguareña Doña Stella', 'quesillos-y-tradicion-yaguarena-dona-stella', 'Más de 30 años elaborando el auténtico quesillo yaguareño envuelto en hoja de plátano con leche pura de ganado local...', 'Carrera 4 # 5-20, Centro, Yaguará', '3124567890', '3124567890', 1, 1, 340, '2.6628', '-75.5215', 'https://images.unsplash.com/photo-1544005313-94ddf0286df2?w=150&auto=format&fit=crop&q=80', 'https://images.unsplash.com/photo-1555396273-367ea4eb4db5?w=800&auto=format&fit=crop&q=80', 'activo'),
(2, 1, 1, 2, 'Pescadería & Estadero El Malecón de Betania', 'pescaderia-y-estadero-el-malecon-de-betania', 'Pescado fresco del Embalse de Betania. Especialistas en Mojarra Roja Frita crocante, Viudo de Capaz en salsa criolla...', 'Malecón Turístico Embalse de Betania, Yaguará', '3157891234', '3157891234', 1, 1, 520, '2.6850', '-75.4850', 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=150&auto=format&fit=crop&q=80', 'https://images.unsplash.com/photo-1534422298391-e4f8c172dddb?w=800&auto=format&fit=crop&q=80', 'activo'),
(3, 1, 1, 3, 'Asados & Tradición Huilense Don Pedro', 'asados-y-tradicion-huilense-don-pedro', 'Auténtico asado huilense horneado en tiesto de barro con insulso, arepa de choclo, tamales yaguareños y carnes al...', 'Calle 8 # 3-15, Barrio Las Ferias, Yaguará', '3109876543', '3109876543', 1, 1, 280, '2.6610', '-75.5190', 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?w=150&auto=format&fit=crop&q=80', 'https://images.unsplash.com/photo-1544025162-d76694265947?w=800&auto=format&fit=crop&q=80', 'activo'),
(4, 1, 2, 1, 'Bizcochería & Achiras La Yaguareñita', 'bizcocheria-y-achiras-la-yaguarenita', 'Las mejores Achiras de Yaguará horneadas con leña y cuajada pura campesina. Bizcochos de manteca, cucas, bizcochuelos...', 'Carrera 5 # 4-10, Parque Principal, Yaguará', '3112345678', '3112345678', 1, 1, 410, '2.6635', '-75.5205', 'https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?w=150&auto=format&fit=crop&q=80', 'https://images.unsplash.com/photo-1509440159596-0249088772ff?w=800&auto=format&fit=crop&q=80', 'activo'),
(5, 1, 2, 1, 'Panadería y Cafetería El Parque Yaguará', 'panaderia-y-cafeteria-el-parque-yaguara', 'Pan aliñado caliente a las 6:00 AM y 4:00 PM, pandebonos, buñuelos, empanadas de carne y pollo, desayunos y jugos...', 'Esquina Parque Principal, Yaguará', '3145678901', '3145678901', 1, 0, 190, '2.6630', '-75.5210', 'https://images.unsplash.com/photo-1519085360753-af0119f7cbe7?w=150&auto=format&fit=crop&q=80', 'https://images.unsplash.com/photo-1555507036-ab1f4038808a?w=800&auto=format&fit=crop&q=80', 'activo'),
(6, 1, 3, 5, 'Supertienda y Abarrotes El Triunfo de Yaguará', 'supertienda-y-abarrotes-el-triunfo-de-yaguara', 'Todo para el mercado del hogar en Yaguará: víveres, arroz de Campoalegre, panela, aceite, huevos campesinos, gaseosas...', 'Calle Principal Barrio El Triunfo, Yaguará', '3161234567', '3161234567', 1, 1, 310, '2.6645', '-75.5230', 'https://images.unsplash.com/photo-1492562080023-ab3db95bfbce?w=150&auto=format&fit=crop&q=80', 'https://images.unsplash.com/photo-1578916171728-46686eac8d58?w=800&auto=format&fit=crop&q=80', 'activo'),
(7, 1, 3, 4, 'Minimarket Los Ganaderos Yaguará', 'minimarket-los-ganaderos-yaguara', 'Frutas, verduras frescas que llegan de la vega, carnes frías, helados, bebidas y recargas a todo operador.', 'Carrera 7 # 8-30, Barrio Upar, Yaguará', '3187654321', '3187654321', 1, 0, 160, '2.6600', '-75.5240', 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=150&auto=format&fit=crop&q=80', 'https://images.unsplash.com/photo-1542838132-92c53300491e?w=800&auto=format&fit=crop&q=80', 'activo'),
(8, 1, 4, 1, 'Droguería La Principal de Yaguará', 'drogueria-la-principal-de-yaguara', 'Farmacia de confianza en Yaguará. Despacho de fórmulas, inyectología certificada, toma de presión arterial, sueros orales...', 'Calle 5 # 4-40, Centro, Yaguará', '3139871234', '3139871234', 1, 1, 290, '2.6625', '-75.5212', 'https://images.unsplash.com/photo-1559839734-2b71ea197ec2?w=150&auto=format&fit=crop&q=80', 'https://images.unsplash.com/photo-1586015555751-63bb77f4322a?w=800&auto=format&fit=crop&q=80', 'activo'),
(9, 1, 4, 4, 'Farmacia San José Yaguará', 'farmacia-san-jose-yaguara', 'Medicamentos genéricos y de marca, pañales, leche de fórmula y artículos de aseo para bebés y adultos.', 'Carrera 6 # 9-10, Barrio Upar, Yaguará', '3176543210', '3176543210', 1, 0, 140, '2.6595', '-75.5225', 'https://images.unsplash.com/photo-1622253692010-333f2da6031d?w=150&auto=format&fit=crop&q=80', 'https://images.unsplash.com/photo-1631549916768-4119b2e5f926?w=800&auto=format&fit=crop&q=80', 'activo')
ON DUPLICATE KEY UPDATE nombre=VALUES(nombre);

-- 5. Catálogo de Productos y Platos
INSERT INTO productos (negocio_id, nombre, descripcion, precio, unidad_medida, disponible) VALUES
(1, 'Quesillo Yaguareño Tradicional (Libra)', 'Elaborado diariamente con cuajada fresca de las fincas yaguareñas.', 14000, 'Libra', 1),
(1, 'Combo Yaguareño: Quesillo + Achiras + Kumis', 'El trío típico por excelencia para disfrutar o llevar de regalo.', 22000, 'Combo', 1),
(2, 'Mojarra Roja Frita de Betania (1.5 lb)', 'Pescado frito crocante servido con patacón gigante, arroz con coco y ensalada.', 32000, 'Plato', 1),
(2, 'Viudo de Pescado Criollo con Yuca y Plátano', 'Pescado cocido en caldo espeso con hogao de cebolla y tomate.', 34000, 'Plato', 1),
(3, 'Plato de Asado Huilense con Insulso', 'Cerdo marinado con hierbas de la huerta, horneado en tiesto y acompañado de insulso.', 28000, 'Plato', 1),
(4, 'Lata de Achiras Tradicionales Yaguará (500g)', 'Empacadas en lata metálica sellada para conservar la frescura y textura crocante.', 20000, 'Lata', 1),
(4, 'Bolsa de Bizcocho de Cuajada (250g)', 'Deliciosos bizcochos hechos con receta tradicional de la abuela.', 8000, 'Bolsa', 1),
(5, 'Pan Aliñado Caliente', 'Pan suave con queso y mantequilla salido del horno a las 6am y 4pm.', 2500, 'Unidad', 1),
(5, 'Pandebono Campesino', 'Masa suave de almidón de yuca y queso fresco.', 2000, 'Unidad', 1),
(6, 'Cubeta de Huevos Criollos AA x30', 'Huevos frescos de gallina de campo de fincas locales.', 18000, 'Cubeta', 1),
(6, 'Arroz Campoalegre Diana 1kg', 'Arroz de primera calidad cultivado en la cuenca del río Neiva.', 4200, 'Kilo', 1),
(7, 'Queso Semisalado Campesino (Libra)', 'Queso fresco artesanal de ordeño diario.', 9000, 'Libra', 1),
(7, 'Bolsa de Leche Fresca Entera 1L', 'Pasteurizada y lista para consumir.', 3800, 'Litro', 1),
(8, 'Suero Oral Electrolit Fresa 625ml', 'Solución rehidratante oral para toda la familia.', 8500, 'Frasco', 1),
(9, 'Acetaminofén 500mg MK x 100', 'Caja de 100 tabletas para alivio del dolor y la fiebre.', 12000, 'Caja', 1),
(9, 'Pañales Etapa 3 x 30', 'Pañales absorbentes y suaves para bebés.', 26000, 'Paquete', 1);
