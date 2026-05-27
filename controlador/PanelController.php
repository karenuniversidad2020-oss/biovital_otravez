<?php
// controlador/PanelController.php
class PanelController {
    
<<<<<<< HEAD
   public function paciente() {
    AuthHelper::checkRole('paciente', true);
    renderView('paciente/pac_catalogo');
}

public function medico() {
    AuthHelper::checkRole('medico', true);
    renderView('medico/med_catalogo');
}

public function asistente() {
    AuthHelper::checkRole('asistente', true);
    renderView('asistente/asi_catalogo');
}

public function administrador() {
    AuthHelper::checkRole('administrador', true);
    renderView('administrador/adm_catalogo');
}
=======
    public function paciente() {
        if ($_SESSION['rol'] !== 'paciente') {
            redirect('login');
        }
        renderView('paciente/pac_catalogo');
    }
    
    public function medico() {
        if ($_SESSION['rol'] !== 'medico') {
            redirect('login');
        }
        renderView('medico/med_catalogo');
    }
    
    public function asistente() {
        if ($_SESSION['rol'] !== 'asistente') {
            redirect('login');
        }
        renderView('asistente/asi_catalogo');
    }
    
    public function administrador() {
        if ($_SESSION['rol'] !== 'administrador') {
            redirect('login');
        }
        renderView('administrador/adm_catalogo');
    }
>>>>>>> d2039bf34adef6d12dd6c79371df596a3d39fedb
}
?>