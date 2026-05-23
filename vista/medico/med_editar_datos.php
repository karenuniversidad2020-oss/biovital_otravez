<?php
// NO session_start() - el Front Controller ya lo hace
if($_SESSION['us_tipo'] != 2 || $_SESSION['rol'] != 'medico'){
    header('Location: ' . APP_URL . '/login/medico');
    exit();
}

$id_medico = $_SESSION['usuario'];
$nombre_usuario = $_SESSION['nombre_us'];
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <script>
        var APP_URL = '<?php echo APP_URL; ?>';
        console.log('APP_URL:', APP_URL);
    </script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="<?php echo APP_URL; ?>/js/config.js"></script>
    <script src="<?php echo APP_URL; ?>/js/csrf.js"></script>
    
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo APP_URL; ?>/css/css/all.min.css">
    <link rel="stylesheet" href="<?php echo APP_URL; ?>/css/adminlte.min.css">
    <link rel="stylesheet" href="<?php echo APP_URL; ?>/css/dashboard.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <title>Médico | Mi Perfil</title>
    
    <style>
        .profile-header {
            background: linear-gradient(135deg, #0d9488, #0f766e);
            border-radius: 16px;
            padding: 2rem;
            margin-bottom: 1.5rem;
            position: relative;
            overflow: hidden;
        }
        .profile-header::before {
            content: '';
            position: absolute;
            top: -30%;
            right: -5%;
            width: 200px;
            height: 200px;
            background: rgba(255,255,255,0.08);
            border-radius: 50%;
        }
        .profile-header::after {
            content: '';
            position: absolute;
            bottom: -20%;
            left: -5%;
            width: 150px;
            height: 150px;
            background: rgba(255,255,255,0.05);
            border-radius: 50%;
        }
        .profile-avatar {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            border: 4px solid white;
            box-shadow: 0 4px 15px rgba(0,0,0,0.15);
            object-fit: cover;
            transition: transform 0.3s;
        }
        .profile-avatar:hover {
            transform: scale(1.05);
        }
        .info-card {
            border-radius: 16px;
            border: none;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
            transition: transform 0.3s, box-shadow 0.3s;
            margin-bottom: 1.5rem;
        }
        .info-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 28px rgba(0,0,0,0.12);
        }
        .info-card .card-header {
            background: white;
            border-bottom: 2px solid #0d9488;
            padding: 1rem 1.5rem;
        }
        .info-card .card-header h3 {
            font-size: 1.1rem;
            font-weight: 700;
            margin: 0;
            color: var(--bv-dark);
        }
        .info-item {
            padding: 0.75rem 0;
            border-bottom: 1px solid #eef2f6;
        }
        .info-item:last-child {
            border-bottom: none;
        }
        .info-label {
            font-weight: 600;
            color: var(--bv-text-light);
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .info-value {
            font-weight: 500;
            color: var(--bv-dark);
            margin-top: 0.25rem;
        }
        .btn-editar {
            background: linear-gradient(135deg, #0d9488, #0f766e);
            border: none;
            border-radius: 10px;
            padding: 0.6rem 1.5rem;
            font-weight: 600;
            transition: all 0.3s;
        }
        .btn-editar:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(13,148,136,0.3);
        }
        .form-card {
            border-radius: 16px;
            border: none;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        }
        .form-card .card-header {
            background: white;
            border-bottom: 2px solid #0d9488;
            padding: 1rem 1.5rem;
        }
        .form-control, .form-select {
            border-radius: 10px;
            border: 1.5px solid #e2e8f0;
            padding: 0.6rem 1rem;
            transition: all 0.3s;
        }
        .form-control:focus, .form-select:focus {
            border-color: #0d9488;
            box-shadow: 0 0 0 3px rgba(13,148,136,0.1);
        }
        .btn-guardar {
            background: linear-gradient(135deg, #10b981, #059669);
            border: none;
            border-radius: 10px;
            padding: 0.7rem 2rem;
            font-weight: 600;
            transition: all 0.3s;
        }
        .btn-guardar:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(16,185,129,0.3);
        }
        .alert-custom {
            border-radius: 12px;
            border: none;
            padding: 1rem;
        }
        .required-field::after {
            content: " *";
            color: #dc3545;
        }
        .csrf-info {
            font-size: 0.75rem;
            color: #94a3b8;
            text-align: center;
            margin-top: 1rem;
        }
        .badge-role {
            background: rgba(255,255,255,0.2);
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
        }
    </style>
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">

<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
    </ul>
    <ul class="navbar-nav ml-auto">
        <a href="<?php echo APP_URL; ?>/logout" class="btn btn-danger btn-sm">
            <i class="fas fa-sign-out-alt"></i> Cerrar sesión
        </a>
    </ul>
</nav>

<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="<?php echo APP_URL; ?>/panel/medico" class="brand-link">
        <img src="<?php echo APP_URL; ?>/img/logo_azul.png" alt="Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">BIOVITAL</span>
    </a>
    <div class="sidebar">
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img id="avatar_nav" src="<?php echo APP_URL; ?>/img/avatar.png" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block"><?php echo htmlspecialchars($nombre_usuario); ?></a>
            </div>
        </div>
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu">
                <li class="nav-header">
                    <i class="fas fa-user-md"></i> Usuario
                </li>
                <li class="nav-item">
                    <a href="<?php echo APP_URL; ?>/perfil" class="nav-link active">
                        <i class="nav-icon fas fa-user-cog"></i>
                        <p>Datos personales</p>
                    </a>
                </li>
                <li class="nav-header">
                    <i class="fas fa-clinic-medical"></i> Clínica
                </li>
                <li class="nav-item">
                    <a href="<?php echo APP_URL; ?>/recetas" class="nav-link">
                        <i class="nav-icon fas fa-prescription-bottle-alt"></i>
                        <p>Recetas</p>
                    </a>
                </li>
                <li class="nav-header">
                    <i class="fas fa-users"></i> Pacientes
                </li>
                <li class="nav-item">
                    <a href="<?php echo APP_URL; ?>/medico/pacientes" class="nav-link">
                        <i class="nav-icon fas fa-users"></i>
                        <p>Mis Pacientes</p>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</aside>

<!-- Modal Cambiar Contraseña -->
<div class="modal fade" id="cambiocontra" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius: 16px;">
            <div class="modal-header" style="background: linear-gradient(135deg, #0d9488, #0f766e); color: white; border-radius: 16px 16px 0 0;">
                <h5 class="modal-title"><i class="fas fa-key"></i> Cambiar contraseña</h5>
                <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="text-center mb-3">
                    <img id="avatar3" src="<?php echo APP_URL; ?>/img/avatar.png" class="profile-avatar" style="width: 80px; height: 80px;">
                    <h5 class="mt-2"><?php echo htmlspecialchars($nombre_usuario); ?></h5>
                </div>
                <div class="alert alert-success alert-custom" id="update" style="display:none;">
                    <i class="fas fa-check-circle"></i> Contraseña actualizada correctamente
                </div>
                <div class="alert alert-danger alert-custom" id="noupdate" style="display:none;">
                    <i class="fas fa-exclamation-circle"></i> Contraseña actual incorrecta
                </div>
                <form id="form-pass">
                    <?php echo Security::campoCSRF(); ?>
                    <div class="form-group">
                        <label>Contraseña actual</label>
                        <input type="password" id="oldpass" class="form-control" placeholder="Ingrese su contraseña actual" required>
                    </div>
                    <div class="form-group">
                        <label>Contraseña nueva</label>
                        <input type="password" id="newpass" class="form-control" placeholder="Mínimo 6 caracteres" required>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Guardar cambios</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Cambiar Avatar -->
<div class="modal fade" id="cambiophoto" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius: 16px;">
            <div class="modal-header" style="background: linear-gradient(135deg, #0d9488, #0f766e); color: white; border-radius: 16px 16px 0 0;">
                <h5 class="modal-title"><i class="fas fa-camera"></i> Cambiar avatar</h5>
                <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="text-center mb-3">
                    <img id="avatar_modal" src="<?php echo APP_URL; ?>/img/avatarDES.jpg" class="profile-avatar" style="width: 100px; height: 100px;">
                    <h5 class="mt-2"><?php echo htmlspecialchars($nombre_usuario); ?></h5>
                </div>
                <div class="alert alert-success alert-custom" id="edit" style="display:none;">
                    <i class="fas fa-check-circle"></i> Avatar actualizado correctamente
                </div>
                <div class="alert alert-danger alert-custom" id="noedit" style="display:none;">
                    <i class="fas fa-exclamation-circle"></i> Formato no admitido. Use JPG, PNG o GIF
                </div>
                <form id="form-photo" enctype="multipart/form-data">
                    <?php echo Security::campoCSRF(); ?>
                    <div class="form-group">
                        <label>Seleccionar imagen</label>
                        <input type="file" name="photo" class="form-control" accept="image/jpeg,image/png,image/gif" required>
                        <small class="text-muted">Formatos permitidos: JPG, PNG, GIF. Tamaño máximo: 5MB</small>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Guardar cambios</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Content Wrapper -->
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><i class="fas fa-user-circle"></i> Mi Perfil</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?php echo APP_URL; ?>/panel/medico">Home</a></li>
                        <li class="breadcrumb-item active">Mi Perfil</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <input type="hidden" id="id_usuario" value="<?php echo htmlspecialchars($id_medico); ?>">
            
            <div class="row">
                <!-- COLUMNA IZQUIERDA - PERFIL VISUAL -->
                <div class="col-md-4">
                    <!-- Profile Header -->
                    <div class="profile-header text-white">
                        <div class="text-center">
                            <img id="avatar2" src="<?php echo APP_URL; ?>/img/avatarDES.jpg" class="profile-avatar mb-3">
                            <h3 id="nombre_us" class="mb-0">Cargando...</h3>
                            <p id="apellidos_us" class="opacity-75 mb-2">Cargando...</p>
                            <span class="badge-role"><i class="fas fa-user-md"></i> Médico</span>
                            <div class="mt-2">
                                <button type="button" data-toggle="modal" data-target="#cambiophoto" class="btn btn-light btn-sm">
                                    <i class="fas fa-camera"></i> Cambiar avatar
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Información Personal Card -->
                    <div class="info-card">
                        <div class="card-header">
                            <h3><i class="fas fa-id-card"></i> Información Personal</h3>
                        </div>
                        <div class="card-body">
                            <div class="info-item">
                                <div class="info-label"><i class="fas fa-birthday-cake"></i> Edad</div>
                                <div class="info-value" id="edad">-</div>
                            </div>
                            <div class="info-item">
                                <div class="info-label"><i class="fas fa-id-card"></i> Cédula</div>
                                <div class="info-value" id="cedula_us">-</div>
                            </div>
                            <div class="info-item">
                                <div class="info-label"><i class="fas fa-venus-mars"></i> Sexo</div>
                                <div class="info-value" id="sexo_us">-</div>
                            </div>
                        </div>
                    </div>

                    <!-- Contacto Card -->
                    <div class="info-card">
                        <div class="card-header">
                            <h3><i class="fas fa-address-card"></i> Contacto</h3>
                        </div>
                        <div class="card-body">
                            <div class="info-item">
                                <div class="info-label"><i class="fas fa-phone"></i> Teléfono</div>
                                <div class="info-value" id="telefono_us">-</div>
                            </div>
                            <div class="info-item">
                                <div class="info-label"><i class="fas fa-envelope"></i> Correo Electrónico</div>
                                <div class="info-value" id="correo_us">-</div>
                            </div>
                            <div class="info-item">
                                <div class="info-label"><i class="fas fa-map-marker-alt"></i> Dirección</div>
                                <div class="info-value" id="direccion_us">-</div>
                            </div>
                            <div class="info-item">
                                <div class="info-label"><i class="fas fa-pencil-alt"></i> Información adicional</div>
                                <div class="info-value" id="adicional_us">-</div>
                            </div>
                        </div>
                        <div class="card-footer bg-transparent text-center">
                            <button class="edit btn btn-editor btn-sm w-100">
                                <i class="fas fa-edit"></i> Editar información
                            </button>
                            <button data-toggle="modal" data-target="#cambiocontra" type="button" class="btn btn-outline-warning btn-sm w-100 mt-2">
                                <i class="fas fa-key"></i> Cambiar contraseña
                            </button>
                        </div>
                    </div>
                </div>

                <!-- COLUMNA DERECHA - FORMULARIO DE EDICIÓN -->
                <div class="col-md-8">
                    <div class="form-card">
                        <div class="card-header">
                            <h3><i class="fas fa-user-edit"></i> Editar Datos Personales</h3>
                        </div>
                        <div class="card-body">
                            <div class="alert alert-success alert-custom" id="editado" style="display:none;">
                                <i class="fas fa-check-circle"></i> Datos actualizados correctamente
                            </div>
                            <div class="alert alert-danger alert-custom" id="noeditado" style="display:none;">
                                <i class="fas fa-exclamation-circle"></i> Primero haga clic en "Editar información"
                            </div>
                            
                            <form id="form-usuario" class="form-horizontal">
                                <?php echo Security::campoCSRF(); ?>
                                
                                <div class="form-group">
                                    <label for="telefono" class="required-field">Teléfono</label>
                                    <input type="tel" id="telefono" class="form-control" placeholder="Ej: 04141234567" disabled>
                                </div>
                                
                                <!-- Sistema de Ubicación -->
                                <h5 class="mt-4 mb-3"><i class="fas fa-map-marker-alt text-primary"></i> Ubicación</h5>
                                <hr>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="estado">Estado</label>
                                            <select class="form-control" id="estado" disabled>
                                                <option value="">Seleccione un estado...</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="ciudad">Ciudad</label>
                                            <select class="form-control" id="ciudad" disabled>
                                                <option value="">Seleccione un estado primero...</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="municipio">Municipio</label>
                                            <select class="form-control" id="municipio" disabled>
                                                <option value="">Seleccione un estado primero...</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="parroquia">Parroquia</label>
                                            <select class="form-control" id="parroquia" disabled>
                                                <option value="">Seleccione un municipio primero...</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="direccion_detallada">Dirección Detallada</label>
                                    <input type="text" class="form-control" id="direccion_detallada" placeholder="Av. Principal, Edificio, Número, etc." disabled>
                                    <small class="form-text text-muted">Ej: Av. Principal, Edificio Central, Casa #123</small>
                                </div>

                                <input type="hidden" id="direccion" name="direccion">
                                
                                <div class="form-group">
                                    <label for="correo" class="required-field">Correo Electrónico</label>
                                    <input type="email" id="correo" class="form-control" placeholder="ejemplo@correo.com" disabled>
                                </div>
                                
                                <div class="form-group">
                                    <label for="sexo">Sexo</label>
                                    <select id="sexo" class="form-control" disabled>
                                        <option value="">Seleccione...</option>
                                        <option value="Masculino">Masculino</option>
                                        <option value="Femenino">Femenino</option>
                                        <option value="Otro">Otro</option>
                                    </select>
                                </div>
                                
                                <div class="form-group">
                                    <label for="adicional">Información adicional</label>
                                    <textarea class="form-control" id="adicional" rows="4" placeholder="Especialidad, años de experiencia, etc..." disabled></textarea>
                                </div>
                                
                                <div class="text-center mt-4">
                                    <button type="submit" class="btn btn-guardar" disabled>
                                        <i class="fas fa-save"></i> Guardar Cambios
                                    </button>
                                </div>
                            </form>
                        </div>
                        <div class="card-footer">
                            <div class="csrf-info">
                                <i class="fas fa-shield-alt"></i> Todos los cambios están protegidos contra falsificación de solicitudes (CSRF)
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<footer class="main-footer">
    <div class="float-right d-none d-sm-block">
        <b>Version</b> 1.0.0
    </div>
    <strong>Copyright &copy; 2024 BioVital.</strong> Todos los derechos reservados.
</footer>

</div>

<script src="<?php echo APP_URL; ?>/js/adminlte.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="<?php echo APP_URL; ?>/js/medico.js"></script>
<script src="<?php echo APP_URL; ?>/js/ubicacion.js"></script>

<script>
// Corrección para el botón de edición
$(document).ready(function() {
    // Asegurar que el botón con clase 'btn-editor' también tenga la clase 'edit'
    $('.btn-editor').addClass('edit');
    
    // También asegurar que cualquier botón con clase 'edit' funcione
    $(document).on('click', '.edit', function(e) {
        e.preventDefault();
        console.log('Botón editar clickeado - Perfil Médico');
        // La funcionalidad está en medico.js
    });
    
    // Inicializar ubicación después de cargar los datos
    // Esto se maneja en medico.js con cargarDireccionExistente
});
</script>

</body>
</html>