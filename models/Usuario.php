<?php
class Usuario extends Model {
    
    // Registrar un nuevo usuario
    public function registrar($nombre, $correo, $celular, $contrasena) {
        // Verificar si el correo ya existe
        $stmt = $this->db->prepare("SELECT id FROM usuarios WHERE correo = ?");
        $stmt->execute([$correo]);
        
        if ($stmt->fetch()) {
            return ["exito" => false, "mensaje" => "El correo electrónico ya está registrado."];
        }

        $contrasena_hasheada = password_hash($contrasena, PASSWORD_BCRYPT);

        $stmt = $this->db->prepare("INSERT INTO usuarios (nombre, correo, celular, contrasena, rol) VALUES (?, ?, ?, ?, 'usuario')");
        $stmt->execute([$nombre, $correo, $celular, $contrasena_hasheada]);

        return ["exito" => true, "mensaje" => "¡Registro exitoso!", "id" => $this->db->lastInsertId()];
    }

    // Iniciar sesión
    public function login($correo, $contrasena) {
        $stmt = $this->db->prepare("SELECT * FROM usuarios WHERE correo = ? AND activo = 1");
        $stmt->execute([$correo]);

        if ($stmt->rowCount() == 1) {
            $usuario = $stmt->fetch();
            
            if (password_verify($contrasena, $usuario['contrasena'])) {
                $_SESSION['usuario_id'] = $usuario['id'];
                $_SESSION['usuario_nombre'] = $usuario['nombre'];
                $_SESSION['usuario_rol'] = $usuario['rol'];
                $_SESSION['usuario_correo'] = $usuario['correo'];
                $_SESSION['usuario_foto'] = $usuario['foto_perfil'] ?? null;
                
                return ["exito" => true, "usuario" => $usuario];
            } else {
                return ["exito" => false, "mensaje" => "Contraseña incorrecta."];
            }
        } else {
            return ["exito" => false, "mensaje" => "El usuario no existe o está desactivado."];
        }
    }

    // Obtener usuario por ID
    public function getById($id) {
        $stmt = $this->db->prepare("SELECT id, nombre, correo, celular, rol, foto_perfil, activo, fecha_creacion FROM usuarios WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    // Actualizar perfil de usuario
    public function actualizarPerfil($id, $nombre, $celular, $foto_perfil = null, $nueva_contrasena = null) {
        try {
            $sql = "UPDATE usuarios SET nombre = ?, celular = ?";
            $params = [$nombre, $celular];

            if (!empty($foto_perfil)) {
                $sql .= ", foto_perfil = ?";
                $params[] = $foto_perfil;
            }

            if (!empty($nueva_contrasena)) {
                $sql .= ", contrasena = ?";
                $params[] = password_hash($nueva_contrasena, PASSWORD_BCRYPT);
            }

            $sql .= " WHERE id = ?";
            $params[] = $id;

            $stmt = $this->db->prepare($sql);
            return $stmt->execute($params);
        } catch (Exception $e) {
            return false;
        }
    }

    // Obtener todos los usuarios (admin)
    public function getAll() {
        $stmt = $this->db->query("SELECT id, nombre, correo, celular, rol, foto_perfil, activo, fecha_creacion FROM usuarios ORDER BY fecha_creacion DESC");
        return $stmt->fetchAll();
    }

    // Contar usuarios por rol
    public function contarPorRol() {
        $stmt = $this->db->query("
            SELECT rol, COUNT(*) as total FROM usuarios GROUP BY rol
        ");
        $rows = $stmt->fetchAll();
        $conteo = ['administrador' => 0, 'usuario' => 0, 'total' => 0];
        foreach ($rows as $row) {
            $conteo[$row['rol']] = (int)$row['total'];
            $conteo['total'] += (int)$row['total'];
        }
        return $conteo;
    }

    // Cambiar rol (admin)
    public function cambiarRol($id, $rol) {
        $stmt = $this->db->prepare("UPDATE usuarios SET rol = ? WHERE id = ?");
        return $stmt->execute([$rol, $id]);
    }

    // Activar/desactivar usuario (admin)
    public function toggleActivo($id) {
        $stmt = $this->db->prepare("UPDATE usuarios SET activo = NOT activo WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
