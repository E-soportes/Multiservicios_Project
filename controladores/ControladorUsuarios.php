<?php
/**
 * Controlador Usuarios (CRUD admin)
 */

class ControladorUsuarios {
    public function index() {
        $usuarios = Usuario::todos();
        require __DIR__ . '/../vistas/usuarios/index.php';
    }

    public function crear() {
        $roles = Rol::todos();
        if ($_POST) {
            Usuario::crear($_POST);
            header('Location: /usuarios');
            exit;
        }
        require __DIR__ . '/../vistas/usuarios/crear.php';
    }

    public function editar($id) {
        $usuario = Usuario::porId($id);
        $roles = Rol::todos();
        if ($_POST) {
            Usuario::actualizar($id, $_POST);
            header('Location: /usuarios');
            exit;
        }
        require __DIR__ . '/../vistas/usuarios/editar.php';
    }

    public function eliminar($id) {
        Usuario::eliminar($id);
        header('Location: /usuarios');
        exit;
    }
}

