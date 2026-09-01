<?php
class Categoria extends Model {

    // Obtener todas las categorías activas
    public function getAll($soloActivas = true) {
        $sql = "SELECT * FROM categorias";
        if ($soloActivas) {
            $sql .= " WHERE activo = 1";
        }
        $sql .= " ORDER BY orden ASC, nombre ASC";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll();
    }

    // Obtener categoría por ID
    public function getById($id) {
        $stmt = $this->db->prepare("SELECT * FROM categorias WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    // Obtener categoría por slug
    public function getBySlug($slug) {
        $stmt = $this->db->prepare("SELECT * FROM categorias WHERE slug = ?");
        $stmt->execute([$slug]);
        return $stmt->fetch();
    }

    // Crear categoría
    public function crear($datos) {
        $stmt = $this->db->prepare("INSERT INTO categorias (nombre, slug, icono, descripcion, color, orden, activo) VALUES (?, ?, ?, ?, ?, ?, ?)");
        return $stmt->execute([
            $datos['nombre'],
            $this->generarSlug($datos['nombre']),
            $datos['icono'] ?? 'fas fa-store',
            $datos['descripcion'] ?? null,
            $datos['color'] ?? '#059669',
            $datos['orden'] ?? 0,
            $datos['activo'] ?? 1
        ]);
    }

    // Actualizar categoría
    public function actualizar($id, $datos) {
        $stmt = $this->db->prepare("UPDATE categorias SET nombre = ?, slug = ?, icono = ?, descripcion = ?, color = ?, orden = ?, activo = ? WHERE id = ?");
        return $stmt->execute([
            $datos['nombre'],
            $this->generarSlug($datos['nombre']),
            $datos['icono'] ?? 'fas fa-store',
            $datos['descripcion'] ?? null,
            $datos['color'] ?? '#059669',
            $datos['orden'] ?? 0,
            $datos['activo'] ?? 1,
            $id
        ]);
    }

    // Eliminar categoría
    public function eliminar($id) {
        $stmt = $this->db->prepare("DELETE FROM categorias WHERE id = ?");
        return $stmt->execute([$id]);
    }

    // Obtener categorías con conteo de negocios activos
    public function conConteoNegocios() {
        $stmt = $this->db->query("
            SELECT c.*, COUNT(n.id) as total_negocios
            FROM categorias c
            LEFT JOIN negocios n ON c.id = n.categoria_id AND n.estado = 'activo'
            WHERE c.activo = 1
            GROUP BY c.id
            ORDER BY c.orden ASC
        ");
        return $stmt->fetchAll();
    }

    // Generar slug desde nombre
    private function generarSlug($texto) {
        $slug = strtolower(trim($texto));
        $slug = preg_replace('/[áàäâ]/u', 'a', $slug);
        $slug = preg_replace('/[éèëê]/u', 'e', $slug);
        $slug = preg_replace('/[íìïî]/u', 'i', $slug);
        $slug = preg_replace('/[óòöô]/u', 'o', $slug);
        $slug = preg_replace('/[úùüû]/u', 'u', $slug);
        $slug = preg_replace('/ñ/u', 'n', $slug);
        $slug = preg_replace('/[^a-z0-9]+/', '-', $slug);
        $slug = trim($slug, '-');
        return $slug;
    }
}
