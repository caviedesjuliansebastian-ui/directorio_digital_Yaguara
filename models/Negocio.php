<?php
class Negocio extends Model {

    // Obtener todos los negocios (con filtros opcionales)
    public function getAll($estado = 'activo', $pagina = 1, $porPagina = null) {
        $porPagina = $porPagina ?? ITEMS_PER_PAGE;
        $offset = ($pagina - 1) * $porPagina;

        $stmt = $this->db->prepare("
            SELECT n.*, c.nombre as categoria_nombre, c.icono as categoria_icono, c.color as categoria_color,
                   s.nombre as sector_nombre, u.nombre as propietario_nombre
            FROM negocios n
            LEFT JOIN categorias c ON n.categoria_id = c.id
            LEFT JOIN sectores s ON n.sector_id = s.id
            LEFT JOIN usuarios u ON n.usuario_id = u.id
            WHERE n.estado = ?
            ORDER BY n.destacado DESC, n.fecha_creacion DESC
            LIMIT ? OFFSET ?
        ");
        $stmt->execute([$estado, $porPagina, $offset]);
        return $stmt->fetchAll();
    }

    // Contar total para paginación
    public function contarTotal($estado = 'activo') {
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM negocios WHERE estado = ?");
        $stmt->execute([$estado]);
        return (int)$stmt->fetchColumn();
    }

    // Obtener negocio por ID
    public function getById($id) {
        $stmt = $this->db->prepare("
            SELECT n.*, c.nombre as categoria_nombre, c.icono as categoria_icono, c.color as categoria_color,
                   s.nombre as sector_nombre, u.nombre as propietario_nombre, u.celular as propietario_celular
            FROM negocios n
            LEFT JOIN categorias c ON n.categoria_id = c.id
            LEFT JOIN sectores s ON n.sector_id = s.id
            LEFT JOIN usuarios u ON n.usuario_id = u.id
            WHERE n.id = ?
        ");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    // Obtener negocio por slug
    public function getBySlug($slug) {
        $stmt = $this->db->prepare("
            SELECT n.*, c.nombre as categoria_nombre, c.icono as categoria_icono, c.color as categoria_color,
                   s.nombre as sector_nombre, u.nombre as propietario_nombre, u.celular as propietario_celular
            FROM negocios n
            LEFT JOIN categorias c ON n.categoria_id = c.id
            LEFT JOIN sectores s ON n.sector_id = s.id
            LEFT JOIN usuarios u ON n.usuario_id = u.id
            WHERE n.slug = ? AND n.estado = 'activo'
        ");
        $stmt->execute([$slug]);
        return $stmt->fetch();
    }

    // Buscar negocios
    public function buscar($query = '', $categoriaId = null, $sectorId = null, $pagina = 1, $soloVerificados = false) {
        $porPagina = ITEMS_PER_PAGE;
        $offset = ($pagina - 1) * $porPagina;
        $params = [];

        $sql = "
            SELECT n.*, c.nombre as categoria_nombre, c.icono as categoria_icono, c.color as categoria_color,
                   s.nombre as sector_nombre
            FROM negocios n
            LEFT JOIN categorias c ON n.categoria_id = c.id
            LEFT JOIN sectores s ON n.sector_id = s.id
            WHERE n.estado = 'activo'
        ";

        if (!empty($query)) {
            $sql .= " AND (n.nombre LIKE ? OR n.descripcion LIKE ? OR n.direccion LIKE ?)";
            $params[] = '%' . $query . '%';
            $params[] = '%' . $query . '%';
            $params[] = '%' . $query . '%';
        }

        if ($categoriaId) {
            $sql .= " AND n.categoria_id = ?";
            $params[] = $categoriaId;
        }

        if ($sectorId) {
            $sql .= " AND n.sector_id = ?";
            $params[] = $sectorId;
        }
        
        if ($soloVerificados) {
            $sql .= " AND n.verificado = 1";
        }

        $sql .= " ORDER BY n.destacado DESC, n.verificado DESC, n.visitas DESC LIMIT ? OFFSET ?";
        $params[] = $porPagina;
        $params[] = $offset;

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    // Contar resultados de búsqueda
    public function contarBusqueda($query = '', $categoriaId = null, $sectorId = null, $soloVerificados = false) {
        $params = [];
        $sql = "SELECT COUNT(*) FROM negocios n WHERE n.estado = 'activo'";

        if (!empty($query)) {
            $sql .= " AND (n.nombre LIKE ? OR n.descripcion LIKE ? OR n.direccion LIKE ?)";
            $params[] = '%' . $query . '%';
            $params[] = '%' . $query . '%';
            $params[] = '%' . $query . '%';
        }
        if ($categoriaId) {
            $sql .= " AND n.categoria_id = ?";
            $params[] = $categoriaId;
        }
        if ($sectorId) {
            $sql .= " AND n.sector_id = ?";
            $params[] = $sectorId;
        }
        if ($soloVerificados) {
            $sql .= " AND n.verificado = 1";
        }

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return (int)$stmt->fetchColumn();
    }

    // Crear negocio
    public function crear($datos) {
        $slug = $this->generarSlugUnico($datos['nombre']);
        $stmt = $this->db->prepare("
            INSERT INTO negocios (usuario_id, categoria_id, sector_id, nombre, slug, descripcion, direccion,
                telefono, whatsapp, email, sitio_web, facebook, instagram, latitud, longitud, logo, imagen_portada, estado)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'pendiente')
        ");
        $stmt->execute([
            $datos['usuario_id'],
            $datos['categoria_id'] ?: null,
            $datos['sector_id'] ?: null,
            $datos['nombre'],
            $slug,
            $datos['descripcion'] ?? null,
            $datos['direccion'] ?? null,
            $datos['telefono'] ?? null,
            $datos['whatsapp'] ?? null,
            $datos['email'] ?? null,
            $datos['sitio_web'] ?? null,
            $datos['facebook'] ?? null,
            $datos['instagram'] ?? null,
            $datos['latitud'] ?? null,
            $datos['longitud'] ?? null,
            $datos['logo'] ?? null,
            $datos['imagen_portada'] ?? null
        ]);
        return $this->db->lastInsertId();
    }

    // Actualizar negocio
    public function actualizar($id, $datos) {
        $campos = [];
        $params = [];

        $permitidos = ['nombre', 'descripcion', 'direccion', 'telefono', 'whatsapp', 'email',
                        'sitio_web', 'facebook', 'instagram', 'latitud', 'longitud',
                        'categoria_id', 'sector_id', 'logo', 'imagen_portada'];

        foreach ($permitidos as $campo) {
            if (array_key_exists($campo, $datos)) {
                $campos[] = "$campo = ?";
                $params[] = $datos[$campo] ?: null;
            }
        }

        if (!empty($datos['nombre'])) {
            $campos[] = "slug = ?";
            $params[] = $this->generarSlugUnico($datos['nombre'], $id);
        }

        if (empty($campos)) return false;

        $params[] = $id;
        $sql = "UPDATE negocios SET " . implode(', ', $campos) . " WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute($params);
    }

    // Eliminar negocio
    public function eliminar($id) {
        $stmt = $this->db->prepare("DELETE FROM negocios WHERE id = ?");
        return $stmt->execute([$id]);
    }

    // Obtener negocios destacados
    public function getDestacados($limite = 6) {
        $stmt = $this->db->prepare("
            SELECT n.*, c.nombre as categoria_nombre, c.icono as categoria_icono, c.color as categoria_color,
                   s.nombre as sector_nombre
            FROM negocios n
            LEFT JOIN categorias c ON n.categoria_id = c.id
            LEFT JOIN sectores s ON n.sector_id = s.id
            WHERE n.estado = 'activo' AND n.destacado = 1
            ORDER BY n.visitas DESC
            LIMIT ?
        ");
        $stmt->execute([$limite]);
        $destacados = $stmt->fetchAll();

        // Si no hay suficientes destacados, rellenar con los más visitados
        if (count($destacados) < $limite) {
            $idsExcluir = array_column($destacados, 'id');
            $placeholders = !empty($idsExcluir) ? implode(',', array_fill(0, count($idsExcluir), '?')) : '0';
            $falta = $limite - count($destacados);

            $stmt2 = $this->db->prepare("
                SELECT n.*, c.nombre as categoria_nombre, c.icono as categoria_icono, c.color as categoria_color,
                       s.nombre as sector_nombre
                FROM negocios n
                LEFT JOIN categorias c ON n.categoria_id = c.id
                LEFT JOIN sectores s ON n.sector_id = s.id
                WHERE n.estado = 'activo' AND n.id NOT IN ($placeholders)
                ORDER BY n.visitas DESC
                LIMIT ?
            ");
            $params = array_merge($idsExcluir, [$falta]);
            $stmt2->execute($params);
            $destacados = array_merge($destacados, $stmt2->fetchAll());
        }

        return $destacados;
    }

    // Negocios por categoría
    public function getPorCategoria($categoriaId, $pagina = 1) {
        return $this->buscar('', $categoriaId, null, $pagina);
    }

    // Negocios por sector
    public function getPorSector($sectorId, $pagina = 1) {
        return $this->buscar('', null, $sectorId, $pagina);
    }

    // Negocios de un usuario
    public function getPorUsuario($usuarioId) {
        $stmt = $this->db->prepare("
            SELECT n.*, c.nombre as categoria_nombre, c.icono as categoria_icono,
                   s.nombre as sector_nombre
            FROM negocios n
            LEFT JOIN categorias c ON n.categoria_id = c.id
            LEFT JOIN sectores s ON n.sector_id = s.id
            WHERE n.usuario_id = ?
            ORDER BY n.fecha_creacion DESC
        ");
        $stmt->execute([$usuarioId]);
        return $stmt->fetchAll();
    }

    // Incrementar visitas
    public function incrementarVisitas($id) {
        $stmt = $this->db->prepare("UPDATE negocios SET visitas = visitas + 1 WHERE id = ?");
        return $stmt->execute([$id]);
    }

    // Promedio calificación
    public function getPromedioCalificacion($negocioId) {
        $stmt = $this->db->prepare("SELECT AVG(calificacion) as promedio, COUNT(*) as total FROM resenas WHERE negocio_id = ?");
        $stmt->execute([$negocioId]);
        $row = $stmt->fetch();
        return [
            'promedio' => $row['promedio'] ? round((float)$row['promedio'], 1) : 0,
            'total' => (int)$row['total']
        ];
    }

    // Cambiar estado (admin)
    public function cambiarEstado($id, $estado) {
        $stmt = $this->db->prepare("UPDATE negocios SET estado = ? WHERE id = ?");
        return $stmt->execute([$estado, $id]);
    }

    // Verificar negocio (admin)
    public function verificar($id, $verificado = true) {
        $stmt = $this->db->prepare("UPDATE negocios SET verificado = ? WHERE id = ?");
        return $stmt->execute([$verificado ? 1 : 0, $id]);
    }

    // Destacar negocio (admin)
    public function destacar($id, $destacado = true) {
        $stmt = $this->db->prepare("UPDATE negocios SET destacado = ? WHERE id = ?");
        return $stmt->execute([$destacado ? 1 : 0, $id]);
    }

    // Todos los negocios para admin
    public function getAllAdmin() {
        $stmt = $this->db->query("
            SELECT n.*, c.nombre as categoria_nombre, s.nombre as sector_nombre,
                   u.nombre as propietario_nombre, u.correo as propietario_correo
            FROM negocios n
            LEFT JOIN categorias c ON n.categoria_id = c.id
            LEFT JOIN sectores s ON n.sector_id = s.id
            LEFT JOIN usuarios u ON n.usuario_id = u.id
            ORDER BY 
                CASE n.estado 
                    WHEN 'pendiente' THEN 0 
                    WHEN 'activo' THEN 1 
                    WHEN 'inactivo' THEN 2 
                    WHEN 'rechazado' THEN 3 
                END,
                n.fecha_creacion DESC
        ");
        return $stmt->fetchAll();
    }

    // Estadísticas para dashboard admin
    public function getEstadisticas() {
        $stats = [];
        $stmt = $this->db->query("SELECT COUNT(*) FROM negocios WHERE estado = 'activo'");
        $stats['activos'] = (int)$stmt->fetchColumn();
        $stmt = $this->db->query("SELECT COUNT(*) FROM negocios WHERE estado = 'pendiente'");
        $stats['pendientes'] = (int)$stmt->fetchColumn();
        $stmt = $this->db->query("SELECT COUNT(*) FROM negocios");
        $stats['total'] = (int)$stmt->fetchColumn();
        $stmt = $this->db->query("SELECT COUNT(*) FROM negocios WHERE verificado = 1");
        $stats['verificados'] = (int)$stmt->fetchColumn();
        return $stats;
    }

    // Negocios para GeoJSON (API mapas)
    public function getParaMapa() {
        $stmt = $this->db->query("
            SELECT n.id, n.nombre, n.slug, n.direccion, n.latitud, n.longitud, n.logo,
                   c.nombre as categoria_nombre, c.icono as categoria_icono, c.color as categoria_color,
                   s.nombre as sector_nombre
            FROM negocios n
            LEFT JOIN categorias c ON n.categoria_id = c.id
            LEFT JOIN sectores s ON n.sector_id = s.id
            WHERE n.estado = 'activo' AND n.latitud IS NOT NULL AND n.longitud IS NOT NULL
        ");
        return $stmt->fetchAll();
    }

    // Generar slug único
    private function generarSlugUnico($nombre, $excluirId = null) {
        $slug = $this->generarSlug($nombre);
        $original = $slug;
        $counter = 1;

        while (true) {
            $sql = "SELECT id FROM negocios WHERE slug = ?";
            $params = [$slug];
            if ($excluirId) {
                $sql .= " AND id != ?";
                $params[] = $excluirId;
            }
            $stmt = $this->db->prepare($sql);
            $stmt->execute($params);
            if (!$stmt->fetch()) break;
            $slug = $original . '-' . $counter++;
        }

        return $slug;
    }

    private function generarSlug($texto) {
        $slug = strtolower(trim($texto));
        $slug = preg_replace('/[áàäâ]/u', 'a', $slug);
        $slug = preg_replace('/[éèëê]/u', 'e', $slug);
        $slug = preg_replace('/[íìïî]/u', 'i', $slug);
        $slug = preg_replace('/[óòöô]/u', 'o', $slug);
        $slug = preg_replace('/[úùüû]/u', 'u', $slug);
        $slug = preg_replace('/ñ/u', 'n', $slug);
        $slug = preg_replace('/[^a-z0-9]+/', '-', $slug);
        return trim($slug, '-');
    }
}
