<?php
if(!empty($_SESSION['us_tipo']) && $_SESSION['rol'] == 'administrador'){
    header('Location: ' . APP_URL . '/panel/administrador');
    exit();
}
header('Location: ' . APP_URL . '/home');
exit();
?>