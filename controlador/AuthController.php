<?php
class AuthController {
    
    public function showLoginPaciente() {
        // Redirigir a la página principal con el parámetro para abrir el login
        header('Location: ' . APP_URL . '?openLogin=paciente');
        exit();
    }
    
    public function showLoginMedico() {
        header('Location: ' . APP_URL . '?openLogin=medico');
        exit();
    }
    
    public function showLoginAsistente() {
        header('Location: ' . APP_URL . '?openLogin=asistente');
        exit();
    }
    
    public function showLoginAdministrador() {
        header('Location: ' . APP_URL . '?openLogin=administrador');
        exit();
    }
    
    public function login() {
        $user = $_POST['user'] ?? '';
        $pass = $_POST['pass'] ?? '';
        $rol = $_POST['rol'] ?? '';
        
        $isAjax = isset($_SERVER['HTTP_X_REQUESTED_WITH']) && 
                  strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
        
        $loginMap = [
            'paciente' => ['class' => 'LoginPaciente', 'idField' => 'id_paciente', 'tipoField' => 'paciente_tipo', 'nameField' => 'nombre_paciente'],
            'medico' => ['class' => 'LoginMedico', 'idField' => 'id_medico', 'tipoField' => 'medico_tipo', 'nameField' => 'nombre_medico'],
            'asistente' => ['class' => 'LoginAsistente', 'idField' => 'id_asistente', 'tipoField' => 'asistente_tipo', 'nameField' => 'nombre_asistente'],
            'administrador' => ['class' => 'LoginAdministrador', 'idField' => 'id_administrador', 'tipoField' => 'administrador_tipo', 'nameField' => 'nombre_administrador']
        ];
        
        if (!isset($loginMap[$rol])) {
            if ($isAjax) jsonResponse(['success' => false, 'error' => 'Rol inválido']);
            redirect('?error=1');
            return;
        }
        
        $map = $loginMap[$rol];
        $login = new $map['class']();
        $login->Loguearse($user, $pass);
        
        if (!empty($login->objetos)) {
            foreach ($login->objetos as $objeto) {
                $_SESSION['usuario'] = $objeto->{$map['idField']};
                $_SESSION['us_tipo'] = $objeto->{$map['tipoField']};
                $_SESSION['nombre_us'] = $objeto->{$map['nameField']};
                $_SESSION['rol'] = $rol;
                $login->actualizarUltimoAcceso($objeto->{$map['idField']});
            }
            
            // Redirigir al panel correspondiente
            $redirectUrl = 'panel/' . $rol;
            
            if ($isAjax) {
                jsonResponse(['success' => true, 'redirect' => $redirectUrl]);
            } else {
                header('Location: ' . APP_URL . '/' . $redirectUrl);
                exit();
            }
        } else {
            if ($isAjax) {
                jsonResponse(['success' => false, 'error' => 'Cédula o contraseña incorrecta']);
            } else {
                redirect('?error=1');
            }
        }
    }
    
    public function logout() {
        session_destroy();
        redirect('');
    }
}
?>