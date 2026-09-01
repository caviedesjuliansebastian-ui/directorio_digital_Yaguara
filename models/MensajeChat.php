<?php
class MensajeChat extends Model {

    // Obtener conversación entre dos usuarios para un negocio
    public function getConversacion($usuario1, $usuario2, $negocioId) {
        $stmt = $this->db->prepare("
            SELECT m.*, u.nombre as emisor_nombre, u.foto_perfil as emisor_foto
            FROM mensajes_chat m
            JOIN usuarios u ON m.emisor_id = u.id
            WHERE m.negocio_id = ?
              AND ((m.emisor_id = ? AND m.receptor_id = ?) OR (m.emisor_id = ? AND m.receptor_id = ?))
            ORDER BY m.fecha_envio ASC
        ");
        $stmt->execute([$negocioId, $usuario1, $usuario2, $usuario2, $usuario1]);
        return $stmt->fetchAll();
    }

    // Enviar mensaje
    public function enviar($emisorId, $receptorId, $negocioId, $mensaje) {
        $stmt = $this->db->prepare("
            INSERT INTO mensajes_chat (emisor_id, receptor_id, negocio_id, mensaje, leido)
            VALUES (?, ?, ?, ?, 0)
        ");
        return $stmt->execute([$emisorId, $receptorId, $negocioId, trim($mensaje)]);
    }

    // Marcar mensajes como leídos
    public function marcarLeidos($emisorId, $receptorId, $negocioId) {
        $stmt = $this->db->prepare("
            UPDATE mensajes_chat
            SET leido = 1
            WHERE emisor_id = ? AND receptor_id = ? AND negocio_id = ?
        ");
        return $stmt->execute([$emisorId, $receptorId, $negocioId]);
    }

    // Bandeja de entrada (últimos chats de un usuario)
    public function getInbox($usuarioId) {
        $stmt = $this->db->prepare("
            SELECT m.*, 
                   n.nombre as negocio_nombre, n.slug as negocio_slug, n.logo as negocio_logo,
                   u_emisor.nombre as emisor_nombre,
                   u_receptor.nombre as receptor_nombre
            FROM mensajes_chat m
            JOIN negocios n ON m.negocio_id = n.id
            JOIN usuarios u_emisor ON m.emisor_id = u_emisor.id
            JOIN usuarios u_receptor ON m.receptor_id = u_receptor.id
            WHERE m.id IN (
                SELECT MAX(id) 
                FROM mensajes_chat 
                WHERE emisor_id = ? OR receptor_id = ?
                GROUP BY negocio_id, LEAST(emisor_id, receptor_id), GREATEST(emisor_id, receptor_id)
            )
            ORDER BY m.fecha_envio DESC
        ");
        $stmt->execute([$usuarioId, $usuarioId]);
        return $stmt->fetchAll();
    }
}
