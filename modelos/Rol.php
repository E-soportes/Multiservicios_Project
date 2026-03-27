<?php
/**
 * Modelo Rol
 */

class Rol {
    public static function todos() {
        return Database::query("SELECT * FROM roles ORDER BY nombre")->fetchAll();
    }

    public static function porId($id) {
        $sql = "SELECT * FROM roles WHERE id = ?";
        $stmt = Database::query($sql, [$id]);
        return $stmt->fetch();
    }
}

