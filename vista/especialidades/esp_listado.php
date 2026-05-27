<?php
// vista/especialidades/esp_listado.php
if($_SESSION['us_tipo'] != 4 || $_SESSION['rol'] != 'administrador'){
    header('Location: ' . APP_URL . '/login/administrador');
    exit();
}

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
    <link rel="stylesheet" href="<?php echo APP_URL; ?>/css/dashboard.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <title>Administrador | Especialidades</title>
    
    <style>
        .especialidad-card {
            transition: transform 0.3s, box-shadow 0.3s;
            margin-bottom: 20px;
            border-radius: 16px;
            overflow: hidden;
            border: none;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        }
        .especialidad-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 28px rgba(0,0,0,0.12);
        }
        .especialidad-card .card-header {
            background: linear-gradient(135deg, var(--bv-primary), var(--bv-accent));
            color: white;
            border: none;
            padding: 1rem 1.25rem;
        }
        .especialidad-card .card-header h5 {
            font-weight: 600;
            margin: 0;
        }
        .especialidad-card .card-body {
            padding: 1.25rem;
        }
        .especialidad-card .card-footer {
            background: #f8f9fa;
            border-top: 1px solid #eef2f6;
            padding: 0.75rem 1.25rem;
        }
        .badge-medicos {
            background-color: #e8f4f8;
            color: #0d9488;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }
        .search-box {
            max-width: 350px;
        }
        .info-box-icon {
            transition: transform 0.3s;
        }
        .info-box:hover .info-box-icon {
            transform: scale(1.1);
        }
        .btn-accion {
            transition: all 0.2s;
        }
        .btn-accion:hover {
            transform: translateY(-2px);
        }
        .descripcion-text {
            font-size: 0.85rem;
            color: #6c757d;
            line-height: 1.4;
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
                    <h1><i class="fas fa-stethoscope"></i> Gestión de Especialidades</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?php echo APP_URL; ?>/panel/administrador">Home</a></li>
                        <li class="breadcrumb-item active">Especialidades</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            
            <!-- Welcome Banner (estilo dashboard) -->
            <div class="bv-welcome-banner admin bv-animate">
                <h2><i class="fas fa-stethoscope"></i> Especialidades Médicas</h2>
                <p>Gestiona las especialidades, tarifas y asignación de médicos.</p>
                <div class="bv-role-tag"><i class="fas fa-stethoscope"></i> Catálogo de Especialidades</div>
            </div>

            <!-- Stats Cards -->
            <div class="row">
                <div class="col-md-3 col-sm-6 col-12">
                    <div class="info-box bv-animate bv-animate-delay-1">
                        <span class="info-box-icon bg-info elevation-1"><i class="fas fa-stethoscope"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Total Especialidades</span>
                            <span class="info-box-number" id="total_especialidades">0</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6 col-12">
                    <div class="info-box bv-animate bv-animate-delay-1">
                        <span class="info-box-icon bg-success elevation-1"><i class="fas fa-check-circle"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Activas</span>
                            <span class="info-box-number" id="total_activas">0</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6 col-12">
                    <div class="info-box bv-animate bv-animate-delay-2">
                        <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-user-md"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Médicos</span>
                            <span class="info-box-number" id="total_medicos">0</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6 col-12">
                    <div class="info-box bv-animate bv-animate-delay-2">
                        <span class="info-box-icon bg-primary elevation-1"><i class="fas fa-calendar-week"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Citas del Mes</span>
                            <span class="info-box-number" id="citas_mes">0</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Search Bar -->
            <div class="row mt-3">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body py-2">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text bg-white"><i class="fas fa-search text-muted"></i></span>
                                        </div>
                                        <input type="text" id="buscar_especialidad" class="form-control" placeholder="Buscar especialidad por nombre o descripción...">
                                        <div class="input-group-append">
                                            <button class="btn btn-secondary" id="btnBuscar">
                                                <i class="fas fa-search"></i> Buscar
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <select class="form-control" id="filtro_estado">
                                        <option value="todas">Todas</option>
                                        <option value="activas">Activas</option>
                                        <option value="inactivas">Inactivas</option>
                                    </select>
                                </div>
                                <div class="col-md-2 text-right">
                                    <button class="btn btn-primary btn-block" id="btnNuevaEspecialidad">
                                        <i class="fas fa-plus"></i> Nueva Especialidad
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tarjetas de especialidades (Grid estilo dashboard) -->
            <div class="row" id="contenedor_especialidades">
                <div class="col-12 text-center">
                    <div class="spinner-border text-primary" role="status">
                        <span class="sr-only">Cargando...</span>
                    </div>
                    <p class="mt-2">Cargando especialidades...</p>
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

<!-- Modal de confirmación para eliminar -->
<div class="modal fade" id="modalEliminar" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title"><i class="fas fa-exclamation-triangle"></i> Confirmar Eliminación</h5>
                <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <p>¿Está seguro que desea eliminar esta especialidad?</p>
                <p class="text-muted">Esta acción no se puede deshacer.</p>
                <input type="hidden" id="eliminar_id">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-danger" id="confirmarEliminar">Eliminar</button>
            </div>
        </div>
    </div>
</div>

<script src="<?php echo APP_URL; ?>/js/adminlte.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="<?php echo APP_URL; ?>/js/especialidades.js"></script>

<script>
$(document).ready(function() {
    $('#btnNuevaEspecialidad').click(function() {
        window.location.href = APP_URL + '/especialidades/crear';
    });
});
</script>

</body>
</html>
