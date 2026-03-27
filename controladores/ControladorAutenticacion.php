<?php
/**
 * Controlador Autenticación
 */

class ControladorAutenticacion {
    public function login() {
        if ($_POST) {
            $username = trim($_POST['username']);
            $password = $_POST['password'];
            
            if (Autenticacion::login($username, $password)) {
                header('Location: /dashboard');
                exit;
            } else {
                $error = "Credenciales inválidas";
            }
        }
        require __DIR__ . '/../vistas/autenticacion/login.php';
    }

    public function logout() {
        Autenticacion::logout();
        header('Location: /autenticacion/login');
        exit;
    }

    public function register() {
        // Solo admin puede registrar
        if (!Autenticacion::verificarLogin()) {
            header('Location: /autenticacion/login');
            exit;
        }
        
        if ($_POST) {
            // Validaciones + insert usuario
            $username = trim($_POST['username']);
            $email = trim($_POST['email']);
            $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
            $rol_id = $_POST['rol_id'];
            
            try {
                $sql = "INSERT INTO usuarios (username, email, password_hash, rol_id) VALUES (?, ?, ?, ?)";
                Database::query($sql, [$username, $email, $password, $rol_id]);
                $success = "Usuario creado exitosamente";
            } catch (Exception $e) {
                $error = "Error: " . $e->getMessage();
            }
        }
        
        // Obtener roles
        $roles = Database::query("SELECT id, nombre FROM roles")->fetchAll();
        require __DIR__ . '/../vistas/autenticacion/register.php';
    }
}

