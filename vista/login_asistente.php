<?php
if(!empty($_SESSION['us_tipo']) && $_SESSION['rol'] == 'asistente'){
    header('Location: ' . APP_URL . '/panel/asistente');
    exit();
}
header('Location: ' . APP_URL . '/home');
exit();
?>