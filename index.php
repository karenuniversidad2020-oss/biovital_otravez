<?php
// ==================== FRONT CONTROLLER ====================
<<<<<<< HEAD

// Detectar entorno
$environment = getenv('APP_ENV') ?: 'development';
$isProduction = ($environment === 'production');

// Configuración de errores (ANTES de cualquier otra cosa)
if ($isProduction) {
    error_reporting(0);
    ini_set('display_errors', 0);
    ini_set('display_startup_errors', 0);
    ini_set('log_errors', 1);
    
    $logDir = dirname(__FILE__) . '/logs';
    if (!is_dir($logDir)) {
        mkdir($logDir, 0755, true);
    }
    ini_set('error_log', $logDir . '/php_errors.log');
} else {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    ini_set('log_errors', 1);
}

// Incluir configuración de errores
require_once __DIR__ . '/config/errors.php';

// Iniciar sesión SOLO UNA VEZ al principio
if (session_status() === PHP_SESSION_NONE) {
    if ($isProduction) {
        ini_set('session.cookie_httponly', 1);
        ini_set('session.cookie_secure', 1);
        ini_set('session.cookie_samesite', 'Strict');
        ini_set('session.use_strict_mode', 1);
    }
=======
// Iniciar sesión SOLO UNA VEZ al principio
if (session_status() === PHP_SESSION_NONE) {
>>>>>>> d2039bf34adef6d12dd6c79371df596a3d39fedb
    session_start();
}

require_once 'config/app.php';

<<<<<<< HEAD
=======
// Configuración de errores (desactivar en producción)
error_reporting(E_ALL);
ini_set('display_errors', 1);

>>>>>>> d2039bf34adef6d12dd6c79371df596a3d39fedb
// Constantes de rutas
define('DS', DIRECTORY_SEPARATOR);
define('ROOT_PATH', dirname(__FILE__));
define('CONTROLLER_PATH', ROOT_PATH . DS . 'controlador');
define('MODEL_PATH', ROOT_PATH . DS . 'modelo');
define('VIEW_PATH', ROOT_PATH . DS . 'vista');
define('API_PATH', ROOT_PATH . DS . 'api');
define('IMG_PATH', ROOT_PATH . DS . 'img');
<<<<<<< HEAD
define('HELPER_PATH', ROOT_PATH . DS . 'helpers');

// Cargar helpers necesarios
if (file_exists(HELPER_PATH . DS . 'AuthHelper.php')) {
    require_once HELPER_PATH . DS . 'AuthHelper.php';
}
if (file_exists(HELPER_PATH . DS . 'ApiResponse.php')) {
    require_once HELPER_PATH . DS . 'ApiResponse.php';
}
=======
>>>>>>> d2039bf34adef6d12dd6c79371df596a3d39fedb

// Autoloader
spl_autoload_register(function($className) {
    $classMap = [
        'Security' => MODEL_PATH . DS . 'Security.php',
        'Conexion' => MODEL_PATH . DS . 'Conexion.php',
        'Paciente' => MODEL_PATH . DS . 'Paciente.php',
        'Medico' => MODEL_PATH . DS . 'Medico.php',
        'Asistente' => MODEL_PATH . DS . 'Asistente.php',
        'Administrador' => MODEL_PATH . DS . 'Administrador.php',
        'Consultorio' => MODEL_PATH . DS . 'Consultorio.php',
        'Receta' => MODEL_PATH . DS . 'Receta.php',
        'LoginPaciente' => MODEL_PATH . DS . 'LoginPaciente.php',
        'LoginMedico' => MODEL_PATH . DS . 'LoginMedico.php',
        'LoginAsistente' => MODEL_PATH . DS . 'LoginAsistente.php',
        'LoginAdministrador' => MODEL_PATH . DS . 'LoginAdministrador.php'
    ];
    
    if (isset($classMap[$className])) {
        require_once $classMap[$className];
        return;
    }
    
    $modelFile = MODEL_PATH . DS . $className . '.php';
    $controllerFile = CONTROLLER_PATH . DS . $className . '.php';
    
    if (file_exists($modelFile)) {
        require_once $modelFile;
    } elseif (file_exists($controllerFile)) {
        require_once $controllerFile;
    }
});

// Funciones auxiliares
function jsonResponse($data, $statusCode = 200) {
<<<<<<< HEAD
    if (class_exists('ApiResponse')) {
        ApiResponse::send(true, ApiResponse::CODE_SUCCESS, 'Operación exitosa', $data, $statusCode);
    } else {
        http_response_code($statusCode);
        header('Content-Type: application/json');
        echo json_encode($data);
        exit();
    }
=======
    http_response_code($statusCode);
    header('Content-Type: application/json');
    echo json_encode($data);
    exit();
>>>>>>> d2039bf34adef6d12dd6c79371df596a3d39fedb
}

function redirect($url, $permanent = false) {
    if ($permanent) {
        header('HTTP/1.1 301 Moved Permanently');
    }
    header('Location: ' . APP_URL . '/' . ltrim($url, '/'));
    exit();
}

function renderView($view, $data = []) {
    extract($data);
    $viewFile = VIEW_PATH . DS . $view . '.php';
    if (file_exists($viewFile)) {
        require_once $viewFile;
    } else {
        die("Vista no encontrada: {$view}");
    }
}

// ==================== ROUTER CON PARÁMETROS DINÁMICOS ====================
$requestUri = $_SERVER['REQUEST_URI'];
$scriptName = dirname($_SERVER['SCRIPT_NAME']);
$path = str_replace($scriptName, '', $requestUri);
$path = trim($path, '/');
$method = $_SERVER['REQUEST_METHOD'];
$isAjax = isset($_SERVER['HTTP_X_REQUESTED_WITH']) && 
          strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';

// Verificar si las rutas existen
$routesFile = ROOT_PATH . DS . 'config' . DS . 'routes.php';
if (!file_exists($routesFile)) {
    die("Error: Archivo de rutas no encontrado en: " . $routesFile);
}

<<<<<<< HEAD
=======
// Definición de rutas
>>>>>>> d2039bf34adef6d12dd6c79371df596a3d39fedb
$routes = require_once $routesFile;

function verificarRol($rolRequerido, $rolUsuario) {
    if (is_array($rolRequerido)) {
        return in_array($rolUsuario, $rolRequerido);
    }
    return $rolRequerido === $rolUsuario;
}

$routeFound = false;
$routeParams = [];
<<<<<<< HEAD
$isApiRoute = false;

$pathParts = explode('/', $path);

foreach ($routes as $route => $config) {
    $routeParts = explode('/', $route);
    
=======

// Dividir la URL solicitada en partes
$pathParts = explode('/', $path);

foreach ($routes as $route => $config) {
    // Dividir la ruta definida en partes
    $routeParts = explode('/', $route);
    
    // Verificar que tengan la misma cantidad de partes
>>>>>>> d2039bf34adef6d12dd6c79371df596a3d39fedb
    if (count($routeParts) !== count($pathParts)) {
        continue;
    }
    
    $match = true;
    $params = [];
    
<<<<<<< HEAD
    for ($i = 0; $i < count($routeParts); $i++) {
        if (strpos($routeParts[$i], ':') === 0) {
            $paramName = substr($routeParts[$i], 1);
            $params[$paramName] = $pathParts[$i];
            $_GET[$paramName] = $pathParts[$i];
        } 
=======
    // Comparar cada parte
    for ($i = 0; $i < count($routeParts); $i++) {
        // Si la parte de la ruta comienza con ":", es un parámetro dinámico
        if (strpos($routeParts[$i], ':') === 0) {
            $paramName = substr($routeParts[$i], 1);
            $params[$paramName] = $pathParts[$i];
            // Guardar en $_GET para que esté disponible en los controladores
            $_GET[$paramName] = $pathParts[$i];
        } 
        // Si no es parámetro, debe coincidir exactamente
>>>>>>> d2039bf34adef6d12dd6c79371df596a3d39fedb
        elseif ($routeParts[$i] !== $pathParts[$i]) {
            $match = false;
            break;
        }
    }
    
    if ($match) {
        $routeFound = true;
        $routeParams = $params;
        
<<<<<<< HEAD
        // Detectar si es una ruta de API (empieza con 'api/')
        $isApiRoute = (strpos($route, 'api/') === 0);
        
        // Verificar método HTTP
        if (isset($config['method']) && $config['method'] !== $method) {
            if ($isApiRoute || $isAjax) {
                if (class_exists('ApiResponse')) {
                    ApiResponse::error('Método no permitido', ApiResponse::CODE_SERVER_ERROR, [], 405);
                } else {
                    http_response_code(405);
                    die("Método no permitido");
                }
            } else {
                http_response_code(405);
                die("Método no permitido");
            }
=======
        // Verificar método HTTP
        if (isset($config['method']) && $config['method'] !== $method) {
            jsonResponse(['error' => 'Método no permitido'], 405);
>>>>>>> d2039bf34adef6d12dd6c79371df596a3d39fedb
        }
        
        // Verificar autenticación
        if (isset($config['auth']) && $config['auth'] === true) {
            if (!isset($_SESSION['usuario']) || !isset($_SESSION['rol'])) {
<<<<<<< HEAD
                if ($isApiRoute || $isAjax) {
                    if (class_exists('ApiResponse')) {
                        ApiResponse::unauthorized('Debe iniciar sesión para acceder a este recurso');
                    } else {
                        http_response_code(401);
                        die("No autorizado");
                    }
=======
                if ($isAjax) {
                    jsonResponse(['error' => 'Sesión no iniciada'], 401);
>>>>>>> d2039bf34adef6d12dd6c79371df596a3d39fedb
                } else {
                    redirect('login');
                }
            }
        }
        
        // Verificar rol
        if (isset($config['rol'])) {
            if (!isset($_SESSION['rol'])) {
<<<<<<< HEAD
                if ($isApiRoute || $isAjax) {
                    if (class_exists('ApiResponse')) {
                        ApiResponse::forbidden('No tiene permisos para acceder a este recurso');
                    } else {
                        http_response_code(403);
                        die("Prohibido");
                    }
=======
                if ($isAjax) {
                    jsonResponse(['error' => 'No autorizado'], 403);
>>>>>>> d2039bf34adef6d12dd6c79371df596a3d39fedb
                } else {
                    redirect('login');
                }
            }
            if (!verificarRol($config['rol'], $_SESSION['rol'])) {
<<<<<<< HEAD
                if ($isApiRoute || $isAjax) {
                    if (class_exists('ApiResponse')) {
                        ApiResponse::forbidden('Rol no autorizado para acceder a este recurso');
                    } else {
                        http_response_code(403);
                        die("Prohibido");
                    }
=======
                if ($isAjax) {
                    jsonResponse(['error' => 'No tiene permisos'], 403);
>>>>>>> d2039bf34adef6d12dd6c79371df596a3d39fedb
                } else {
                    redirect('login');
                }
            }
        }
        
        $controllerName = $config['controller'];
        $actionName = $config['action'];
        $controllerFile = CONTROLLER_PATH . DS . $controllerName . '.php';
        
        if (!file_exists($controllerFile)) {
<<<<<<< HEAD
            if ($isApiRoute || $isAjax) {
                if (class_exists('ApiResponse')) {
                    ApiResponse::serverError("Archivo de controlador no encontrado: {$controllerName}");
                } else {
                    http_response_code(500);
                    die("Error interno");
                }
            } else {
                die("Error: Archivo de controlador no encontrado: {$controllerName}");
            }
=======
            jsonResponse(['error' => "Archivo de controlador no encontrado: {$controllerName}"], 500);
>>>>>>> d2039bf34adef6d12dd6c79371df596a3d39fedb
        }
        
        require_once $controllerFile;
        
        if (!class_exists($controllerName)) {
<<<<<<< HEAD
            if ($isApiRoute || $isAjax) {
                if (class_exists('ApiResponse')) {
                    ApiResponse::serverError("Controlador '{$controllerName}' no encontrado");
                } else {
                    http_response_code(500);
                    die("Error interno");
                }
            } else {
                die("Error: Controlador '{$controllerName}' no encontrado");
            }
=======
            jsonResponse(['error' => "Controlador '{$controllerName}' no encontrado"], 500);
>>>>>>> d2039bf34adef6d12dd6c79371df596a3d39fedb
        }
        
        $controller = new $controllerName();
        
        if (!method_exists($controller, $actionName)) {
<<<<<<< HEAD
            if ($isApiRoute || $isAjax) {
                if (class_exists('ApiResponse')) {
                    ApiResponse::serverError("Acción '{$actionName}' no encontrada en {$controllerName}");
                } else {
                    http_response_code(500);
                    die("Error interno");
                }
            } else {
                die("Error: Acción '{$actionName}' no encontrada en {$controllerName}");
            }
        }
        
        // Iniciar buffer SOLO para rutas que NO son API
        // Las rutas API ya manejan su propia salida con ApiResponse
        if (!$isApiRoute) {
            ob_start();
=======
            jsonResponse(['error' => "Acción '{$actionName}' no encontrada en {$controllerName}"], 500);
>>>>>>> d2039bf34adef6d12dd6c79371df596a3d39fedb
        }
        
        // Ejecutar el controlador
        $controller->$actionName();
<<<<<<< HEAD
        
        // Si es una ruta que NO es API, capturar y mostrar la salida normalmente
        if (!$isApiRoute) {
            $output = ob_get_clean();
            
            // Verificar si el controlador ya envió headers (por ejemplo, con redirect)
            if (!headers_sent()) {
                // Si no hay salida, mostrar un mensaje por defecto
                if (empty($output)) {
                    echo "Vista renderizada correctamente.";
                } else {
                    echo $output;
                }
            }
        }
        
=======
>>>>>>> d2039bf34adef6d12dd6c79371df596a3d39fedb
        break;
    }
}

<<<<<<< HEAD
// ==================== MANEJO DE RUTAS NO ENCONTRADAS ====================
if (!$routeFound) {
    if ($isAjax) {
        if (class_exists('ApiResponse')) {
            ApiResponse::notFound("Ruta: {$path}");
        } else {
            http_response_code(404);
            echo json_encode(['error' => 'Ruta no encontrada']);
        }
=======
if (!$routeFound) {
    if ($isAjax) {
        jsonResponse(['error' => 'Ruta no encontrada: ' . $path], 404);
>>>>>>> d2039bf34adef6d12dd6c79371df596a3d39fedb
    } else {
        http_response_code(404);
        if (file_exists(VIEW_PATH . DS . 'errors' . DS . '404.php')) {
            renderView('errors/404');
        } else {
<<<<<<< HEAD
            echo "<!DOCTYPE html>
            <html>
            <head>
                <meta charset='UTF-8'>
                <title>404 - Página no encontrada</title>
                <style>
                    body { font-family: Arial, sans-serif; text-align: center; padding: 50px; }
                    h1 { font-size: 48px; color: #dc3545; }
                    p { font-size: 18px; color: #666; }
                </style>
            </head>
            <body>
                <h1>404</h1>
                <p>La página que buscas no existe.</p>
                <p><a href='" . APP_URL . "'>Volver al inicio</a></p>
            </body>
            </html>";
        }
    }
    exit();
}
=======
            echo "<h1>404 - Página no encontrada</h1>";
            echo "<p>La ruta solicitada no existe: {$path}</p>";
        }
    }
}
?>
>>>>>>> d2039bf34adef6d12dd6c79371df596a3d39fedb
