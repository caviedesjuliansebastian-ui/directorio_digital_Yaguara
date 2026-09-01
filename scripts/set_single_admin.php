<?php
require_once __DIR__ . '/../config/database.php';
$db = (new Database())->getConnection();

// 1. Quitar rol de administrador a todos los demás usuarios
$db->exec("UPDATE usuarios SET rol = 'usuario' WHERE correo != 'admin@directorio.com'");

// 2. Verificar si admin@directorio.com existe
$stmt = $db->prepare("SELECT id FROM usuarios WHERE correo = 'admin@directorio.com'");
$stmt->execute();
$admin = $stmt->fetch(PDO::FETCH_ASSOC);

$hash = password_hash('12345678', PASSWORD_BCRYPT);

if ($admin) {
    // Actualizar contraseña y asegurar rol
    $update = $db->prepare("UPDATE usuarios SET contrasena = ?, rol = 'administrador', activo = 1 WHERE correo = 'admin@directorio.com'");
    $update->execute([$hash]);
    echo "Usuario admin@directorio.com actualizado con rol 'administrador' y contraseña '12345678'.\n";
} else {
    // Crear el usuario admin
    $insert = $db->prepare("INSERT INTO usuarios (nombre, correo, celular, contrasena, rol, activo) VALUES ('Administrador General', 'admin@directorio.com', '3100000000', ?, 'administrador', 1)");
    $insert->execute([$hash]);
    echo "Usuario admin@directorio.com creado exitosamente como único 'administrador' con contraseña '12345678'.\n";
}

// 3. Mostrar resumen de usuarios y roles
$stmt = $db->query("SELECT id, nombre, correo, rol, activo FROM usuarios");
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);
echo "\nLista actual de usuarios:\n";
print_r($users);
