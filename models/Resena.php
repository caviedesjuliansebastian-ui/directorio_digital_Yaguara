<?php
class Resena extends Model {

    // Obtener reseñas de un negocio
    public function getPorNegocio($negocioId, $limite = 20) {
        $stmt = $this->db->prepare("
            SELECT r.*, u.nombre as usuario_nombre, u.foto_perfil as usuario_foto
            FROM resenas r
            JOIN usuarios u ON r.usuario_id = u.id
            WHERE r.negocio_id = ?
            ORDER BY r.fecha_creacion DESC
            LIMIT ?
        ");
        $stmt->execute([$negocioId, $limite]);
        return $stmt->fetchAll();
    }

    // Crear reseña
    public function crear($negocioId, $usuarioId, $calificacion, $comentario = null) {
        // Verificar que no haya reseñado ya
        $stmt = $this->db->prepare("SELECT id FROM resenas WHERE negocio_id = ? AND usuario_id = ?");
        $stmt->execute([$negocioId, $usuarioId]);
        if ($stmt->fetch()) {
            return ['exito' => false, 'mensaje' => 'Ya has dejado una reseña en este negocio.'];
        }

        $stmt = $this->db->prepare("INSERT INTO resenas (negocio_id, usuario_id, calificacion, comentario) VALUES (?, ?, ?, ?)");
        $stmt->execute([$negocioId, $usuarioId, $calificacion, $comentario]);
        return ['exito' => true, 'mensaje' => '¡Reseña publicada!'];
    }

    // Eliminar reseña
    public function eliminar($id, $usuarioId = null) {
        $sql = "DELETE FROM resenas WHERE id = ?";
        $params = [$id];
        if ($usuarioId) {
            $sql .= " AND usuario_id = ?";
            $params[] = $usuarioId;
        }
        $stmt = $this->db->prepare($sql);
        return $stmt->execute($params);
    }

    // Promedio y total
    public function getPromedio($negocioId) {
        $stmt = $this->db->prepare("SELECT AVG(calificacion) as promedio, COUNT(*) as total FROM resenas WHERE negocio_id = ?");
        $stmt->execute([$negocioId]);
        $row = $stmt->fetch();
        return [
            'promedio' => $row['promedio'] ? round((float)$row['promedio'], 1) : 0,
            'total' => (int)$row['total']
        ];
    }

    // Distribución de calificaciones
    public function getDistribucion($negocioId) {
        $stmt = $this->db->prepare("
            SELECT calificacion, COUNT(*) as total
            FROM resenas WHERE negocio_id = ?
            GROUP BY calificacion ORDER BY calificacion DESC
        ");
        $stmt->execute([$negocioId]);
        $rows = $stmt->fetchAll();

        $dist = [5 => 0, 4 => 0, 3 => 0, 2 => 0, 1 => 0];
        foreach ($rows as $row) {
            $dist[(int)$row['calificacion']] = (int)$row['total'];
        }
        return $dist;
    }
}
