<?php
if(!empty($_SESSION['us_tipo']) && $_SESSION['rol'] == 'medico'){
    header('Location: ' . APP_URL . '/panel/medico');
    exit();
}
header('Location: ' . APP_URL . '/home');
exit();
?>