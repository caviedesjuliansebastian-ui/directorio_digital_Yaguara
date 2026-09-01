<?php
require_once 'config/database.php';

try {
    $db = new Database();
    $conn = $db->getConnection();
    
    // Configurar UTF-8
    $conn->exec("SET NAMES utf8mb4");

    // Limpiar tablas dependientes para reiniciar desde cero
    $conn->exec("DELETE FROM productos_servicios");
    $conn->exec("DELETE FROM perfiles_proveedor");
    $conn->exec("DELETE FROM usuarios WHERE rol = 'proveedor'");

    // Diccionarios de datos
    $nombres = ['Carlos', 'Ana', 'Mario', 'Luisa', 'Jorge', 'Diana', 'Roberto', 'Carmen', 'Pedro', 'Laura', 'Juan', 'Sofia', 'Miguel', 'Valentina'];
    $apellidos = ['Pérez', 'Gómez', 'Rodríguez', 'López', 'Martínez', 'García', 'Ramírez', 'Díaz', 'Sánchez', 'Vargas'];
    $calles = ['Calle Principal', 'Carrera 2', 'Barrio Centro', 'Avenida del Río', 'Carrera 4', 'Calle 10', 'Barrio Las Brisas', 'Terminal', 'Avenida del Lago'];
    
    // Configuración por categoría (1 a 8)
    $categorias_config = [
        1 => ['nombres_negocio' => ['La Parrilla de %s', 'Restaurante %s', 'Pizzería %s', 'Asados %s', 'Comida Rápida %s', 'Cafetería %s', 'Delicias de %s', 'Sabor a %s', 'El Buen Sazón', 'Hamburguesas %s'], 'fotos' => ['1555939594-58d7cb561ad1', '1414235077428-9711455343c4', '1504674900247-0877df9cc836', '1550547660-d9450f859349']],
        2 => ['nombres_negocio' => ['Spa %s', 'Barbería %s', 'Salón de Belleza %s', 'Estética %s', 'Cortes %s', 'Uñas y Belleza %s', 'Peluquería %s', 'Centro de Relajación', 'Estudio %s', '%s Beauty'], 'fotos' => ['1562322140-8baeececf3df', '1521590832167-7bfcfaa6362f', '1516975080664-ed2fc6a32937', '1595152772835-219674b2a8a6']],
        3 => ['nombres_negocio' => ['Plomería %s', 'Electricista %s', 'Reparaciones %s', 'Taller %s', 'Servicio Técnico %s', 'Mantenimiento %s', 'Carpintería %s', 'Construcciones %s', 'Soldadura %s', 'Refrigeración %s'], 'fotos' => ['1581141849291-1125c7b692b5', '1504328345606-18bbc8c9d7d1', '1584622650111-993a426fbf0a', '1505330622279-bf7d7fc918f4']],
        4 => ['nombres_negocio' => ['Transportes %s', 'Acarreos %s', 'Mudanzas %s', 'Taxis %s', 'Mototaxi %s', 'Carga %s', 'Fletes %s', 'Logística %s', 'Servicio de Moto %s', 'Viajes %s'], 'fotos' => ['1601584115197-04ecc0da31d7', '1600880292203-757bb62b4baf', '1519003722824-194d4455a60c', '1494976388531-d1058494cdd8']],
        5 => ['nombres_negocio' => ['TechZone %s', 'Celulares %s', 'CompuStore %s', 'Reparación de Móviles', 'Accesorios %s', 'Cyber %s', 'Soporte PC %s', 'Tecnología %s', 'Mundo Smart', 'Gadgets %s'], 'fotos' => ['1512499617640-c74ae3a79d37', '1556656793-08538906a9f8', '1496181133206-80ce9b88a853', '1550009158-9c8f25c79745']],
        6 => ['nombres_negocio' => ['Boutique %s', 'Moda %s', 'Ropa y Estilo', 'Calzado %s', 'Deportes %s', 'Jeans %s', 'Tienda %s', 'Tendencias %s', 'Fashion %s', 'Outlet %s'], 'fotos' => ['1441986300917-64674bd600d8', '1441984904996-e0b6ba687e04', '1489987707023-af7e9e8f8d58', '1567113463300-102a922b4d59']],
        7 => ['nombres_negocio' => ['Veterinaria %s', 'Mascotas %s', 'Huellitas', 'PetShop %s', 'Clínica Animal %s', 'Peluquería Canina %s', 'Agropecuaria %s', 'Cuidados %s', 'Mundo Peludo', 'Amor de Huellas'], 'fotos' => ['1628009368231-7bb7cfcb0def', '1583337130417-3346a1be7dee', '1596492784531-6e6eb5ea9993', '1516734212186-a967f81ad0d7']],
        8 => ['nombres_negocio' => ['Hotel %s', 'Hostal %s', 'Cabañas %s', 'Finca %s', 'Resort %s', 'Alojamiento %s', 'Mirador %s', 'Posada %s', 'EcoHotel %s', 'Turismo %s'], 'fotos' => ['1566073771259-6a8506099945', '1542314831-c6a4d142104d', '1578683010236-d716f9a3f461', '1551882547-ff40c0d1396a']]
    ];

    $password_hasheada = password_hash('12345678', PASSWORD_BCRYPT);
    $usuario_id = 3000;
    
    // Generar 10 por categoría
    for ($cat_id = 1; $cat_id <= 8; $cat_id++) {
        for ($i = 0; $i < 10; $i++) {
            $usuario_id++;
            
            $nombre = $nombres[array_rand($nombres)];
            $apellido = $apellidos[array_rand($apellidos)];
            $nombre_completo = $nombre . ' ' . $apellido;
            $correo = strtolower($nombre . $usuario_id . '@prueba.com');
            $celular = '3' . rand(100000000, 299999999);
            
            // Insertar Usuario
            $stmt = $conn->prepare("INSERT INTO usuarios (id, nombre, correo, celular, contrasena, rol) VALUES (?, ?, ?, ?, ?, 'proveedor')");
            $stmt->execute([$usuario_id, $nombre_completo, $correo, $celular, $password_hasheada]);
            
            // Perfil
            $config = $categorias_config[$cat_id];
            $nombre_negocio_plantilla = $config['nombres_negocio'][$i];
            $nombre_negocio = sprintf($nombre_negocio_plantilla, $nombre);
            
            $direccion = $calles[array_rand($calles)] . ' #' . rand(1, 20) . '-' . rand(10, 99);
            
            $foto_perfil = 'https://images.unsplash.com/photo-' . $config['fotos'][array_rand($config['fotos'])] . '?w=400&q=80';
            $foto_portada = 'https://images.unsplash.com/photo-' . $config['fotos'][array_rand($config['fotos'])] . '?w=1200&q=80';
            
            $descripcion = "Bienvenidos a $nombre_negocio. Ofrecemos los mejores servicios en Yaguará con excelente atención y profesionalismo.";
            
            $stmt = $conn->prepare("INSERT INTO perfiles_proveedor (usuario_id, nombre_negocio, descripcion, categoria_id, direccion, celular_contacto, whatsapp, esta_verificado, estado, imagen_perfil, imagen_portada) VALUES (?, ?, ?, ?, ?, ?, ?, 1, 'activo', ?, ?)");
            $stmt->execute([$usuario_id, $nombre_negocio, $descripcion, $cat_id, $direccion, $celular, $celular, $foto_perfil, $foto_portada]);
            $proveedor_id = $conn->lastInsertId();
            
            // 2 Productos por comercio
            for($p=1; $p<=2; $p++){
                $precio = rand(10, 100) * 1000;
                $prod_img = 'https://images.unsplash.com/photo-' . $config['fotos'][array_rand($config['fotos'])] . '?w=600&q=80';
                $stmt = $conn->prepare("INSERT INTO productos_servicios (proveedor_id, nombre, descripcion, precio, url_imagen) VALUES (?, ?, ?, ?, ?)");
                $stmt->execute([$proveedor_id, "Servicio/Producto $p", "El mejor servicio de calidad garantizada.", $precio, $prod_img]);
            }
        }
    }
    
    echo "¡80 Negocios (10 por categoria) generados con éxito!";
} catch(Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>
