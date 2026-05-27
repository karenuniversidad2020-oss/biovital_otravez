<?php
<<<<<<< HEAD
=======
// NO iniciar sesión aquí - el Front Controller ya lo hace
>>>>>>> d2039bf34adef6d12dd6c79371df596a3d39fedb
if($_SESSION['us_tipo'] != 4 || $_SESSION['rol'] != 'administrador'){
    header('Location: ' . APP_URL . '/login/administrador');
    exit();
}

$securityPath = dirname(__DIR__, 2) . '/modelo/Security.php';
if (!file_exists($securityPath)) {
    die("Error: No se encuentra Security.php en: " . $securityPath);
}
include_once $securityPath;

$nombre_usuario = $_SESSION['nombre_us'] ?? 'Administrador';
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
    
    <title>Administrador | Nuevo Consultorio</title>
    
    <style>
        .form-card {
            border-radius: 20px;
            border: none;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
            overflow: hidden;
            margin-bottom: 1.5rem;
        }
        .form-card .card-header {
            background: white;
            border-bottom: 2px solid var(--bv-primary);
            padding: 1.25rem 1.5rem;
        }
        .form-card .card-header h3 {
            font-size: 1.1rem;
            font-weight: 700;
            margin: 0;
            color: var(--bv-dark);
        }
        .form-card .card-header h3 i {
            color: var(--bv-primary);
            margin-right: 0.5rem;
        }
        .form-card .card-body {
            padding: 1.5rem;
        }
        .preview-card {
            background: linear-gradient(135deg, #f8f9fa, #fff);
            border-radius: 16px;
            border: 1px solid #eef2f6;
            transition: all 0.3s;
        }
        .preview-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(0,0,0,0.1);
        }
        .form-control, .form-select {
            border-radius: 10px;
            border: 1.5px solid #e2e8f0;
            padding: 0.6rem 1rem;
            transition: all 0.3s;
        }
        .form-control:focus, .form-select:focus {
            border-color: var(--bv-primary);
            box-shadow: 0 0 0 3px rgba(0,119,182,0.1);
        }
        .checkbox-group {
            max-height: 250px;
            overflow-y: auto;
            border: 1.5px solid #e2e8f0;
            border-radius: 12px;
            padding: 1rem;
            background: #fafbfc;
        }
        .checkbox-group .form-check {
            margin-bottom: 0.6rem;
            padding-left: 1.8rem;
        }
        .checkbox-group .form-check-input {
            margin-left: -1.5rem;
        }
        .checkbox-group .form-check-label {
            font-size: 0.9rem;
            cursor: pointer;
        }
        .required-field::after {
            content: " *";
            color: #dc3545;
        }
        .btn-submit {
            background: linear-gradient(135deg, var(--bv-primary), var(--bv-accent));
            border: none;
            border-radius: 12px;
            padding: 0.8rem 2rem;
            font-weight: 600;
            font-size: 1rem;
            transition: all 0.3s;
        }
        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(0,119,182,0.3);
        }
        .btn-cancel {
            background: linear-gradient(135deg, #6c757d, #5a6268);
            border: none;
            border-radius: 12px;
            padding: 0.8rem 2rem;
            font-weight: 600;
            transition: all 0.3s;
        }
        .btn-cancel:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(108,117,125,0.3);
        }
        .alert-custom {
            border-radius: 12px;
            border: none;
            padding: 1rem;
        }
        .section-title {
            font-size: 1rem;
            font-weight: 700;
            color: var(--bv-dark);
            margin: 1.5rem 0 1rem 0;
            padding-bottom: 0.5rem;
            border-bottom: 2px solid #eef2f6;
        }
        .section-title i {
            color: var(--bv-primary);
            margin-right: 0.5rem;
        }
        .preview-nombre {
            font-size: 1.2rem;
            font-weight: 700;
            color: var(--bv-primary);
        }
        .preview-info {
            font-size: 0.85rem;
            color: var(--bv-text-light);
            margin-bottom: 0.5rem;
        }
        .badge-preview {
            background: #e8f4f8;
            color: #0d9488;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
        }
        .row-selects {
            margin-bottom: 1rem;
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
    <a href="<?php echo APP_URL; ?>/panel/administrador" class="brand-link">
        <img src="<?php echo APP_URL; ?>/img/logo_azul.png" alt="Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
<<<<<<< HEAD
        <span class="brand-text font-weight-light">BioVital</span>
=======
        <span class="brand-text font-weight-light">BIOVITAL</span>
>>>>>>> d2039bf34adef6d12dd6c79371df596a3d39fedb
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
                    <i class="fas fa-user-shield"></i> Usuario
                </li>
                <li class="nav-item">
                    <a href="<?php echo APP_URL; ?>/perfil" class="nav-link">
                        <i class="nav-icon fas fa-user-cog"></i>
                        <p>Datos personales</p>
                    </a>
                </li>
                <li class="nav-header">
                    <i class="fas fa-chart-line"></i> Gestión
                </li>
                <li class="nav-item">
                    <a href="<?php echo APP_URL; ?>/administrador/usuarios" class="nav-link">
                        <i class="nav-icon fas fa-users"></i>
                        <p>Usuarios</p>
                    </a>
<<<<<<< HEAD
                </li>               
                <li class="nav-header">
                    <i class="fas fa-hospital-user"></i> Clínica
                </li>
                 <li class="nav-item">
                    <a href="<?php echo APP_URL; ?>/especialidades" class="nav-link">
                        <i class="nav-icon fas fa-stethoscope"></i>
                        <p>Especialidades</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?php echo APP_URL; ?>/consultorios" class="nav-link active">
=======
                </li>
                <li class="nav-header">
                    <i class="fas fa-hospital-user"></i> Clínica
                </li>
                <li class="nav-item">
                    <a href="<?php echo APP_URL; ?>/consultorios" class="nav-link">
>>>>>>> d2039bf34adef6d12dd6c79371df596a3d39fedb
                        <i class="nav-icon fas fa-building"></i>
                        <p>Consultorios</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?php echo APP_URL; ?>/recetas" class="nav-link">
                        <i class="nav-icon fas fa-prescription-bottle-alt"></i>
                        <p>Recetas</p>
                    </a>
                </li>
                <li class="nav-header">
                    <i class="fas fa-chart-bar"></i> Reportes
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-chart-bar"></i>
                        <p>Estadísticas</p>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</aside>

<!-- Content Wrapper -->
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><i class="fas fa-plus-circle"></i> Nuevo Consultorio</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?php echo APP_URL; ?>/panel/administrador">Home</a></li>
                        <li class="breadcrumb-item"><a href="<?php echo APP_URL; ?>/consultorios">Consultorios</a></li>
                        <li class="breadcrumb-item active">Crear</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            
            <!-- Welcome Banner -->
            <div class="bv-welcome-banner admin bv-animate">
                <h2><i class="fas fa-building"></i> Registrar Nuevo Consultorio</h2>
                <p>Complete el formulario para agregar un nuevo consultorio al sistema.</p>
                <div class="bv-role-tag"><i class="fas fa-hospital-user"></i> Infraestructura</div>
            </div>
<<<<<<< HEAD
=======

>>>>>>> d2039bf34adef6d12dd6c79371df596a3d39fedb
            <div class="row">
                <div class="col-md-8">
                    <!-- Formulario Principal -->
                    <div class="form-card">
                        <div class="card-header">
                            <h3><i class="fas fa-clipboard-list"></i> Información Básica</h3>
                        </div>
                        <div class="card-body">
                            <div class="alert alert-success alert-custom" id="alertExito" style="display:none;">
                                <i class="fas fa-check-circle"></i> Consultorio creado exitosamente. Redirigiendo...
                            </div>
                            <div class="alert alert-danger alert-custom" id="alertError" style="display:none;">
                                <i class="fas fa-exclamation-circle"></i> <span id="errorMensaje"></span>
                            </div>
                            
                            <form id="formCrearConsultorio">
                                <?php echo Security::campoCSRF(); ?>
                                
                                <div class="form-group">
                                    <label for="nombre" class="required-field">Nombre del Consultorio</label>
                                    <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Ej: Centro Médico Santa Fe" required>
                                </div>
                                
                                <div class="form-group">
                                    <label for="descripcion">Descripción</label>
                                    <textarea class="form-control" id="descripcion" name="descripcion" rows="2" placeholder="Breve descripción del consultorio..."></textarea>
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="apertura" class="required-field">Apertura Habitual</label>
                                            <input type="time" class="form-control" id="apertura" name="apertura" value="08:00" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="cierre" class="required-field">Cierre Habitual</label>
                                            <input type="time" class="form-control" id="cierre" name="cierre" value="17:00" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label>Especialidades Admitidas</label>
                                    <div class="checkbox-group" id="especialidades_container">
                                        <div class="text-center py-3">
                                            <div class="spinner-border spinner-border-sm text-primary"></div>
                                            <span class="ml-2">Cargando especialidades...</span>
                                        </div>
                                    </div>
                                    <small class="form-text text-muted">Seleccione las especialidades que se atienden en este consultorio</small>
                                </div>

                                <div class="section-title">
                                    <i class="fas fa-map-marker-alt"></i> Ubicación
                                </div>

                                <div class="row row-selects">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="estado" class="required-field">Estado</label>
                                            <select class="form-control" id="estado" name="estado" required>
                                                <option value="">Seleccione un estado...</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="ciudad" class="required-field">Ciudad</label>
                                            <select class="form-control" id="ciudad" name="ciudad" required disabled>
                                                <option value="">Primero seleccione un estado...</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="row row-selects">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="municipio">Municipio</label>
                                            <select class="form-control" id="municipio" name="municipio" disabled>
                                                <option value="">Primero seleccione un estado...</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="parroquia">Parroquia</label>
                                            <select class="form-control" id="parroquia" name="parroquia" disabled>
                                                <option value="">Primero seleccione un municipio...</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="direccion" class="required-field">Dirección Detallada</label>
                                    <input type="text" class="form-control" id="direccion" name="direccion" required placeholder="Av. Principal, Edificio, Número, etc.">
                                    <small class="form-text text-muted">Ej: Av. Principal, Edificio Central, Piso 3, Oficina 5</small>
                                </div>

                                <div class="section-title">
                                    <i class="fas fa-address-card"></i> Datos de Contacto
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="telefono">Teléfono Interno/Directo</label>
                                            <input type="text" class="form-control" id="telefono" name="telefono" placeholder="Ej: 0212-5551234">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="email">Email del Consultorio</label>
                                            <input type="email" class="form-control" id="email" name="email" placeholder="Ej: consultorio@correo.com">
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="text-center mt-4">
                                    <button type="button" class="btn btn-secondary btn-cancel mr-2" onclick="window.location.href='<?php echo APP_URL; ?>/consultorios'">
                                        <i class="fas fa-times"></i> Cancelar
                                    </button>
                                    <button type="submit" class="btn btn-submit">
                                        <i class="fas fa-save"></i> Guardar Consultorio
                                    </button>
                                </div>
                                
                                <div class="csrf-info mt-3">
                                    <i class="fas fa-shield-alt"></i> Formulario protegido contra CSRF
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <!-- Vista Previa -->
                    <div class="preview-card p-3">
                        <div class="text-center mb-3">
                            <i class="fas fa-building fa-2x" style="color: var(--bv-primary);"></i>
                            <h5 class="mt-2 mb-0">Vista Previa</h5>
                            <small class="text-muted">Así se verá el consultorio</small>
                        </div>
                        <hr>
                        <div class="preview-nombre text-center" id="preview_nombre">
                            Nombre del Consultorio
                        </div>
                        <div class="preview-info text-center mt-2">
                            <i class="fas fa-map-marker-alt text-danger"></i>
                            <span id="preview_ciudad">Ciudad no seleccionada</span>
                        </div>
                        <div class="preview-info text-center" id="preview_descripcion">
                            <em class="text-muted">Sin descripción</em>
                        </div>
                        <hr>
                        <div class="preview-info">
                            <i class="fas fa-phone text-success"></i>
                            <span id="preview_telefono">-</span>
                        </div>
                        <div class="preview-info">
                            <i class="fas fa-envelope text-info"></i>
                            <span id="preview_email">-</span>
                        </div>
                        <div class="preview-info">
                            <i class="fas fa-clock text-warning"></i>
                            <span id="preview_horario">08:00 - 17:00</span>
                        </div>
                        <hr>
                        <div class="text-center">
                            <span class="badge-preview">
                                <i class="fas fa-check-circle"></i> Consultorio disponible
                            </span>
                        </div>
                    </div>

                    <!-- Info Adicional -->
                    <div class="info-card mt-3" style="border-radius: 16px; background: #f8f9fa;">
                        <div class="card-body">
                            <h6 class="text-primary"><i class="fas fa-info-circle"></i> Información importante</h6>
                            <hr>
                            <p class="small text-muted mb-1">
                                <i class="fas fa-check-circle text-success"></i> Los campos marcados con <span class="text-danger">*</span> son obligatorios
                            </p>
                            <p class="small text-muted mb-1">
                                <i class="fas fa-clock"></i> Los horarios pueden modificarse después de crear el consultorio
                            </p>
                            <p class="small text-muted mb-0">
                                <i class="fas fa-user-md"></i> Los médicos se asignan desde la página de detalle
                            </p>
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
<script src="<?php echo APP_URL; ?>/js/consultorio.js"></script>

<script>
// Funciones adicionales para vista previa mejorada
$(document).ready(function() {
    // Actualizar vista previa en tiempo real
    function actualizarPreview() {
        $('#preview_nombre').text($('#nombre').val() || 'Nombre del Consultorio');
        
        var ciudadNombre = $('#ciudad option:selected').text();
        if (ciudadNombre && ciudadNombre !== 'Seleccione una ciudad...' && ciudadNombre !== 'Primero seleccione un estado...') {
            $('#preview_ciudad').text(ciudadNombre);
        } else {
            $('#preview_ciudad').text('Ciudad no seleccionada');
        }
        
        var descripcion = $('#descripcion').val();
        if (descripcion) {
            $('#preview_descripcion').html(descripcion.substring(0, 80) + (descripcion.length > 80 ? '...' : ''));
        } else {
            $('#preview_descripcion').html('<em class="text-muted">Sin descripción</em>');
        }
        
        $('#preview_telefono').text($('#telefono').val() || '-');
        $('#preview_email').text($('#email').val() || '-');
        $('#preview_horario').text($('#apertura').val() + ' - ' + $('#cierre').val());
    }
    
    // Eventos para actualizar vista previa
    $('#nombre, #descripcion, #telefono, #email, #apertura, #cierre').on('input change', function() {
        actualizarPreview();
    });
    
    $(document).on('change', '#ciudad', function() {
        actualizarPreview();
    });
    
    // Inicializar vista previa
    actualizarPreview();
    
    // Envío del formulario
    $('#formCrearConsultorio').submit(function(e) {
        e.preventDefault();
        crearConsultorio();
    });
});
</script>

</body>
</html>