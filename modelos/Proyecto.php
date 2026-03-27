<?php
/**
 * Modelo Proyecto
 */

class Proyecto {
    public static function todos($filtros = []) {
        $sql = "SELECT p.*, c.nombre as cliente_nombre, u.username as responsable_nombre 
                FROM proyectos p 
                LEFT JOIN clientes c ON p.cliente_id = c.id
                LEFT JOIN usuarios u ON p.responsable_id = u.id";
        
        $where = [];
        $params = [];
        
        if (!empty($filtros['estado'])) {
            $where[] = "p.estado = ?";
            $params[] = $filtros['estado'];
        }
        if (!empty($filtros['busqueda'])) {
            $where[] = "(p.nombre LIKE ? OR c.nombre LIKE ?)";
            $params[] = "%{$filtros['busqueda']}%";
            $params[] = "%{$filtros['busqueda']}%";
        }
        
        if (!empty($where)) {
            $sql .= " WHERE " . implode(' AND ', $where);
        }
        
        $sql .= " ORDER BY p.creado_en DESC";
        return Database::query($sql, $params)->fetchAll();
    }

    public static function porId($id) {
        $sql = "SELECT p.*, c.nombre as cliente_nombre 
                FROM proyectos p 
                LEFT JOIN clientes c ON p.cliente_id = c.id
                WHERE p.id = ?";
        return Database::query($sql, [$id])->fetch();
    }

    public static function crear($data) {
        $sql = "INSERT INTO proyectos (nombre, cliente_id, empresa, valor, fecha_inicio, fecha_fin, 
                estado, responsable_id, descripcion, prioridad, observaciones) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        Database::query($sql, [
            $data['nombre'],
            $data['cliente_id'] ?? null,
            $data['empresa'],
            $data['valor'],
            $data['fecha_inicio'],
            $data['fecha_fin'],
            $data['estado'],
            $data['responsable_id'] ?? null,
            $data['descripcion'],
            $data['prioridad'],
            $data['observaciones']
        ]);
        return Database::getInstance()->lastInsertId();
    }

    public static function actualizar($id, $data) {
        $sql = "UPDATE proyectos SET nombre = ?, cliente_id = ?, empresa = ?, valor = ?, 
                fecha_inicio = ?, fecha_fin = ?, estado = ?, responsable_id = ?, 
                descripcion = ?, prioridad = ?, observaciones = ? WHERE id = ?";
        Database::query($sql, [
            $data['nombre'],
            $data['cliente_id'] ?? null,
            $data['empresa'],
            $data['valor'],
            $data['fecha_inicio'],
            $data['fecha_fin'],
            $data['estado'],
            $data['responsable_id'] ?? null,
            $data['descripcion'],
            $data['prioridad'],
            $data['observaciones'],
            $id
        ]);
    }

    public static function eliminar($id) {
        Database::query("DELETE FROM proyectos WHERE id = ?", [$id]);
    }

    // Avance total proyecto (suma etapas)
    public static function avanceTotal($id) {
        $sql = "SELECT COALESCE(SUM(avance * porcentaje / 100.0), 0) as total_avance 
                FROM proyecto_etapas WHERE proyecto_id = ?";
        return Database::query($sql, [$id])->fetchColumn();
    }
}

