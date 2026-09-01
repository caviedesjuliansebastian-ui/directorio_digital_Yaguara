<?php
class Favorito extends Model {

    // Toggle favorito (agregar o quitar)
    public function toggle($usuarioId, $negocioId) {
        $stmt = $this->db->prepare("SELECT id FROM favoritos WHERE usuario_id = ? AND negocio_id = ?");
        $stmt->execute([$usuarioId, $negocioId]);

        if ($stmt->fetch()) {
            // Quitar favorito
            $stmtDel = $this->db->prepare("DELETE FROM favoritos WHERE usuario_id = ? AND negocio_id = ?");
            $stmtDel->execute([$usuarioId, $negocioId]);
            return ['favorito' => false, 'mensaje' => 'Eliminado de favoritos'];
        } else {
            // Agregar favorito
            $stmtIns = $this->db->prepare("INSERT INTO favoritos (usuario_id, negocio_id) VALUES (?, ?)");
            $stmtIns->execute([$usuarioId, $negocioId]);
            return ['favorito' => true, 'mensaje' => 'Agregado a favoritos'];
        }
    }

    // Obtener array de IDs de negocios favoritos de un usuario
    public function getIdsPorUsuario($usuarioId) {
        if (!$usuarioId) return [];
        $stmt = $this->db->prepare("SELECT negocio_id FROM favoritos WHERE usuario_id = ?");
        $stmt->execute([$usuarioId]);
        return $stmt->fetchAll(PDO::FETCH_COLUMN) ?: [];
    }

    // Obtener favoritos de un usuario
    public function getPorUsuario($usuarioId) {
        $stmt = $this->db->prepare("
            SELECT n.*, c.nombre as categoria_nombre, c.icono as categoria_icono, c.color as categoria_color,
                   s.nombre as sector_nombre, f.fecha_creacion as fecha_favorito
            FROM favoritos f
            JOIN negocios n ON f.negocio_id = n.id
            LEFT JOIN categorias c ON n.categoria_id = c.id
            LEFT JOIN sectores s ON n.sector_id = s.id
            WHERE f.usuario_id = ? AND n.estado = 'activo'
            ORDER BY f.fecha_creacion DESC
        ");
        $stmt->execute([$usuarioId]);
        return $stmt->fetchAll();
    }

    // Verificar si es favorito
    public function esFavorito($usuarioId, $negocioId) {
        $stmt = $this->db->prepare("SELECT id FROM favoritos WHERE usuario_id = ? AND negocio_id = ?");
        $stmt->execute([$usuarioId, $negocioId]);
        return (bool)$stmt->fetch();
    }

    // Contar favoritos de un negocio
    public function contarPorNegocio($negocioId) {
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM favoritos WHERE negocio_id = ?");
        $stmt->execute([$negocioId]);
        return (int)$stmt->fetchColumn();
    }
}
