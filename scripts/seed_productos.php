<?php
require_once __DIR__ . '/../config/database.php';
$db = (new Database())->getConnection();

// Limpiar productos existentes para evitar duplicados
$db->exec("DELETE FROM productos");

$productos = [
    // Restaurante El Embalse (ID 1)
    [
        'negocio_id' => 1,
        'nombre' => 'Mojarra Frita Especial del Embalse',
        'descripcion' => 'Mojarra roja fresca criada en las jaulas de Betania, acompañada de patacón gigante, arroz con coco y ensalada de la casa.',
        'precio' => 28000,
        'unidad_medida' => 'Plato',
        'foto' => null,
        'disponible' => 1
    ],
    [
        'negocio_id' => 1,
        'nombre' => 'Sancocho de Gallina Criolla Campesina',
        'descripcion' => 'Tradicional sancocho de gallina criolla cocido a leña con yuca, plátano, mazorca y ahogado de la región.',
        'precio' => 24000,
        'unidad_medida' => 'Plato',
        'foto' => null,
        'disponible' => 1
    ],
    [
        'negocio_id' => 1,
        'nombre' => 'Quesillo Yaguareño Auténtico en Hoja',
        'descripcion' => 'Quesillo tradicional elaborado con leche fresca de las fincas de Yaguará, envuelto en hoja de plátano verde.',
        'precio' => 12000,
        'unidad_medida' => 'Libra',
        'foto' => null,
        'disponible' => 1
    ],

    // Asadero La Brasa Yaguareña (ID 2)
    [
        'negocio_id' => 2,
        'nombre' => 'Combo Pollo Asado Familiar a la Leña',
        'descripcion' => 'Pollo entero marinado con especias del Huila, acompañado de 4 arepas campesinas, papas al vapor y ají casero.',
        'precio' => 36000,
        'unidad_medida' => 'Combo',
        'foto' => null,
        'disponible' => 1
    ],
    [
        'negocio_id' => 2,
        'nombre' => 'Plátano Asado con Quesillo y Bocadillo',
        'descripcion' => 'Plátano maduro asado al carbón relleno de abundante quesillo de Yaguará y dulce de guayaba.',
        'precio' => 8000,
        'unidad_medida' => 'Unidad',
        'foto' => null,
        'disponible' => 1
    ],

    // Minimercado Don Pedro (ID 3)
    [
        'negocio_id' => 3,
        'nombre' => 'Achiras Tradicionales del Huila (500g)',
        'descripcion' => 'Bizcochos de achira horneados en horno de barro artesanal con 100% cuajada fresca de la región.',
        'precio' => 15000,
        'unidad_medida' => 'Bolsa',
        'foto' => null,
        'disponible' => 1
    ],
    [
        'negocio_id' => 3,
        'nombre' => 'Bizcochuelo Yaguareño Artesanal',
        'descripcion' => 'Bizcochuelo esponjoso tradicional huilense empacado al vacío.',
        'precio' => 10000,
        'unidad_medida' => 'Caja',
        'foto' => null,
        'disponible' => 1
    ],
    [
        'negocio_id' => 3,
        'nombre' => 'Panela Orgánica de Finca (Atado x 4)',
        'descripcion' => 'Panela pura de caña cultivada en el municipio sin químicos ni aditivos.',
        'precio' => 7500,
        'unidad_medida' => 'Atado',
        'foto' => null,
        'disponible' => 1
    ],

    // Electri-Servicios Yaguará (ID 6)
    [
        'negocio_id' => 6,
        'nombre' => 'Servicio de Mantenimiento e Instalación de Motobombas',
        'descripcion' => 'Revisión eléctrica, cebado, cambio de sellos mecánicos e instalación de motobombas para fincas y piscícolas.',
        'precio' => 65000,
        'unidad_medida' => 'Servicio',
        'foto' => null,
        'disponible' => 1
    ],
    [
        'negocio_id' => 6,
        'nombre' => 'Revisión y Cableado Residencial / Comercial',
        'descripcion' => 'Detección de cortos, balanceo de cargas en tablero de breakers e instalación de tomas polo a tierra.',
        'precio' => 40000,
        'unidad_medida' => 'Hora',
        'foto' => null,
        'disponible' => 1
    ],

    // MotoExpress Yaguará (ID 7)
    [
        'negocio_id' => 7,
        'nombre' => 'Sincronización y Mantenimiento General de Moto',
        'descripcion' => 'Limpieza de carburador o inyector, calibración de válvulas, tensión de cadena y frenos.',
        'precio' => 45000,
        'unidad_medida' => 'Servicio',
        'foto' => null,
        'disponible' => 1
    ],
    [
        'negocio_id' => 7,
        'nombre' => 'Servicio de Desvare y Grúa Municipal',
        'descripcion' => 'Asistencia mecánica rápida en cualquier punto del casco urbano o vía hacia el Embalse de Betania.',
        'precio' => 30000,
        'unidad_medida' => 'Servicio',
        'foto' => null,
        'disponible' => 1
    ],

    // Heladería y Frutería Tropical (ID 14)
    [
        'negocio_id' => 14,
        'nombre' => 'Jugo Natural de Cholupa Huilense en Agua o Leche',
        'descripcion' => 'La fruta insignia del Huila preparada al instante, refrescante y natural.',
        'precio' => 6000,
        'unidad_medida' => 'Vaso',
        'foto' => null,
        'disponible' => 1
    ],
    [
        'negocio_id' => 14,
        'nombre' => 'Salpicón Especial con Bola de Helado',
        'descripcion' => 'Mezcla de papaya, banano, melón, manzana y uvas bañado en jugo de sandía y coronado con helado.',
        'precio' => 8500,
        'unidad_medida' => 'Copa',
        'foto' => null,
        'disponible' => 1
    ]
];

$stmt = $db->prepare("
    INSERT INTO productos (negocio_id, nombre, descripcion, precio, unidad_medida, foto, disponible)
    VALUES (?, ?, ?, ?, ?, ?, ?)
");

foreach ($productos as $p) {
    $stmt->execute([
        $p['negocio_id'],
        $p['nombre'],
        $p['descripcion'],
        $p['precio'],
        $p['unidad_medida'],
        $p['foto'],
        $p['disponible']
    ]);
}

echo "¡Se han insertado " . count($productos) . " productos y servicios reales de Yaguará!\n";
