<?php
/**
 * Entry point MVC - Router básico
 * @version 1.0
 */

session_start();
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../helpers/Autenticacion.php'; // Pendiente crear

// Autoload simple
spl_autoload_register(function ($class) {
    $paths = [
        __DIR__ . '/../controladores/',
        __DIR__ . '/../modelos/',
        __DIR__ . '/../helpers/'
    ];
    foreach ($paths as $path) {
        $file = $path . $class . '.php';
        if (file_exists($file)) {
            require_once $file;
            return;
        }
    }
});

// Configurar zona horaria
date_default_timezone_set('America/Bogota');

// Limpiar URL
$request_uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$request_uri = trim($request_uri, '/');
$segments = explode('/', $request_uri);

// Default controller/view
$controller = 'Dashboard';
$action = 'index';
$params = [];

if (!empty($segments[0])) {
    $controller = ucfirst($segments[0]) . 'Controller';
}
if (!empty($segments[1])) {
    $action = $segments[1];
}
if (isset($segments[2])) {
    $params[] = $segments[2];
}

// Middleware auth básica
if (!Autenticacion::verificarLogin() && $controller !== 'AuthController' && $action !== 'login') {
    header('Location: /autenticacion/login');
    exit;
}

// Cargar controller
$controller_file = __DIR__ . '/../controladores/' . $controller . '.php';
if (file_exists($controller_file)) {
    $controller_obj = new $controller();
    if (method_exists($controller_obj, $action)) {
        call_user_func_array([$controller_obj, $action], $params);
    } else {
        error404();
    }
} else {
    error404();
}

function error404() {
    http_response_code(404);
    echo "Página no encontrada";
    exit;
}

