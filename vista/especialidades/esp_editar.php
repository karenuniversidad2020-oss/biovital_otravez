<?php
// vista/especialidades/esp_editar.php
if($_SESSION['us_tipo'] != 4 || $_SESSION['rol'] != 'administrador'){
    header('Location: ' . APP_URL . '/login/administrador');
    exit();
}

include_once dirname(__DIR__) . '/modelo/Security.php';

$nombre_usuario = $_SESSION['nombre_us'] ?? 'Administrador';
$id_especialidad = isset($_GET['id']) ? intval($_GET['id']) : 0;
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
    
    <title>Administrador | Editar Especialidad</title>
    
    <style>
        .preview-card {
            background-color: #f8f9fa;
            border-left: 4px solid #ffc107;
        }
        .csrf-info {
            font-size: 12px;
            color: #6c757d;
            margin-top: 10px;
            text-align: center;
        }
        .color-preview {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: inline-block;
            margin-left: 10px;
            vertical-align: middle;
        }
        .switch {
            position: relative;
            display: inline-block;
            width: 60px;
            height: 34px;
        }
        .switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }
        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            transition: .4s;
            border-radius: 34px;
        }
        .slider:before {
            position: absolute;
            content: "";
            height: 26px;
            width: 26px;
            left: 4px;
            bottom: 4px;
            background-color: white;
            transition: .4s;
            border-radius: 50%;
        }
        input:checked + .slider {
            background-color: #28a745;
        }
        input:checked + .slider:before {
            transform: translateX(26px);
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
                    <h1><i class="fas fa-edit"></i> Editar Especialidad</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?php echo APP_URL; ?>/panel/administrador">Home</a></li>
                        <li class="breadcrumb-item"><a href="<?php echo APP_URL; ?>/especialidades">Especialidades</a></li>
                        <li class="breadcrumb-item"><a href="<?php echo APP_URL; ?>/especialidades/detalle/<?php echo $id_especialidad; ?>">Detalle</a></li>
                        <li class="breadcrumb-item active">Editar</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <input type="hidden" id="id_especialidad" value="<?php echo $id_especialidad; ?>">
            
            <div class="row">
                <div class="col-md-8">
                    <div class="card card-warning">
                        <div class="card-header">
                            <h3 class="card-title">Editar Información</h3>
                        </div>
                        <div class="card-body">
                            <div class="alert alert-success" id="alertExito" style="display:none;">
                                <i class="fas fa-check-circle"></i> Especialidad actualizada exitosamente
                            </div>
                            <div class="alert alert-danger" id="alertError" style="display:none;">
                                <i class="fas fa-exclamation-circle"></i> <span id="errorMensaje"></span>
                            </div>
                            
                            <form id="formEditarEspecialidad" method="POST">
                                <?php echo Security::campoCSRF(); ?>
                                
                                <div class="form-group">
                                    <label>Nombre de la Especialidad</label>
                                    <input type="text" class="form-control" id="nombre" name="nombre" required>
                                </div>
                                
                                <div class="form-group">
                                    <label>Código</label>
                                    <input type="text" class="form-control" id="codigo" name="codigo">
                                    <small class="form-text text-muted">Código interno para identificación rápida</small>
                                </div>
                                
                                <div class="form-group">
                                    <label>Descripción</label>
                                    <textarea class="form-control" id="descripcion" name="descripcion" rows="3"></textarea>
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
                                                <option value="30">30 minutos</option>
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
                                                <span id="color_preview" class="color-preview"></span>
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
                                                <option value="Media">Media</option>
                                                <option value="Alta">Alta</option>
                                                <option value="Urgente">Urgente</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Orden de visualización</label>
                                            <input type="number" class="form-control" id="orden_visualizacion" name="orden_visualizacion">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label>Estado</label>
                                    <div>
                                        <label class="switch">
                                            <input type="checkbox" id="activo" name="activo">
                                            <span class="slider"></span>
                                        </label>
                                        <span id="estado_texto" class="ml-2">Activo</span>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label>Requisitos para Citas</label>
                                    <textarea class="form-control" id="requisitos" name="requisitos" rows="3"></textarea>
                                </div>

                                <div class="form-group">
                                    <label>Observaciones</label>
                                    <textarea class="form-control" id="observaciones" name="observaciones" rows="3"></textarea>
                                </div>
                                
                                <button type="submit" class="btn btn-warning btn-lg btn-block">
                                    <i class="fas fa-save"></i> Guardar Cambios
                                </button>
                                <a href="<?php echo APP_URL; ?>/especialidades/detalle/<?php echo $id_especialidad; ?>" class="btn btn-secondary btn-block mt-2">
                                    <i class="fas fa-times"></i> Cancelar
                                </a>
                                
                                <div class="csrf-info mt-3">
                                    <i class="fas fa-shield-alt"></i> Todos los cambios están protegidos contra CSRF
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="card card-outline card-warning">
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
<script src="<?php echo APP_URL; ?>/js/especialidades.js"></script>

<script>
$(document).ready(function() {
    // Cargar datos de la especialidad
    cargarDatosEspecialidad();
    
    // Vista previa en tiempo real
    $('#nombre').on('input', function() { $('#preview_nombre').text($(this).val() || 'Nombre de Especialidad'); });
    $('#descripcion').on('input', function() { $('#preview_descripcion').text($(this).val() || 'Descripción de la especialidad'); });
    $('#duracion_defecto').on('change', function() { $('#preview_duracion').text($(this).val() + ' min'); });
    
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
    
    // Estado del switch
    $('#activo').change(function() {
        $('#estado_texto').text($(this).is(':checked') ? 'Activo' : 'Inactivo');
    });
    
    function cargarDatosEspecialidad() {
        var id = $('#id_especialidad').val();
        
        $.ajax({
            url: APP_URL + '/api/especialidades/obtener-detalle',
            type: 'POST',
            data: { id_especialidad: id },
            dataType: 'json',
            success: function(data) {
                $('#nombre').val(data.nombre);
                $('#codigo').val(data.codigo || '');
                $('#descripcion').val(data.descripcion || '');
                $('#duracion_defecto').val(data.duracion_defecto);
                $('#color').val(data.color);
                $('#prioridad').val(data.prioridad);
                $('#orden_visualizacion').val(data.orden_visualizacion);
                $('#requisitos').val(data.requisitos || '');
                $('#observaciones').val(data.observaciones || '');
                $('#activo').prop('checked', data.activo == 1);                
                $('#preview_nombre').text(data.nombre);
                $('#preview_descripcion').text(data.descripcion || '');
                $('#preview_duracion').text(data.duracion_defecto + ' min');
                
                var prioridadClass = 'info';
                if (data.prioridad === 'Alta') prioridadClass = 'danger';
                else if (data.prioridad === 'Urgente') prioridadClass = 'warning';
                else if (data.prioridad === 'Baja') prioridadClass = 'secondary';
                $('#preview_prioridad').removeClass().addClass('badge badge-' + prioridadClass).text(data.prioridad);
                
                var colorMap = {
                    'Azul Médico': '#007bff',
                    'Verde Salud': '#28a745',
                    'Rojo Urgencias': '#dc3545',
                    'Amarillo Precaución': '#ffc107',
                    'Púrpura Especial': '#6f42c1',
                    'Naranja': '#fd7e14'
                };
                $('#color_preview').css('background-color', colorMap[data.color] || '#007bff');
                $('#estado_texto').text(data.activo == 1 ? 'Activo' : 'Inactivo');
            },
            error: function() {
                mostrarError('Error al cargar los datos de la especialidad');
            }
        });
    }
    
    // Enviar formulario
    $('#formEditarEspecialidad').submit(function(e) {
        e.preventDefault();
        
        var datos = {
            id_especialidad: $('#id_especialidad').val(),
            nombre: $('#nombre').val(),
            descripcion: $('#descripcion').val(),
            codigo: $('#codigo').val(),
            duracion_defecto: $('#duracion_defecto').val(),
            color: $('#color').val(),
            prioridad: $('#prioridad').val(),
            orden_visualizacion: $('#orden_visualizacion').val(),
            requisitos: $('#requisitos').val(),
            observaciones: $('#observaciones').val(),
            activo: $('#activo').is(':checked') ? 1 : 0,
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
            url: APP_URL + '/api/especialidades/editar',
            type: 'POST',
            data: datos,
            dataType: 'json',
            success: function(response) {
                if (response.resultado === 'editado') {
                    $('#alertExito').show();
                    setTimeout(function() {
                        window.location.href = APP_URL + '/especialidades/detalle/' + $('#id_especialidad').val();
                    }, 2000);
                } else {
                    mostrarError('Error al actualizar la especialidad');
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