<?php
if($_SESSION['us_tipo'] != 4 || $_SESSION['rol'] != 'administrador'){
    header('Location: ' . APP_URL . '/login/administrador');
    exit();
}

// RUTA CORRECTA - Sube dos niveles hasta la raíz del proyecto
include_once dirname(__DIR__, 2) . '/modelo/Security.php';

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
    </script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="<?php echo APP_URL; ?>/js/config.js"></script>
    <script src="<?php echo APP_URL; ?>/js/csrf.js"></script>
    
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo APP_URL; ?>/css/css/all.min.css">
    <link rel="stylesheet" href="<?php echo APP_URL; ?>/css/adminlte.min.css">
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
    
    <title>Administrador | Crear Especialidad</title>
    
    <style>
        .preview-card {
            background-color: #f8f9fa;
            border-left: 4px solid #007bff;
        }
        .csrf-info {
            font-size: 12px;
            color: #6c757d;
            margin-top: 10px;
            text-align: center;
        }
        .required-field::after {
            content: " *";
            color: red;
        }
        .color-preview {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: inline-block;
            margin-left: 10px;
            vertical-align: middle;
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
        <a href="<?php echo APP_URL; ?>/logout" class="btn btn-danger btn-sm">Cerrar sesión</a>
    </ul>
</nav>

<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="<?php echo APP_URL; ?>/panel/administrador" class="brand-link">
        <img src="<?php echo APP_URL; ?>/img/logo_azul.png" alt="Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">BioVital</span>
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
                </li>      
                <li class="nav-header">
                    <i class="fas fa-hospital-user"></i> Clínica
                </li>
                 <li class="nav-item">
                    <a href="<?php echo APP_URL; ?>/especialidades" class="nav-link active">
                        <i class="nav-icon fas fa-stethoscope"></i>
                        <p>Especialidades</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?php echo APP_URL; ?>/consultorios" class="nav-link">
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
                    <h1><i class="fas fa-plus-circle"></i> Crear Especialidad</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?php echo APP_URL; ?>/panel/administrador">Home</a></li>
                        <li class="breadcrumb-item"><a href="<?php echo APP_URL; ?>/especialidades">Especialidades</a></li>
                        <li class="breadcrumb-item active">Crear</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-8">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Información Básica</h3>
                        </div>
                        <div class="card-body">
                            <div class="alert alert-success" id="alertExito" style="display:none;">
                                <i class="fas fa-check-circle"></i> Especialidad creada exitosamente
                            </div>
                            <div class="alert alert-danger" id="alertError" style="display:none;">
                                <i class="fas fa-exclamation-circle"></i> <span id="errorMensaje"></span>
                            </div>
                            
                            <form id="formCrearEspecialidad" method="POST">
                                <?php echo Security::campoCSRF(); ?>
                                
                                <div class="form-group">
                                    <label class="required-field">Nombre de la Especialidad</label>
                                    <input type="text" class="form-control" id="nombre" name="nombre" required placeholder="Ej: Radiología">
                                </div>
                                
                                <div class="form-group">
                                    <label>Código</label>
                                    <input type="text" class="form-control" id="codigo" name="codigo" placeholder="Ej: RADI-01">
                                    <small class="form-text text-muted">Código interno para identificar el tipo de especialidad (opcional)</small>
                                </div>
                                
                                <div class="form-group">
                                    <label>Descripción</label>
                                    <textarea class="form-control" id="descripcion" name="descripcion" rows="3" placeholder="Ej: Diagnósticos con imágenes (Rayos X)"></textarea>
                                </div>

                                <h4 class="mt-4">Configuración</h4>
                                <hr>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Duración por Defecto (min)</label>
                                            <select class="form-control" id="duracion_defecto" name="duracion_defecto">
                                                <option value="15">15 minutos</option>
                                                <option value="20">20 minutos</option>
                                                <option value="30" selected>30 minutos</option>
                                                <option value="45">45 minutos</option>
                                                <option value="60">60 minutos</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Color Identificador</label>
                                            <div class="input-group">
                                                <select class="form-control" id="color" name="color">
                                                    <option value="Azul Médico">Azul Médico</option>
                                                    <option value="Verde Salud">Verde Salud</option>
                                                    <option value="Rojo Urgencias">Rojo Urgencias</option>
                                                    <option value="Amarillo Precaución">Amarillo Precaución</option>
                                                    <option value="Púrpura Especial">Púrpura Especial</option>
                                                    <option value="Naranja">Naranja</option>
                                                </select>
                                                <span id="color_preview" class="color-preview" style="background-color: #007bff;"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Prioridad</label>
                                            <select class="form-control" id="prioridad" name="prioridad">
                                                <option value="Baja">Baja</option>
                                                <option value="Media" selected>Media</option>
                                                <option value="Alta">Alta</option>
                                                <option value="Urgente">Urgente</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Orden de visualización</label>
                                            <input type="number" class="form-control" id="orden_visualizacion" name="orden_visualizacion" value="0">
                                            <small class="form-text text-muted">Número más pequeño = aparece primero</small>
                                        </div>
                                    </div>
                                </div>

                                <h4 class="mt-4">Información Adicional</h4>
                                <hr>

                                <div class="form-group">
                                    <label>Requisitos para Citas</label>
                                    <textarea class="form-control" id="requisitos" name="requisitos" rows="3" placeholder="Ej: Ayuno de 8 horas, resultados previos, etc."></textarea>
                                </div>

                                <div class="form-group">
                                    <label>Observaciones</label>
                                    <textarea class="form-control" id="observaciones" name="observaciones" rows="3" placeholder="Notas internas sobre la especialidad..."></textarea>
                                </div>
                                
                                <button type="submit" class="btn btn-primary btn-lg btn-block">
                                    <i class="fas fa-save"></i> Guardar Especialidad
                                </button>
                                
                                <div class="csrf-info mt-3">
                                    <i class="fas fa-shield-alt"></i> Formulario protegido contra CSRF
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="card card-outline card-primary">
                        <div class="card-header">
                            <h3 class="card-title"><i class="fas fa-eye"></i> Vista Previa</h3>
                        </div>
                        <div class="card-body">
                            <div class="preview-card p-3">
                                <h4 id="preview_nombre">Nombre de Especialidad</h4>
                                <p id="preview_descripcion" class="text-muted small">Descripción de la especialidad</p>
                                <hr>
                                <div class="text-center">
                                    <span class="badge badge-primary" id="preview_duracion">30 min</span>
                                    <span class="badge badge-info" id="preview_prioridad">Media</span>
                                </div>
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
<script>
$(document).ready(function() {
    // Vista previa en tiempo real
    $('#nombre').on('input', function() {
        $('#preview_nombre').text($(this).val() || 'Nombre de Especialidad');
    });
    
    $('#descripcion').on('input', function() {
        $('#preview_descripcion').text($(this).val() || 'Descripción de la especialidad');
    });
    
    $('#duracion_defecto').on('change', function() {
        var val = $(this).val();
        $('#preview_duracion').text(val + ' min');
    });
    
    $('#prioridad').on('change', function() {
        var val = $(this).val();
        var badgeClass = 'badge-info';
        if (val === 'Alta') badgeClass = 'badge-danger';
        else if (val === 'Urgente') badgeClass = 'badge-warning';
        else if (val === 'Baja') badgeClass = 'badge-secondary';
        $('#preview_prioridad').removeClass().addClass('badge ' + badgeClass).text(val);
    });
    
    $('#color').on('change', function() {
        var colorMap = {
            'Azul Médico': '#007bff',
            'Verde Salud': '#28a745',
            'Rojo Urgencias': '#dc3545',
            'Amarillo Precaución': '#ffc107',
            'Púrpura Especial': '#6f42c1',
            'Naranja': '#fd7e14'
        };
        $('#color_preview').css('background-color', colorMap[$(this).val()] || '#007bff');
    });
    
    $('#color').trigger('change');
    
    // Enviar formulario
    $('#formCrearEspecialidad').submit(function(e) {
        e.preventDefault();
        
        var datos = {
            nombre: $('#nombre').val(),
            descripcion: $('#descripcion').val(),
            codigo: $('#codigo').val(),
            duracion_defecto: $('#duracion_defecto').val(),
            color: $('#color').val(),
            prioridad: $('#prioridad').val(),
            orden_visualizacion: $('#orden_visualizacion').val(),
            requisitos: $('#requisitos').val(),
            observaciones: $('#observaciones').val(),
            csrf_token: CSRF.getToken()
        };
        
        if (!datos.nombre) {
            mostrarError('El nombre de la especialidad es requerido');
            return;
        }
        
        var $btn = $(this).find('button[type="submit"]');
        var originalText = $btn.html();
        $btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Guardando...');
        
        $.ajax({
            url: APP_URL + '/api/especialidades/crear',
            type: 'POST',
            data: datos,
            dataType: 'json',
            success: function(response) {
                if (response.resultado === 'creado') {
                    $('#alertExito').show();
                    setTimeout(function() {
                        window.location.href = APP_URL + '/especialidades';
                    }, 2000);
                } else {
                    mostrarError('Error al crear la especialidad: ' + (response.error || response.resultado));
                }
            },
            error: function(xhr) {
                mostrarError('Error de conexión: ' + xhr.status);
            },
            complete: function() {
                $btn.prop('disabled', false).html(originalText);
            }
        });
    });
    
    function mostrarError(mensaje) {
        $('#errorMensaje').text(mensaje);
        $('#alertError').show();
        setTimeout(function() { $('#alertError').hide(); }, 4000);
    }
});
</script>

</body>
</html>