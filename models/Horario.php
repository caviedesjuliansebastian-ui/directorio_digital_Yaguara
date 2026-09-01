<?php
class Horario extends Model {

    // Días de la semana en español
    private $dias = [
        0 => 'Domingo', 1 => 'Lunes', 2 => 'Martes', 3 => 'Miércoles',
        4 => 'Jueves', 5 => 'Viernes', 6 => 'Sábado'
    ];

    // Obtener horarios de un negocio
    public function getPorNegocio($negocioId) {
        $stmt = $this->db->prepare("SELECT * FROM horarios WHERE negocio_id = ? ORDER BY dia_semana ASC");
        $stmt->execute([$negocioId]);
        $rows = $stmt->fetchAll();

        // Indexar por día
        $horarios = [];
        foreach ($rows as $row) {
            $row['dia_nombre'] = $this->dias[$row['dia_semana']] ?? '';
            $horarios[$row['dia_semana']] = $row;
        }
        return $horarios;
    }

    // Guardar horarios completos (reemplaza todos)
    public function guardar($negocioId, $horariosData) {
        // Eliminar horarios actuales
        $stmtDel = $this->db->prepare("DELETE FROM horarios WHERE negocio_id = ?");
        $stmtDel->execute([$negocioId]);

        // Insertar nuevos
        $stmt = $this->db->prepare("INSERT INTO horarios (negocio_id, dia_semana, hora_apertura, hora_cierre, cerrado) VALUES (?, ?, ?, ?, ?)");

        foreach ($horariosData as $dia => $h) {
            $cerrado = !empty($h['cerrado']) ? 1 : 0;
            $stmt->execute([
                $negocioId,
                (int)$dia,
                $cerrado ? null : ($h['hora_apertura'] ?? null),
                $cerrado ? null : ($h['hora_cierre'] ?? null),
                $cerrado
            ]);
        }
        return true;
    }

    // Verificar si el negocio está abierto ahora
    public function estaAbierto($negocioId) {
        $diaActual = (int)date('w'); // 0=Domingo
        $horaActual = date('H:i:s');

        $stmt = $this->db->prepare("
            SELECT * FROM horarios 
            WHERE negocio_id = ? AND dia_semana = ?
        ");
        $stmt->execute([$negocioId, $diaActual]);
        $horario = $stmt->fetch();

        if (!$horario || $horario['cerrado']) {
            return false;
        }

        if ($horario['hora_apertura'] && $horario['hora_cierre']) {
            return ($horaActual >= $horario['hora_apertura'] && $horaActual <= $horario['hora_cierre']);
        }

        return true; // Si no tiene horarios definidos, se considera abierto
    }

    // Obtener nombre del día
    public function getNombreDia($numero) {
        return $this->dias[$numero] ?? '';
    }

    // Obtener todos los días
    public function getDias() {
        return $this->dias;
    }
}
