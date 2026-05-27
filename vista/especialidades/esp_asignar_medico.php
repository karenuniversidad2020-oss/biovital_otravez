<?php
// vista/especialidades/esp_asignar_medico.php
if($_SESSION['us_tipo'] != 4 || $_SESSION['rol'] != 'administrador'){
    header('Location: ' . APP_URL . '/login/administrador');
    exit();
}

// RUTA CORREGIDA - Security.php está en la carpeta modelo a nivel de raíz
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
    
    <title>Administrador | Asignar Médico</title>
    
    <style>
        .form-section {
            background: #f8f9fa;
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 20px;
        }
        .form-section h4 {
            color: var(--bv-primary);
            margin-bottom: 15px;
        }
        .required-field::after {
            content: " *";
            color: red;
        }
        .info-especialidad {
            background: linear-gradient(135deg, var(--bv-primary), var(--bv-accent));
            color: white;
            border-radius: 12px;
            padding: 15px;
            margin-bottom: 20px;
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
                    <h1><i class="fas fa-user-md"></i> Asignar Médico</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?php echo APP_URL; ?>/panel/administrador">Home</a></li>
                        <li class="breadcrumb-item"><a href="<?php echo APP_URL; ?>/especialidades">Especialidades</a></li>
                        <li class="breadcrumb-item"><a href="<?php echo APP_URL; ?>/especialidades/detalle/<?php echo $id_especialidad; ?>">Detalle</a></li>
                        <li class="breadcrumb-item active">Asignar Médico</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <input type="hidden" id="id_especialidad" value="<?php echo $id_especialidad; ?>">
            
            <div class="row">
                <div class="col-md-8 offset-md-2">
                    <!-- Información de la Especialidad -->
                    <div class="info-especialidad" id="info_especialidad">
                        <div class="text-center">
                            <i class="fas fa-stethoscope fa-3x mb-2"></i>
                            <h3 id="especialidad_nombre">Cargando...</h3>
                            <p id="especialidad_descripcion" class="mb-0"></p>
                        </div>
                    </div>

                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title"><i class="fas fa-user-plus"></i> Registrar Médico a Especialidad</h3>
                        </div>
                        <div class="card-body">
                            <div class="alert alert-success" id="alertExito" style="display:none;">
                                <i class="fas fa-check-circle"></i> Médico asignado exitosamente
                            </div>
                            <div class="alert alert-danger" id="alertError" style="display:none;">
                                <i class="fas fa-exclamation-circle"></i> <span id="errorMensaje"></span>
                            </div>
                            
                            <form id="formAsignarMedico">
                                <?php echo Security::campoCSRF(); ?>
                                
                                <div class="form-section">
                                    <h4><i class="fas fa-user-md"></i> Datos del Médico</h4>
                                    
                                    <div class="form-group">
                                        <label class="required-field">Seleccionar Médico</label>
                                        <select class="form-control" id="medico_seleccionado" name="id_medico" required>
                                            <option value="">Seleccione un médico...</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-section">
                                    <h4><i class="fas fa-chart-line"></i> Datos Profesionales</h4>
                                    
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Tarifa ($)</label>
                                                <input type="number" step="0.01" class="form-control" id="tarifa" name="tarifa" placeholder="0.00">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>EXP (AÑOS)</label>
                                                <input type="number" class="form-control" id="exp_anios" name="exp_anios" placeholder="0">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Extra ($)</label>
                                                <input type="number" step="0.01" class="form-control" id="extra" name="extra" placeholder="0.00">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-check mt-4">
                                                <input type="checkbox" class="form-check-input" id="domicilio" name="domicilio">
                                                <label class="form-check-label" for="domicilio">¿Realiza consulta a domicilio?</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <button type="submit" class="btn btn-primary btn-lg btn-block">
                                    <i class="fas fa-save"></i> Asignar Médico
                                </button>
                                <a href="<?php echo APP_URL; ?>/especialidades/detalle/<?php echo $id_especialidad; ?>" class="btn btn-secondary btn-block mt-2">
                                    <i class="fas fa-times"></i> Cancelar
                                </a>
                            </form>
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
    var id_especialidad = $('#id_especialidad').val();
    
    // Cargar información de la especialidad
    cargarEspecialidad();
    
    // Cargar lista de médicos disponibles
    cargarMedicosDisponibles();
    
    function cargarEspecialidad() {
        $.ajax({
            url: APP_URL + '/api/especialidades/obtener-detalle',
            type: 'POST',
            data: { id_especialidad: id_especialidad },
            dataType: 'json',
            success: function(data) {
                $('#especialidad_nombre').text(data.nombre);
                $('#especialidad_descripcion').text(data.descripcion || 'Sin descripción');
            },
            error: function() {
                $('#especialidad_nombre').text('Error al cargar especialidad');
            }
        });
    }
    
    function cargarMedicosDisponibles() {
        $.ajax({
            url: APP_URL + '/api/especialidades/listar-medicos',
            type: 'POST',
            data: { id_especialidad: id_especialidad },
            dataType: 'json',
            success: function(medicos) {
                var options = '<option value="">Seleccione un médico...</option>';
                for (var i = 0; i < medicos.length; i++) {
                    options += '<option value="' + medicos[i].id_medico + '">' + 
                               medicos[i].nombre + ' (Cédula: ' + medicos[i].cedula + ')' + 
                               (medicos[i].mpps ? ' - MPPS: ' + medicos[i].mpps : '') + 
                               '</option>';
                }
                $('#medico_seleccionado').html(options);
            },
            error: function() {
                $('#medico_seleccionado').html('<option value="">Error al cargar médicos</option>');
            }
        });
    }
    
    // Enviar formulario
    $('#formAsignarMedico').submit(function(e) {
        e.preventDefault();
        
        var datos = {
            id_especialidad: id_especialidad,
            id_medico: $('#medico_seleccionado').val(),
            tarifa: $('#tarifa').val(),
            exp_anios: $('#exp_anios').val(),
            extra: $('#extra').val(),
            domicilio: $('#domicilio').is(':checked') ? 1 : 0,
            csrf_token: CSRF.getToken()
        };
        
        if (!datos.id_medico) {
            mostrarError('Debe seleccionar un médico');
            return;
        }
        
        var $btn = $(this).find('button[type="submit"]');
        var originalText = $btn.html();
        $btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Asignando...');
        
        $.ajax({
            url: APP_URL + '/api/especialidades/asignar-medico',
            type: 'POST',
            data: datos,
            dataType: 'json',
            success: function(response) {
                if (response.resultado === 'asignado') {
                    $('#alertExito').show();
                    setTimeout(function() {
                        window.location.href = APP_URL + '/especialidades/detalle/' + id_especialidad;
                    }, 2000);
                } else if (response.resultado === 'ya_asignado') {
                    mostrarError('El médico ya está asignado a esta especialidad');
                } else {
                    mostrarError('Error al asignar el médico');
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