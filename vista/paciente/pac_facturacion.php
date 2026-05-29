<?php
// vista/paciente/pac_facturacion.php
// Historial de Facturas y Pagos para el Paciente
?>
<style>
    .patient-card {
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.05);
        border: none;
        margin-bottom: 25px;
    }
    .gradient-header-patient {
        background: linear-gradient(135deg, #11998e, #38ef7d);
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
    
    .financial-stat-card {
        border-radius: 16px;
        padding: 1.25rem;
        text-align: center;
        border: 1px solid #eef2f6;
        background: white;
        transition: transform 0.3s;
    }
    .financial-stat-card:hover {
        transform: translateY(-2px);
    }
    .financial-number {
        font-size: 1.6rem;
        font-weight: 800;
    }
    .financial-label {
        font-size: 0.75rem;
        color: #8898aa;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
</style>

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1><i class="fas fa-receipt text-success"></i> Mis Pagos y Facturas</h1>
            </div>
        </div>
    </div>
</div>

<section class="content">
    <div class="container-fluid">
        
        <!-- Welcome Banner -->
        <div class="gradient-header-patient mb-4">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2><i class="fas fa-file-invoice me-2"></i> Estado de Cuenta</h2>
                    <p class="mb-0">Consulta tus facturas médicas, estados de pago y descarga tus recibos oficiales.</p>
                </div>
                <div class="d-none d-md-block">
                    <i class="fas fa-file-invoice-dollar fa-3x" style="opacity: 0.2;"></i>
                </div>
            </div>
        </div>

        <!-- Financial Mini Stats -->
        <div class="row mb-4">
            <div class="col-md-4">
                <div class="financial-stat-card">
                    <div class="financial-number text-success" id="stat_total_pagado">0.00 Bs</div>
                    <div class="financial-label">Total Pagado</div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="financial-stat-card">
                    <div class="financial-number text-warning" id="stat_total_pendiente">0.00 Bs</div>
                    <div class="financial-label">Pendiente por Pagar</div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="financial-stat-card">
                    <div class="financial-number text-primary" id="stat_total_facturas">0</div>
                    <div class="financial-label">Facturas Emitidas</div>
                </div>
            </div>
        </div>

        <!-- Filter Bar -->
        <div class="card patient-card">
            <div class="card-body p-3">
                <div class="row align-items-center">
                    <div class="col-md-5">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-search"></i></span>
                            </div>
                            <input type="text" id="buscar_factura_pac" class="form-control" placeholder="Buscar por número de factura...">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <select id="filtro_estado_pac" class="form-control">
                            <option value="todos">Todos los estados</option>
                            <option value="Pagado">Pagados</option>
                            <option value="Pendiente">Pendientes</option>
                            <option value="Anulado">Anulados</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <button class="btn btn-success btn-block font-weight-bold" id="btnActualizarFacturasPac">
                            <i class="fas fa-sync-alt"></i> Actualizar
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Invoices Table -->
        <div class="card patient-card">
            <div class="card-header bg-transparent border-0">
                <h3 class="card-title font-weight-bold"><i class="fas fa-history text-success"></i> Historial Clínico de Pagos</h3>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover table-striped mb-0">
                        <thead class="bg-success text-white">
                            <tr>
                                <th>Factura N°</th>
                                <th>Fecha Emisión</th>
                                <th>Método de Pago</th>
                                <th>Subtotal</th>
                                <th>IVA</th>
                                <th>Total</th>
                                <th>Estado</th>
                                <th class="text-center">Ver Recibo</th>
                            </tr>
                        </thead>
                        <tbody id="tabla_facturas_pac">
                            <tr>
                                <td colspan="8" class="text-center py-4">
                                    <div class="spinner-border text-success" role="status"></div>
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
    console.log('=== FACTURACIÓN PACIENTE ===');
    
    let facturasList = [];
    
    cargarFacturasPaciente();
    
    $('#btnActualizarFacturasPac').click(function() {
        cargarFacturasPaciente();
    });

    $('#buscar_factura_pac').on('keyup', function() {
        filtrarTabla();
    });

    $('#filtro_estado_pac').change(function() {
        filtrarTabla();
    });

    function cargarFacturasPaciente() {
        $('#tabla_facturas_pac').html(`
            <tr>
                <td colspan="8" class="text-center py-4">
                    <div class="spinner-border text-success" role="status"></div>
                    <p class="mt-2 mb-0">Cargando facturas...</p>
                </td>
            </tr>
        `);
        
        $.ajax({
            url: APP_URL + '/api/facturacion/listar',
            type: 'POST',
            dataType: 'json',
            success: function(response) {
                console.log('Facturas del paciente:', response);
                
                // Manejar ApiResponse
                let data = [];
                if (response.success && response.data) {
                    data = response.data;
                } else if (Array.isArray(response)) {
                    data = response;
                }
                
                facturasList = data;
                calcularMiniEstadisticas(data);
                renderizarFacturas(data);
            },
            error: function(xhr, status, error) {
                console.error('Error cargando facturas:', error);
                $('#tabla_facturas_pac').html(`
                    <tr>
                        <td colspan="8" class="text-center text-danger py-4">
                            <i class="fas fa-exclamation-triangle"></i> Error al conectar con el servidor
                        </td>
                    </tr>
                `);
            }
        });
    }
    
    function calcularMiniEstadisticas(facturas) {
        let pagado = 0;
        let pendiente = 0;
        let cantidad = 0;
        
        facturas.forEach(f => {
            if (f.estado_pago === 'Pagado') {
                pagado += parseFloat(f.total);
            } else if (f.estado_pago === 'Pendiente') {
                pendiente += parseFloat(f.total);
            }
            if (f.estado_pago !== 'Anulado') {
                cantidad++;
            }
        });
        
        $('#stat_total_pagado').text(pagado.toFixed(2) + ' Bs');
        $('#stat_total_pendiente').text(pendiente.toFixed(2) + ' Bs');
        $('#stat_total_facturas').text(cantidad);
    }

    function renderizarFacturas(facturas) {
        let html = '';
        if (facturas.length === 0) {
            html = `<tr><td colspan="8" class="text-center text-muted py-4">No tienes facturas registradas.</td></tr>`;
        } else {
            facturas.forEach(f => {
                let badgeClass = '';
                if (f.estado_pago === 'Pagado') badgeClass = 'badge-status-pagado';
                else if (f.estado_pago === 'Pendiente') badgeClass = 'badge-status-pendiente';
                else if (f.estado_pago === 'Anulado') badgeClass = 'badge-status-anulado';
                
                html += `
                    <tr>
                        <td><strong>${escapeHtml(f.numero_factura)}</strong></td>
                        <td>${f.fecha_emision}</td>
                        <td>${escapeHtml(f.metodo_pago)}</td>
                        <td>${numberFormat(f.subtotal)} Bs</td>
                        <td>${numberFormat(f.iva)} Bs</td>
                        <td><strong>${numberFormat(f.total)} Bs</strong></td>
                        <td><span class="badge-status ${badgeClass}">${f.estado_pago}</span></td>
                        <td class="text-center">
                            <a href="${APP_URL}/facturacion/ver/${f.id_factura}" target="_blank" class="btn btn-success btn-sm font-weight-bold" title="Imprimir / Ver Detalle">
                                <i class="fas fa-print"></i> Detalle
                            </a>
                        </td>
                    </tr>
                `;
            });
        }
        $('#tabla_facturas_pac').html(html);
    }
    
    function filtrarTabla() {
        let busqueda = $('#buscar_factura_pac').val().toLowerCase();
        let estado = $('#filtro_estado_pac').val();
        
        let filtradas = facturasList.filter(f => {
            let matchBusqueda = f.numero_factura.toLowerCase().includes(busqueda);
            let matchEstado = (estado === 'todos' || f.estado_pago === estado);
            return matchBusqueda && matchEstado;
        });
        
        renderizarFacturas(filtradas);
    }

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
