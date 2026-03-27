<?php
/**
 * Controlador Dashboard
 */

class ControladorDashboard {
    public function index() {
        // Métricas
        $proyectos_por_estado = Database::query("
            SELECT estado, COUNT(*) as total 
            FROM proyectos 
            GROUP BY estado
        ")->fetchAll();
        
        $proyectos_atrasados = Database::query("
            SELECT COUNT(*) as total 
            FROM proyectos p 
            JOIN proyecto_etapas pe ON p.id = pe.proyecto_id 
            WHERE pe.estado = 'Atrasado'
            GROUP BY p.id
            HAVING COUNT(*) > 0
        ")->fetchColumn();
        
        $total_proyectos = Database::query("SELECT COUNT(*) FROM proyectos")->fetchColumn();
        $actividades_pendientes = Database::query("
            SELECT COUNT(*) FROM actividades 
            WHERE finalizado IS NULL
        ")->fetchColumn();
        
        $usuario_actual = Autenticacion::usuarioActual();
        
        $titulo = "Dashboard";
        ob_start();
        require __DIR__ . '/../vistas/dashboard/index.php';
        $contenido = ob_get_clean();
        require __DIR__ . '/../vistas/layouts/principal.php';
    }
}

