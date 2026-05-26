<?php
// controlador/PanelController.php
class PanelController {
    
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
}
?>