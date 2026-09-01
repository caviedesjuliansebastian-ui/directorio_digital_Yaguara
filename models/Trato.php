<?php
class Trato extends Model {

    // Crear un trato / cotización (calcula 5% de comisión de la plataforma)
    public function crear($clienteId, $negocioId, $concepto, $montoTotal) {
        $comision = round($montoTotal * 0.05, 2); // 5% de comisión
        $stmt = $this->db->prepare("
            INSERT INTO tratos (cliente_id, negocio_id, concepto, monto_total, comision_plataforma, estado)
            VALUES (?, ?, ?, ?, ?, 'propuesto')
        ");
        $stmt->execute([$clienteId, $negocioId, trim($concepto), $montoTotal, $comision]);
        return $this->db->lastInsertId();
    }

    // Cerrar trato (Trato Cerrado)
    public function cerrar($tratoId) {
        $stmt = $this->db->prepare("
            UPDATE tratos 
            SET estado = 'cerrado', fecha_cierre = NOW() 
            WHERE id = ?
        ");
        return $stmt->execute([$tratoId]);
    }

    // Cancelar trato
    public function cancelar($tratoId) {
        $stmt = $this->db->prepare("
            UPDATE tratos 
            SET estado = 'cancelado' 
            WHERE id = ?
        ");
        return $stmt->execute([$tratoId]);
    }

    // Obtener tratos de una conversación
    public function getPorNegocioYCliente($negocioId, $clienteId) {
        $stmt = $this->db->prepare("
            SELECT * FROM tratos 
            WHERE negocio_id = ? AND cliente_id = ?
            ORDER BY fecha_creacion DESC
        ");
        $stmt->execute([$negocioId, $clienteId]);
        return $stmt->fetchAll();
    }

    // Métricas del proveedor (GMV, Tratos cerrados, comisiones)
    public function getMetricasProveedor($negocioId) {
        $stmt = $this->db->prepare("
            SELECT 
                COUNT(*) as total_tratos,
                SUM(CASE WHEN estado = 'cerrado' THEN 1 ELSE 0 END) as tratos_cerrados,
                COALESCE(SUM(CASE WHEN estado = 'cerrado' THEN monto_total ELSE 0 END), 0) as total_gmv,
                COALESCE(SUM(CASE WHEN estado = 'cerrado' THEN comision_plataforma ELSE 0 END), 0) as total_comisiones
            FROM tratos
            WHERE negocio_id = ?
        ");
        $stmt->execute([$negocioId]);
        return $stmt->fetch();
    }
}
