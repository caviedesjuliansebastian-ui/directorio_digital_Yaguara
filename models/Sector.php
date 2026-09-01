<?php
class Sector extends Model {

    // Obtener todos los sectores activos
    public function getAll($soloActivos = true) {
        $sql = "SELECT * FROM sectores";
        if ($soloActivos) {
            $sql .= " WHERE activo = 1";
        }
        $sql .= " ORDER BY nombre ASC";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll();
    }

    // Obtener sector por ID
    public function getById($id) {
        $stmt = $this->db->prepare("SELECT * FROM sectores WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    // Obtener sector por slug
    public function getBySlug($slug) {
        $stmt = $this->db->prepare("SELECT * FROM sectores WHERE slug = ?");
        $stmt->execute([$slug]);
        return $stmt->fetch();
    }

    // Crear sector
    public function crear($datos) {
        $stmt = $this->db->prepare("INSERT INTO sectores (nombre, slug, descripcion, latitud, longitud, activo) VALUES (?, ?, ?, ?, ?, ?)");
        return $stmt->execute([
            $datos['nombre'],
            $this->generarSlug($datos['nombre']),
            $datos['descripcion'] ?? null,
            $datos['latitud'] ?? null,
            $datos['longitud'] ?? null,
            $datos['activo'] ?? 1
        ]);
    }

    // Actualizar sector
    public function actualizar($id, $datos) {
        $stmt = $this->db->prepare("UPDATE sectores SET nombre = ?, slug = ?, descripcion = ?, latitud = ?, longitud = ?, activo = ? WHERE id = ?");
        return $stmt->execute([
            $datos['nombre'],
            $this->generarSlug($datos['nombre']),
            $datos['descripcion'] ?? null,
            $datos['latitud'] ?? null,
            $datos['longitud'] ?? null,
            $datos['activo'] ?? 1,
            $id
        ]);
    }

    // Eliminar sector
    public function eliminar($id) {
        $stmt = $this->db->prepare("DELETE FROM sectores WHERE id = ?");
        return $stmt->execute([$id]);
    }

    // Sectores con conteo de negocios
    public function conConteoNegocios() {
        $stmt = $this->db->query("
            SELECT s.*, COUNT(n.id) as total_negocios
            FROM sectores s
            LEFT JOIN negocios n ON s.id = n.sector_id AND n.estado = 'activo'
            WHERE s.activo = 1
            GROUP BY s.id
            ORDER BY s.nombre ASC
        ");
        return $stmt->fetchAll();
    }

    // Generar slug
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
