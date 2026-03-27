<?php
/**
 * Validador de formularios y seguridad
 */

class Validador {
    private $errores = [];

    public function validarRequerido($campo, $valor) {
        if (empty(trim($valor))) {
            $this->errores[$campo] = $campo . ' es requerido';
        }
    }

    public function validarEmail($campo, $email) {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->errores[$campo] = 'Email inválido';
        }
    }

    public function validarNumero($campo, $valor, $min = null, $max = null) {
        if (!is_numeric($valor)) {
            $this->errores[$campo] = $campo . ' debe ser numérico';
            return;
        }
        if ($min !== null && $valor < $min) {
            $this->errores[$campo] = $campo . ' mínimo ' . $min;
        }
        if ($max !== null && $valor > $max) {
            $this->errores[$campo] = $campo . ' máximo ' . $max;
        }
    }

    public function validarPorcentaje($valor) {
        $this->validarNumero('porcentaje', $valor, 0, 100);
    }

    public function tieneErrores() {
        return !empty($this->errores);
    }

    public function errores() {
        return $this->errores;
    }

    // Sanitizar input
    public static function sanitizar($data) {
        if (is_array($data)) {
            return array_map([self::class, 'sanitizar'], $data);
        }
        return htmlspecialchars(trim($data), ENT_QUOTES, 'UTF-8');
    }

    // CSRF token
    public static function generarTokenCSRF() {
        if (empty($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['csrf_token'];
    }

    public static function verificarTokenCSRF($token) {
        return hash_equals($_SESSION['csrf_token'] ?? '', $token);
    }
}

