<?php
/**
 * Modelos Etapas
 */

class Etapa {
    public static function todas() {
        return Database::query("SELECT * FROM etapas ORDER BY orden")->fetchAll();
    }
}

class ProyectoEtapa {
    public static function todasPorProyecto($proyecto_id) {
        $sql = "SELECT pe.*, e.nombre, u.username as responsable_nombre 
                FROM proyecto_etapas pe
                JOIN etapas e ON pe.etapa_id = e.id
                LEFT JOIN usuarios u ON pe.responsable_id = u.id
                WHERE pe.proyecto_id = ? 
                ORDER BY e.orden";
        return Database::query($sql, [$proyecto_id])->fetchAll();
    }

    public static function crear($data) {
        $sql = "INSERT INTO proyecto_etapas (proyecto_id, etapa_id, responsable_id, porcentaje, 
                fecha_inicio, fecha_estimada, fecha_final, estado, avance, comentarios) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        Database::query($sql, [
            $data['proyecto_id'],
            $data['etapa_id'],
            $data['responsable_id'] ?? null,
            $data['porcentaje'],
            $data['fecha_inicio'] ?? null,
            $data['fecha_estimada'] ?? null,
            $data['fecha_final'] ?? null,
            $data['estado'],
            $data['avance'] ?? 0,
            $data['comentarios'] ?? null
        ]);
    }

    public static function actualizar($id, $data) {
        $sql = "UPDATE proyecto_etapas SET responsable_id = ?, porcentaje = ?, fecha_inicio = ?, 
                fecha_estimada = ?, fecha_final = ?, estado = ?, avance = ?, comentarios = ? WHERE id = ?";
        Database::query($sql, [
            $data['responsable_id'] ?? null,
            $data['porcentaje'],
            $data['fecha_inicio'] ?? null,
            $data['fecha_estimada'] ?? null,
            $data['fecha_final'] ?? null,
            $data['estado'],
            $data['avance'] ?? 0,
            $data['comentarios'] ?? null,
            $id
        ]);
    }

    public static function sumaPorcentajes($proyecto_id) {
        $sql = "SELECT SUM(porcentaje) as total FROM proyecto_etapas WHERE proyecto_id = ?";
        return Database::query($sql, [$proyecto_id])->fetchColumn();
    }
}

