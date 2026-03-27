<?php
/**
 * Modelo Cliente
 */

class Cliente {
    public static function todos() {
        return Database::query("SELECT * FROM clientes ORDER BY nombre")->fetchAll();
    }

    public static function crear($data) {
        $sql = "INSERT INTO clientes (nombre, contacto, telefono, email, observaciones) VALUES (?, ?, ?, ?, ?)";
        Database::query($sql, [
            $data['nombre'],
            $data['contacto'] ?? null,
            $data['telefono'] ?? null,
            $data['email'] ?? null,
            $data['observaciones'] ?? null
        ]);
        return Database::getInstance()->lastInsertId();
    }
}

