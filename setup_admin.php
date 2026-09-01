<?php
require_once 'config/database.php';

try {
    $db = new Database();
    $conn = $db->getConnection();

    // Eliminar el administrador anterior si existe (para evitar duplicados)
    $stmt = $conn->prepare("DELETE FROM usuarios WHERE correo = 'admin@directorio.com'");
    $stmt->execute();

    // Crear la contraseña segura
    $password_hasheada = password_hash('12345678', PASSWORD_BCRYPT);

    // Insertar el nuevo administrador
    $stmt = $conn->prepare("
        INSERT INTO usuarios (nombre, correo, celular, contrasena, rol) 
        VALUES ('Administrador Supremo', 'admin@directorio.com', '0000000000', :contrasena, 'administrador')
    ");
    
    $stmt->bindParam(':contrasena', $password_hasheada);
    
    if($stmt->execute()){
        echo "Exito: Administrador creado correctamente.";
    } else {
        echo "Error: No se pudo crear el administrador.";
    }
} catch(Exception $e) {
    echo "Error Exception: " . $e->getMessage();
}
?>
