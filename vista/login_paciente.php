<?php
// Si ya tiene sesión, redirigir al panel
if(!empty($_SESSION['us_tipo']) && $_SESSION['rol'] == 'paciente'){
    header('Location: ' . APP_URL . '/panel/paciente');
    exit();
}
// Redirigir al nuevo home unificado
header('Location: ' . APP_URL . '/home');
exit();
?>