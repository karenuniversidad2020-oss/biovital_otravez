<?php
class PageController {
    
    public function home() {
        if (isset($_SESSION['usuario']) && isset($_SESSION['rol'])) {
            $redirects = [
                'paciente' => 'panel/paciente',
                'medico' => 'panel/medico',
                'asistente' => 'panel/asistente',
                'administrador' => 'panel/administrador'
            ];
            if (isset($redirects[$_SESSION['rol']])) {
                redirect($redirects[$_SESSION['rol']]);
                return;
            }
        }
        renderView('home');
        
    } public function loginRedirect() {
        // Obtener el rol de los parámetros de la ruta
        // (disponible gracias a la captura que hicimos en routes.php)
        $rol = $_GET['rol'] ?? 'paciente';

        // Establecer una variable de sesión para que home.php sepa qué modal abrir
        $_SESSION['open_login'] = $rol;

        // Finalmente, cargar la vista home, que al iniciarse leerá esta variable
        $this->home();
    }
}
?>