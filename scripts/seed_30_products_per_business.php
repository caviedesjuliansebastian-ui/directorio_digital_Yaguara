<?php
require_once 'config/database.php';

try {
    $db = new Database();
    $conn = $db->getConnection();
    $conn->exec("SET NAMES utf8mb4");

    // Limpiar tabla de productos
    $conn->exec("TRUNCATE TABLE productos");

    require_once 'scripts/catalogo_data_restante.php'; // $catalogoRestante (cat 3 a 10)
    require_once 'scripts/catalogo_data_11_a_15.php';    // $catalogo11a15 (cat 11 a 15)

    // Cat 1 (Comidas Típicas & Pescaderías de Betania)
    $cat1_30 = [
        ['nombre' => 'Mojarra Roja Frita de Betania (1.5 lb)', 'descripcion' => 'Pescado fresco del Embalse de Betania dorado y crocante, con patacón gigante, arroz con coco y ensalada.', 'precio' => 32000, 'unidad_medida' => 'Plato', 'foto' => 'https://images.unsplash.com/photo-1534422298391-e4f8c172dddb?w=600&auto=format&fit=crop&q=80'],
        ['nombre' => 'Viudo de Capaz en Salsa Criolla Tradicional', 'descripcion' => 'Pescado capaz cocido al vapor sobre cama de plátano, yuca tierna y abundante hogao casero huilense.', 'precio' => 34000, 'unidad_medida' => 'Plato', 'foto' => 'https://images.unsplash.com/photo-1519708227418-c8fd9a32b7a2?w=600&auto=format&fit=crop&q=80'],
        ['nombre' => 'Sancocho de Bagre en Leche de Coco de Betania', 'descripcion' => 'Cazuela caliente con posta grande de bagre fresco, plátano verde, mazorca y caldo concentrado.', 'precio' => 28000, 'unidad_medida' => 'Cazuela', 'foto' => 'https://images.unsplash.com/photo-1547592166-23ac45744acd?w=600&auto=format&fit=crop&q=80'],
        ['nombre' => 'Asado Huilense Tradicional Yaguareño', 'descripcion' => 'Carne de cerdo marinada con poleo, orégano, cerveza y naranja agria, asada lentamente al horno de barro con insulso.', 'precio' => 35000, 'unidad_medida' => 'Plato', 'foto' => 'https://images.unsplash.com/photo-1544025162-d76694265947?w=600&auto=format&fit=crop&q=80'],
        ['nombre' => 'Quesillo Yaguareño en Hoja de Plátano (Libra 500g)', 'descripcion' => 'Elaborado artesanalmente con leche pura de vaca, textura elástica y suave aroma tradicional.', 'precio' => 15000, 'unidad_medida' => 'Libra', 'foto' => 'https://images.unsplash.com/photo-1486297678162-eb2a19b0a32d?w=600&auto=format&fit=crop&q=80'],
        ['nombre' => 'Quesillo Especial Bloque Familiar (1 Kilogramo)', 'descripcion' => 'Quesillo fresco prensado en hoja de bijao, ideal para compartir en familia o llevar de recuerdo.', 'precio' => 28000, 'unidad_medida' => 'Kilo', 'foto' => 'https://images.unsplash.com/photo-1624806992066-5ffcf7ca186b?w=600&auto=format&fit=crop&q=80'],
        ['nombre' => 'Cazuela de Mariscos & Filete de Tilapia de Betania', 'descripcion' => 'Selección de mariscos en crema de coco y filete fresco de tilapia con patacones crocantes.', 'precio' => 42000, 'unidad_medida' => 'Cazuela', 'foto' => 'https://images.unsplash.com/photo-1535400255456-984241443b29?w=600&auto=format&fit=crop&q=80'],
        ['nombre' => 'Mojarra Sudada en Zumo de Coco y Especias', 'descripcion' => 'Mojarra entera cocinada a fuego lento con hogao, leche de coco y finas hierbas del Huila.', 'precio' => 36000, 'unidad_medida' => 'Plato', 'foto' => 'https://images.unsplash.com/photo-1544551763-46a013bb70d5?w=600&auto=format&fit=crop&q=80'],
        ['nombre' => 'Lechona Huilense Tradicional con Insulso', 'descripcion' => 'Piel crocante dorada, carne de cerdo desmechada con arveja amarilla cocida a la leña.', 'precio' => 22000, 'unidad_medida' => 'Porción', 'foto' => 'https://images.unsplash.com/photo-1555939594-58d7cb561ad1?w=600&auto=format&fit=crop&q=80'],
        ['nombre' => 'Filete de Tilapia al Ajillo con Patacón', 'descripcion' => 'Filete sin espinas dorado a la plancha bañado en salsa suave de ajo y mantequilla de campo.', 'precio' => 30000, 'unidad_medida' => 'Plato', 'foto' => 'https://images.unsplash.com/photo-1519708227418-c8fd9a32b7a2?w=600&auto=format&fit=crop&q=80'],
        ['nombre' => 'Costillitas de Cerdo Ahumadas en Salsa de Panela', 'descripcion' => 'Costilla tierna marinada en especias huilenses y glaseada con reducción de panela y maracuyá.', 'precio' => 38000, 'unidad_medida' => 'Plato', 'foto' => 'https://images.unsplash.com/photo-1544025162-d76694265947?w=600&auto=format&fit=crop&q=80'],
        ['nombre' => 'Tamal Típico Huilense con Doble Carne', 'descripcion' => 'Masa suave de maíz con pollo campesino, tocino, huevo cocido y papa, envuelto en hoja de plátano.', 'precio' => 12000, 'unidad_medida' => 'Unidad', 'foto' => 'https://images.unsplash.com/photo-1589301760014-d929f3979dbc?w=600&auto=format&fit=crop&q=80'],
        ['nombre' => 'Picada Campestre Mixta El Malecón (Para 3 Personas)', 'descripcion' => 'Mojarra troceada, chicharrón crocante, plátano maduro, patacones, queso y hogao de la casa.', 'precio' => 55000, 'unidad_medida' => 'Platón', 'foto' => 'https://images.unsplash.com/photo-1555939594-58d7cb561ad1?w=600&auto=format&fit=crop&q=80'],
        ['nombre' => 'Ceviche Mixto de Tilapia y Camarón al Estilo Betania', 'descripcion' => 'Pescado fresco marinado en limón mandarino, cilantro, cebolla morada y maíz tostado.', 'precio' => 26000, 'unidad_medida' => 'Copa', 'foto' => 'https://images.unsplash.com/photo-1535400255456-984241443b29?w=600&auto=format&fit=crop&q=80'],
        ['nombre' => 'Insulso Huilense Dulce de Maíz y Panela (x4 unidades)', 'descripcion' => 'Acompañamiento tradicional para carnes y pescados, horneado en hoja de bijao.', 'precio' => 8000, 'unidad_medida' => 'Paquete', 'foto' => 'https://images.unsplash.com/photo-1509440159596-0249088772ff?w=600&auto=format&fit=crop&q=80'],
        ['nombre' => 'Queso Campesino Semiduro Yaguará (Libra)', 'descripcion' => 'Queso fresco de hacienda con bajo nivel de sal, elaborado diariamente en las veredas.', 'precio' => 12000, 'unidad_medida' => 'Libra', 'foto' => 'https://images.unsplash.com/photo-1486297678162-eb2a19b0a32d?w=600&auto=format&fit=crop&q=80'],
        ['nombre' => 'Arequipe Artesanal de Leche Pura (Frasco 300g)', 'descripcion' => 'Dulce de leche cremoso cocinado en paila de cobre con toque de vainilla natural.', 'precio' => 9000, 'unidad_medida' => 'Frasco', 'foto' => 'https://images.unsplash.com/photo-1589881133595-a3c085cb731d?w=600&auto=format&fit=crop&q=80'],
        ['nombre' => 'Yogurt Casero de Mora y Fresa Silvestre (1 Litro)', 'descripcion' => 'Yogurt espeso elaborado con frutas frescas cultivadas en la región.', 'precio' => 11000, 'unidad_medida' => 'Botella', 'foto' => 'https://images.unsplash.com/photo-1550583724-b2692b85b150?w=600&auto=format&fit=crop&q=80'],
        ['nombre' => 'Postre de Las Tres Leches con Quesillo Rallado', 'descripcion' => 'Bizcochuelo húmedo bañado en crema de leche y decorado con virutas de quesillo dulce.', 'precio' => 10000, 'unidad_medida' => 'Porción', 'foto' => 'https://images.unsplash.com/photo-1578985545062-69928b1d9587?w=600&auto=format&fit=crop&q=80'],
        ['nombre' => 'Chuzo de Carne de Res con Arepa de Choclo', 'descripcion' => 'Brocheta de lomo tierno asado al carbón con arepa campesina y mantequilla derretida.', 'precio' => 18000, 'unidad_medida' => 'Unidad', 'foto' => 'https://images.unsplash.com/photo-1555939594-58d7cb561ad1?w=600&auto=format&fit=crop&q=80'],
        ['nombre' => 'Jarra de Limonada de Panela con Hierbabuena (1.5 Litros)', 'descripcion' => 'Bebida hidratante tradicional bien fría con limón pajarito y hierbabuena fresca.', 'precio' => 12000, 'unidad_medida' => 'Jarra', 'foto' => 'https://images.unsplash.com/photo-1513558161293-cdaf765ed2fd?w=600&auto=format&fit=crop&q=80'],
        ['nombre' => 'Jugo Natural de Cholupa Huilense en Agua o Leche', 'descripcion' => 'La fruta insignia del Huila, sabor exótico y refrescante servido con hielo picado.', 'precio' => 7500, 'unidad_medida' => 'Vaso', 'foto' => 'https://images.unsplash.com/photo-1622597467836-f3285f2131b7?w=600&auto=format&fit=crop&q=80'],
        ['nombre' => 'Jugo de Maracuyá del Valle del Magdalena (500ml)', 'descripcion' => 'Jugo espeso y ácido equilibrado con azúcar orgánica.', 'precio' => 7000, 'unidad_medida' => 'Vaso', 'foto' => 'https://images.unsplash.com/photo-1513558161293-cdaf765ed2fd?w=600&auto=format&fit=crop&q=80'],
        ['nombre' => 'Cerveza Artesanal Huilense Rubia o Negra (330ml)', 'descripcion' => 'Cerveza elaborada en la región con notas de malta y lúpulo aromático.', 'precio' => 11000, 'unidad_medida' => 'Botella', 'foto' => 'https://images.unsplash.com/photo-1608270586620-248524c67de9?w=600&auto=format&fit=crop&q=80'],
        ['nombre' => 'Bandeja Campesina Yaguareña Especial', 'descripcion' => 'Frijoles de la vega, arroz blanco, carne molida, chicharrón, huevo frito, tajada y aguacate.', 'precio' => 32000, 'unidad_medida' => 'Plato', 'foto' => 'https://images.unsplash.com/photo-1544025162-d76694265947?w=600&auto=format&fit=crop&q=80'],
        ['nombre' => 'Sopa de Ropa Vieja con Mazorca y Plátano', 'descripcion' => 'Caldo tradicional espeso con carne desmechada, papa criolla y picadillo de cilantro.', 'precio' => 16000, 'unidad_medida' => 'Tazón', 'foto' => 'https://images.unsplash.com/photo-1547592166-23ac45744acd?w=600&auto=format&fit=crop&q=80'],
        ['nombre' => 'Filete de Pechuga a la Plancha en Salsa Criolla', 'descripcion' => 'Pechuga campesina tierna bañada en hogao de cebolla junca y tomate chonto.', 'precio' => 25000, 'unidad_medida' => 'Plato', 'foto' => 'https://images.unsplash.com/photo-1598515214211-89d3c73ae83b?w=600&auto=format&fit=crop&q=80'],
        ['nombre' => 'Patacón Gigante con Quesillo y Hogao', 'descripcion' => 'Plátano verde frito crocante cubierto con abundante quesillo derretido y salsa criolla.', 'precio' => 14000, 'unidad_medida' => 'Plato', 'foto' => 'https://images.unsplash.com/photo-1534422298391-e4f8c172dddb?w=600&auto=format&fit=crop&q=80'],
        ['nombre' => 'Porción de Chicharrón Carnudo con Arepa', 'descripcion' => 'Chicharrón tostado crocante con limón mandarino y arepa de maíz blanco.', 'precio' => 16000, 'unidad_medida' => 'Porción', 'foto' => 'https://images.unsplash.com/photo-1555939594-58d7cb561ad1?w=600&auto=format&fit=crop&q=80'],
        ['nombre' => 'Plato Mixto Malecón: Media Mojarra + Asado + Insulso', 'descripcion' => 'Lo mejor de dos mundos: media mojarra roja frita y generosa porción de asado huilense.', 'precio' => 46000, 'unidad_medida' => 'Plato', 'foto' => 'https://images.unsplash.com/photo-1555939594-58d7cb561ad1?w=600&auto=format&fit=crop&q=80']
    ];

    // Cat 2 (Bizcocherías & Panaderías)
    $cat2_30 = [
        ['nombre' => 'Achiras Tradicionales de Yaguará (Bolsa 250g)', 'descripcion' => 'Elaboradas con almidón de sagú y queso campesino auténtico, horneadas a la leña.', 'precio' => 10000, 'unidad_medida' => 'Bolsa', 'foto' => 'https://images.unsplash.com/photo-1509440159596-0249088772ff?w=600&auto=format&fit=crop&q=80'],
        ['nombre' => 'Achiras Especiales de Queso en Lata de Lujo (500g)', 'descripcion' => 'Presentación premium ideal para regalo con empaque sellado que conserva el crocante.', 'precio' => 22000, 'unidad_medida' => 'Lata', 'foto' => 'https://images.unsplash.com/photo-1589367920969-ab8e050bbb04?w=600&auto=format&fit=crop&q=80'],
        ['nombre' => 'Bizcocho de Cuajada Huilense Horneado (Bolsa 200g)', 'descripcion' => 'Bizcocho tostado y dorado preparado con cuajada fresca pura y toque salado tradicional.', 'precio' => 8500, 'unidad_medida' => 'Bolsa', 'foto' => 'https://images.unsplash.com/photo-1509440159596-0249088772ff?w=600&auto=format&fit=crop&q=80'],
        ['nombre' => 'Bizcocho de Manteca de Cerdo Casero (Paquete x12)', 'descripcion' => 'Receta de las abuelas yaguareñas, suave y crocante para remojar en chocolate caliente.', 'precio' => 9000, 'unidad_medida' => 'Paquete', 'foto' => 'https://images.unsplash.com/photo-1555507036-ab1f4038808a?w=600&auto=format&fit=crop&q=80'],
        ['nombre' => 'Pan de Maíz y Queso Campesino (Bandeja x6)', 'descripcion' => 'Pan esponjoso horneado a primera hora de la mañana con relleno generoso de queso.', 'precio' => 7500, 'unidad_medida' => 'Bandeja', 'foto' => 'https://images.unsplash.com/photo-1509440159596-0249088772ff?w=600&auto=format&fit=crop&q=80'],
        ['nombre' => 'Pan Rollo Tradicional de Panadería (Paquete x10)', 'descripcion' => 'Pan clásico para el desayuno con corteza dorada y miga suave.', 'precio' => 6000, 'unidad_medida' => 'Paquete', 'foto' => 'https://images.unsplash.com/photo-1555507036-ab1f4038808a?w=600&auto=format&fit=crop&q=80'],
        ['nombre' => 'Mogollas Chicharronas con Guascas (Bolsa x6)', 'descripcion' => 'Pan campesino relleno con crocantes trocitos de chicharrón horneado.', 'precio' => 8000, 'unidad_medida' => 'Bolsa', 'foto' => 'https://images.unsplash.com/photo-1509440159596-0249088772ff?w=600&auto=format&fit=crop&q=80'],
        ['nombre' => 'Almojábanas Calientes de Queso y Maíz (Bandeja x6)', 'descripcion' => 'Almojábanas recién salidas del horno con textura tierna y dorado perfecto.', 'precio' => 9500, 'unidad_medida' => 'Bandeja', 'foto' => 'https://images.unsplash.com/photo-1589367920969-ab8e050bbb04?w=600&auto=format&fit=crop&q=80'],
        ['nombre' => 'Pan de Bono Valluno-Huilense (Bandeja x6)', 'descripcion' => 'Masa elástica con queso costeño y almidón de yuca bien horneado.', 'precio' => 9000, 'unidad_medida' => 'Bandeja', 'foto' => 'https://images.unsplash.com/photo-1509440159596-0249088772ff?w=600&auto=format&fit=crop&q=80'],
        ['nombre' => 'Pan de Yuca Crocante (Bolsa x8 unidades)', 'descripcion' => 'Textura crujiente por fuera y ligera por dentro con queso derretido.', 'precio' => 8500, 'unidad_medida' => 'Bolsa', 'foto' => 'https://images.unsplash.com/photo-1555507036-ab1f4038808a?w=600&auto=format&fit=crop&q=80'],
        ['nombre' => 'Torta Artesanal de Tres Leches con Fresas', 'descripcion' => 'Bizcocho húmedo con tres tipos de leche y fresas frescas de la montaña.', 'precio' => 38000, 'unidad_medida' => 'Unidad', 'foto' => 'https://images.unsplash.com/photo-1578985545062-69928b1d9587?w=600&auto=format&fit=crop&q=80'],
        ['nombre' => 'Torta de Chocolate y Arequipe Huilense', 'descripcion' => 'Capa doble de chocolate semiamargo con relleno generoso de arequipe y nueces.', 'precio' => 42000, 'unidad_medida' => 'Unidad', 'foto' => 'https://images.unsplash.com/photo-1578985545062-69928b1d9587?w=600&auto=format&fit=crop&q=80'],
        ['nombre' => 'Brazo de Reina con Dulce de Guayaba y Crema', 'descripcion' => 'Rollo suave de vainilla espolvoreado con azúcar micropulverizada.', 'precio' => 24000, 'unidad_medida' => 'Rollo', 'foto' => 'https://images.unsplash.com/photo-1586985289688-ca3cf47d3e6e?w=600&auto=format&fit=crop&q=80'],
        ['Pastel Gloria Relleno de Arequipe y Bocadillo', 'Hojaldre crujiente horneado con azúcar caramelizada encima.', 3500, 'Unidad', 'https://images.unsplash.com/photo-1509440159596-0249088772ff?w=600&auto=format&fit=crop&q=80'],
        ['nombre' => 'Milhojas de Hojaldre con Crema Pastelera y Arequipe', 'descripcion' => 'Capas finas de hojaldre crocante con crema fresca y arequipe.', 'precio' => 6000, 'unidad_medida' => 'Porción', 'foto' => 'https://images.unsplash.com/photo-1586985289688-ca3cf47d3e6e?w=600&auto=format&fit=crop&q=80'],
        ['nombre' => 'Galletas de Avena y Miel Campesina (Caja x12)', 'descripcion' => 'Galletas saludables horneadas con avena en hojuela, miel pura y canela.', 'precio' => 12000, 'unidad_medida' => 'Caja', 'foto' => 'https://images.unsplash.com/photo-1499636136210-6f4ee915583e?w=600&auto=format&fit=crop&q=80'],
        ['nombre' => 'Galletas Polvorosas Tradicionales (Paquete x10)', 'descripcion' => 'Galletas de harina de trigo que se deshacen suavemente en la boca.', 'precio' => 7000, 'unidad_medida' => 'Paquete', 'foto' => 'https://images.unsplash.com/photo-1558961363-fa8fdf82db35?w=600&auto=format&fit=crop&q=80'],
        ['nombre' => 'Donas Glaseadas Rellenas de Chocolate o Arequipe', 'descripcion' => 'Donas esponjosas con cobertura brillante de chocolate o vainilla.', 'precio' => 4500, 'unidad_medida' => 'Unidad', 'foto' => 'https://images.unsplash.com/photo-1551024709-8f23befc6f87?w=600&auto=format&fit=crop&q=80'],
        ['nombre' => 'Croissant de Mantequilla Francés', 'descripcion' => 'Hojaldrado perfecto con mantequilla de alta calidad y aroma tentador.', 'precio' => 4000, 'unidad_medida' => 'Unidad', 'foto' => 'https://images.unsplash.com/photo-1555507036-ab1f4038808a?w=600&auto=format&fit=crop&q=80'],
        ['nombre' => 'Croissant Mixto Relleno de Jamón y Quesillo', 'descripcion' => 'Croissant horneado con queso derretido y jamón seleccionado.', 'precio' => 6500, 'unidad_medida' => 'Unidad', 'foto' => 'https://images.unsplash.com/photo-1509440159596-0249088772ff?w=600&auto=format&fit=crop&q=80'],
        ['nombre' => 'Empanadas Horneadas de Carne Desmechada (x3)', 'descripcion' => 'Hojaldre relleno de carne sazonada con cebolla y pimentón.', 'precio' => 9000, 'unidad_medida' => 'Orden', 'foto' => 'https://images.unsplash.com/photo-1589301760014-d929f3979dbc?w=600&auto=format&fit=crop&q=80'],
        ['nombre' => 'Pastel de Pollo Hojaldrado Especial', 'descripcion' => 'Relleno abundante de pechuga de pollo desmechada con salsa bechamel.', 'precio' => 5000, 'unidad_medida' => 'Unidad', 'foto' => 'https://images.unsplash.com/photo-1509440159596-0249088772ff?w=600&auto=format&fit=crop&q=80'],
        ['nombre' => 'Torta Casera de Zanahoria y Nueces con Frosting', 'descripcion' => 'Bizcocho especiado con canela, nueces y suave crema de queso.', 'precio' => 32000, 'unidad_medida' => 'Unidad', 'foto' => 'https://images.unsplash.com/photo-1578985545062-69928b1d9587?w=600&auto=format&fit=crop&q=80'],
        ['nombre' => 'Brownie con Helado Artesanal de Vainilla', 'descripcion' => 'Brownie húmedo de chocolate oscuro acompañado con bola de helado y sirope.', 'precio' => 12000, 'unidad_medida' => 'Porción', 'foto' => 'https://images.unsplash.com/photo-1563805042-7684c019e1cb?w=600&auto=format&fit=crop&q=80'],
        ['nombre' => 'Muffins de Arándanos y Chocolate Blanco (Caja x4)', 'descripcion' => 'Magdalenas esponjosas con arándanos frescos y chispas dulces.', 'precio' => 14000, 'unidad_medida' => 'Caja', 'foto' => 'https://images.unsplash.com/photo-1586985289688-ca3cf47d3e6e?w=600&auto=format&fit=crop&q=80'],
        ['nombre' => 'Pan Tajado Artesanal Integral con Semillas', 'descripcion' => 'Pan saludable con chía, linaza, ajonjolí y avena para sándwiches.', 'precio' => 9500, 'unidad_medida' => 'Bolsa', 'foto' => 'https://images.unsplash.com/photo-1509440159596-0249088772ff?w=600&auto=format&fit=crop&q=80'],
        ['nombre' => 'Pan Trenzado Relleno de Queso y Bocadillo', 'descripcion' => 'Pan dulce con costra dorada y relleno generoso de dulce de guayaba.', 'precio' => 8000, 'unidad_medida' => 'Unidad', 'foto' => 'https://images.unsplash.com/photo-1555507036-ab1f4038808a?w=600&auto=format&fit=crop&q=80'],
        ['nombre' => 'Chicharrón de Guayaba Hojaldrado', 'descripcion' => 'Tira crocante de hojaldre rellena de dulce de guayaba azucarado.', 'precio' => 3500, 'unidad_medida' => 'Unidad', 'foto' => 'https://images.unsplash.com/photo-1509440159596-0249088772ff?w=600&auto=format&fit=crop&q=80'],
        ['nombre' => 'Torta Fría de Maracuyá y Queso Crema', 'descripcion' => 'Postre refrescante con base de galleta y coulis brillante de maracuyá.', 'precio' => 36000, 'unidad_medida' => 'Unidad', 'foto' => 'https://images.unsplash.com/photo-1578985545062-69928b1d9587?w=600&auto=format&fit=crop&q=80'],
        ['nombre' => 'Combo Desayuno: Café con Leche + 2 Almojábanas + Queso', 'descripcion' => 'Combo tradicional para iniciar la mañana en el parque de Yaguará.', 'precio' => 12000, 'unidad_medida' => 'Combo', 'foto' => 'https://images.unsplash.com/photo-1501339847302-ac426a4a7cbb?w=600&auto=format&fit=crop&q=80']
    ];

    $catalogoCompleto = [
        1 => $cat1_30,
        2 => $cat2_30
    ];

    // Añadir categorías 3 a 10
    foreach ($catalogoRestante as $catId => $prods) {
        $catalogoCompleto[$catId] = $prods;
    }

    // Añadir categorías 11 a 15
    foreach ($catalogo11a15 as $catId => $prods) {
        $catalogoCompleto[$catId] = $prods;
    }

    // Obtener todos los 44 negocios
    $negocios = $conn->query("SELECT id, categoria_id, nombre FROM negocios ORDER BY id ASC")->fetchAll(PDO::FETCH_ASSOC);

    $stmtInsert = $conn->prepare("
        INSERT INTO productos (negocio_id, nombre, descripcion, precio, unidad_medida, foto, disponible, fecha_creacion)
        VALUES (?, ?, ?, ?, ?, ?, 1, NOW())
    ");

    $totalProductos = 0;

    foreach ($negocios as $neg) {
        $catId = (int)$neg['categoria_id'];
        $pool = $catalogoCompleto[$catId] ?? $cat1_30;

        foreach ($pool as $p) {
            $stmtInsert->execute([
                $neg['id'],
                $p['nombre'] ?? $p[0],
                $p['descripcion'] ?? $p[1],
                $p['precio'] ?? $p[2],
                $p['unidad_medida'] ?? $p[3],
                $p['foto'] ?? $p[4]
            ]);
            $totalProductos++;
        }
    }

    echo "¡Catálogo masivo generado con éxito! ($totalProductos productos creados, exactamente 30 productos para cada uno de los 44 negocios).\n";

} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
