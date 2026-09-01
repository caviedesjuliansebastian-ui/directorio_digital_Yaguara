<?php
// ============================================================
// SCRIPT SEEDER: 30 PRODUCTOS REALISTAS CON IMÁGENES POR CADA CATEGORÍA / SERVICIO DE YAGUARÁ
// ============================================================

require_once __DIR__ . '/../config/database.php';

try {
    $db = new Database();
    $conn = $db->getConnection();
    $conn->exec("SET NAMES utf8mb4");

    // Limpiar tabla productos actual
    $conn->exec("TRUNCATE TABLE productos");
    echo "Tabla 'productos' vaciada con éxito.\n";

    // Obtener negocios por categoría
    $stmt = $conn->query("SELECT id, categoria_id, nombre FROM negocios ORDER BY categoria_id, id");
    $negociosPorCat = [];
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $negociosPorCat[$row['categoria_id']][] = $row['id'];
    }

    // Definición de 30 productos por cada una de las 15 categorías
    $catalogoPorCategoria = [
        // ==========================================
        // 1. Comidas Típicas, Quesillos & Pescaderías
        // ==========================================
        1 => [
            [
                'nombre' => 'Quesillo Yaguareño Tradicional en Hoja de Plátano (Libra)',
                'descripcion' => 'Auténtico quesillo yaguareño elaborado con cuajada pura de leche fresca de fincas locales, envuelto artesanalmente en hoja de plátano verde.',
                'precio' => 15000,
                'unidad_medida' => 'Libra',
                'foto' => 'https://images.unsplash.com/photo-1589881133595-a3c085cb731d?w=600&auto=format&fit=crop&q=80'
            ],
            [
                'nombre' => 'Quesillo Especial Bloque Familiar (1 Kilogramo)',
                'descripcion' => 'Quesillo tradicional de pasta hilada suave y textura elástica perfecta, ideal para compartir en familia o llevar de recuerdo típico.',
                'precio' => 28000,
                'unidad_medida' => 'Kilo',
                'foto' => 'https://images.unsplash.com/photo-1624806992066-5ffcf7ca186b?w=600&auto=format&fit=crop&q=80'
            ],
            [
                'nombre' => 'Combo Yaguareño: Quesillo + Achiras + Kumis Artesanal',
                'descripcion' => 'La combinación reina de Yaguará: media libra de quesillo fresco, bolsa de achiras de cuajada y botella de kumis casero.',
                'precio' => 24000,
                'unidad_medida' => 'Combo',
                'foto' => 'https://images.unsplash.com/photo-1528735602780-2552fd46c7af?w=600&auto=format&fit=crop&q=80'
            ],
            [
                'nombre' => 'Mojarra Roja Frita Gigante de Betania (1.5 Libras)',
                'descripcion' => 'Pescado fresco del Embalse de Betania, frito crocante al punto y servido con patacón gigante, arroz con coco y ensalada huilense.',
                'precio' => 36000,
                'unidad_medida' => 'Plato',
                'foto' => 'https://images.unsplash.com/photo-1534422298391-e4f8c172dddb?w=600&auto=format&fit=crop&q=80'
            ],
            [
                'nombre' => 'Viudo de Capaz de Betania en Salsa Criolla',
                'descripcion' => 'Pescado capaz cocido al vapor en hogao criollo con cebolla larga, tomate maduro, yuca harinosa y plátano verde de la vega.',
                'precio' => 38000,
                'unidad_medida' => 'Plato',
                'foto' => 'https://images.unsplash.com/photo-1544025162-d76694265947?w=600&auto=format&fit=crop&q=80'
            ],
            [
                'nombre' => 'Sancocho de Pescado con Bagre del Magdalena y Betania',
                'descripcion' => 'Caldo espeso y reconfortante con trozos generosos de bagre de río, mazorca tierna, plátano, yuca y cilantro cimarrón.',
                'precio' => 30000,
                'unidad_medida' => 'Plato',
                'foto' => 'https://images.unsplash.com/photo-1547592166-23ac45744acd?w=600&auto=format&fit=crop&q=80'
            ],
            [
                'nombre' => 'Mojarra Roja Sudada a la Criolla con Hogao Campesino',
                'descripcion' => 'Mojarra jugosa cocinada a fuego lento en reducción de tomate de árbol, hierbas de azotea y leche de coco.',
                'precio' => 34000,
                'unidad_medida' => 'Plato',
                'foto' => 'https://images.unsplash.com/photo-1519708227418-c8fd9a32b7a2?w=600&auto=format&fit=crop&q=80'
            ],
            [
                'nombre' => 'Ceviche de Tilapia Roja Fresca de Betania',
                'descripcion' => 'Cubos de tilapia marinados en jugo de limón recién exprimido, cebolla morada, cilantro y servido con chips de plátano verde.',
                'precio' => 22000,
                'unidad_medida' => 'Plato',
                'foto' => 'https://images.unsplash.com/photo-1535400255456-984241443b29?w=600&auto=format&fit=crop&q=80'
            ],
            [
                'nombre' => 'Filete de Tilapia al Ajillo con Mantequilla de Campo',
                'descripcion' => 'Suave filete sin espinas dorado a la plancha bañado en cremosa salsa de ajo asado y perejil fresco con patacones.',
                'precio' => 32000,
                'unidad_medida' => 'Plato',
                'foto' => 'https://images.unsplash.com/photo-1519708227418-c8fd9a32b7a2?w=600&auto=format&fit=crop&q=80'
            ],
            [
                'nombre' => 'Plato Tradicional de Asado Huilense con Insulso',
                'descripcion' => 'Carne de cerdo marinada con poleo, orégano y cerveza, asada en tiesto de barro y acompañada de insulso y arepa orejeperro.',
                'precio' => 32000,
                'unidad_medida' => 'Plato',
                'foto' => 'https://images.unsplash.com/photo-1555939594-58d7cb561ad1?w=600&auto=format&fit=crop&q=80'
            ],
            [
                'nombre' => 'Tamal Yaguareño Especial con Pollo, Cerdo y Huevo',
                'descripcion' => 'Masa sazonada de arroz y arveja amarilla con presa de pollo campesino, tocino de cerdo y huevo duro, envuelto en hoja de achira.',
                'precio' => 12000,
                'unidad_medida' => 'Unidad',
                'foto' => 'https://images.unsplash.com/photo-1628294895950-9805252327bc?w=600&auto=format&fit=crop&q=80'
            ],
            [
                'nombre' => 'Insulso Huilense Dulce de Maíz y Panela (Porción x4)',
                'descripcion' => 'Acompañamiento típico a base de harina de maíz cocida con panela de caña y canela, envuelto en hojas de plátano.',
                'precio' => 8000,
                'unidad_medida' => 'Porción',
                'foto' => 'https://images.unsplash.com/photo-1509440159596-0249088772ff?w=600&auto=format&fit=crop&q=80'
            ],
            [
                'nombre' => 'Arepas Orejeperro de Arroz Tradicionales (Paquete x10)',
                'descripcion' => 'Arepas delgadas y crocantes de masa de arroz remojado y queso molido, asadas a la brasa sin grasa añadida.',
                'precio' => 10000,
                'unidad_medida' => 'Paquete',
                'foto' => 'https://images.unsplash.com/photo-1565299585323-38d6b0865b47?w=600&auto=format&fit=crop&q=80'
            ],
            [
                'nombre' => 'Costillas de Cerdo Ahumadas en Leña Yaguareña (400g)',
                'descripcion' => 'Costillas jugosas marinadas durante 24 horas y ahumadas lentamente con leña de guayabo y naranja.',
                'precio' => 36000,
                'unidad_medida' => 'Plato',
                'foto' => 'https://images.unsplash.com/photo-1544025162-d76694265947?w=600&auto=format&fit=crop&q=80'
            ],
            [
                'nombre' => 'Sancocho de Gallina Criolla Campesina de Finca',
                'descripcion' => 'Preparado con gallina campesina criada libre en las veredas de Yaguará, con plátano verde, yuca fresca y mazorca.',
                'precio' => 28000,
                'unidad_medida' => 'Plato',
                'foto' => 'https://images.unsplash.com/photo-1604908176997-125f25cc6f3d?w=600&auto=format&fit=crop&q=80'
            ],
            [
                'nombre' => 'Bagre Frito en Salsa de Coco y Ajo Criollo',
                'descripcion' => 'Rodaja gruesa de bagre fresco dorada y bañada en reducción suave de coco con patacón pisao.',
                'precio' => 38000,
                'unidad_medida' => 'Plato',
                'foto' => 'https://images.unsplash.com/photo-1534422298391-e4f8c172dddb?w=600&auto=format&fit=crop&q=80'
            ],
            [
                'nombre' => 'Picada Campestre Mixta Huilense (Para 2-3 Personas)',
                'descripcion' => 'Generosa picada con asado huilense, chicharrón crocante, longaniza casera, papas criollas, patacón y ají de aguacate.',
                'precio' => 48000,
                'unidad_medida' => 'Plato',
                'foto' => 'https://images.unsplash.com/photo-1555939594-58d7cb561ad1?w=600&auto=format&fit=crop&q=80'
            ],
            [
                'nombre' => 'Quesillo Picado con Dulce de Guayaba y Arequipe',
                'descripcion' => 'Postre tradicional yaguareño que combina el toque salado del quesillo con la dulzura del dulce de guayaba de la región.',
                'precio' => 12000,
                'unidad_medida' => 'Porción',
                'foto' => 'https://images.unsplash.com/photo-1589881133595-a3c085cb731d?w=600&auto=format&fit=crop&q=80'
            ],
            [
                'nombre' => 'Cuajada Fresca de Finca con Melao de Panela Negra',
                'descripcion' => 'Cuajada artesanal del día bañada en melado espeso de panela orgánica aromatizado con clavos y hojas de naranjo.',
                'precio' => 10000,
                'unidad_medida' => 'Porción',
                'foto' => 'https://images.unsplash.com/photo-1624806992066-5ffcf7ca186b?w=600&auto=format&fit=crop&q=80'
            ],
            [
                'nombre' => 'Queso Asadero Huilense en Bloque (Libra)',
                'descripcion' => 'Queso semi-graso ideal para asar a la plancha, no se derrite por completo y adquiere una costra dorada exquisita.',
                'precio' => 16000,
                'unidad_medida' => 'Libra',
                'foto' => 'https://images.unsplash.com/photo-1486297678162-eb2a19b0a32d?w=600&auto=format&fit=crop&q=80'
            ],
            [
                'nombre' => 'Porción de Chicharrón Carnudo Crocante con Patacones',
                'descripcion' => 'Tocino seleccionado frito en su propia grasa hasta alcanzar textura crocante con patacones de plátano verde.',
                'precio' => 20000,
                'unidad_medida' => 'Plato',
                'foto' => 'https://images.unsplash.com/photo-1544025162-d76694265947?w=600&auto=format&fit=crop&q=80'
            ],
            [
                'nombre' => 'Cazuela de Mariscos y Pescado de Betania',
                'descripcion' => 'Cremosa cazuela gratinada con filete de pescado fresco, camarones, pimientos y hierbas aromáticas.',
                'precio' => 42000,
                'unidad_medida' => 'Plato',
                'foto' => 'https://images.unsplash.com/photo-1547592166-23ac45744acd?w=600&auto=format&fit=crop&q=80'
            ],
            [
                'nombre' => 'Trucha Asada al Carbón con Mantequilla de Ajo',
                'descripcion' => 'Trucha mariposa fresca asada a la brasa con toques de limón mandarina, patacón y ensalada fresca.',
                'precio' => 35000,
                'unidad_medida' => 'Plato',
                'foto' => 'https://images.unsplash.com/photo-1519708227418-c8fd9a32b7a2?w=600&auto=format&fit=crop&q=80'
            ],
            [
                'nombre' => 'Filete de Bagre a la Plancha con Yuca al Vapor',
                'descripcion' => 'Filete tierno a la plancha servido con yuca blanca campesina y ensalada de aguacate con tomate chonto.',
                'precio' => 34000,
                'unidad_medida' => 'Plato',
                'foto' => 'https://images.unsplash.com/photo-1534422298391-e4f8c172dddb?w=600&auto=format&fit=crop&q=80'
            ],
            [
                'nombre' => 'Kumis Casero Artesanal Yaguareño (Botella 1 Litro)',
                'descripcion' => 'Bebida láctea fermentada tradicional con leche entera de vaca, textura cremosa y sabor equilibrado.',
                'precio' => 9000,
                'unidad_medida' => 'Litro',
                'foto' => 'https://images.unsplash.com/photo-1571115177098-24ec42ed204d?w=600&auto=format&fit=crop&q=80'
            ],
            [
                'nombre' => 'Yogur Natural Artesanal de Finca (Litro con Fruta Real)',
                'descripcion' => 'Yogur probiótico espeso preparado con leche de hatos yaguareños con trozos de mora, maracuyá o melocotón.',
                'precio' => 11000,
                'unidad_medida' => 'Litro',
                'foto' => 'https://images.unsplash.com/photo-1563636619-e9143da7973b?w=600&auto=format&fit=crop&q=80'
            ],
            [
                'nombre' => 'Arequipe de Leche Pura de Ganado Yaguareño (Vaso 250g)',
                'descripcion' => 'Dulce de leche cocinado lentamente en paila de cobre con azúcar morena y toque de canela.',
                'precio' => 8500,
                'unidad_medida' => 'Vaso',
                'foto' => 'https://images.unsplash.com/photo-1589881133595-a3c085cb731d?w=600&auto=format&fit=crop&q=80'
            ],
            [
                'nombre' => 'Mojarra Gratinada con Queso Huilense y Camarones',
                'descripcion' => 'Mojarra frita cubierta con salsa bechamel de la casa, camarones y queso campesino gratinado al horno.',
                'precio' => 44000,
                'unidad_medida' => 'Plato',
                'foto' => 'https://images.unsplash.com/photo-1534422298391-e4f8c172dddb?w=600&auto=format&fit=crop&q=80'
            ],
            [
                'nombre' => 'Caldo de Pescado Mañanero Revitalizante',
                'descripcion' => 'Consomé concentrado de cabeza y espinazo de mojarra y bagre con plátano y cilantro fresco, ideal para iniciar el día.',
                'precio' => 16000,
                'unidad_medida' => 'Plato',
                'foto' => 'https://images.unsplash.com/photo-1547592166-23ac45744acd?w=600&auto=format&fit=crop&q=80'
            ],
            [
                'nombre' => 'Plato Mixto Malecón: Media Mojarra + Asado Huilense + Insulso',
                'descripcion' => 'Lo mejor de dos mundos: media mojarra roja frita de Betania y generosa porción de asado huilense con insulso y patacón.',
                'precio' => 46000,
                'unidad_medida' => 'Plato',
                'foto' => 'https://images.unsplash.com/photo-1555939594-58d7cb561ad1?w=600&auto=format&fit=crop&q=80'
            ]
        ],

        // ==========================================
        // 2. Bizcochería, Achiras y Panaderías
        // ==========================================
        2 => [
            [
                'nombre' => 'Lata Metálica de Achiras Tradicionales de Yaguará (500g)',
                'descripcion' => 'Genuinas achiras huilenses elaboradas con almidón de sagú y cuajada pura, horneadas en lata hermética sellada.',
                'precio' => 22000,
                'unidad_medida' => 'Lata',
                'foto' => 'https://images.unsplash.com/photo-1509440159596-0249088772ff?w=600&auto=format&fit=crop&q=80'
            ],
            [
                'nombre' => 'Paquete de Achiras Artesanales de Cuajada (250g)',
                'descripcion' => 'Achiras crocantes horneadas con leña siguiendo la receta centenaria de las bizcocheras de Yaguará.',
                'precio' => 12000,
                'unidad_medida' => 'Paquete',
                'foto' => 'https://images.unsplash.com/photo-1555507036-ab1f4038808a?w=600&auto=format&fit=crop&q=80'
            ],
            [
                'nombre' => 'Bizcocho de Cuajada Tostado Tradicional (Paquete 300g)',
                'descripcion' => 'Bizcocho tostado elaborado con harina de maíz criollo y cuajada fresca, perfecto para tomar con chocolate o café.',
                'precio' => 10000,
                'unidad_medida' => 'Paquete',
                'foto' => 'https://images.unsplash.com/photo-1509440159596-0249088772ff?w=600&auto=format&fit=crop&q=80'
            ],
            [
                'nombre' => 'Bizcocho de Manteca de Cerdo Horneado en Tiesto (Bolsa x12)',
                'descripcion' => 'Bizcochitos tradicionales con textura arenosa y suave sabor criollo, horneados en hornos de barro.',
                'precio' => 9000,
                'unidad_medida' => 'Bolsa',
                'foto' => 'https://images.unsplash.com/photo-1517433670267-08bbd4be890f?w=600&auto=format&fit=crop&q=80'
            ],
            [
                'nombre' => 'Cucas Huilenses con Panela Negra y Especias (Paquete x6)',
                'descripcion' => 'Galletas suaves y esponjosas endulzadas con miel de panela orgánica, canela y clavos de olor.',
                'precio' => 7500,
                'unidad_medida' => 'Paquete',
                'foto' => 'https://images.unsplash.com/photo-1558961363-fa8fdf82db35?w=600&auto=format&fit=crop&q=80'
            ],
            [
                'nombre' => 'Bizcochuelo Huilense Esponjoso Tradicional',
                'descripcion' => 'Torta esponjosa tradicional de las fiestas de San Pedro, elaborada a base de huevos de campo batidos y aguardiente.',
                'precio' => 14000,
                'unidad_medida' => 'Unidad',
                'foto' => 'https://images.unsplash.com/photo-1578985545062-69928b1d9587?w=600&auto=format&fit=crop&q=80'
            ],
            [
                'nombre' => 'Pandebono Campesino Recién Horneado',
                'descripcion' => 'Masa suave de almidón de yuca, queso costeño/huilense y maíz, horneado caliente cada 20 minutos.',
                'precio' => 2500,
                'unidad_medida' => 'Unidad',
                'foto' => 'https://images.unsplash.com/photo-1586985289688-ca3cf47d3e6e?w=600&auto=format&fit=crop&q=80'
            ],
            [
                'nombre' => 'Pan Aliñado Especial con Queso Doble Crema',
                'descripcion' => 'Pan trenzado con generosa mantequilla de campo y queso derretido en su interior, corteza dorada.',
                'precio' => 3500,
                'unidad_medida' => 'Unidad',
                'foto' => 'https://images.unsplash.com/photo-1509440159596-0249088772ff?w=600&auto=format&fit=crop&q=80'
            ],
            [
                'nombre' => 'Buñuelo Crocante Gigante de Queso Costeño',
                'descripcion' => 'Buñuelo redondo y esponjoso con cubierta crocante y centro suave, preparado con mezcla de quesos frescos.',
                'precio' => 2500,
                'unidad_medida' => 'Unidad',
                'foto' => 'https://images.unsplash.com/photo-1541696490-8744a5dc0228?w=600&auto=format&fit=crop&q=80'
            ],
            [
                'nombre' => 'Empanada de Carne Desmechada con Papa Criolla y Ají',
                'descripcion' => 'Empanada crocante de masa de maíz amarillo rellena de carne de res mechada con hogao y papa criolla.',
                'precio' => 3000,
                'unidad_medida' => 'Unidad',
                'foto' => 'https://images.unsplash.com/photo-1628294895950-9805252327bc?w=600&auto=format&fit=crop&q=80'
            ],
            [
                'nombre' => 'Empanada de Pollo Guisado y Arroz Campesino',
                'descripcion' => 'Empanada frita al momento con pechuga de pollo desmenuzada y arroz sazonado.',
                'precio' => 3000,
                'unidad_medida' => 'Unidad',
                'foto' => 'https://images.unsplash.com/photo-1628294895950-9805252327bc?w=600&auto=format&fit=crop&q=80'
            ],
            [
                'nombre' => 'Torta Casera de Guanábana Yaguareña (Porción)',
                'descripcion' => 'Torta húmeda elaborada con pulpa fresca de guanábana cultivada en las vegas de Yaguará y crema de leche.',
                'precio' => 7000,
                'unidad_medida' => 'Porción',
                'foto' => 'https://images.unsplash.com/photo-1578985545062-69928b1d9587?w=600&auto=format&fit=crop&q=80'
            ],
            [
                'nombre' => 'Torta Tres Leches Tradicional con Canela (Porción)',
                'descripcion' => 'Bizcocho bañado en mezcla de leche condensada, crema de leche y leche entera con merengue suizo.',
                'precio' => 8000,
                'unidad_medida' => 'Porción',
                'foto' => 'https://images.unsplash.com/photo-1535141192574-5d4897c13136?w=600&auto=format&fit=crop&q=80'
            ],
            [
                'nombre' => 'Pan de Yuca Caliente de Horno de Leña',
                'descripcion' => 'Panecillo esponjoso elaborado con almidón de yuca agrio y abundante queso rallado.',
                'precio' => 2800,
                'unidad_medida' => 'Unidad',
                'foto' => 'https://images.unsplash.com/photo-1586985289688-ca3cf47d3e6e?w=600&auto=format&fit=crop&q=80'
            ],
            [
                'nombre' => 'Croissant de Mantequilla Relleno de Jamón y Queso',
                'descripcion' => 'Hojaldre francés crujiente y suave por dentro con jamón de cerdo seleccionado y queso mozzarella.',
                'precio' => 5500,
                'unidad_medida' => 'Unidad',
                'foto' => 'https://images.unsplash.com/photo-1555507036-ab1f4038808a?w=600&auto=format&fit=crop&q=80'
            ],
            [
                'nombre' => 'Almojábana Huilense Caliente de Puro Maíz y Cuajada',
                'descripcion' => 'Pastelito horneado tradicional de masa de maíz poroso con cuajada campesina y toque de azúcar.',
                'precio' => 3000,
                'unidad_medida' => 'Unidad',
                'foto' => 'https://images.unsplash.com/photo-1509440159596-0249088772ff?w=600&auto=format&fit=crop&q=80'
            ],
            [
                'nombre' => 'Rosquillas de Sagú Artesanales Tostadas (Paquete 200g)',
                'descripcion' => 'Rosquitas crocantes libres de gluten elaboradas con almidón de sagú y queso seco.',
                'precio' => 8000,
                'unidad_medida' => 'Paquete',
                'foto' => 'https://images.unsplash.com/photo-1555507036-ab1f4038808a?w=600&auto=format&fit=crop&q=80'
            ],
            [
                'nombre' => 'Pan Integral de Semillas y Miel de Abejas Local',
                'descripcion' => 'Pan saludable con harina integral 100%, semillas de chía, linaza, girasol y miel pura de apiarios yaguareños.',
                'precio' => 6500,
                'unidad_medida' => 'Unidad',
                'foto' => 'https://images.unsplash.com/photo-1509440159596-0249088772ff?w=600&auto=format&fit=crop&q=80'
            ],
            [
                'nombre' => 'Pastel de Pollo y Champiñones Hojaldrado',
                'descripcion' => 'Hojaldre horneado relleno de pechuga de pollo en crema y champiñones frescos salteados.',
                'precio' => 5000,
                'unidad_medida' => 'Unidad',
                'foto' => 'https://images.unsplash.com/photo-1555507036-ab1f4038808a?w=600&auto=format&fit=crop&q=80'
            ],
            [
                'nombre' => 'Pastel de Carne y Huevo Hojaldrado',
                'descripcion' => 'Pastel hojaldrado relleno de carne molida sazonada y huevo duro con especias finas.',
                'precio' => 5000,
                'unidad_medida' => 'Unidad',
                'foto' => 'https://images.unsplash.com/photo-1555507036-ab1f4038808a?w=600&auto=format&fit=crop&q=80'
            ],
            [
                'nombre' => 'Donas Glaseadas de Chocolate y Arequipe (Caja x4)',
                'descripcion' => 'Donas suaves esponjosas fritas y cubiertas con cobertura de chocolate semiamargo y arequipe.',
                'precio' => 14000,
                'unidad_medida' => 'Caja',
                'foto' => 'https://images.unsplash.com/photo-1551024709-8f23befc6f87?w=600&auto=format&fit=crop&q=80'
            ],
            [
                'nombre' => 'Pan Trenza Dulce con Bocadillo y Queso Fundido',
                'descripcion' => 'Pan dulce grande relleno con tiras de dulce de guayaba veleño y queso blanco cremoso.',
                'precio' => 8000,
                'unidad_medida' => 'Unidad',
                'foto' => 'https://images.unsplash.com/photo-1509440159596-0249088772ff?w=600&auto=format&fit=crop&q=80'
            ],
            [
                'nombre' => 'Tarta de Manzana y Canela Casera (Porción)',
                'descripcion' => 'Masa quebrada rellena de láminas de manzana caramelizadas con canela molida y azúcar morena.',
                'precio' => 7500,
                'unidad_medida' => 'Porción',
                'foto' => 'https://images.unsplash.com/photo-1535141192574-5d4897c13136?w=600&auto=format&fit=crop&q=80'
            ],
            [
                'nombre' => 'Galletas de Avena y Miel Artesanal (Paquete x6)',
                'descripcion' => 'Galletas crujientes y nutritivas con hojuelas de avena entera, uvas pasas y miel de abejas.',
                'precio' => 6000,
                'unidad_medida' => 'Paquete',
                'foto' => 'https://images.unsplash.com/photo-1499636136210-6f4ee915583e?w=600&auto=format&fit=crop&q=80'
            ],
            [
                'nombre' => 'Brazo de Reina Relleno de Fresa y Crema Chantilly',
                'descripcion' => 'Rollo de bizcochuelo suave espolvoreado con azúcar micropulverizada y fresas frescas.',
                'precio' => 9000,
                'unidad_medida' => 'Porción',
                'foto' => 'https://images.unsplash.com/photo-1578985545062-69928b1d9587?w=600&auto=format&fit=crop&q=80'
            ],
            [
                'nombre' => 'Chicharrón de Guayaba Hojaldrado Dulce',
                'descripcion' => 'Hojaldre crujiente espolvoreado con azúcar y relleno de jalea de guayaba roja.',
                'precio' => 3500,
                'unidad_medida' => 'Unidad',
                'foto' => 'https://images.unsplash.com/photo-1555507036-ab1f4038808a?w=600&auto=format&fit=crop&q=80'
            ],
            [
                'nombre' => 'Pan Baguette Rústico Horneado a la Piedra',
                'descripcion' => 'Barra de pan de masa madre con corteza crujiente y miga aireada, elaborado a diario.',
                'precio' => 4500,
                'unidad_medida' => 'Unidad',
                'foto' => 'https://images.unsplash.com/photo-1509440159596-0249088772ff?w=600&auto=format&fit=crop&q=80'
            ],
            [
                'nombre' => 'Lata Coleccionable Achiras de Yaguará Gourmet (1 Kilogramo)',
                'descripcion' => 'Presentación de lujo en lata metálica litografiada con motivos del Huila, ideal para regalos y turistas.',
                'precio' => 42000,
                'unidad_medida' => 'Lata',
                'foto' => 'https://images.unsplash.com/photo-1509440159596-0249088772ff?w=600&auto=format&fit=crop&q=80'
            ],
            [
                'nombre' => 'Pan Hawaiano con Jamón, Piña Caramelizada y Queso',
                'descripcion' => 'Pan suave relleno de trozos de piña en almíbar, jamón ahumado y queso gratinado.',
                'precio' => 7000,
                'unidad_medida' => 'Unidad',
                'foto' => 'https://images.unsplash.com/photo-1509440159596-0249088772ff?w=600&auto=format&fit=crop&q=80'
            ],
            [
                'nombre' => 'Combo Desayuno Tradicional: Café con Leche + 2 Pandebonos + Huevos',
                'descripcion' => 'Desayuno completo con huevos al gusto (pericos o fritos), 2 pandebonos calientes y café con leche entera.',
                'precio' => 12000,
                'unidad_medida' => 'Combo',
                'foto' => 'https://images.unsplash.com/photo-1533089860892-a7c6f0a88666?w=600&auto=format&fit=crop&q=80'
            ]
        ]
    ];

    // Cargar las demás categorías (3 a 15)
    require_once __DIR__ . '/catalogo_data_restante.php';
    // Combinar con las categorías 3 a 15 definidas en catalogo_data_restante.php
    if (isset($catalogoRestante)) {
        foreach ($catalogoRestante as $catId => $prods) {
            $catalogoPorCategoria[$catId] = $prods;
        }
    }

    $insertStmt = $conn->prepare("
        INSERT INTO productos (negocio_id, nombre, descripcion, precio, unidad_medida, foto, disponible, fecha_creacion)
        VALUES (?, ?, ?, ?, ?, ?, 1, NOW())
    ");

    $totalInsertados = 0;

    for ($catId = 1; $catId <= 15; $catId++) {
        if (!isset($catalogoPorCategoria[$catId])) {
            echo "Aviso: Categoría $catId no tiene productos configurados.\n";
            continue;
        }

        $productosCat = $catalogoPorCategoria[$catId];
        $negociosCat = $negociosPorCat[$catId] ?? [1];
        $totalNegocios = count($negociosCat);

        echo "Procesando Categoría $catId (" . count($productosCat) . " productos para $totalNegocios negocios)...\n";

        foreach ($productosCat as $index => $prod) {
            // Asignar el producto rotativamente entre los negocios de esta categoría
            $negocioId = $negociosCat[$index % $totalNegocios];

            $insertStmt->execute([
                $negocioId,
                $prod['nombre'],
                $prod['descripcion'],
                $prod['precio'],
                $prod['unidad_medida'],
                $prod['foto']
            ]);

            $totalInsertados++;
        }
    }

    echo "\n============================================\n";
    echo "¡ÉXITO TOTAL! Se han insertado $totalInsertados productos en la base de datos (30 por cada una de las 15 categorías).\n";
    echo "============================================\n";

} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
