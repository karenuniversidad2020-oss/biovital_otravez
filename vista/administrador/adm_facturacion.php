<?php
// vista/administrador/adm_facturacion.php
// Dashboard de Facturación para el Administrador
?>
<style>
    .admin-card {
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.05);
        border: none;
        margin-bottom: 25px;
    }
    .gradient-header-admin {
        background: linear-gradient(135deg, #30cfd0, #330867);
        color: white;
        border-radius: 16px;
        padding: 1.5rem;
    }
    .badge-status {
        font-size: 0.75rem;
        padding: 6px 12px;
        border-radius: 20px;
        font-weight: 600;
    }
    .badge-status-pagado { background-color: #d1fae5; color: #065f46; }
    .badge-status-pendiente { background-color: #fef3c7; color: #92400e; }
    .badge-status-anulado { background-color: #fee2e2; color: #991b1b; }
    
    .metric-card {
        background: white;
        border-radius: 16px;
        border: 1px solid #eef2f6;
        padding: 1.5rem;
        margin-bottom: 20px;
        box-shadow: 0 2px 12px rgba(0,0,0,0.02);
        transition: transform 0.3s;
    }
    .metric-card:hover {
        transform: translateY(-2px);
    }
    .metric-number {
        font-size: 2rem;
        font-weight: 800;
        margin-bottom: 5px;
    }
    .metric-label {
        font-size: 0.75rem;
        color: #8898aa;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        font-weight: 600;
    }
    .progress-bar-custom {
        height: 8px;
        border-radius: 4px;
    }
</style>

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1><i class="fas fa-chart-line text-purple"></i> Dashboard Financiero y Facturación</h1>
            </div>
        </div>
    </div>
</div>

<section class="content">
    <div class="container-fluid">
        
        <!-- Welcome Banner -->
        <div class="gradient-header-admin mb-4">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2><i class="fas fa-university me-2"></i> Reporte e Ingresos</h2>
                    <p class="mb-0">Audita todas las transacciones, visualiza el flujo de caja e ingresos mensuales del centro clínico BioVital.</p>
                </div>
                <div class="d-none d-md-block">
                    <i class="fas fa-chart-pie fa-3x" style="opacity: 0.2;"></i>
                </div>
            </div>
        </div>

        <!-- Metric Cards -->
        <div class="row">
            <div class="col-lg-4 col-md-6 col-12">
                <div class="metric-card">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div class="metric-label">Ingresos de este Mes</div>
                        <i class="fas fa-dollar-sign text-success fa-lg"></i>
                    </div>
                    <div class="metric-number text-success" id="lblAdminIngresos">0.00 Bs</div>
                    <small class="text-muted"><i class="fas fa-check-circle text-success"></i> Solo facturas pagadas</small>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-12">
                <div class="metric-card">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div class="metric-label">Facturas Emitidas (Mes)</div>
                        <i class="fas fa-file-invoice text-primary fa-lg"></i>
                    </div>
                    <div class="metric-number text-primary" id="lblAdminFacturasEmitidas">0</div>
                    <small class="text-muted"><i class="fas fa-clock text-primary"></i> Total transacciones de este mes</small>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-12">
                <div class="metric-card">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div class="metric-label">Facturas Pendientes</div>
                        <i class="fas fa-exclamation-circle text-warning fa-lg"></i>
                    </div>
                    <div class="metric-number text-warning" id="lblAdminFacturasPendientes">0</div>
                    <small class="text-muted"><i class="fas fa-hand-holding-usd text-warning"></i> Cuentas pendientes de cobro</small>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Payment Methods Card -->
            <div class="col-md-6">
                <div class="card admin-card">
                    <div class="card-header bg-transparent border-0">
                        <h3 class="card-title font-weight-bold"><i class="fas fa-wallet text-secondary"></i> Ingresos por Métodos de Pago</h3>
                    </div>
                    <div class="card-body" id="payment_methods_container">
                        <p class="text-muted text-center py-4">No hay ingresos registrados este mes.</p>
                    </div>
                </div>
            </div>
            
            <!-- History Chart/List Card -->
            <div class="col-md-6">
                <div class="card admin-card">
                    <div class="card-header bg-transparent border-0">
                        <h3 class="card-title font-weight-bold"><i class="fas fa-chart-bar text-secondary"></i> Historial Últimos 6 Meses</h3>
                    </div>
                    <div class="card-body" id="monthly_history_container">
                        <p class="text-muted text-center py-4">No hay historial registrado.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filter Bar -->
        <div class="card admin-card">
            <div class="card-body p-3">
                <div class="row align-items-center">
                    <div class="col-md-3">
                        <div class="input-group input-group-sm">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-search"></i></span>
                            </div>
                            <input type="text" id="buscar_factura_admin" class="form-control" placeholder="Buscar factura, CI, paciente...">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <select id="filtro_estado_admin" class="form-control form-control-sm">
                            <option value="todos">Todos los estados</option>
                            <option value="Pagado">Pagados</option>
                            <option value="Pendiente">Pendientes</option>
                            <option value="Anulado">Anulados</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <input type="date" id="filtro_fecha_inicio" class="form-control form-control-sm" title="Fecha inicio">
                    </div>
                    <div class="col-md-2">
                        <input type="date" id="filtro_fecha_fin" class="form-control form-control-sm" title="Fecha fin">
                    </div>
                    <div class="col-md-3">
                        <button class="btn btn-primary btn-sm btn-block font-weight-bold" id="btnRecargarAdmin">
                            <i class="fas fa-sync-alt"></i> Actualizar Listado
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Invoices List -->
        <div class="card admin-card">
            <div class="card-header bg-transparent border-0">
                <h3 class="card-title font-weight-bold"><i class="fas fa-list text-primary"></i> Auditoría de Transacciones</h3>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover table-striped mb-0">
                        <thead class="thead-dark">
                            <tr>
                                <th>Factura N°</th>
                                <th>Paciente</th>
                                <th>Cédula</th>
                                <th>Fecha Emisión</th>
                                <th>Método de Pago</th>
                                <th>Total</th>
                                <th>Estado</th>
                                <th class="text-center">Acciones</th>
                            </tr>
                        </thead>
                        <tbody id="tabla_facturas_admin">
                            <tr>
                                <td colspan="8" class="text-center py-4">
                                    <div class="spinner-border text-primary" role="status"></div>
                                    <p class="mt-2 mb-0">Cargando facturas...</p>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        
    </div>
</section>

<script>
$(document).ready(function() {
    console.log('=== ADMIN FACTURACIÓN ===');
    
    let facturasList = [];
    
    cargarDatosAdmin();
    
    $('#btnRecargarAdmin').click(function() {
        cargarDatosAdmin();
    });

    $('#buscar_factura_admin').on('keyup', function() {
        filtrarTabla();
    });
    
    $('#filtro_estado_admin, #filtro_fecha_inicio, #filtro_fecha_fin').change(function() {
        filtrarTabla();
    });

    function cargarDatosAdmin() {
        cargarEstadisticasAdmin();
        cargarFacturasAdmin();
    }
    
    function cargarEstadisticasAdmin() {
        $.ajax({
            url: APP_URL + '/api/facturacion/estadisticas',
            type: 'POST',
            dataType: 'json',
            success: function(response) {
                console.log('Estadísticas recibidas:', response);
                let data = response;
                if (response.success && response.data) {
                    data = response.data;
                }
                
                $('#lblAdminIngresos').text(numberFormat(data.ingresos_mes) + ' Bs');
                $('#lblAdminFacturasEmitidas').text(data.facturas_mes);
                $('#lblAdminFacturasPendientes').text(data.facturas_pendientes);
                
                renderizarMetodosPago(data.por_metodo, data.ingresos_mes);
                renderizarHistorico(data.historico);
            }
        });
    }

    function renderizarMetodosPago(metodos, totalMes) {
        let html = '';
        if (!metodos || metodos.length === 0) {
            html = `<p class="text-muted text-center py-4">No hay ingresos registrados este mes.</p>`;
        } else {
            metodos.forEach(m => {
                let perc = totalMes > 0 ? ((m.total / totalMes) * 100) : 0;
                let barClass = 'bg-primary';
                if (m.metodo_pago === 'Divisas') barClass = 'bg-success';
                else if (m.metodo_pago === 'Pago Móvil') barClass = 'bg-info';
                else if (m.metodo_pago === 'Transferencia') barClass = 'bg-warning';
                else if (m.metodo_pago === 'Tarjeta') barClass = 'bg-danger';
                
                html += `
                    <div class="mb-3">
                        <div class="d-flex justify-content-between mb-1">
                            <span class="font-weight-bold text-dark">${escapeHtml(m.metodo_pago)} (${m.cantidad} fac)</span>
                            <span class="font-weight-bold text-secondary">${numberFormat(m.total)} Bs (${perc.toFixed(0)}%)</span>
                        </div>
                        <div class="progress progress-bar-custom bg-light">
                            <div class="progress-bar ${barClass}" role="progressbar" style="width: ${perc}%;" aria-valuenow="${perc}" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                `;
            });
        }
        $('#payment_methods_container').html(html);
    }
    
    function renderizarHistorico(historico) {
        let html = '';
        if (!historico || historico.length === 0) {
            html = `<p class="text-muted text-center py-4">No hay historial registrado.</p>`;
        } else {
            // Obtener el valor máximo para calcular proporciones
            let maxTotal = 0;
            historico.forEach(h => {
                let t = parseFloat(h.total) || 0;
                if (t > maxTotal) maxTotal = t;
            });
            
            historico.forEach(h => {
                let t = parseFloat(h.total) || 0;
                let perc = maxTotal > 0 ? ((t / maxTotal) * 100) : 0;
                
                // Formatear mes (YYYY-MM a MM/YYYY o similar)
                let parts = h.mes.split('-');
                let mesStr = parts[1] + '/' + parts[0];
                
                html += `
                    <div class="d-flex align-items-center mb-3">
                        <div class="font-weight-bold text-secondary" style="width: 70px;">${mesStr}</div>
                        <div class="flex-grow-1 mx-3">
                            <div class="progress progress-bar-custom bg-light">
                                <div class="progress-bar bg-purple" role="progressbar" style="width: ${perc}%;" aria-valuenow="${perc}" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                        <div class="font-weight-bold text-dark" style="width: 100px; text-align: right;">${numberFormat(t)} Bs</div>
                    </div>
                `;
            });
        }
        $('#monthly_history_container').html(html);
    }

    function cargarFacturasAdmin() {
        $('#tabla_facturas_admin').html(`
            <tr>
                <td colspan="8" class="text-center py-4">
                    <div class="spinner-border text-primary" role="status"></div>
                    <p class="mt-2 mb-0">Cargando facturas...</p>
                </td>
            </tr>
        `);
        
        $.ajax({
            url: APP_URL + '/api/facturacion/listar',
            type: 'POST',
            dataType: 'json',
            success: function(response) {
                console.log('Facturas globales recibidas:', response);
                let data = [];
                if (response.success && response.data) {
                    data = response.data;
                } else if (Array.isArray(response)) {
                    data = response;
                }
                
                facturasList = data;
                renderizarFacturas(data);
            },
            error: function(xhr, status, error) {
                console.error('Error cargando facturas:', error);
                $('#tabla_facturas_admin').html(`
                    <tr>
                        <td colspan="8" class="text-center text-danger py-4">
                            <i class="fas fa-exclamation-triangle"></i> Error al cargar facturas de la base de datos
                        </td>
                    </tr>
                `);
            }
        });
    }

    function renderizarFacturas(facturas) {
        let html = '';
        if (facturas.length === 0) {
            html = `<tr><td colspan="8" class="text-center text-muted py-4">No hay facturas registradas.</td></tr>`;
        } else {
            facturas.forEach(f => {
                let badgeClass = '';
                if (f.estado_pago === 'Pagado') badgeClass = 'badge-status-pagado';
                else if (f.estado_pago === 'Pendiente') badgeClass = 'badge-status-pendiente';
                else if (f.estado_pago === 'Anulado') badgeClass = 'badge-status-anulado';
                
                let btnAnularHTML = '';
                if (f.estado_pago !== 'Anulado') {
                    btnAnularHTML = `
                        <button class="btn btn-danger btn-xs btn-anular-fact-admin" data-id="${f.id_factura}" title="Anular factura">
                            <i class="fas fa-ban"></i>
                        </button>
                    `;
                }
                
                html += `
                    <tr>
                        <td><strong>${escapeHtml(f.numero_factura)}</strong></td>
                        <td>${escapeHtml(f.paciente_nombre)}</td>
                        <td>${escapeHtml(f.cedula_paciente)}</td>
                        <td>${f.fecha_emision}</td>
                        <td>${escapeHtml(f.metodo_pago)}</td>
                        <td><strong>${numberFormat(f.total)} Bs</strong></td>
                        <td><span class="badge-status ${badgeClass}">${f.estado_pago}</span></td>
                        <td class="text-center">
                            <a href="${APP_URL}/facturacion/ver/${f.id_factura}" target="_blank" class="btn btn-info btn-xs" title="Ver / Imprimir">
                                <i class="fas fa-print"></i>
                            </a>
                            ${btnAnularHTML}
                        </td>
                    </tr>
                `;
            });
        }
        $('#tabla_facturas_admin').html(html);
    }
    
    function filtrarTabla() {
        let busqueda = $('#buscar_factura_admin').val().toLowerCase();
        let estado = $('#filtro_estado_admin').val();
        let fecha_ini = $('#filtro_fecha_inicio').val();
        let fecha_fin = $('#filtro_fecha_fin').val();
        
        let filtradas = facturasList.filter(f => {
            let matchBusqueda = f.numero_factura.toLowerCase().includes(busqueda) || 
                                f.paciente_nombre.toLowerCase().includes(busqueda) || 
                                f.cedula_paciente.includes(busqueda);
            
            let matchEstado = (estado === 'todos' || f.estado_pago === estado);
            
            let matchFecha = true;
            if (fecha_ini) {
                matchFecha = matchFecha && (f.fecha_emision >= fecha_ini);
            }
            if (fecha_fin) {
                matchFecha = matchFecha && (f.fecha_emision <= fecha_fin);
            }
            
            return matchBusqueda && matchEstado && matchFecha;
        });
        
        renderizarFacturas(filtradas);
    }

    // ==================== ANULAR FACTURA (ADMIN) ====================
    $(document).on('click', '.btn-anular-fact-admin', function() {
        let id = $(this).data('id');
        if (confirm('¿Está seguro de que desea ANULAR esta factura como administrador? Esta acción cancelará la transacción financieramente y no se podrá deshacer.')) {
            $.ajax({
                url: APP_URL + '/api/facturacion/anular',
                type: 'POST',
                data: { id_factura: id },
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        alert('Factura anulada con éxito.');
                        cargarDatosAdmin();
                    } else {
                        alert('Error: ' + response.message);
                    }
                },
                error: function() {
                    alert('No se pudo completar la anulación.');
                }
            });
        }
    });

    // Helpers
    function numberFormat(val) {
        return parseFloat(val).toFixed(2);
    }
    
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
