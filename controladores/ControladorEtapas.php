<?php
/**
 * Controlador Etapas por Proyecto
 */

class ControladorEtapas {
    public function proyecto($proyecto_id) {
        $proyecto = Proyecto::porId($proyecto_id);
        if (!$proyecto) {
            header('Location: /proyectos');
            exit;
        }
        
        $etapas = ProyectoEtapa::todasPorProyecto($proyecto_id);
        $etapas_master = Etapa::todas();
        $usuarios = Usuario::todos(100);
        $suma_porcentajes = ProyectoEtapa::sumaPorcentajes($proyecto_id);
        
        if ($_POST) {
            if (isset($_POST['asignar_etapa'])) {
                $data = $_POST;
                $data['proyecto_id'] = $proyecto_id;
                ProyectoEtapa::crear($data);
            } elseif (isset($_POST['actualizar_etapa'])) {
                $etapa_id = $_POST['etapa_id'];
                ProyectoEtapa::actualizar($etapa_id, $_POST);
            }
            header("Location: /etapas/proyecto/$proyecto_id");
            exit;
        }
        
        require __DIR__ . '/../vistas/etapas/proyecto.php';
    }
}

