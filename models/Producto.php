<?php
class Producto extends Model {

    public function getByNegocio($negocioId) {
        $stmt = $this->db->prepare("SELECT * FROM productos WHERE negocio_id = ? ORDER BY fecha_creacion DESC");
        $stmt->execute([$negocioId]);
        return $stmt->fetchAll();
    }

    public function crear($datos) {
        $stmt = $this->db->prepare("
            INSERT INTO productos (negocio_id, nombre, descripcion, precio, unidad_medida, foto, disponible)
            VALUES (?, ?, ?, ?, ?, ?, ?)
        ");
        return $stmt->execute([
            $datos['negocio_id'],
            $datos['nombre'],
            $datos['descripcion'] ?? null,
            $datos['precio'],
            $datos['unidad_medida'],
            $datos['foto'] ?? null,
            $datos['disponible']
        ]);
    }
}
