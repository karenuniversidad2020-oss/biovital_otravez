<?php
<<<<<<< HEAD
// vista/paciente/pac_recetas.php - CORREGIDO
// Maneja correctamente el formato ApiResponse

// Verificar autenticación y rol
=======

>>>>>>> d2039bf34adef6d12dd6c79371df596a3d39fedb
if($_SESSION['us_tipo'] != 1 || $_SESSION['rol'] != 'paciente'){
    header('Location: ' . APP_URL . '/login/paciente');
    exit();
}

<<<<<<< HEAD
// Incluir Security para CSRF si es necesario
$securityPath = dirname(__DIR__, 2) . '/modelo/Security.php';
if (file_exists($securityPath)) {
    include_once $securityPath;
}

$nombre_usuario = $_SESSION['nombre_us'] ?? 'Usuario';
$id_paciente = $_SESSION['usuario'];
=======
// Usar rutas absolutas con dirname()
>>>>>>> d2039bf34adef6d12dd6c79371df596a3d39fedb
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <script>
        var APP_URL = '<?php echo APP_URL; ?>';
<<<<<<< HEAD
        var ID_PACIENTE = <?php echo json_encode($id_paciente); ?>;
        console.log('APP_URL:', APP_URL);
        console.log('ID_PACIENTE:', ID_PACIENTE);
=======
>>>>>>> d2039bf34adef6d12dd6c79371df596a3d39fedb
    </script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="<?php echo APP_URL; ?>/js/config.js"></script>
    <script src="<?php echo APP_URL; ?>/js/csrf.js"></script>
    
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo APP_URL; ?>/css/css/all.min.css">
    <link rel="stylesheet" href="<?php echo APP_URL; ?>/css/adminlte.min.css">
<<<<<<< HEAD
    <link rel="stylesheet" href="<?php echo APP_URL; ?>/css/dashboard.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <title>Paciente | Mis Recetas</title>
    
    <style>
        .table-actions {
            white-space: nowrap;
            width: 80px;
        }
        .badge-receta {
            background-color: #28a745;
            color: white;
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 11px;
        }
        .modal-lg-custom {
            max-width: 800px;
        }
        .receta-card {
            transition: transform 0.2s;
            margin-bottom: 20px;
        }
        .receta-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }
        .search-box {
            max-width: 300px;
        }
        .stats-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 20px;
        }
        .stats-number {
            font-size: 2rem;
            font-weight: 700;
        }
        .btn-ver-detalle {
            background: none;
            border: none;
            color: #007bff;
            cursor: pointer;
            transition: all 0.2s;
        }
        .btn-ver-detalle:hover {
            color: #0056b3;
            transform: scale(1.05);
        }
        .prescription-icon {
            font-size: 2.5rem;
            color: var(--bv-primary);
        }
    </style>
=======
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
    
    <title>Paciente | Mis Recetas</title>
>>>>>>> d2039bf34adef6d12dd6c79371df596a3d39fedb
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
<<<<<<< HEAD
        <a href="<?php echo APP_URL; ?>/logout" class="btn btn-danger btn-sm">
            <i class="fas fa-sign-out-alt"></i> Cerrar sesión
        </a>
=======
        <a href="<?php echo APP_URL; ?>/logout" class="btn btn-danger btn-sm">Cerrar sesión</a>
>>>>>>> d2039bf34adef6d12dd6c79371df596a3d39fedb
    </ul>
</nav>

<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="<?php echo APP_URL; ?>/panel/paciente" class="brand-link">
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
                <img id="avatar4" src="<?php echo APP_URL; ?>/img/avatar.png" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
<<<<<<< HEAD
                <a href="#" class="d-block"><?php echo htmlspecialchars($nombre_usuario); ?></a>
=======
                <a href="#" class="d-block"><?php echo htmlspecialchars($_SESSION['nombre_us'] ?? 'Usuario'); ?></a>
>>>>>>> d2039bf34adef6d12dd6c79371df596a3d39fedb
            </div>
        </div>
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu">
<<<<<<< HEAD
                <li class="nav-header">
                    <i class="fas fa-user-injured"></i> Usuario
                </li>
=======
                <li class="nav-header">Usuario</li>
>>>>>>> d2039bf34adef6d12dd6c79371df596a3d39fedb
                <li class="nav-item">
                    <a href="<?php echo APP_URL; ?>/perfil" class="nav-link">
                        <i class="nav-icon fas fa-user-cog"></i>
                        <p>Datos personales</p>
                    </a>
                </li>
<<<<<<< HEAD
                <li class="nav-header">
                    <i class="fas fa-clinic-medical"></i> Clínica
                </li>
                <li class="nav-item">
                    <a href="<?php echo APP_URL; ?>/paciente/recetas" class="nav-link active">
=======
                <li class="nav-header">Clínica</li>
                <li class="nav-item">
                    <a href="<?php echo APP_URL; ?>/paciente/recetas" class="nav-link">
>>>>>>> d2039bf34adef6d12dd6c79371df596a3d39fedb
                        <i class="nav-icon fas fa-prescription-bottle-alt"></i>
                        <p>Mis Recetas</p>
                    </a>
                </li>
<<<<<<< HEAD
                <li class="nav-header">
                    <i class="fas fa-calendar-alt"></i> Citas
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-calendar-alt"></i>
                        <p>Mis Citas</p>
=======
                <li class="nav-item">
                    <a href="<?php echo APP_URL; ?>/documentos" class="nav-link">
                        <i class="nav-icon fas fa-file-medical"></i>
                        <p>Documentos médicos</p>
>>>>>>> d2039bf34adef6d12dd6c79371df596a3d39fedb
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</aside>

<<<<<<< HEAD
<!-- Content Wrapper -->
=======

>>>>>>> d2039bf34adef6d12dd6c79371df596a3d39fedb
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><i class="fas fa-prescription-bottle-alt"></i> Mis Recetas Médicas</h1>
                </div>
<<<<<<< HEAD
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?php echo APP_URL; ?>/panel/paciente">Home</a></li>
                        <li class="breadcrumb-item active">Mis Recetas</li>
                    </ol>
                </div>
=======
>>>>>>> d2039bf34adef6d12dd6c79371df596a3d39fedb
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
<<<<<<< HEAD
            
            <!-- Welcome Banner -->
            <div class="bv-welcome-banner bv-animate">
                <h2><i class="fas fa-prescription"></i> Mis Recetas</h2>
                <p>Consulta todas las recetas médicas que te han sido prescritas.</p>
                <div class="bv-role-tag"><i class="fas fa-user-injured"></i> Historial de Recetas</div>
            </div>

            <!-- Stats Cards -->
            <div class="row">
                <div class="col-md-6 col-sm-6 col-12">
                    <div class="info-box bv-animate bv-animate-delay-1">
                        <span class="info-box-icon bg-info"><i class="fas fa-prescription-bottle-alt"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Total Recetas</span>
                            <span class="info-box-number" id="total_recetas">0</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-sm-6 col-12">
                    <div class="info-box bv-animate bv-animate-delay-2">
                        <span class="info-box-icon bg-success"><i class="fas fa-user-md"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Médicos Atendidos</span>
                            <span class="info-box-number" id="total_medicos">0</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Search Bar -->
            <div class="row mt-3">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body py-2">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-white"><i class="fas fa-search text-muted"></i></span>
                                </div>
                                <input type="text" id="buscar_receta" class="form-control" placeholder="Buscar receta por medicamento, médico o fecha...">
                                <div class="input-group-append">
                                    <button class="btn btn-secondary" id="btnBuscar">
                                        <i class="fas fa-search"></i> Buscar
                                    </button>
                                    <button class="btn btn-outline-secondary" id="btnLimpiarBusqueda" style="display: none;">
                                        <i class="fas fa-times"></i> Limpiar
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tabla de Recetas -->
=======
>>>>>>> d2039bf34adef6d12dd6c79371df596a3d39fedb
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
<<<<<<< HEAD
                            <h3 class="card-title"><i class="fas fa-list"></i> Listado de Recetas</h3>
                            <div class="card-tools">
                                <button class="btn btn-default btn-sm" id="btnRefresh">
                                    <i class="fas fa-sync-alt"></i> Actualizar
                                </button>
=======
                            <h3 class="card-title">Listado de Recetas</h3>
                            <div class="card-tools">
                                <div class="input-group input-group-sm" style="width: 200px;">
                                    <input type="text" id="buscar_receta" class="form-control float-right" placeholder="Buscar...">
                                </div>
>>>>>>> d2039bf34adef6d12dd6c79371df596a3d39fedb
                            </div>
                        </div>
                        <div class="card-body table-responsive p-0">
                            <table class="table table-hover text-nowrap">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Medicamento</th>
                                        <th>Marca</th>
                                        <th>Cantidad</th>
                                        <th>Dosis</th>
                                        <th>Médico</th>
                                        <th>Fecha</th>
<<<<<<< HEAD
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody id="tabla_recetas">
                                    <tr><td colspan="8" class="text-center">
                                        <div class="spinner-border text-primary" role="status">
                                            <span class="sr-only">Cargando...</span>
                                        </div>
                                        <p>Cargando recetas...</p>
                                    </td></tr>
=======
                                    </tr>
                                </thead>
                                <tbody id="tabla_recetas">
                                    <tr><td colspan="7" class="text-center">Cargando recetas...</td</tr>
>>>>>>> d2039bf34adef6d12dd6c79371df596a3d39fedb
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<<<<<<< HEAD
<footer class="main-footer">
    <div class="float-right d-none d-sm-block">
        <b>Version</b> 1.0.0
    </div>
    <strong>Copyright &copy; 2024 BioVital.</strong> Todos los derechos reservados.
</footer>

</div>

<!-- Modal Ver Detalle Receta -->
<div class="modal fade" id="modalDetalleReceta" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg-custom" role="document">
        <div class="modal-content" style="border-radius: 16px;">
            <div class="modal-header bg-info text-white" style="border-radius: 16px 16px 0 0;">
                <h5 class="modal-title"><i class="fas fa-file-prescription"></i> Detalle de Receta</h5>
                <button type="button" class="close text-white" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body" id="detalle_receta_content">
                <div class="text-center">
                    <div class="spinner-border text-primary"></div>
                    <p>Cargando detalles...</p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" onclick="window.print()">
                    <i class="fas fa-print"></i> Imprimir
                </button>
            </div>
        </div>
    </div>
</div>

<script src="<?php echo APP_URL; ?>/js/adminlte.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
$(document).ready(function() {
    console.log('=== CARGANDO RECETAS DEL PACIENTE ===');
    console.log('ID Paciente:', ID_PACIENTE);
    
    cargarEstadisticas();
    listar_recetas();

    // Botón refrescar
    $('#btnRefresh').click(function() {
        listar_recetas();
        cargarEstadisticas();
    });

    // Buscar en la tabla
    $('#btnBuscar').click(function() {
        let busqueda = $('#buscar_receta').val().toLowerCase();
        buscarEnTabla(busqueda);
    });

    $('#buscar_receta').keypress(function(e) {
        if (e.which == 13) {
            $('#btnBuscar').click();
        }
    });

    $('#btnLimpiarBusqueda').click(function() {
        $('#buscar_receta').val('');
        $(this).hide();
        listar_recetas();
    });

    function buscarEnTabla(busqueda) {
        let hayResultados = false;
        $('#tabla_recetas tr').each(function() {
            if ($(this).find('td').length > 0) {
                let texto = $(this).text().toLowerCase();
                let mostrar = texto.indexOf(busqueda) > -1;
                $(this).toggle(mostrar);
                if (mostrar) hayResultados = true;
            }
        });
        
        if (busqueda.length > 0) {
            $('#btnLimpiarBusqueda').show();
            if (!hayResultados) {
                $('#tabla_recetas').append('<tr class="sin-resultados"><td colspan="8" class="text-center text-muted">No se encontraron resultados para "' + escapeHtml(busqueda) + '"</td></tr>');
            }
        } else {
            $('#btnLimpiarBusqueda').hide();
            $('.sin-resultados').remove();
        }
    }

    function cargarEstadisticas() {
        $.ajax({
            url: APP_URL + '/api/pacientes/mis-estadisticas',
            type: 'POST',
            data: { id_paciente: ID_PACIENTE },
            dataType: 'json',
            success: function(response) {
                console.log('Estadísticas recibidas:', response);
                
                // Manejar formato ApiResponse
                var data = response;
                if (response.success && response.data) {
                    data = response.data;
                }
                
                $('#total_recetas').text(data.total_recetas || 0);
                // Calcular médicos únicos de las recetas (esto se puede mejorar)
                $('#total_medicos').text(data.medicos_atendieron || 0);
            },
            error: function(xhr, status, error) {
                console.error('Error al cargar estadísticas:', error);
                $('#total_recetas').text('0');
                $('#total_medicos').text('0');
            }
        });
    }

    function listar_recetas() {
        $('#tabla_recetas').html('<tr><td colspan="8" class="text-center"><div class="spinner-border text-primary"></div><p>Cargando recetas...</p></td></tr>');
=======
<script>
$(document).ready(function() {
    listar_recetas();

    $('#buscar_receta').on('keyup', function() {
        let value = $(this).val().toLowerCase();
        $('#tabla_recetas tr').filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
        });
    });

    function listar_recetas() {
        $('#tabla_recetas').html('<tr><td colspan="7" class="text-center">Cargando recetas...<div class="spinner-border spinner-border-sm ml-2"></div></td></tr>');
>>>>>>> d2039bf34adef6d12dd6c79371df596a3d39fedb
        
        $.ajax({
            url: APP_URL + '/api/recetas/mis-recetas',
            type: 'POST',
<<<<<<< HEAD
            data: { id_paciente: ID_PACIENTE },
            dataType: 'json',
            success: function(response) {
                console.log('Respuesta recetas (raw):', response);
                
                // ==================== MANEJAR FORMATO ApiResponse ====================
                var recetas = [];
                
                // Si la respuesta tiene el formato ApiResponse (success + data)
                if (response.success && response.data) {
                    recetas = response.data;
                    console.log('Recetas extraídas de ApiResponse.data:', recetas);
                } 
                // Si es un array directo
                else if (Array.isArray(response)) {
                    recetas = response;
                    console.log('Recetas es un array directo:', recetas);
                }
                // Si tiene propiedad recetas
                else if (response.recetas && Array.isArray(response.recetas)) {
                    recetas = response.recetas;
                    console.log('Recetas extraídas de response.recetas:', recetas);
                }
                // Otro formato
                else {
                    console.warn('Formato de respuesta no reconocido:', response);
                    recetas = [];
                }
                
                // Asegurar que sea un array
                if (!Array.isArray(recetas)) {
                    console.error('recetas no es un array:', recetas);
                    recetas = [];
                }
                
                console.log('Recetas procesadas (cantidad):', recetas.length);
                
                let html = '';
                
                if (recetas.length === 0) {
                    html = '<tr><td colspan="8" class="text-center text-muted">No hay recetas registradas</td></tr>';
                } else {
                    for (let i = 0; i < recetas.length; i++) {
                        let receta = recetas[i];
                        html += `
                            <tr>
                                <td><span class="badge badge-secondary">${receta.id_receta || ''}</span></td>
                                <td><strong>${escapeHtml(receta.nombre_medicamento || '')}</strong></td>
                                <td>${escapeHtml(receta.marca || '')}</td>
                                <td>${escapeHtml(receta.cantidad || '')}</td>
                                <td>${escapeHtml(receta.dosis || '-')}</td>
                                <td><i class="fas fa-user-md text-success"></i> ${escapeHtml(receta.medico || 'N/A')}</td>
                                <td><i class="fas fa-calendar-alt"></i> ${receta.fecha_receta || ''}</td>
                                <td class="table-actions">
                                    <button class="btn btn-info btn-sm btn-ver-detalle" data-id="${receta.id_receta}">
                                        <i class="fas fa-eye"></i> Ver
                                    </button>
                                  </td>
                              </tr>
                        `;
                    }
                }
                
                $('#tabla_recetas').html(html);
                console.log('Tabla actualizada con', recetas.length, 'recetas');
            },
            error: function(xhr, status, error) {
                console.error('Error al listar recetas:', error);
                console.error('Respuesta del servidor:', xhr.responseText);
                $('#tabla_recetas').html('</table><td colspan="8" class="text-center text-danger">Error al cargar las recetas: ' + error + '</td></tr>');
            }
        });
    }

    // Ver detalle de receta
    $(document).on('click', '.btn-ver-detalle', function() {
        let id = $(this).data('id');
        console.log('Ver detalle receta ID:', id);
        
        $('#detalle_receta_content').html('<div class="text-center"><div class="spinner-border text-primary"></div><p>Cargando detalles...</p></div>');
        $('#modalDetalleReceta').modal('show');
        
        $.ajax({
            url: APP_URL + '/api/recetas/obtener',
            type: 'POST',
            data: { id_receta: id },
            dataType: 'json',
            success: function(response) {
                console.log('Detalle receta:', response);
                
                // Manejar formato ApiResponse
                var receta = response;
                if (response.success && response.data) {
                    receta = response.data;
                }
                
                if (receta && receta.id_receta) {
                    let html = `
                        <div class="receta-detalle">
                            <div class="row mb-3">
                                <div class="col-md-12 text-center">
                                    <h3 class="text-primary">RECETA MÉDICA</h3>
                                    <hr>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <p><strong><i class="fas fa-id-badge"></i> ID Receta:</strong> ${receta.id_receta}</p>
                                    <p><strong><i class="fas fa-capsules"></i> Medicamento:</strong> ${escapeHtml(receta.nombre_medicamento)}</p>
                                    <p><strong><i class="fas fa-trademark"></i> Marca:</strong> ${escapeHtml(receta.marca)}</p>
                                    <p><strong><i class="fas fa-cubes"></i> Cantidad:</strong> ${escapeHtml(receta.cantidad)}</p>
                                </div>
                                <div class="col-md-6">
                                    <p><strong><i class="fas fa-clock"></i> Dosis:</strong> ${escapeHtml(receta.dosis || 'No especificada')}</p>
                                    <p><strong><i class="fas fa-calendar-day"></i> Fecha:</strong> ${receta.fecha_receta}</p>
                                    <p><strong><i class="fas fa-user-md"></i> Médico ID:</strong> ${receta.id_medico || 'N/A'}</p>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-md-12">
                                    <div class="card">
                                        <div class="card-header bg-info text-white">
                                            <strong><i class="fas fa-stethoscope"></i> Instrucciones</strong>
                                        </div>
                                        <div class="card-body">
                                            ${escapeHtml(receta.instrucciones) || '<em class="text-muted">Sin instrucciones adicionales</em>'}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-md-12 text-muted text-center">
                                    <small>Documento generado electrónicamente por BioVital - Sistema de Gestión Médica</small>
                                </div>
                            </div>
                        </div>
                    `;
                    $('#detalle_receta_content').html(html);
                } else {
                    $('#detalle_receta_content').html('<div class="alert alert-danger">Error al cargar los detalles de la receta</div>');
                }
            },
            error: function(xhr, status, error) {
                console.error('Error al obtener detalle:', error);
                $('#detalle_receta_content').html('<div class="alert alert-danger">Error al cargar los detalles de la receta</div>');
            }
        });
    });

=======
            data: { id_paciente: <?php echo $_SESSION['usuario']; ?> },
            dataType: 'json',
            success: function(recetas) {
                let html = '';
                if (!recetas || recetas.length === 0) {
                    html = '<tr><td colspan="7" class="text-center">No hay recetas registradas</td></tr>';
                } else {
                    for (let receta of recetas) {
                        html += `
                            <tr>
                                <td>${receta.id_receta}</td>
                                <td><strong>${escapeHtml(receta.nombre_medicamento)}</strong></td>
                                <td>${escapeHtml(receta.marca)}</td>
                                <td>${escapeHtml(receta.cantidad)}</td>
                                <td>${escapeHtml(receta.dosis || '-')}</td>
                                <td>${escapeHtml(receta.medico || 'N/A')}</td>
                                <td>${receta.fecha_receta}</td>
                            </tr>
                        `;
                    }
                }
                $('#tabla_recetas').html(html);
            },
            error: function(xhr, status, error) {
                console.error('Error:', error);
                $('#tabla_recetas').html('<tr><td colspan="7" class="text-center text-danger">Error al cargar recetas</td></tr>');
            }
        });
    }
    
>>>>>>> d2039bf34adef6d12dd6c79371df596a3d39fedb
    function escapeHtml(str) {
        if (!str) return '';
        return str
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;')
            .replace(/'/g, '&#39;');
    }
});
</script>

<<<<<<< HEAD
<?php include_once dirname(__DIR__) . '/layouts/footer.php'; ?>
=======
<?php
include_once dirname(__DIR__) . '/layouts/footer.php';
?>
>>>>>>> d2039bf34adef6d12dd6c79371df596a3d39fedb
