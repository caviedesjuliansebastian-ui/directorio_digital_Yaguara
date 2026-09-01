<?php
require_once __DIR__ . '/../config/database.php';
$db = (new Database())->getConnection();

// Desactivar chequeo de foreign keys para poblar limpiamente
$db->exec("SET FOREIGN_KEY_CHECKS = 0");
$db->exec("TRUNCATE TABLE productos");
$db->exec("TRUNCATE TABLE resenas");
$db->exec("TRUNCATE TABLE horarios");
$db->exec("TRUNCATE TABLE favoritos");
$db->exec("TRUNCATE TABLE negocios");
$db->exec("TRUNCATE TABLE categorias");
$db->exec("TRUNCATE TABLE sectores");
$db->exec("SET FOREIGN_KEY_CHECKS = 1");

// 1. Insertar Categorías Amplias (15 Categorías)
$categorias = [
    [1, 'Comidas Típicas, Quesillos & Pescaderías', 'comidas-tipicas-quesillos-pescaderias', 'fas fa-utensils', '#f97316', 1],
    [2, 'Bizcochería, Achiras y Panaderías', 'bizcocheria-achiras-panaderias', 'fas fa-bread-slice', '#f59e0b', 2],
    [3, 'Tiendas de Barrio & Abarrotes', 'tiendas-de-barrio-abarrotes', 'fas fa-shopping-basket', '#10b981', 3],
    [4, 'Droguerías & Farmacias', 'droguerias-farmacias', 'fas fa-pills', '#ef4444', 4],
    [5, 'Electricistas, Motobombas & Plomería', 'electricistas-motobombas-plomeria', 'fas fa-bolt', '#3b82f6', 5],
    [6, 'Hoteles, Cabañas & Turismo Betania', 'hoteles-cabanas-turismo-betania', 'fas fa-hotel', '#8b5cf6', 6],
    [7, 'Cafeterías, Heladerías & Jugos', 'cafeterias-heladerias-jugos', 'fas fa-coffee', '#ec4899', 7],
    [8, 'Talleres de Motos & Repuestos', 'talleres-de-motos-repuestos', 'fas fa-motorcycle', '#6366f1', 8],
    [9, 'Ferreterías & Construcción', 'ferreterias-construccion', 'fas fa-tools', '#d97706', 9],
    [10, 'Barberías, Peluquerías & Estética', 'barberias-peluquerias-estetica', 'fas fa-cut', '#14b8a6', 10],
    [11, 'Veterinarias & Agropecuarias', 'veterinarias-agropecuarias', 'fas fa-paw', '#84cc16', 11],
    [12, 'Carnicerías & Fama de Carnes', 'carnicerias-fama-de-carnes', 'fas fa-drumstick-bite', '#dc2626', 12],
    [13, 'Fruterías & Verduras Campesinas', 'fruterias-verduras-campesinas', 'fas fa-apple-alt', '#22c55e', 13],
    [14, 'Artesanías, Papelería & Regalos', 'artesanias-papeleria-regalos', 'fas fa-gift', '#a855f7', 14],
    [15, 'Restaurantes, Asaderos & Comidas Rápidas', 'restaurantes-asaderos-comidas-rapidas', 'fas fa-hamburger', '#f43f5e', 15]
];

$stmtCat = $db->prepare("INSERT INTO categorias (id, nombre, slug, icono, color, orden, activo) VALUES (?, ?, ?, ?, ?, ?, 1)");
foreach ($categorias as $c) {
    $stmtCat->execute($c);
}

// 2. Insertar Sectores / Barrios de Yaguará
$sectores = [
    [1, 'Centro', 'centro', '2.6630', '-75.5210'],
    [2, 'Malecón Betania', 'malecon-betania', '2.6850', '-75.4850'],
    [3, 'Las Ferias', 'las-ferias', '2.6610', '-75.5190'],
    [4, 'Barrio Upar', 'barrio-upar', '2.6600', '-75.5240'],
    [5, 'El Triunfo', 'el-triunfo', '2.6645', '-75.5230'],
    [6, 'El Progreso', 'el-progreso', '2.6650', '-75.5200'],
    [7, 'La Playa', 'la-playa', '2.6840', '-75.4860'],
    [8, 'Vía al Embalse', 'via-al-embalse', '2.6750', '-75.4950']
];

$stmtSec = $db->prepare("INSERT INTO sectores (id, nombre, slug, latitud, longitud, activo) VALUES (?, ?, ?, ?, ?, 1)");
foreach ($sectores as $s) {
    $stmtSec->execute($s);
}

// 3. Más de 30 Negocios Emblemáticos de Yaguará con imágenes temáticas en alta calidad
$negocios = [
    // 1 - 5: Comidas típicas & Bizcocherías (Mockup core)
    [
        'id' => 1, 'categoria_id' => 1, 'sector_id' => 1,
        'nombre' => 'Quesillos y Tradición Yaguareña Doña Stella',
        'slug' => 'quesillos-y-tradicion-yaguarena-dona-stella',
        'descripcion' => 'Más de 30 años elaborando el auténtico quesillo yaguareño envuelto en hoja de plátano con leche pura de ganado local...',
        'direccion' => 'Carrera 4 # 5-20, Centro, Yaguará',
        'telefono' => '3124567890', 'whatsapp' => '3124567890',
        'verificado' => 1, 'destacado' => 1, 'visitas' => 450,
        'latitud' => '2.6628', 'longitud' => '-75.5215',
        'logo' => 'https://images.unsplash.com/photo-1544005313-94ddf0286df2?w=150&auto=format&fit=crop&q=80',
        'imagen_portada' => 'https://images.unsplash.com/photo-1555396273-367ea4eb4db5?w=800&auto=format&fit=crop&q=80',
        'prods' => [
            ['Quesillo Yaguareño Tradicional (Libra)', 'Elaborado diariamente con cuajada fresca de las fincas yaguareñas.', 14000, 'Libra'],
            ['Combo Yaguareño: Quesillo + Achiras + Kumis', 'El trío típico por excelencia para disfrutar o llevar de regalo.', 22000, 'Combo']
        ]
    ],
    [
        'id' => 2, 'categoria_id' => 1, 'sector_id' => 2,
        'nombre' => 'Pescadería & Estadero El Malecón de Betania',
        'slug' => 'pescaderia-y-estadero-el-malecon-de-betania',
        'descripcion' => 'Pescado fresco del Embalse de Betania. Especialistas en Mojarra Roja Frita crocante, Viudo de Capaz en salsa criolla...',
        'direccion' => 'Malecón Turístico Embalse de Betania, Yaguará',
        'telefono' => '3157891234', 'whatsapp' => '3157891234',
        'verificado' => 1, 'destacado' => 1, 'visitas' => 610,
        'latitud' => '2.6850', 'longitud' => '-75.4850',
        'logo' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=150&auto=format&fit=crop&q=80',
        'imagen_portada' => 'https://images.unsplash.com/photo-1534422298391-e4f8c172dddb?w=800&auto=format&fit=crop&q=80',
        'prods' => [
            ['Mojarra Roja Frita de Betania (1.5 lb)', 'Pescado frito crocante servido con patacón gigante, arroz con coco y ensalada.', 32000, 'Plato'],
            ['Viudo de Pescado Criollo con Yuca y Plátano', 'Pescado cocido en caldo espeso con hogao de cebolla y tomate.', 34000, 'Plato']
        ]
    ],
    [
        'id' => 3, 'categoria_id' => 1, 'sector_id' => 3,
        'nombre' => 'Asados & Tradición Huilense Don Pedro',
        'slug' => 'asados-y-tradicion-huilense-don-pedro',
        'descripcion' => 'Auténtico asado huilense horneado en tiesto de barro con insulso, arepa de choclo, tamales yaguareños y carnes al...',
        'direccion' => 'Calle 8 # 3-15, Barrio Las Ferias, Yaguará',
        'telefono' => '3109876543', 'whatsapp' => '3109876543',
        'verificado' => 1, 'destacado' => 1, 'visitas' => 390,
        'latitud' => '2.6610', 'longitud' => '-75.5190',
        'logo' => 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?w=150&auto=format&fit=crop&q=80',
        'imagen_portada' => 'https://images.unsplash.com/photo-1544025162-d76694265947?w=800&auto=format&fit=crop&q=80',
        'prods' => [
            ['Plato de Asado Huilense con Insulso', 'Cerdo marinado con hierbas de la huerta, horneado en tiesto y acompañado de insulso.', 28000, 'Plato']
        ]
    ],
    [
        'id' => 4, 'categoria_id' => 2, 'sector_id' => 1,
        'nombre' => 'Bizcochería & Achiras La Yaguareñita',
        'slug' => 'bizcocheria-y-achiras-la-yaguarenita',
        'descripcion' => 'Las mejores Achiras de Yaguará horneadas con leña y cuajada pura campesina. Bizcochos de manteca, cucas, bizcochuelos...',
        'direccion' => 'Carrera 5 # 4-10, Parque Principal, Yaguará',
        'telefono' => '3112345678', 'whatsapp' => '3112345678',
        'verificado' => 1, 'destacado' => 1, 'visitas' => 480,
        'latitud' => '2.6635', 'longitud' => '-75.5205',
        'logo' => 'https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?w=150&auto=format&fit=crop&q=80',
        'imagen_portada' => 'https://images.unsplash.com/photo-1509440159596-0249088772ff?w=800&auto=format&fit=crop&q=80',
        'prods' => [
            ['Lata de Achiras Tradicionales Yaguará (500g)', 'Empacadas en lata metálica sellada para conservar la frescura y textura crocante.', 20000, 'Lata'],
            ['Bolsa de Bizcocho de Cuajada (250g)', 'Deliciosos bizcochos hechos con receta tradicional de la abuela.', 8000, 'Bolsa']
        ]
    ],
    [
        'id' => 5, 'categoria_id' => 2, 'sector_id' => 1,
        'nombre' => 'Panadería y Cafetería El Parque Yaguará',
        'slug' => 'panaderia-y-cafeteria-el-parque-yaguara',
        'descripcion' => 'Pan aliñado caliente a las 6:00 AM y 4:00 PM, pandebonos, buñuelos, empanadas de carne y pollo, desayunos y jugos...',
        'direccion' => 'Esquina Parque Principal, Yaguará',
        'telefono' => '3145678901', 'whatsapp' => '3145678901',
        'verificado' => 1, 'destacado' => 0, 'visitas' => 260,
        'latitud' => '2.6630', 'longitud' => '-75.5210',
        'logo' => 'https://images.unsplash.com/photo-1519085360753-af0119f7cbe7?w=150&auto=format&fit=crop&q=80',
        'imagen_portada' => 'https://images.unsplash.com/photo-1555507036-ab1f4038808a?w=800&auto=format&fit=crop&q=80',
        'prods' => [
            ['Pan Aliñado Caliente', 'Pan suave con queso y mantequilla salido del horno a las 6am y 4pm.', 2500, 'Unidad'],
            ['Pandebono Campesino', 'Masa suave de almidón de yuca y queso fresco.', 2000, 'Unidad']
        ]
    ],

    // 6 - 10: Abarrotes, Droguerías & Servicios
    [
        'id' => 6, 'categoria_id' => 3, 'sector_id' => 5,
        'nombre' => 'Supertienda y Abarrotes El Triunfo de Yaguará',
        'slug' => 'supertienda-y-abarrotes-el-triunfo-de-yaguara',
        'descripcion' => 'Todo para el mercado del hogar en Yaguará: víveres, arroz de Campoalegre, panela, aceite, huevos campesinos, gaseosas...',
        'direccion' => 'Calle Principal Barrio El Triunfo, Yaguará',
        'telefono' => '3161234567', 'whatsapp' => '3161234567',
        'verificado' => 1, 'destacado' => 1, 'visitas' => 340,
        'latitud' => '2.6645', 'longitud' => '-75.5230',
        'logo' => 'https://images.unsplash.com/photo-1492562080023-ab3db95bfbce?w=150&auto=format&fit=crop&q=80',
        'imagen_portada' => 'https://images.unsplash.com/photo-1578916171728-46686eac8d58?w=800&auto=format&fit=crop&q=80',
        'prods' => [
            ['Cubeta de Huevos Criollos AA x30', 'Huevos frescos de gallina de campo de fincas locales.', 18000, 'Cubeta'],
            ['Arroz Campoalegre Diana 1kg', 'Arroz de primera calidad cultivado en la cuenca del río Neiva.', 4200, 'Kilo']
        ]
    ],
    [
        'id' => 7, 'categoria_id' => 3, 'sector_id' => 4,
        'nombre' => 'Minimarket Los Ganaderos Yaguará',
        'slug' => 'minimarket-los-ganaderos-yaguara',
        'descripcion' => 'Frutas, verduras frescas que llegan de la vega, carnes frías, helados, bebidas y recargas a todo operador.',
        'direccion' => 'Carrera 7 # 8-30, Barrio Upar, Yaguará',
        'telefono' => '3187654321', 'whatsapp' => '3187654321',
        'verificado' => 1, 'destacado' => 0, 'visitas' => 210,
        'latitud' => '2.6600', 'longitud' => '-75.5240',
        'logo' => 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=150&auto=format&fit=crop&q=80',
        'imagen_portada' => 'https://images.unsplash.com/photo-1542838132-92c53300491e?w=800&auto=format&fit=crop&q=80',
        'prods' => [
            ['Queso Semisalado Campesino (Libra)', 'Queso fresco artesanal de ordeño diario.', 9000, 'Libra'],
            ['Bolsa de Leche Fresca Entera 1L', 'Pasteurizada y lista para consumir.', 3800, 'Litro']
        ]
    ],
    [
        'id' => 8, 'categoria_id' => 4, 'sector_id' => 1,
        'nombre' => 'Droguería La Principal de Yaguará',
        'slug' => 'drogueria-la-principal-de-yaguara',
        'descripcion' => 'Farmacia de confianza en Yaguará. Despacho de fórmulas, inyectología certificada, toma de presión arterial, sueros orales...',
        'direccion' => 'Calle 5 # 4-40, Centro, Yaguará',
        'telefono' => '3139871234', 'whatsapp' => '3139871234',
        'verificado' => 1, 'destacado' => 1, 'visitas' => 380,
        'latitud' => '2.6625', 'longitud' => '-75.5212',
        'logo' => 'https://images.unsplash.com/photo-1559839734-2b71ea197ec2?w=150&auto=format&fit=crop&q=80',
        'imagen_portada' => 'https://images.unsplash.com/photo-1586015555751-63bb77f4322a?w=800&auto=format&fit=crop&q=80',
        'prods' => [
            ['Suero Oral Electrolit Fresa 625ml', 'Solución rehidratante oral para toda la familia.', 8500, 'Frasco']
        ]
    ],
    [
        'id' => 9, 'categoria_id' => 4, 'sector_id' => 4,
        'nombre' => 'Farmacia San José Yaguará',
        'slug' => 'farmacia-san-jose-yaguara',
        'descripcion' => 'Medicamentos genéricos y de marca, pañales, leche de fórmula y artículos de aseo para bebés y adultos.',
        'direccion' => 'Carrera 6 # 9-10, Barrio Upar, Yaguará',
        'telefono' => '3176543210', 'whatsapp' => '3176543210',
        'verificado' => 1, 'destacado' => 0, 'visitas' => 180,
        'latitud' => '2.6595', 'longitud' => '-75.5225',
        'logo' => 'https://images.unsplash.com/photo-1622253692010-333f2da6031d?w=150&auto=format&fit=crop&q=80',
        'imagen_portada' => 'https://images.unsplash.com/photo-1631549916768-4119b2e5f926?w=800&auto=format&fit=crop&q=80',
        'prods' => [
            ['Acetaminofén 500mg MK x 100', 'Caja de 100 tabletas para alivio del dolor y la fiebre.', 12000, 'Caja'],
            ['Pañales Etapa 3 x 30', 'Pañales absorbentes y suaves para bebés.', 26000, 'Paquete']
        ]
    ],
    [
        'id' => 10, 'categoria_id' => 5, 'sector_id' => 3,
        'nombre' => 'Servicios Técnicos & Motobombas Don Hernán',
        'slug' => 'servicios-tecnicos-y-motobombas-don-hernan',
        'descripcion' => 'Mantenimiento preventivo y correctivo de motobombas agrícolas, instalaciones eléctricas trifásicas y plomería en fincas.',
        'direccion' => 'Calle 9 # 2-45, Barrio Las Ferias, Yaguará',
        'telefono' => '3201239876', 'whatsapp' => '3201239876',
        'verificado' => 1, 'destacado' => 1, 'visitas' => 290,
        'latitud' => '2.6615', 'longitud' => '-75.5180',
        'logo' => 'https://images.unsplash.com/photo-1560250097-0b93528c311a?w=150&auto=format&fit=crop&q=80',
        'imagen_portada' => 'https://images.unsplash.com/photo-1581092160607-ee22621dd758?w=800&auto=format&fit=crop&q=80',
        'prods' => [
            ['Mantenimiento General Motobomba 2HP a 5HP', 'Desarme, cambio de rodamientos, sellos mecánicos y prueba de presión.', 85000, 'Servicio'],
            ['Revisión Eléctrica Domiciliaria / Finca', 'Diagnóstico de sobrecarga, cambio de breakers e instalación a tierra.', 60000, 'Visita']
        ]
    ],

    // 11 - 15: Turismo, Hoteles, Cafeterías & Mecánica
    [
        'id' => 11, 'categoria_id' => 6, 'sector_id' => 2,
        'nombre' => 'Cabañas Ecoturísticas & Náutica Betania View',
        'slug' => 'cabanas-ecoturisticas-nautica-betania-view',
        'descripcion' => 'Alojamiento frente al Embalse de Betania con piscina, paseo en lancha a la cueva del amor, pesca deportiva y restaurante.',
        'direccion' => 'Vía Embalse de Betania Km 3, Yaguará',
        'telefono' => '3149876543', 'whatsapp' => '3149876543',
        'verificado' => 1, 'destacado' => 1, 'visitas' => 740,
        'latitud' => '2.6880', 'longitud' => '-75.4820',
        'logo' => 'https://images.unsplash.com/photo-1571003123894-1f0594d2b5d9?w=150&auto=format&fit=crop&q=80',
        'imagen_portada' => 'https://images.unsplash.com/photo-1566073771259-6a8506099945?w=800&auto=format&fit=crop&q=80',
        'prods' => [
            ['Noche Cabaña Familiar con Vista al Embalse (4 Personas)', 'Incluye desayuno típico, acceso a piscina y muelle privado.', 220000, 'Noche'],
            ['Tour Náutico en Lancha por el Embalse de Betania (1 Hora)', 'Recorrido panorámico con chalecos salvavidas y guía turístico.', 140000, 'Paseo']
        ]
    ],
    [
        'id' => 12, 'categoria_id' => 6, 'sector_id' => 1,
        'nombre' => 'Hotel Colonial Yaguará Plaza',
        'slug' => 'hotel-colonial-yaguara-plaza',
        'descripcion' => 'Cómodas habitaciones con aire acondicionado, WiFi de alta velocidad, parqueadero privado y desayuno incluido en pleno centro.',
        'direccion' => 'Carrera 5 # 3-25, Frente al Parque, Yaguará',
        'telefono' => '3116549870', 'whatsapp' => '3116549870',
        'verificado' => 1, 'destacado' => 0, 'visitas' => 310,
        'latitud' => '2.6638', 'longitud' => '-75.5208',
        'logo' => 'https://images.unsplash.com/photo-1582719478250-c89cae4dc85b?w=150&auto=format&fit=crop&q=80',
        'imagen_portada' => 'https://images.unsplash.com/photo-1590490360182-c33d57733427?w=800&auto=format&fit=crop&q=80',
        'prods' => [
            ['Habitación Matrimonial Climatizada con Desayuno', 'Cama queen, TV Smart, baño privado y aire acondicionado.', 90000, 'Noche']
        ]
    ],
    [
        'id' => 13, 'categoria_id' => 7, 'sector_id' => 1,
        'nombre' => 'Café & Heladería Artesanal Dulce Placer Yaguará',
        'slug' => 'cafe-y-heladeria-artesanal-dulce-placer-yaguara',
        'descripcion' => 'Café de origen huilense filtrado, granizados de café con quesillo, copas de helado artesanal, waffles y malteadas.',
        'direccion' => 'Calle 6 # 4-15, Parque Principal, Yaguará',
        'telefono' => '3182345678', 'whatsapp' => '3182345678',
        'verificado' => 1, 'destacado' => 1, 'visitas' => 510,
        'latitud' => '2.6632', 'longitud' => '-75.5218',
        'logo' => 'https://images.unsplash.com/photo-1535713875002-d1d0cf377fde?w=150&auto=format&fit=crop&q=80',
        'imagen_portada' => 'https://images.unsplash.com/photo-1501339847302-ac426a4a7cbb?w=800&auto=format&fit=crop&q=80',
        'prods' => [
            ['Granizado de Café Especial con Trocitos de Quesillo', 'Bebida insignia fría decorada con crema chantilly y arequipe.', 11000, 'Copa'],
            ['Copa de Helado de Frutas Tropicales', '3 bolas de helado, fresas, banano, barquillo y salsa de mora.', 13000, 'Copa']
        ]
    ],
    [
        'id' => 14, 'categoria_id' => 8, 'sector_id' => 6,
        'nombre' => 'Taller & Repuestos de Motos El Paisa Yaguará',
        'slug' => 'taller-y-repuestos-de-motos-el-paisa-yaguara',
        'descripcion' => 'Sincronización electrónica, cambio de aceite, llantas, kits de arrastre, cascos certificados y repuestos para Boxer, GN, NMAX y AKT.',
        'direccion' => 'Carrera 3 # 7-10, Barrio El Progreso, Yaguará',
        'telefono' => '3174561230', 'whatsapp' => '3174561230',
        'verificado' => 1, 'destacado' => 0, 'visitas' => 280,
        'latitud' => '2.6650', 'longitud' => '-75.5200',
        'logo' => 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=150&auto=format&fit=crop&q=80',
        'imagen_portada' => 'https://images.unsplash.com/photo-1558981806-ec527fa84c39?w=800&auto=format&fit=crop&q=80',
        'prods' => [
            ['Cambio de Aceite Motul 4T + Lavado de Cadena', 'Incluye revisión básica de frenos y presión de llantas.', 35000, 'Servicio'],
            ['Kit de Arrastre Reforzado Cadena Dorada', 'Compatible con motos 125cc a 150cc.', 95000, 'Kit']
        ]
    ],
    [
        'id' => 15, 'categoria_id' => 9, 'sector_id' => 1,
        'nombre' => 'Ferretería & Materiales San Mateo de Yaguará',
        'slug' => 'ferreteria-y-materiales-san-mateo-de-yaguara',
        'descripcion' => 'Cemento, varilla, arena lavada, tubería PVC, pinturas, herramientas eléctricas, motobombas y mangueras para riego.',
        'direccion' => 'Calle 4 # 2-30, Centro, Yaguará',
        'telefono' => '3128901234', 'whatsapp' => '3128901234',
        'verificado' => 1, 'destacado' => 1, 'visitas' => 360,
        'latitud' => '2.6620', 'longitud' => '-75.5228',
        'logo' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=150&auto=format&fit=crop&q=80',
        'imagen_portada' => 'https://images.unsplash.com/photo-1504307651254-35680f356dfd?w=800&auto=format&fit=crop&q=80',
        'prods' => [
            ['Bulto de Cemento Gris Argos 50kg', 'Cemento de alta resistencia para estructuras y acabados.', 34000, 'Bulto'],
            ['Manguera de Riego Agrícola 1/2 pulgada x 100m', 'Manguera negra reforzada para trabajo pesado en fincas.', 88000, 'Rollo']
        ]
    ],

    // 16 - 20: Barberías, Veterinarias, Carnes & Frutas
    [
        'id' => 16, 'categoria_id' => 10, 'sector_id' => 1,
        'nombre' => 'Barbería & Estilo Urbano Yaguará',
        'slug' => 'barberia-y-estilo-urbano-yaguara',
        'descripcion' => 'Cortes clásicos y modernos (fade, degrade), perfilado de barba con toalla caliente, mascarillas faciales y tintes.',
        'direccion' => 'Carrera 4 # 6-12, Centro, Yaguará',
        'telefono' => '3167890123', 'whatsapp' => '3167890123',
        'verificado' => 1, 'destacado' => 0, 'visitas' => 270,
        'latitud' => '2.6631', 'longitud' => '-75.5214',
        'logo' => 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?w=150&auto=format&fit=crop&q=80',
        'imagen_portada' => 'https://images.unsplash.com/photo-1503951914875-452162b0f3f1?w=800&auto=format&fit=crop&q=80',
        'prods' => [
            ['Corte de Cabello Moderno + Perfilado de Barba', 'Incluye lavado, diseño y aplicación de loción refrescante.', 22000, 'Servicio']
        ]
    ],
    [
        'id' => 17, 'categoria_id' => 11, 'sector_id' => 3,
        'nombre' => 'Agropecuaria & Veterinaria El Ganadero Yaguareño',
        'slug' => 'agropecuaria-y-veterinaria-el-ganadero-yaguareno',
        'descripcion' => 'Medicamentos veterinarios para ganado vacuno y equino, concentrados Italcol y Solla, sales mineralizadas y alambre de púas.',
        'direccion' => 'Calle 8 # 4-50, Barrio Las Ferias, Yaguará',
        'telefono' => '3103456789', 'whatsapp' => '3103456789',
        'verificado' => 1, 'destacado' => 1, 'visitas' => 410,
        'latitud' => '2.6612', 'longitud' => '-75.5185',
        'logo' => 'https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?w=150&auto=format&fit=crop&q=80',
        'imagen_portada' => 'https://images.unsplash.com/photo-1516467508483-a7212febe31a?w=800&auto=format&fit=crop&q=80',
        'prods' => [
            ['Bulto de Concentrado Vacas Lecheras 40kg', 'Alimento balanceado con 18% de proteína para mayor producción.', 92000, 'Bulto'],
            ['Sal Mineralizada Ganar 8% x 40kg', 'Minerales esenciales para ganado de cría y ceba.', 82000, 'Bulto']
        ]
    ],
    [
        'id' => 18, 'categoria_id' => 12, 'sector_id' => 1,
        'nombre' => 'Carnicería & Fama La Especial del Centro',
        'slug' => 'carniceria-y-fama-la-especial-del-centro',
        'descripcion' => 'Carnes de res de primera calidad, lomo, costilla, pulpa, carne de cerdo fresca, pollo campesino y chicharrón crocante.',
        'direccion' => 'Plaza de Mercado Local 4, Centro, Yaguará',
        'telefono' => '3132345678', 'whatsapp' => '3132345678',
        'verificado' => 1, 'destacado' => 0, 'visitas' => 330,
        'latitud' => '2.6627', 'longitud' => '-75.5220',
        'logo' => 'https://images.unsplash.com/photo-1492562080023-ab3db95bfbce?w=150&auto=format&fit=crop&q=80',
        'imagen_portada' => 'https://images.unsplash.com/photo-1607623814075-e51df1bdc82f?w=800&auto=format&fit=crop&q=80',
        'prods' => [
            ['Kilo de Lomo Fino de Res para Asar', 'Carne tierna y jugosa seleccionada de ganado local.', 32000, 'Kilo'],
            ['Libra de Costilla de Cerdo Especial', 'Ideal para sancochos y asados dominicales.', 13000, 'Libra']
        ]
    ],
    [
        'id' => 19, 'categoria_id' => 13, 'sector_id' => 1,
        'nombre' => 'Frutería & Legumbres La Campesina Yaguará',
        'slug' => 'fruteria-y-legumbres-la-campesina-yaguara',
        'descripcion' => 'Frutas recién traídas del campo: papaya, piña oro miel, aguacate papelillo, plátano verde, yuca fresca, tomate y cebolla.',
        'direccion' => 'Carrera 5 # 6-05, Centro, Yaguará',
        'telefono' => '3156789012', 'whatsapp' => '3156789012',
        'verificado' => 1, 'destacado' => 1, 'visitas' => 310,
        'latitud' => '2.6636', 'longitud' => '-75.5202',
        'logo' => 'https://images.unsplash.com/photo-1544005313-94ddf0286df2?w=150&auto=format&fit=crop&q=80',
        'imagen_portada' => 'https://images.unsplash.com/photo-1610832958506-aa56368176cf?w=800&auto=format&fit=crop&q=80',
        'prods' => [
            ['Combo Frutas Semanal (Papaya + Piña + Aguacates + Plátanos)', 'Surtido familiar con frutas frescas seleccionadas.', 25000, 'Combo'],
            ['Bolsa de Yuca Fresca de la Vega (5 Libras)', 'Yuca harinosa que ablanda rápido, ideal para viudo.', 10000, 'Bolsa']
        ]
    ],
    [
        'id' => 20, 'categoria_id' => 14, 'sector_id' => 1,
        'nombre' => 'Artesanías & Variedades El Recuerdo Yaguareño',
        'slug' => 'artesanias-y-variedades-el-recuerdo-yaguareno',
        'descripcion' => 'Souvenirs típicos de Yaguará y Huila: sombreros de pindo, chivas artesanales, materas de barro, bisutería y recuerdos de Betania.',
        'direccion' => 'Calle 5 # 3-40, Centro, Yaguará',
        'telefono' => '3118901234', 'whatsapp' => '3118901234',
        'verificado' => 1, 'destacado' => 0, 'visitas' => 220,
        'latitud' => '2.6629', 'longitud' => '-75.5211',
        'logo' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=150&auto=format&fit=crop&q=80',
        'imagen_portada' => 'https://images.unsplash.com/photo-1513519245088-0e12902e5a38?w=800&auto=format&fit=crop&q=80',
        'prods' => [
            ['Sombrero de Pindo Tradicional Huilense', 'Tejido a mano por artesanas de la región.', 45000, 'Unidad'],
            ['Chiva Artesanal Huilense en Cerámica', 'Pintada a mano con detalles típicos campesinos.', 28000, 'Unidad']
        ]
    ],

    // 21 - 25: Restaurantes, Pizzerías & Comidas Rápidas
    [
        'id' => 21, 'categoria_id' => 15, 'sector_id' => 1,
        'nombre' => 'Pizzería & Restaurante La Terraza Yaguará',
        'slug' => 'pizzeria-y-restaurante-la-terraza-yaguara',
        'descripcion' => 'Pizzas artesanales horneadas a la piedra con masa madurada, lasagna boloñesa, hamburguesas gourmet y cócteles tropicales.',
        'direccion' => 'Carrera 4 # 7-20, Parque Principal, Yaguará',
        'telefono' => '3178901234', 'whatsapp' => '3178901234',
        'verificado' => 1, 'destacado' => 1, 'visitas' => 560,
        'latitud' => '2.6634', 'longitud' => '-75.5216',
        'logo' => 'https://images.unsplash.com/photo-1555396273-367ea4eb4db5?w=150&auto=format&fit=crop&q=80',
        'imagen_portada' => 'https://images.unsplash.com/photo-1513104890138-7c749659a591?w=800&auto=format&fit=crop&q=80',
        'prods' => [
            ['Pizza Familiar Mixta (8 Porciones) a la Leña', 'Mitad Quesillo & Jamón, mitad Carnes Huilenses con borde de queso.', 42000, 'Pizza'],
            ['Hamburguesa Artesanal Doble Carne con Tocineta', 'Pan brioche, 250g de carne de res, queso fundido y papas rústicas.', 22000, 'Combo']
        ]
    ],
    [
        'id' => 22, 'categoria_id' => 15, 'sector_id' => 3,
        'nombre' => 'Asadero de Pollos & Broaster El Rey Yaguará',
        'slug' => 'asadero-de-pollos-y-broaster-el-rey-yaguara',
        'descripcion' => 'Pollo asado con adobo secreto campesino y pollo broaster extra crocante, acompañado de arepas, papa salada y plátano maduro con queso.',
        'direccion' => 'Calle 7 # 3-20, Barrio Las Ferias, Yaguará',
        'telefono' => '3142345678', 'whatsapp' => '3142345678',
        'verificado' => 1, 'destacado' => 0, 'visitas' => 390,
        'latitud' => '2.6618', 'longitud' => '-75.5195',
        'logo' => 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?w=150&auto=format&fit=crop&q=80',
        'imagen_portada' => 'https://images.unsplash.com/photo-1598515214211-89d3c73ae83b?w=800&auto=format&fit=crop&q=80',
        'prods' => [
            ['Combo Pollo Asado Completo + Gaseosa 1.5L', 'Pollo asado entero, 4 arepas, 4 papas y salsa tártara casera.', 38000, 'Combo'],
            ['Medio Pollo Broaster Crocante con Papas a la Francesa', '4 presas de pollo crocante con miel y salsas.', 22000, 'Medio']
        ]
    ],
    [
        'id' => 23, 'categoria_id' => 1, 'sector_id' => 2,
        'nombre' => 'Estadero & Restaurante Campestre Brisas de Betania',
        'slug' => 'estadero-y-restaurante-campestre-brisas-de-betania',
        'descripcion' => 'Restaurante típico con kioscos a orillas del embalse. Sancocho de gallina criolla campesina en leña y trucha al ajillo.',
        'direccion' => 'Sector La Playa Embalse de Betania, Yaguará',
        'telefono' => '3189012345', 'whatsapp' => '3189012345',
        'verificado' => 1, 'destacado' => 1, 'visitas' => 670,
        'latitud' => '2.6865', 'longitud' => '-75.4835',
        'logo' => 'https://images.unsplash.com/photo-1544005313-94ddf0286df2?w=150&auto=format&fit=crop&q=80',
        'imagen_portada' => 'https://images.unsplash.com/photo-1555396273-367ea4eb4db5?w=800&auto=format&fit=crop&q=80',
        'prods' => [
            ['Sancocho de Gallina Criolla en Fogón de Leña', 'Servido con presa gigante de gallina, arroz, aguacate y ensalada.', 30000, 'Plato'],
            ['Trucha Arcoíris Gratinada con Champiñones y Queso', 'Acompañada de patacón y ensalada fresca.', 36000, 'Plato']
        ]
    ],
    [
        'id' => 24, 'categoria_id' => 7, 'sector_id' => 1,
        'nombre' => 'Jugos Naturales & Frutería La Bendición Yaguará',
        'slug' => 'jugos-naturales-y-fruteria-la-bendicion-yaguara',
        'descripcion' => 'Jugos en agua y leche 100% fruta natural: borojó, maracuyá, lulo, guanábana, ensaladas de frutas gigantes con queso y helado.',
        'direccion' => 'Calle 5 # 5-18, Centro, Yaguará',
        'telefono' => '3125678901', 'whatsapp' => '3125678901',
        'verificado' => 1, 'destacado' => 0, 'visitas' => 240,
        'latitud' => '2.6626', 'longitud' => '-75.5210',
        'logo' => 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=150&auto=format&fit=crop&q=80',
        'imagen_portada' => 'https://images.unsplash.com/photo-1622597467836-f3285f2131b7?w=800&auto=format&fit=crop&q=80',
        'prods' => [
            ['Super Ensalada de Frutas con Quesillo y Helado', 'Papaya, manzana, banano, melón, crema especial, quesillo y bola de helado.', 14000, 'Porción'],
            ['Jugo Energético de Borojó con Leche y Miel', 'Vaso gigante preparado al instante.', 9000, 'Vaso']
        ]
    ],
    [
        'id' => 25, 'categoria_id' => 3, 'sector_id' => 7,
        'nombre' => 'Tienda Mi Ranchito Sector La Playa',
        'slug' => 'tienda-mi-ranchito-sector-la-playa',
        'descripcion' => 'Víveres, bebidas frías, hielo en bolsa, carbón para asados y todo lo necesario para los paseos de olla y campamentos en Betania.',
        'direccion' => 'Entrada Sector La Playa, Yaguará',
        'telefono' => '3168901234', 'whatsapp' => '3168901234',
        'verificado' => 1, 'destacado' => 0, 'visitas' => 190,
        'latitud' => '2.6840', 'longitud' => '-75.4860',
        'logo' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=150&auto=format&fit=crop&q=80',
        'imagen_portada' => 'https://images.unsplash.com/photo-1534723452862-4c874018d66d?w=800&auto=format&fit=crop&q=80',
        'prods' => [
            ['Bolsa de Hielo Cristalino x 3kg', 'Ideal para enfriar bebidas en paseos de olla.', 4500, 'Bolsa'],
            ['Bolsa de Carbón Vegetal para Asado x 3kg', 'Carbón seco de fácil encendido.', 8000, 'Bolsa']
        ]
    ],

    // 26 - 32: Servicios, Papelerías, Cabañas & Tradición
    [
        'id' => 26, 'categoria_id' => 5, 'sector_id' => 1,
        'nombre' => 'Plomería & Redes Hidráulicas El Tigre Yaguará',
        'slug' => 'plomeria-y-redes-hidraulicas-el-tigre-yaguara',
        'descripcion' => 'Destape de cañerías con sonda eléctrica, instalación de tanques elevados, motobombas, calentadores y griferías en todo Yaguará.',
        'direccion' => 'Carrera 2 # 4-15, Centro, Yaguará',
        'telefono' => '3108901234', 'whatsapp' => '3108901234',
        'verificado' => 1, 'destacado' => 0, 'visitas' => 170,
        'latitud' => '2.6630', 'longitud' => '-75.5235',
        'logo' => 'https://images.unsplash.com/photo-1560250097-0b93528c311a?w=150&auto=format&fit=crop&q=80',
        'imagen_portada' => 'https://images.unsplash.com/photo-1581244277943-fe4a9c777189?w=800&auto=format&fit=crop&q=80',
        'prods' => [
            ['Servicio de Destape de Cañería con Sonda', 'Atención rápida sin romper pisos ni paredes.', 50000, 'Servicio']
        ]
    ],
    [
        'id' => 27, 'categoria_id' => 14, 'sector_id' => 1,
        'nombre' => 'Papelería & Fotocopiadora Central Yaguará',
        'slug' => 'papeleria-y-fotocopiadora-central-yaguara',
        'descripcion' => 'Fotocopias, impresiones a color, laminación, útiles escolares, trámites en línea (RUT, antecedentes, certificados) y recargas.',
        'direccion' => 'Carrera 4 # 5-55, Centro, Yaguará',
        'telefono' => '3137890123', 'whatsapp' => '3137890123',
        'verificado' => 1, 'destacado' => 0, 'visitas' => 290,
        'latitud' => '2.6628', 'longitud' => '-75.5213',
        'logo' => 'https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?w=150&auto=format&fit=crop&q=80',
        'imagen_portada' => 'https://images.unsplash.com/photo-1588072432836-e10032774350?w=800&auto=format&fit=crop&q=80',
        'prods' => [
            ['Paquete de Hojas de Papel Bond Resma 500 Hojas', 'Papel reprograf para oficina y colegio.', 18000, 'Resma']
        ]
    ],
    [
        'id' => 28, 'categoria_id' => 8, 'sector_id' => 5,
        'nombre' => 'Llantas & Serviteca Rápida de Yaguará',
        'slug' => 'llantas-y-serviteca-rapida-de-yaguara',
        'descripcion' => 'Despinche de llantas de carro y moto, alineación, balanceo, venta de baterías y parches garantizados.',
        'direccion' => 'Salida a Campoalegre Km 1, Yaguará',
        'telefono' => '3153456789', 'whatsapp' => '3153456789',
        'verificado' => 1, 'destacado' => 0, 'visitas' => 230,
        'latitud' => '2.6660', 'longitud' => '-75.5250',
        'logo' => 'https://images.unsplash.com/photo-1492562080023-ab3db95bfbce?w=150&auto=format&fit=crop&q=80',
        'imagen_portada' => 'https://images.unsplash.com/photo-1486006920555-c77dce18193b?w=800&auto=format&fit=crop&q=80',
        'prods' => [
            ['Despinche y Calibración con Nitrógeno (Carro / Camioneta)', 'Despinche con mecha o parche vulcanizado al calor.', 15000, 'Servicio']
        ]
    ],
    [
        'id' => 29, 'categoria_id' => 6, 'sector_id' => 8,
        'nombre' => 'Glamping & Finca Agroturística El Remanso Huilense',
        'slug' => 'glamping-y-finca-agroturistica-el-remanso-huilense',
        'descripcion' => 'Domo geodésico de lujo con jacuzzi privado, fogata nocturna, avistamiento de aves y sendero al embalse.',
        'direccion' => 'Vereda Upar Vía al Embalse, Yaguará',
        'telefono' => '3114567890', 'whatsapp' => '3114567890',
        'verificado' => 1, 'destacado' => 1, 'visitas' => 890,
        'latitud' => '2.6750', 'longitud' => '-75.4950',
        'logo' => 'https://images.unsplash.com/photo-1544005313-94ddf0286df2?w=150&auto=format&fit=crop&q=80',
        'imagen_portada' => 'https://images.unsplash.com/photo-1587061949409-02df41d5e562?w=800&auto=format&fit=crop&q=80',
        'prods' => [
            ['Noche Domo Glamping Deluxe Pareja con Jacuzzi', 'Incluye cena especial, botella de vino y desayuno campesino.', 320000, 'Noche']
        ]
    ],
    [
        'id' => 30, 'categoria_id' => 1, 'sector_id' => 1,
        'nombre' => 'Fábrica de Quesillos & Lácteos Don Ramiro',
        'slug' => 'fabrica-de-quesillos-y-lacteos-don-ramiro',
        'descripcion' => 'Elaboración y venta por mayor y detal de quesillo huilense, doble crema, quesillo en hoja de bijao y cuajada salada.',
        'direccion' => 'Carrera 3 # 6-30, Centro, Yaguará',
        'telefono' => '3123456780', 'whatsapp' => '3123456780',
        'verificado' => 1, 'destacado' => 1, 'visitas' => 470,
        'latitud' => '2.6633', 'longitud' => '-75.5219',
        'logo' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=150&auto=format&fit=crop&q=80',
        'imagen_portada' => 'https://images.unsplash.com/photo-1486297678162-eb2a19b0a32d?w=800&auto=format&fit=crop&q=80',
        'prods' => [
            ['Bloque de Quesillo Yaguareño al Vacío (2.5 kg)', 'Presentación especial para viajeros y restaurantes.', 65000, 'Bloque'],
            ['Quesillo Individual en Hoja de Plátano (Libra)', 'Cuajada fresca de ordeño artesanal.', 13500, 'Libra']
        ]
    ],
    [
        'id' => 31, 'categoria_id' => 2, 'sector_id' => 4,
        'nombre' => 'Panadería y Pastelería La Espiga Dorada Yaguará',
        'slug' => 'panaderia-y-pasteleria-la-espiga-dorada-yaguara',
        'descripcion' => 'Tortas para cumpleaños personalizadas, brazo de reina, postres de tres leches, galletas de mantequilla y pan campesino.',
        'direccion' => 'Calle 10 # 6-40, Barrio Upar, Yaguará',
        'telefono' => '3165678901', 'whatsapp' => '3165678901',
        'verificado' => 1, 'destacado' => 0, 'visitas' => 250,
        'latitud' => '2.6590', 'longitud' => '-75.5220',
        'logo' => 'https://images.unsplash.com/photo-1535713875002-d1d0cf377fde?w=150&auto=format&fit=crop&q=80',
        'imagen_portada' => 'https://images.unsplash.com/photo-1578985545062-69928b1d9587?w=800&auto=format&fit=crop&q=80',
        'prods' => [
            ['Torta de Cumpleaños Tres Leches con Frutas (1 Libra)', 'Decorada con fresas, duraznos y chocolate.', 45000, 'Torta']
        ]
    ],
    [
        'id' => 32, 'categoria_id' => 15, 'sector_id' => 1,
        'nombre' => 'Comidas Rápidas & Parrilla Los Amigos Yaguará',
        'slug' => 'comidas-rapidas-y-parrilla-los-amigos-yaguara',
        'descripcion' => 'Perros calientes gigantes, salchipapas especiales con tocineta y queso fundido, mazorcadas y costillas BBQ al carbón.',
        'direccion' => 'Calle 6 # 3-10, Centro, Yaguará',
        'telefono' => '3148901234', 'whatsapp' => '3148901234',
        'verificado' => 1, 'destacado' => 0, 'visitas' => 310,
        'latitud' => '2.6635', 'longitud' => '-75.5210',
        'logo' => 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?w=150&auto=format&fit=crop&q=80',
        'imagen_portada' => 'https://images.unsplash.com/photo-1561758033-d89a9ad46330?w=800&auto=format&fit=crop&q=80',
        'prods' => [
            ['Salchipapa Especial Gigante Los Amigos (Para 2 Personas)', 'Papas a la francesa, salchicha premium, tocineta, queso y salsa show.', 26000, 'Plato'],
            ['Perro Caliente Suizo con Tocineta y Quesillo', 'Salchicha suiza, papita picada, tocineta y quesillo derretido.', 16000, 'Unidad']
        ]
    ]
];

$stmtNeg = $db->prepare("
    INSERT INTO negocios (id, usuario_id, categoria_id, sector_id, nombre, slug, descripcion, direccion, telefono, whatsapp, verificado, destacado, visitas, latitud, longitud, logo, imagen_portada, estado)
    VALUES (?, 1, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'activo')
");

$stmtProd = $db->prepare("
    INSERT INTO productos (negocio_id, nombre, descripcion, precio, unidad_medida, disponible)
    VALUES (?, ?, ?, ?, ?, 1)
");

$totalNegocios = 0;
$totalProductos = 0;

foreach ($negocios as $n) {
    $stmtNeg->execute([
        $n['id'],
        $n['categoria_id'],
        $n['sector_id'],
        $n['nombre'],
        $n['slug'],
        $n['descripcion'],
        $n['direccion'],
        $n['telefono'],
        $n['whatsapp'],
        $n['verificado'],
        $n['destacado'],
        $n['visitas'],
        $n['latitud'],
        $n['longitud'],
        $n['logo'],
        $n['imagen_portada']
    ]);
    $totalNegocios++;

    if (!empty($n['prods'])) {
        foreach ($n['prods'] as $p) {
            $stmtProd->execute([$n['id'], $p[0], $p[1], $p[2], $p[3]]);
            $totalProductos++;
        }
    }
}

echo "¡Se insertaron exitosamente 15 categorías, 8 sectores, {$totalNegocios} comercios reales y {$totalProductos} productos de catálogo para Yaguará, Huila!\n";
