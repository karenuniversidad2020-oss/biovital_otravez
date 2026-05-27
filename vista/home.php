<<<<<<< HEAD
=======
<?php
// Redireccionar si ya tiene sesión activa
if(isset($_SESSION['usuario']) && isset($_SESSION['rol'])){
    $redirects = [
        'paciente'      => 'panel/paciente',
        'medico'        => 'panel/medico',
        'asistente'     => 'panel/asistente',
        'administrador' => 'panel/administrador'
    ];
    if(isset($redirects[$_SESSION['rol']])){
        header('Location: ' . APP_URL . '/' . $redirects[$_SESSION['rol']]);
        exit();
    }
}
?>
>>>>>>> d2039bf34adef6d12dd6c79371df596a3d39fedb
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
<<<<<<< HEAD
    <title>BioVital - Sistema de Gestión Clínica</title>
    
    <!-- ==================== VARIABLE GLOBAL APP_URL ==================== -->
    <script>
        var APP_URL = '<?php echo rtrim(dirname($_SERVER['SCRIPT_NAME']), '/'); ?>';
        console.log('APP_URL:', APP_URL);
    </script>
    
    <!-- jQuery PRIMERO -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
        }
        
        /* Navbar */
        .navbar {
            background: rgba(255, 255, 255, 0.95);
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            padding: 15px 0;
        }
        
        .navbar-brand img {
            height: 50px;
        }
        
        .navbar-brand span {
            font-size: 1.5rem;
            font-weight: 700;
            color: #4e73df;
            margin-left: 10px;
        }
        
        /* Carrusel */
        .carousel {
            margin-top: 76px;
        }
        
        .carousel-item {
            height: 500px;
        }
        
        .carousel-item img {
            object-fit: cover;
            height: 100%;
            width: 100%;
        }
        
        .carousel-caption {
            background: rgba(0,0,0,0.5);
            border-radius: 10px;
            padding: 20px;
        }
        
        .carousel-caption h3 {
            font-size: 2rem;
            font-weight: 600;
        }
        
        /* Tarjetas de acceso */
        .access-section {
            padding: 60px 0;
            background: #f8f9fa;
        }
        
        .section-title {
            text-align: center;
            margin-bottom: 50px;
        }
        
        .section-title h2 {
            font-size: 2.5rem;
            color: #333;
            margin-bottom: 15px;
        }
        
        .section-title p {
            color: #666;
            font-size: 1.1rem;
        }
        
        .access-card {
            background: white;
            border-radius: 15px;
            padding: 30px;
            text-align: center;
            transition: transform 0.3s, box-shadow 0.3s;
            cursor: pointer;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            margin-bottom: 30px;
        }
        
        .access-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(0,0,0,0.2);
        }
        
        .access-card .icon {
            width: 80px;
            height: 80px;
            margin: 0 auto 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            font-size: 2.5rem;
            color: white;
        }
        
        .card-paciente .icon { background: #4e73df; }
        .card-medico .icon { background: #1cc88a; }
        .card-asistente .icon { background: #36b9cc; }
        .card-administrador .icon { background: #e74a3b; }
        
        .access-card h3 {
            font-size: 1.5rem;
            margin-bottom: 10px;
            color: #333;
        }
        
        .access-card p {
            color: #666;
            margin-bottom: 0;
        }
        
        /* Modal de login */
        .modal-content {
            border-radius: 15px;
            border: none;
        }
        
        .modal-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 15px 15px 0 0;
            border: none;
        }
        
        .modal-header .btn-close {
            filter: brightness(0) invert(1);
        }
        
        .login-form .input-group {
            margin-bottom: 20px;
        }
        
        .login-form .input-group-text {
            background: #f0f0f0;
            border: none;
            border-radius: 10px 0 0 10px;
        }
        
        .login-form .form-control {
            border: none;
            border-radius: 0 10px 10px 0;
            background: #f0f0f0;
            padding: 12px 15px;
        }
        
        .login-form .form-control:focus {
            box-shadow: none;
            background: #e8e8e8;
        }
        
        .btn-login {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            padding: 12px;
            border-radius: 10px;
            font-weight: 600;
            width: 100%;
            margin-top: 10px;
        }
        
        .btn-login:hover {
            transform: scale(1.02);
            background: linear-gradient(135deg, #5a67d8 0%, #6b46a0 100%);
        }
        
        .register-link {
            text-align: center;
            margin-top: 20px;
        }
        
        .register-link a {
            color: #4e73df;
            text-decoration: none;
        }
        
        .register-link a:hover {
            text-decoration: underline;
        }
        
        footer {
            background: #2c3e50;
            color: white;
            padding: 30px 0;
            text-align: center;
        }
        
        @media (max-width: 768px) {
            .carousel-item {
                height: 300px;
            }
            .carousel-caption h3 {
                font-size: 1.2rem;
            }
            .carousel-caption p {
                font-size: 0.8rem;
            }
        }
    </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg fixed-top">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center" href="<?php echo APP_URL; ?>">
            <img src="<?php echo APP_URL; ?>/img/logo_azul.png" alt="Logo">
            <span>BioVital</span>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link" href="#">Inicio</a></li>
                <li class="nav-item"><a class="nav-link" href="#">Servicios</a></li>
                <li class="nav-item"><a class="nav-link" href="#">Nosotros</a></li>
                <li class="nav-item"><a class="nav-link" href="#">Contacto</a></li>
            </ul>
        </div>
    </div>
</nav>

<!-- Carrusel -->
<div id="mainCarousel" class="carousel slide" data-bs-ride="carousel">
    <div class="carousel-indicators">
        <button type="button" data-bs-target="#mainCarousel" data-bs-slide-to="0" class="active"></button>
        <button type="button" data-bs-target="#mainCarousel" data-bs-slide-to="1"></button>
        <button type="button" data-bs-target="#mainCarousel" data-bs-slide-to="2"></button>
    </div>
    <div class="carousel-inner">
        <div class="carousel-item active">
            <img src="<?php echo APP_URL; ?>../img/Dotora1.jpg" class="d-block w-100" alt="Hospital">
            <div class="carousel-caption d-none d-md-block">
                <h3>Atención Médica de Calidad</h3>
                <p>Comprometidos con tu salud y bienestar</p>
            </div>
        </div>
        <div class="carousel-item">
            <img src="<?php echo APP_URL; ?>../img/banner.png" class="d-block w-100" alt="Médicos">
            <div class="carousel-caption d-none d-md-block">
                <h3>Profesionales Especializados</h3>
                <p>Contamos con los mejores especialistas</p>
            </div>
        </div>
        <div class="carousel-item">
            <img src="<?php echo APP_URL; ?>../img/imagen_tecnologia.png" class="d-block w-100" alt="Tecnología">
            <div class="carousel-caption d-none d-md-block">
                <h3>Tecnología de Punta</h3>
                <p>Equipos modernos para tu diagnóstico</p>
            </div>
        </div>
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#mainCarousel" data-bs-slide="prev">
        <span class="carousel-control-prev-icon"></span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#mainCarousel" data-bs-slide="next">
        <span class="carousel-control-next-icon"></span>
    </button>
</div>

<!-- Sección de Acceso -->
<section class="access-section">
    <div class="container">
        <div class="section-title">
            <h2>Portal de Acceso</h2>
            <p>Seleccione su perfil para acceder al sistema</p>
        </div>
        <div class="row">
            <div class="col-md-3">
                <div class="access-card card-paciente" data-rol="paciente">
                    <div class="icon">
                        <i class="fas fa-user"></i>
                    </div>
                    <h3>Paciente</h3>
                    <p>Acceda a sus recetas y citas médicas</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="access-card card-medico" data-rol="medico">
                    <div class="icon">
                        <i class="fas fa-user-md"></i>
                    </div>
                    <h3>Médico</h3>
                    <p>Gestione sus pacientes y recetas</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="access-card card-asistente" data-rol="asistente">
                    <div class="icon">
                        <i class="fas fa-user-nurse"></i>
                    </div>
                    <h3>Asistente</h3>
                    <p>Administre la agenda y pacientes</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="access-card card-administrador" data-rol="administrador">
                    <div class="icon">
                        <i class="fas fa-user-shield"></i>
                    </div>
                    <h3>Administrador</h3>
                    <p>Control total del sistema</p>
=======
    <title>BioVital - Consultoría Médica Inteligente</title>
    <meta name="description" content="BioVital - Tu salud es nuestra prioridad. Ecosistema médico digital con especialidades en cardiología, neumonología, psicología y pediatría.">
    <meta name="keywords" content="consultoría médica, salud, cardiología, neumonología, psicología, pediatría, BioVital">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="<?php echo APP_URL; ?>/css/home.css">
    
    <!-- ==================== VARIABLES GLOBALES PARA JAVASCRIPT ==================== -->
    <script>
        const APP_URL = '<?php echo APP_URL; ?>';
        // Pasar la variable de sesión de PHP a JavaScript (para el login redirect)
        const openLoginRol = '<?php echo $_SESSION['open_login'] ?? ''; ?>';
        <?php if(isset($_SESSION['open_login'])) unset($_SESSION['open_login']); ?>
    </script>
</head>
<body>

<!-- ============ HEADER NAVIGATION ============ -->
<header class="header" id="header">
    <nav class="navbar">
        <div class="nav-container">
            <div class="logo-container" onclick="scrollToSection('home')">
                <div class="logo-icon"><i class="fa-solid fa-heart-pulse"></i></div>
                <div class="logo-text">Bio<span>vital</span></div>
            </div>
            <ul class="nav-menu" id="navMenu">
                <li class="nav-item"><a href="#especializaciones" class="nav-link">Especialidades</a></li>
                <li class="nav-item"><a href="#nosotros" class="nav-link">Sobre Nosotros</a></li>
                <li class="nav-item"><a href="#ubicacion" class="nav-link">Ubicación</a></li>
                <li class="nav-item"><a href="<?php echo APP_URL; ?>/registro/paciente" class="nav-link btn-nav">Registrarse</a></li>
                <li class="nav-item"><a href="javascript:void(0)" onclick="scrollToSection('acceso')" class="nav-link btn-nav btn-nav-accent">Iniciar Sesión</a></li>
            </ul>
            <div class="hamburger" id="hamburger">
                <span class="bar"></span>
                <span class="bar"></span>
                <span class="bar"></span>
            </div>
        </div>
    </nav>
</header>

<!-- ============ IMAGE CAROUSEL ============ -->
<section class="image-carousel" id="carousel">
    <div class="carousel-container">
        <div class="carousel-wrapper">
            <div class="carousel-track">
                <div class="carousel-slide">
                    <img src="<?php echo APP_URL; ?>/img/banner.jpeg.png" alt="Instalaciones Modernas" class="carousel-img">
                    <div class="carousel-caption">
                        <h3>Instalaciones Modernas</h3>
                        <p>Tecnología de última generación al servicio de tu salud</p>
                    </div>
                </div>
                <div class="carousel-slide">
                    <img src="<?php echo APP_URL; ?>/img/Doctoraaaa.jpeg.png" alt="Equipo Médico" class="carousel-img">
                    <div class="carousel-caption">
                        <h3>Equipo Médico Especializado</h3>
                        <p>Profesionales altamente calificados comprometidos contigo</p>
                    </div>
                </div>
                <div class="carousel-slide">
                    <img src="<?php echo APP_URL; ?>/img/locacion.jpeg.png" alt="Atención Personalizada" class="carousel-img">
                    <div class="carousel-caption">
                        <h3>Atención Personalizada</h3>
                        <p>Cuidado individual adaptado a cada paciente</p>
                    </div>
                </div>
            </div>
            <button class="carousel-btn carousel-btn-prev" id="prevBtn" aria-label="Anterior"><i class="fas fa-chevron-left"></i></button>
            <button class="carousel-btn carousel-btn-next" id="nextBtn" aria-label="Siguiente"><i class="fas fa-chevron-right"></i></button>
        </div>
        <div class="carousel-indicators">
            <button class="indicator active" data-slide="0" aria-label="Slide 1"></button>
            <button class="indicator" data-slide="1" aria-label="Slide 2"></button>
            <button class="indicator" data-slide="2" aria-label="Slide 3"></button>
        </div>
    </div>
</section>

<!-- ============ HERO SECTION ============ -->
<section class="hero" id="home">
    <div class="hero-bg-shapes">
        <div class="shape shape-1"></div>
        <div class="shape shape-2"></div>
        <div class="shape shape-3"></div>
    </div>
    <div class="hero-content">
        <div class="hero-text">
            <h1 class="hero-title">Tu Salud es Nuestra <span class="gradient-text">Prioridad</span></h1>
            <p class="hero-subtitle">Ecosistema médico digital de última generación. Accede a consultas, especialidades y seguimiento desde una sola plataforma.</p>
        </div>
        <div class="specialties-grid" id="especializaciones">
            <div class="specialty-card" data-specialty="general">
                <div class="specialty-icon"><i class="fas fa-stethoscope"></i></div>
                <span class="specialty-name">GENERAL</span>
            </div>
            <div class="specialty-card" data-specialty="cardiologia">
                <div class="specialty-icon"><i class="fas fa-heartbeat"></i></div>
                <span class="specialty-name">CARDIOLOGÍA</span>
            </div>
            <div class="specialty-card" data-specialty="neumonologia">
                <div class="specialty-icon"><i class="fas fa-lungs"></i></div>
                <span class="specialty-name">NEUMOLOGÍA</span>
            </div>
            <div class="specialty-card" data-specialty="psicologia">
                <div class="specialty-icon"><i class="fas fa-brain"></i></div>
                <span class="specialty-name">PSICOLOGÍA</span>
            </div>
            <div class="specialty-card" data-specialty="pediatria">
                <div class="specialty-icon"><i class="fas fa-baby"></i></div>
                <span class="specialty-name">PEDIATRÍA</span>
            </div>
        </div>
    </div>
</section>

<!-- ============ ABOUT US SECTION ============ -->
<section class="about" id="nosotros">
    <div class="about-container">
        <div class="about-image">
            <img src="<?php echo APP_URL; ?>/img/Doctoraaaa.jpeg.png" alt="Profesional de la salud" class="about-img">
            <div class="about-image-badge"><i class="fas fa-award"></i><span>Certificados</span></div>
        </div>
        <div class="about-content">
            <span class="section-tag"><i class="fas fa-info-circle"></i> Conócenos</span>
            <h2 class="about-title">Excelencia Médica con Tecnología de Vanguardia</h2>
            <p class="about-text">En BioVital, nos comprometemos a ofrecer servicios médicos de la más alta calidad con un equipo de profesionales altamente calificados y experimentados. Nuestra misión es brindar atención médica integral y personalizada.</p>
            <p class="about-text">Contamos con tecnología de última generación e instalaciones modernas para asegurar diagnósticos precisos y tratamientos efectivos en todas nuestras especialidades.</p>
            <div class="about-stats">
                <div class="stat-item">
                    <span class="stat-number" data-count="15">0</span><span class="stat-suffix">+</span>
                    <span class="stat-label">Años de Experiencia</span>
                </div>
                <div class="stat-item">
                    <span class="stat-number" data-count="50">0</span><span class="stat-suffix">+</span>
                    <span class="stat-label">Médicos Especializados</span>
                </div>
                <div class="stat-item">
                    <span class="stat-number" data-count="10">0</span><span class="stat-suffix">K+</span>
                    <span class="stat-label">Pacientes Atendidos</span>
>>>>>>> d2039bf34adef6d12dd6c79371df596a3d39fedb
                </div>
            </div>
        </div>
    </div>
</section>

<<<<<<< HEAD
<!-- Modal de Login -->
<div class="modal fade" id="loginModal" tabindex="-1" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitle">Iniciar Sesión</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="loginForm" class="login-form">
                    <input type="hidden" id="rol" name="rol" value="">
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                        <input type="text" class="form-control" id="cedula" name="user" placeholder="Cédula" required>
                    </div>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-lock"></i></span>
                        <input type="password" class="form-control" id="password" name="pass" placeholder="Contraseña" required>
                    </div>
                    <button type="submit" class="btn btn-primary btn-login">
                        <i class="fas fa-sign-in-alt"></i> Iniciar Sesión
                    </button>
                    <div class="register-link" id="registerLink">
                        <a href="#" id="registerButton">¿No tienes cuenta? Regístrate aquí</a>
                    </div>
                    <div id="loginError" class="alert alert-danger mt-3" style="display:none;"></div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Footer -->
<footer>
    <div class="container">
        <p>&copy; 2024 BioVital - Sistema de Gestión Clínica. Todos los derechos reservados.</p>
    </div>
</footer>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
$(document).ready(function() {
    // Verificar que APP_URL esté definida
    if (typeof APP_URL === 'undefined') {
        console.error('APP_URL no está definida');
        window.APP_URL = '';
    }
    
    console.log('APP_URL:', APP_URL);
    
    var currentRol = '';
    var modal = null;
    
    // Función para abrir el modal con un rol específico
    function abrirModalConRol(rol) {
        console.log('abrirModalConRol llamado con rol:', rol);
        
        var titulo = '';
        var registerUrl = '';
        
        switch(rol) {
            case 'paciente':
                titulo = 'Acceso Paciente';
                registerUrl = APP_URL + '/registro/paciente';
                break;
            case 'medico':
                titulo = 'Acceso Médico';
                registerUrl = APP_URL + '/registro/medico';
                break;
            case 'asistente':
                titulo = 'Acceso Asistente';
                registerUrl = APP_URL + '/registro/asistente';
                break;
            case 'administrador':
                titulo = 'Acceso Administrador';
                registerUrl = APP_URL + '/registro/administrador';
                break;
            default:
                console.error('Rol no válido:', rol);
                return false;
        }
        
        // Verificar que los elementos existan
        if ($('#modalTitle').length === 0) {
            console.error('Elemento #modalTitle no encontrado');
            return false;
        }
        
        if ($('#rol').length === 0) {
            console.error('Elemento #rol no encontrado');
            return false;
        }
        
        if ($('#registerButton').length === 0) {
            console.error('Elemento #registerButton no encontrado');
            return false;
        }
        
        $('#modalTitle').text(titulo);
        $('#rol').val(rol);
        $('#registerButton').attr('href', registerUrl);
        
        // Limpiar formulario
        $('#cedula').val('');
        $('#password').val('');
        $('#loginError').hide();
        
        // Crear y abrir modal si no existe, o reutilizar
        var modalElement = document.getElementById('loginModal');
        if (!modalElement) {
            console.error('Modal #loginModal no encontrado');
            return false;
        }
        
        if (!modal) {
            modal = new bootstrap.Modal(modalElement);
        }
        modal.show();
        
        console.log('Modal abierto para rol:', rol);
        return true;
    }
    
    // ==================== ABRIR MODAL AUTOMÁTICAMENTE ====================
    // Verificar si hay parámetro openLogin en la URL
    var urlParams = new URLSearchParams(window.location.search);
    var openLogin = urlParams.get('openLogin');
    
    if (openLogin) {
        console.log('Parámetro openLogin detectado:', openLogin);
        
        // Pequeño retraso para asegurar que el DOM esté completamente cargado
        setTimeout(function() {
            var success = abrirModalConRol(openLogin);
            if (success) {
                // Limpiar el parámetro de la URL para que no se quede visible
                var newUrl = window.location.protocol + "//" + window.location.host + window.location.pathname;
                window.history.replaceState({}, document.title, newUrl);
                console.log('URL limpiada:', newUrl);
            } else {
                console.error('No se pudo abrir el modal para el rol:', openLogin);
                // Mostrar mensaje de error en la consola pero no al usuario
            }
        }, 200); // Pequeño retraso para asegurar que todo esté listo
    }
    // ==================== FIN ABRIR MODAL AUTOMÁTICO ====================
    
    // Abrir modal según el rol seleccionado (click en tarjetas)
    $('.access-card').on('click', function() {
        var rol = $(this).data('rol');
        console.log('Tarjeta clickeada, rol:', rol);
        abrirModalConRol(rol);
    });
    
    // Procesar login
    $('#loginForm').on('submit', function(e) {
        e.preventDefault();
        
        console.log('Formulario de login enviado');
        
        var rol = $('#rol').val();
        var cedula = $('#cedula').val().trim();
        var password = $('#password').val();
        
        console.log('Datos:', { rol: rol, cedula: cedula, password: password ? '***' : '' });
        
        if (!rol) {
            mostrarError('Por favor seleccione un rol');
            return;
        }
        
        if (!cedula) {
            mostrarError('Por favor ingrese su cédula');
            return;
        }
        
        if (!password) {
            mostrarError('Por favor ingrese su contraseña');
            return;
        }
        
        // Deshabilitar botón mientras se procesa
        var $btn = $(this).find('button[type="submit"]');
        var originalText = $btn.html();
        $btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Ingresando...');
        
        $.ajax({
            url: APP_URL + '/login',
            type: 'POST',
            data: {
                user: cedula,
                pass: password,
                rol: rol
            },
            dataType: 'json',
            timeout: 15000,
            success: function(response) {
                console.log('Respuesta login:', response);
                
                if (response.success) {
                    // Redirigir al panel correspondiente
                    var redirectUrl = APP_URL + '/panel/' + rol;
                    console.log('Login exitoso, redirigiendo a:', redirectUrl);
                    window.location.href = redirectUrl;
                } else {
                    mostrarError(response.error || 'Cédula o contraseña incorrecta');
                    $btn.prop('disabled', false).html(originalText);
                }
            },
            error: function(xhr, status, error) {
                console.error('Error en login:', status, error);
                console.error('Respuesta del servidor:', xhr.responseText);
                
                var errorMsg = 'Error de conexión. ';
                if (xhr.status === 404) {
                    errorMsg += 'El servidor no responde. Verifique que el sistema esté funcionando.';
                } else if (xhr.status === 500) {
                    errorMsg += 'Error interno del servidor.';
                } else {
                    errorMsg += 'Intente nuevamente.';
                }
                
                mostrarError(errorMsg);
                $btn.prop('disabled', false).html(originalText);
            }
        });
    });
    
    function mostrarError(mensaje) {
        console.error('Error:', mensaje);
        var $errorDiv = $('#loginError');
        if ($errorDiv.length) {
            $errorDiv.text(mensaje).fadeIn();
            setTimeout(function() {
                $errorDiv.fadeOut();
            }, 5000);
        } else {
            alert(mensaje);
        }
    }
});
</script>

=======
<!-- ============ ROLE ACCESS SECTION ============ -->
<section class="access-section" id="acceso">
    <div class="access-container">
        <div class="section-header">
            <span class="section-tag"><i class="fas fa-lock-open"></i> Portal de Acceso</span>
            <h2 class="section-title">Ecosistema Digital <span class="gradient-text">Biovital</span></h2>
            <p class="section-subtitle">Selecciona tu perfil para acceder a la plataforma</p>
        </div>

        <!-- HOME VIEW - Role Cards -->
        <div id="home-view" class="view-section active">
            <div class="roles-grid">
                <div class="role-card" onclick="openLogin('paciente', 'fa-user-injured')">
                    <div class="role-icon-wrapper"><i class="fa-solid fa-user-injured"></i></div>
                    <h3>Paciente</h3>
                    <p>Accede a tu historial clínico, agenda citas y descarga recetas.</p>
                </div>
                <div class="role-card" onclick="openLogin('medico', 'fa-user-md')">
                    <div class="role-icon-wrapper"><i class="fa-solid fa-user-md"></i></div>
                    <h3>Médico</h3>
                    <p>Gestiona pacientes, genera diagnósticos y controla horarios.</p>
                </div>
                <div class="role-card" onclick="openLogin('asistente', 'fa-clipboard-list')">
                    <div class="role-icon-wrapper"><i class="fa-solid fa-clipboard-list"></i></div>
                    <h3>Asistente</h3>
                    <p>Organiza flujos de la clínica y agendas de especialistas.</p>
                </div>
                <div class="role-card" onclick="openLogin('administrador', 'fa-sliders')">
                    <div class="role-icon-wrapper"><i class="fa-solid fa-sliders"></i></div>
                    <h3>Administrador</h3>
                    <p>Supervisa métricas operativas, gestiona accesos y seguridad.</p>
                </div>
            </div>
        </div>

        <!-- LOGIN VIEW -->
        <div id="login-view" class="view-section">
            <div class="form-wrapper">
                <button class="back-btn" onclick="showView('home-view')"><i class="fa-solid fa-arrow-left"></i> Volver</button>
                <h2>¡Hola de nuevo!</h2>
                <div id="login-badge" class="role-badge"></div>
                <div id="login-error" class="alert-error">
                    <i class="fa-solid fa-circle-exclamation"></i>
                    <span id="login-error-msg"></span>
                </div>
                <form id="form-login">
                    <input type="hidden" name="rol" id="login-rol" value="">
                    <div class="input-group">
                        <div class="input-wrapper">
                            <input type="text" name="user" id="login-user" placeholder="Cédula de identidad" required>
                            <i class="fa-solid fa-id-card"></i>
                        </div>
                    </div>
                    <div class="input-group">
                        <div class="input-wrapper">
                            <input type="password" name="pass" id="login-pass" placeholder="Contraseña de seguridad" required>
                            <i class="fa-solid fa-lock"></i>
                        </div>
                    </div>
                    <button type="submit" class="submit-btn" id="login-submit-btn">
                        <i class="fas fa-sign-in-alt"></i> Autenticar Entrada
                    </button>
                </form>
                <div class="form-footer" id="signup-redirect"></div>
            </div>
        </div>
    </div>
</section>

<!-- ============ LOCATIONS SECTION ============ -->
<section class="locations" id="ubicacion">
    <div class="locations-container">
        <div class="section-header">
            <span class="section-tag"><i class="fas fa-map-marker-alt"></i> Encuéntranos</span>
            <h2 class="section-title">Nuestras <span class="gradient-text">Sucursales</span></h2>
        </div>
        <div class="locations-grid">
            <div class="location-card">
                <div class="location-icon"><i class="fas fa-map-marker-alt"></i></div>
                <h3 class="location-name">CARACAS (Principal)</h3>
                <p class="location-address">Av. Principal con Calle Secundaria, Edificio Médico, Piso 3</p>
                <p class="location-phone"><i class="fas fa-phone"></i> +58 212-1234567</p>
                <p class="location-email"><i class="fas fa-envelope"></i> caracas@biovital.com</p>
                <button class="location-btn" onclick="showMap('caracas')"><i class="fas fa-directions"></i> Ver en mapa</button>
            </div>
            <div class="location-card">
                <div class="location-icon"><i class="fas fa-map-marker-alt"></i></div>
                <h3 class="location-name">CARACAS (Este)</h3>
                <p class="location-address">Av. Este con Calle Norte, Centro Médico Este, Piso 2</p>
                <p class="location-phone"><i class="fas fa-phone"></i> +58 212-7654321</p>
                <p class="location-email"><i class="fas fa-envelope"></i> este@biovital.com</p>
                <button class="location-btn" onclick="showMap('caracas-este')"><i class="fas fa-directions"></i> Ver en mapa</button>
            </div>
            <div class="location-card">
                <div class="location-icon"><i class="fas fa-map-marker-alt"></i></div>
                <h3 class="location-name">MARACAIBO (Zulia)</h3>
                <p class="location-address">Av. del Lago con Calle 15, Hospital Zulia, Piso 1</p>
                <p class="location-phone"><i class="fas fa-phone"></i> +58 261-9876543</p>
                <p class="location-email"><i class="fas fa-envelope"></i> maracaibo@biovital.com</p>
                <button class="location-btn" onclick="showMap('maracaibo')"><i class="fas fa-directions"></i> Ver en mapa</button>
            </div>
        </div>
    </div>
</section>


<!-- ============ FOOTER ============ -->
<footer class="footer">
    <div class="footer-container">
        <div class="footer-content">
            <div class="footer-brand">
                <div class="footer-logo-container">
                    <div class="logo-icon footer-logo-icon"><i class="fa-solid fa-heart-pulse"></i></div>
                    <div class="logo-text">Bio<span>vital</span></div>
                </div>
                <p class="footer-description">Plataforma tecnológica hospitalaria certificada. Tu bienestar, nuestra misión.</p>
                <div class="social-icons">
                    <a href="#" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
                    <a href="#" aria-label="Twitter"><i class="fab fa-twitter"></i></a>
                    <a href="#" aria-label="LinkedIn"><i class="fab fa-linkedin-in"></i></a>
                </div>
            </div>
            <div class="footer-links">
                <div class="footer-section">
                    <h4>Especialidades</h4>
                    <ul>
                        <li><a href="#especializaciones">Medicina General</a></li>
                        <li><a href="#especializaciones">Cardiología</a></li>
                        <li><a href="#especializaciones">Neumología</a></li>
                        <li><a href="#especializaciones">Psicología</a></li>
                        <li><a href="#especializaciones">Pediatría</a></li>
                    </ul>
                </div>
                <div class="footer-section">
                    <h4>Sucursales</h4>
                    <ul>
                        <li><a href="#ubicacion">Caracas (Principal)</a></li>
                        <li><a href="#ubicacion">Caracas (Este)</a></li>
                        <li><a href="#ubicacion">Maracaibo (Zulia)</a></li>
                    </ul>
                </div>
                <div class="footer-section">
                    <h4>Contacto</h4>
                    <ul>
                        <li><i class="fas fa-phone"></i> <a href="tel:+582121234567">+58 212-1234567</a></li>
                        <li><i class="fas fa-envelope"></i> <a href="mailto:info@biovital.com">info@biovital.com</a></li>
                        <li><i class="fas fa-clock"></i> Lun-Vie: 8AM - 6PM</li>
                        <li><i class="fas fa-calendar"></i> Sáb: 9AM - 1PM</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="footer-bottom">
            <p>© 2026 BioVital. Todos los derechos reservados. Plataforma Tecnológica Hospitalaria.</p>
        </div>
    </div>
</footer>

<!-- ============ SPECIALTY MODAL ============ -->
<div class="modal" id="specialtyModal">
    <div class="modal-content">
        <span class="close-modal" onclick="closeSpecialtyModal()">×</span>
        <div id="specialtyModalBody"></div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="<?php echo APP_URL; ?>/js/home.js"></script>
<script>
    // ==================== INICIALIZACIÓN DEL LOGIN ====================
    document.addEventListener('DOMContentLoaded', function() {
        // 1. Verificar si hay un parámetro en la URL (método antiguo, por compatibilidad)
        const urlParams = new URLSearchParams(window.location.search);
        const openLogin = urlParams.get('openLogin');
        
        if (openLogin && (openLogin === 'paciente' || openLogin === 'medico' || openLogin === 'asistente' || openLogin === 'administrador')) {
            let iconClass = '';
            switch(openLogin) {
                case 'paciente': iconClass = 'fa-user-injured'; break;
                case 'medico': iconClass = 'fa-user-md'; break;
                case 'asistente': iconClass = 'fa-clipboard-list'; break;
                case 'administrador': iconClass = 'fa-sliders'; break;
                default: iconClass = 'fa-user';
            }
            openLogin(openLogin, iconClass);
            // Limpiar la URL para que no se vea feo
            window.history.replaceState({}, document.title, window.location.pathname);
        }
        
        // 2. Verificar si hay una variable de sesión (método nuevo con ruta amigable)
        if (typeof openLoginRol !== 'undefined' && openLoginRol && openLoginRol !== '') {
            let iconClass = '';
            switch(openLoginRol) {
                case 'paciente': iconClass = 'fa-user-injured'; break;
                case 'medico': iconClass = 'fa-user-md'; break;
                case 'asistente': iconClass = 'fa-clipboard-list'; break;
                case 'administrador': iconClass = 'fa-sliders'; break;
                default: iconClass = 'fa-user';
            }
            // Pequeño retraso para asegurar que el DOM está listo
            setTimeout(function() {
                openLogin(openLoginRol, iconClass);
            }, 100);
        }
    });
</script>
>>>>>>> d2039bf34adef6d12dd6c79371df596a3d39fedb
</body>
</html>