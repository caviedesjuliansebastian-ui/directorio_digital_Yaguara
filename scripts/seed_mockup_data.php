<?php
require_once __DIR__ . '/../config/database.php';
$db = (new Database())->getConnection();

// Desactivar chequeo de foreign keys para limpiar ordenadamente
$db->exec("SET FOREIGN_KEY_CHECKS = 0");
$db->exec("TRUNCATE TABLE productos");
$db->exec("TRUNCATE TABLE resenas");
$db->exec("TRUNCATE TABLE horarios");
$db->exec("TRUNCATE TABLE favoritos");
$db->exec("TRUNCATE TABLE negocios");
$db->exec("SET FOREIGN_KEY_CHECKS = 1");

// Categorías
$categoriasMap = [
    'Comidas Típicas, Quesillos & Pescaderías' => 1,
    'Bizcochería, Achiras y Panaderías' => 2,
    'Tiendas de Barrio & Abarrotes' => 3,
    'Droguerías & Farmacias' => 4,
    'Electricistas & Motobombas' => 5,
];

// Sectores
$sectoresMap = [
    'Centro' => 1,
    'Malecón Betania' => 2,
    'Las Ferias' => 3,
    'Barrio Upar' => 4,
    'El Triunfo' => 5,
];

// 1. Insertar Negocios
$negocios = [
    [
        'id' => 1,
        'nombre' => 'Quesillos y Tradición Yaguareña Doña Stella',
        'slug' => 'quesillos-y-tradicion-yaguarena-dona-stella',
        'descripcion' => 'Más de 30 años elaborando el auténtico quesillo yaguareño envuelto en hoja de plátano con leche pura de ganado local...',
        'categoria_id' => 1,
        'sector_id' => 1,
        'direccion' => 'Carrera 4 # 5-20, Centro, Yaguará',
        'telefono' => '3124567890',
        'whatsapp' => '3124567890',
        'verificado' => 1,
        'destacado' => 1,
        'visitas' => 340,
        'latitud' => '2.6628',
        'longitud' => '-75.5215',
        'logo' => 'https://images.unsplash.com/photo-1544005313-94ddf0286df2?w=150&auto=format&fit=crop&q=80',
        'imagen_portada' => 'https://images.unsplash.com/photo-1555396273-367ea4eb4db5?w=800&auto=format&fit=crop&q=80',
        'calificacion' => 5.0,
        'total_resenas' => 94,
        'tiempo_resp' => '100% resp. (~3 min)'
    ],
    [
        'id' => 2,
        'nombre' => 'Pescadería & Estadero El Malecón de Betania',
        'slug' => 'pescaderia-y-estadero-el-malecon-de-betania',
        'descripcion' => 'Pescado fresco del Embalse de Betania. Especialistas en Mojarra Roja Frita crocante, Viudo de Capaz en salsa criolla...',
        'categoria_id' => 1,
        'sector_id' => 2,
        'direccion' => 'Malecón Turístico Embalse de Betania, Yaguará',
        'telefono' => '3157891234',
        'whatsapp' => '3157891234',
        'verificado' => 1,
        'destacado' => 1,
        'visitas' => 520,
        'latitud' => '2.6850',
        'longitud' => '-75.4850',
        'logo' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=150&auto=format&fit=crop&q=80',
        'imagen_portada' => 'https://images.unsplash.com/photo-1534422298391-e4f8c172dddb?w=800&auto=format&fit=crop&q=80',
        'calificacion' => 4.9,
        'total_resenas' => 118,
        'tiempo_resp' => '98% resp. (~5 min)'
    ],
    [
        'id' => 3,
        'nombre' => 'Asados & Tradición Huilense Don Pedro',
        'slug' => 'asados-y-tradicion-huilense-don-pedro',
        'descripcion' => 'Auténtico asado huilense horneado en tiesto de barro con insulso, arepa de choclo, tamales yaguareños y carnes al...',
        'categoria_id' => 1,
        'sector_id' => 3,
        'direccion' => 'Calle 8 # 3-15, Barrio Las Ferias, Yaguará',
        'telefono' => '3109876543',
        'whatsapp' => '3109876543',
        'verificado' => 1,
        'destacado' => 1,
        'visitas' => 280,
        'latitud' => '2.6610',
        'longitud' => '-75.5190',
        'logo' => 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?w=150&auto=format&fit=crop&q=80',
        'imagen_portada' => 'https://images.unsplash.com/photo-1544025162-d76694265947?w=800&auto=format&fit=crop&q=80',
        'calificacion' => 4.8,
        'total_resenas' => 76,
        'tiempo_resp' => '95% resp. (~8 min)'
    ],
    [
        'id' => 4,
        'nombre' => 'Bizcochería & Achiras La Yaguareñita',
        'slug' => 'bizcocheria-y-achiras-la-yaguarenita',
        'descripcion' => 'Las mejores Achiras de Yaguará horneadas con leña y cuajada pura campesina. Bizcochos de manteca, cucas, bizcochuelos...',
        'categoria_id' => 2,
        'sector_id' => 1,
        'direccion' => 'Carrera 5 # 4-10, Parque Principal, Yaguará',
        'telefono' => '3112345678',
        'whatsapp' => '3112345678',
        'verificado' => 1,
        'destacado' => 1,
        'visitas' => 410,
        'latitud' => '2.6635',
        'longitud' => '-75.5205',
        'logo' => 'https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?w=150&auto=format&fit=crop&q=80',
        'imagen_portada' => 'https://images.unsplash.com/photo-1509440159596-0249088772ff?w=800&auto=format&fit=crop&q=80',
        'calificacion' => 4.9,
        'total_resenas' => 82,
        'tiempo_resp' => '99% resp. (~4 min)'
    ],
    [
        'id' => 5,
        'nombre' => 'Panadería y Cafetería El Parque Yaguará',
        'slug' => 'panaderia-y-cafeteria-el-parque-yaguara',
        'descripcion' => 'Pan aliñado caliente a las 6:00 AM y 4:00 PM, pandebonos, buñuelos, empanadas de carne y pollo, desayunos y jugos...',
        'categoria_id' => 2,
        'sector_id' => 1,
        'direccion' => 'Esquina Parque Principal, Yaguará',
        'telefono' => '3145678901',
        'whatsapp' => '3145678901',
        'verificado' => 1,
        'destacado' => 0,
        'visitas' => 190,
        'latitud' => '2.6630',
        'longitud' => '-75.5210',
        'logo' => 'https://images.unsplash.com/photo-1519085360753-af0119f7cbe7?w=150&auto=format&fit=crop&q=80',
        'imagen_portada' => 'https://images.unsplash.com/photo-1555507036-ab1f4038808a?w=800&auto=format&fit=crop&q=80',
        'calificacion' => 4.8,
        'total_resenas' => 45,
        'tiempo_resp' => '95% resp. (~6 min)'
    ],
    [
        'id' => 6,
        'nombre' => 'Supertienda y Abarrotes El Triunfo de Yaguará',
        'slug' => 'supertienda-y-abarrotes-el-triunfo-de-yaguara',
        'descripcion' => 'Todo para el mercado del hogar en Yaguará: víveres, arroz de Campoalegre, panela, aceite, huevos campesinos, gaseosas...',
        'categoria_id' => 3,
        'sector_id' => 5,
        'direccion' => 'Calle Principal Barrio El Triunfo, Yaguará',
        'telefono' => '3161234567',
        'whatsapp' => '3161234567',
        'verificado' => 1,
        'destacado' => 1,
        'visitas' => 310,
        'latitud' => '2.6645',
        'longitud' => '-75.5230',
        'logo' => 'https://images.unsplash.com/photo-1492562080023-ab3db95bfbce?w=150&auto=format&fit=crop&q=80',
        'imagen_portada' => 'https://images.unsplash.com/photo-1578916171728-46686eac8d58?w=800&auto=format&fit=crop&q=80',
        'calificacion' => 4.9,
        'total_resenas' => 68,
        'tiempo_resp' => '98% resp. (~5 min)'
    ],
    [
        'id' => 7,
        'nombre' => 'Minimarket Los Ganaderos Yaguará',
        'slug' => 'minimarket-los-ganaderos-yaguara',
        'descripcion' => 'Frutas, verduras frescas que llegan de la vega, carnes frías, helados, bebidas y recargas a todo operador.',
        'categoria_id' => 3,
        'sector_id' => 4,
        'direccion' => 'Carrera 7 # 8-30, Barrio Upar, Yaguará',
        'telefono' => '3187654321',
        'whatsapp' => '3187654321',
        'verificado' => 1,
        'destacado' => 0,
        'visitas' => 160,
        'latitud' => '2.6600',
        'longitud' => '-75.5240',
        'logo' => 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=150&auto=format&fit=crop&q=80',
        'imagen_portada' => 'https://images.unsplash.com/photo-1542838132-92c53300491e?w=800&auto=format&fit=crop&q=80',
        'calificacion' => 4.7,
        'total_resenas' => 39,
        'tiempo_resp' => '94% resp. (~7 min)'
    ],
    [
        'id' => 8,
        'nombre' => 'Droguería La Principal de Yaguará',
        'slug' => 'drogueria-la-principal-de-yaguara',
        'descripcion' => 'Farmacia de confianza en Yaguará. Despacho de fórmulas, inyectología certificada, toma de presión arterial, sueros orales...',
        'categoria_id' => 4,
        'sector_id' => 1,
        'direccion' => 'Calle 5 # 4-40, Centro, Yaguará',
        'telefono' => '3139871234',
        'whatsapp' => '3139871234',
        'verificado' => 1,
        'destacado' => 1,
        'visitas' => 290,
        'latitud' => '2.6625',
        'longitud' => '-75.5212',
        'logo' => 'https://images.unsplash.com/photo-1559839734-2b71ea197ec2?w=150&auto=format&fit=crop&q=80',
        'imagen_portada' => 'https://images.unsplash.com/photo-1586015555751-63bb77f4322a?w=800&auto=format&fit=crop&q=80',
        'calificacion' => 4.9,
        'total_resenas' => 73,
        'tiempo_resp' => '99% resp. (~3 min)'
    ],
    [
        'id' => 9,
        'nombre' => 'Farmacia San José Yaguará',
        'slug' => 'farmacia-san-jose-yaguara',
        'descripcion' => 'Medicamentos genéricos y de marca, pañales, leche de fórmula y artículos de aseo para bebés y adultos.',
        'categoria_id' => 4,
        'sector_id' => 4,
        'direccion' => 'Carrera 6 # 9-10, Barrio Upar, Yaguará',
        'telefono' => '3176543210',
        'whatsapp' => '3176543210',
        'verificado' => 1,
        'destacado' => 0,
        'visitas' => 140,
        'latitud' => '2.6595',
        'longitud' => '-75.5225',
        'logo' => 'https://images.unsplash.com/photo-1622253692010-333f2da6031d?w=150&auto=format&fit=crop&q=80',
        'imagen_portada' => 'https://images.unsplash.com/photo-1631549916768-4119b2e5f926?w=800&auto=format&fit=crop&q=80',
        'calificacion' => 4.7,
        'total_resenas' => 31,
        'tiempo_resp' => '93% resp. (~8 min)'
    ]
];

$stmt = $db->prepare("
    INSERT INTO negocios (id, usuario_id, categoria_id, sector_id, nombre, slug, descripcion, direccion, telefono, whatsapp, verificado, destacado, visitas, latitud, longitud, logo, imagen_portada, estado)
    VALUES (?, 6, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'activo')
");

foreach ($negocios as $n) {
    $stmt->execute([
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
}

// 2. Insertar Productos de Catálogo Reales
$productos = [
    // 1: Quesillos Doña Stella
    [1, 'Quesillo Yaguareño Tradicional (Libra)', 'Elaborado diariamente con cuajada fresca de las fincas yaguareñas.', 14000, 'Libra'],
    [1, 'Combo Yaguareño: Quesillo + Achiras + Kumis', 'El trío típico por excelencia para disfrutar o llevar de regalo.', 22000, 'Combo'],

    // 2: Pescadería El Malecón
    [2, 'Mojarra Roja Frita de Betania (1.5 lb)', 'Pescado frito crocante servido con patacón gigante, arroz con coco y ensalada.', 32000, 'Plato'],
    [2, 'Viudo de Pescado Criollo con Yuca y Plátano', 'Pescado cocido en caldo espeso con hogao de cebolla y tomate.', 34000, 'Plato'],

    // 3: Asados Don Pedro
    [3, 'Plato de Asado Huilense con Insulso', 'Cerdo marinado con hierbas de la huerta, horneado en tiesto y acompañado de insulso.', 28000, 'Plato'],

    // 4: Achiras La Yaguareñita
    [4, 'Lata de Achiras Tradicionales Yaguará (500g)', 'Empacadas en lata metálica sellada para conservar la frescura y textura crocante.', 20000, 'Lata'],
    [4, 'Bolsa de Bizcocho de Cuajada (250g)', 'Deliciosos bizcochos hechos con receta tradicional de la abuela.', 8000, 'Bolsa'],

    // 5: Panadería El Parque
    [5, 'Pan Aliñado Caliente', 'Pan suave con queso y mantequilla salido del horno a las 6am y 4pm.', 2500, 'Unidad'],
    [5, 'Pandebono Campesino', 'Masa suave de almidón de yuca y queso fresco.', 2000, 'Unidad'],

    // 6: Supertienda El Triunfo
    [6, 'Cubeta de Huevos Criollos AA x30', 'Huevos frescos de gallina de campo de fincas locales.', 18000, 'Cubeta'],
    [6, 'Arroz Campoalegre Diana 1kg', 'Arroz de primera calidad cultivado en la cuenca del río Neiva.', 4200, 'Kilo'],

    // 7: Minimarket Los Ganaderos
    [7, 'Queso Semisalado Campesino (Libra)', 'Queso fresco artesanal de ordeño diario.', 9000, 'Libra'],
    [7, 'Bolsa de Leche Fresca Entera 1L', 'Pasteurizada y lista para consumir.', 3800, 'Litro'],

    // 8: Droguería La Principal
    [8, 'Suero Oral Electrolit Fresa 625ml', 'Solución rehidratante oral para toda la familia.', 8500, 'Frasco'],

    // 9: Farmacia San José
    [9, 'Acetaminofén 500mg MK x 100', 'Caja de 100 tabletas para alivio del dolor y la fiebre.', 12000, 'Caja'],
    [9, 'Pañales Etapa 3 x 30', 'Pañales absorbentes y suaves para bebés.', 26000, 'Paquete']
];

$stmtProd = $db->prepare("
    INSERT INTO productos (negocio_id, nombre, descripcion, precio, unidad_medida, disponible)
    VALUES (?, ?, ?, ?, ?, 1)
");

foreach ($productos as $p) {
    $stmtProd->execute([$p[0], $p[1], $p[2], $p[3], $p[4]]);
}

echo "¡Se han insertado " . count($negocios) . " negocios y " . count($productos) . " productos del catálogo idénticos a los mockups!\n";
