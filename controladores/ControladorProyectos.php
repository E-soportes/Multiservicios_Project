<?php
/**
 * Controlador Proyectos CRUD
 */

class ControladorProyectos {
    public function index() {
        $filtros = [];
        if ($_GET['busqueda'] ?? '') {
            $filtros['busqueda'] = trim($_GET['busqueda']);
        }
        if ($_GET['estado'] ?? '') {
            $filtros['estado'] = $_GET['estado'];
        }
        $proyectos = Proyecto::todos($filtros);
        $clientes = Cliente::todos();
        require __DIR__ . '/../vistas/proyectos/index.php';
    }

    public function crear() {
        $clientes = Cliente::todos();
        $usuarios = Usuario::todos(100); // Responsables
        if ($_POST) {
            $data = $_POST;
            $data['valor'] = str_replace(',', '', $data['valor']); // Limpiar
            $id = Proyecto::crear($data);
            header("Location: /proyectos/ver/$id");
            exit;
        }
        require __DIR__ . '/../vistas/proyectos/crear.php';
    }

    public function ver($id) {
        $proyecto = Proyecto::porId($id);
        $avance = Proyecto::avanceTotal($id);
        require __DIR__ . '/../vistas/proyectos/ver.php';
    }

    public function editar($id) {
        $proyecto = Proyecto::porId($id);
        $clientes = Cliente::todos();
        $usuarios = Usuario::todos(100);
        if ($_POST) {
            $data = $_POST;
            $data['valor'] = str_replace(',', '', $data['valor']);
            Proyecto::actualizar($id, $data);
            header("Location: /proyectos/ver/$id");
            exit;
        }
        require __DIR__ . '/../vistas/proyectos/editar.php';
    }

    public function eliminar($id) {
        Proyecto::eliminar($id);
        header('Location: /proyectos');
        exit;
    }
}

