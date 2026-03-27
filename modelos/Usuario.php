<?php
/**
 * Modelo Usuario
 */

class Usuario {
    public static function todos($limite = 20) {
        $sql = "SELECT u.*, r.nombre as rol_nombre 
                FROM usuarios u 
                JOIN roles r ON u.rol_id = r.id 
                ORDER BY u.creado_en DESC 
                LIMIT ?";
        return Database::query($sql, [$limite])->fetchAll();
    }

    public static function porId($id) {
        $sql = "SELECT u.*, r.nombre as rol_nombre, r.permisos 
                FROM usuarios u 
                JOIN roles r ON u.rol_id = r.id 
                WHERE u.id = ?";
        return Database::query($sql, [$id])->fetch();
    }

    public static function crear($data) {
        $sql = "INSERT INTO usuarios (username, email, password_hash, rol_id) VALUES (?, ?, ?, ?)";
        Database::query($sql, [
            $data['username'],
            $data['email'],
            password_hash($data['password'], PASSWORD_DEFAULT),
            $data['rol_id']
        ]);
        return Database::getInstance()->lastInsertId();
    }

    public static function actualizar($id, $data) {
        $sql = "UPDATE usuarios SET username = ?, email = ?, rol_id = ? WHERE id = ?";
        Database::query($sql, [
            $data['username'],
            $data['email'],
            $data['rol_id'],
            $id
        ]);
    }

    public static function eliminar($id) {
        $sql = "DELETE FROM usuarios WHERE id = ?";
        Database::query($sql, [$id]);
    }
}

