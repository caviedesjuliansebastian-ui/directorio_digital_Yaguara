<?php
class ImagenNegocio extends Model {

    // Obtener imágenes de un negocio
    public function getPorNegocio($negocioId) {
        $stmt = $this->db->prepare("SELECT * FROM imagenes_negocio WHERE negocio_id = ? ORDER BY orden ASC, id ASC");
        $stmt->execute([$negocioId]);
        return $stmt->fetchAll();
    }

    // Agregar imagen
    public function agregar($negocioId, $urlImagen, $descripcion = null) {
        // Obtener orden máximo actual
        $stmt = $this->db->prepare("SELECT MAX(orden) FROM imagenes_negocio WHERE negocio_id = ?");
        $stmt->execute([$negocioId]);
        $maxOrden = (int)$stmt->fetchColumn();

        $stmt = $this->db->prepare("INSERT INTO imagenes_negocio (negocio_id, url_imagen, descripcion, orden) VALUES (?, ?, ?, ?)");
        return $stmt->execute([$negocioId, $urlImagen, $descripcion, $maxOrden + 1]);
    }

    // Eliminar imagen
    public function eliminar($id, $negocioId) {
        $stmt = $this->db->prepare("DELETE FROM imagenes_negocio WHERE id = ? AND negocio_id = ?");
        return $stmt->execute([$id, $negocioId]);
    }

    // Reordenar imágenes
    public function reordenar($negocioId, $idsOrdenados) {
        $stmt = $this->db->prepare("UPDATE imagenes_negocio SET orden = ? WHERE id = ? AND negocio_id = ?");
        foreach ($idsOrdenados as $orden => $id) {
            $stmt->execute([$orden, $id, $negocioId]);
        }
        return true;
    }

    // Contar imágenes de un negocio
    public function contar($negocioId) {
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM imagenes_negocio WHERE negocio_id = ?");
        $stmt->execute([$negocioId]);
        return (int)$stmt->fetchColumn();
    }
}
