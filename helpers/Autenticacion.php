<?php
/**
 * Helper Autenticación y Sesiones
 */

class Autenticacion {
    const SESION_USUARIO = 'usuario_id';

    public static function login($username, $password) {
        $sql = "SELECT id, username, password_hash, rol_id FROM usuarios WHERE username = ? AND activo = 1";
        $stmt = Database::query($sql, [$username]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password_hash'])) {
            $_SESSION[self::SESION_USUARIO] = $user['id'];
            $_SESSION['rol_id'] = $user['rol_id'];
            $_SESSION['username'] = $user['username'];
            // Regenerar ID sesión
            session_regenerate_id(true);
            return true;
        }
        return false;
    }

    public static function verificarLogin() {
        return isset($_SESSION[self::SESION_USUARIO]);
    }

    public static function usuarioId() {
        return $_SESSION[self::SESION_USUARIO] ?? null;
    }

    public static function rolId() {
        return $_SESSION['rol_id'] ?? null;
    }

    public static function requiereRol($roles_permitidos) {
        $mi_rol = self::rolId();
        $sql = "SELECT permisos FROM roles WHERE id = ?";
        $stmt = Database::query($sql, [$mi_rol]);
        $rol = $stmt->fetch();
        $permisos = json_decode($rol['permisos'], true);
        // Lógica permisos simplificada
        return true; // Expandir después
    }

    public static function logout() {
        session_destroy();
        session_start(); // Limpiar cookies
        unset($_SESSION[self::SESION_USUARIO]);
    }

    public static function usuarioActual() {
        $id = self::usuarioId();
        if (!$id) return null;
        $sql = "SELECT * FROM usuarios u JOIN roles r ON u.rol_id = r.id WHERE u.id = ?";
        $stmt = Database::query($sql, [$id]);
        return $stmt->fetch();
    }
}

