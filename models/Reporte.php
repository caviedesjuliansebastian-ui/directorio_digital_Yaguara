<?php
class Reporte extends Model {

    // Crear reporte
    public function crear($negocioId, $usuarioId, $motivo, $descripcion = null) {
        $stmt = $this->db->prepare("INSERT INTO reportes (negocio_id, usuario_id, motivo, descripcion) VALUES (?, ?, ?, ?)");
        $stmt->execute([$negocioId, $usuarioId, $motivo, $descripcion]);
        return ['exito' => true, 'mensaje' => 'Reporte enviado. Será revisado por el administrador.'];
    }

    // Obtener reportes pendientes
    public function getPendientes() {
        $stmt = $this->db->query("
            SELECT r.*, n.nombre as negocio_nombre, n.slug as negocio_slug,
                   u.nombre as usuario_nombre
            FROM reportes r
            JOIN negocios n ON r.negocio_id = n.id
            LEFT JOIN usuarios u ON r.usuario_id = u.id
            WHERE r.estado = 'pendiente'
            ORDER BY r.fecha_creacion DESC
        ");
        return $stmt->fetchAll();
    }

    // Marcar como revisado
    public function marcarRevisado($id, $estado = 'revisado') {
        $stmt = $this->db->prepare("UPDATE reportes SET estado = ? WHERE id = ?");
        return $stmt->execute([$estado, $id]);
    }

    // Contar pendientes
    public function contarPendientes() {
        $stmt = $this->db->query("SELECT COUNT(*) FROM reportes WHERE estado = 'pendiente'");
        return (int)$stmt->fetchColumn();
    }
}
