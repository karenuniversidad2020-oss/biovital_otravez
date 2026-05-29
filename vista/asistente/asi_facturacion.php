<?php
// vista/asistente/asi_facturacion.php
// Interfaz de Facturación para el Asistente
?>
<style>
    .billing-card {
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.05);
        border: none;
        margin-bottom: 25px;
        transition: transform 0.3s ease;
    }
    .billing-card:hover {
        transform: translateY(-2px);
    }
    .btn-gradient-primary {
        background: linear-gradient(135deg, #0d6efd, #0dcaf0);
        color: white;
        border: none;
        font-weight: 600;
        border-radius: 10px;
        transition: all 0.3s;
    }
    .btn-gradient-primary:hover {
        background: linear-gradient(135deg, #0a58ca, #0bacce);
        color: white;
        box-shadow: 0 4px 12px rgba(13,110,253,0.3);
    }
    .btn-gradient-danger {
        background: linear-gradient(135deg, #dc3545, #f15b6c);
        color: white;
        border: none;
        font-weight: 600;
        border-radius: 10px;
    }
    .btn-gradient-danger:hover {
        background: linear-gradient(135deg, #bd2130, #e44d5e);
        color: white;
        box-shadow: 0 4px 12px rgba(220,53,69,0.3);
    }
    .gradient-header {
        background: linear-gradient(135deg, #1e3c72, #2a5298);
        color: white;
        border-radius: 16px 16px 0 0;
        padding: 1.5rem;
    }
    .table-responsive-custom {
        border-radius: 12px;
        overflow: hidden;
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
    
    /* Autocomplete list style */
    .autocomplete-items {
        position: absolute;
        border: 1px solid #d4d4d4;
        border-bottom: none;
        border-top: none;
        z-index: 99;
        top: 100%;
        left: 0;
        right: 0;
        max-height: 250px;
        overflow-y: auto;
        border-radius: 0 0 10px 10px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }
    .autocomplete-items div {
        padding: 10px;
        cursor: pointer;
        background-color: #fff;
        border-bottom: 1px solid #d4d4d4;
        transition: background-color 0.2s;
    }
    .autocomplete-items div:hover {
        background-color: #e9e9e9;
    }
    
    .invoice-total-box {
        background-color: #f8f9fa;
        border-radius: 12px;
        padding: 1.25rem;
        border: 1px dashed #dee2e6;
    }
</style>

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1><i class="fas fa-file-invoice-dollar text-primary"></i> Facturación y Pagos</h1>
            </div>
        </div>
    </div>
</div>

<section class="content">
    <div class="container-fluid">
        
        <!-- Welcome Banner -->
        <div class="bv-welcome-banner assistant bv-animate mb-4">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2><i class="fas fa-cash-register me-2"></i> Gestión de Facturas</h2>
                    <p class="mb-0">Crea facturas para pacientes, gestiona los estados de pago y corrige errores en las facturas existentes.</p>
                </div>
                <div class="d-none d-md-block">
                    <button class="btn btn-light font-weight-bold" id="btnNuevaFactura">
                        <i class="fas fa-plus-circle text-primary"></i> Registrar Factura
                    </button>
                </div>
            </div>
        </div>

        <!-- Filter Bar -->
        <div class="card billing-card">
            <div class="card-body p-3">
                <div class="row align-items-center">
                    <div class="col-md-4">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-search"></i></span>
                            </div>
                            <input type="text" id="buscar_factura" class="form-control" placeholder="Buscar por N° factura, Cédula o Paciente...">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <select id="filtro_estado" class="form-control">
                            <option value="todos">Todos los estados</option>
                            <option value="Pagado">Pagados</option>
                            <option value="Pendiente">Pendientes</option>
                            <option value="Anulado">Anulados</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                            </div>
                            <input type="date" id="filtro_fecha" class="form-control" title="Filtrar por fecha">
                        </div>
                    </div>
                    <div class="col-md-2 text-right">
                        <button class="btn btn-primary btn-block" id="btnRecargarFacturas">
                            <i class="fas fa-sync"></i> Actualizar
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Invoices List -->
        <div class="card billing-card">
            <div class="card-header bg-transparent border-0 d-flex justify-content-between align-items-center">
                <h3 class="card-title font-weight-bold"><i class="fas fa-list text-primary"></i> Historial de Facturas</h3>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive table-responsive-custom">
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
                        <tbody id="tabla_facturas">
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

<!-- Modal Registrar/Editar Factura -->
<div class="modal fade modal-bv" id="modalFactura" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content border-0 shadow">
            <div class="gradient-header d-flex justify-content-between align-items-center">
                <h5 class="modal-title font-weight-bold" id="modalTitleFactura">
                    <i class="fas fa-file-invoice-dollar"></i> Registrar Factura
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body p-4">
                <form id="formFactura">
                    <input type="hidden" id="id_factura" name="id_factura">
                    
                    <div class="row">
                        <!-- Patient Search Section -->
                        <div class="col-md-12 mb-3 position-relative">
                            <label for="buscar_paciente_fact" class="font-weight-bold">Buscar Paciente <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-user-injured"></i></span>
                                </div>
                                <input type="text" id="buscar_paciente_fact" class="form-control" placeholder="Escriba nombre o cédula del paciente..." autocomplete="off">
                                <input type="hidden" id="id_paciente_fact" name="id_paciente">
                            </div>
                            <div id="autocomplete_pacientes" class="autocomplete-items" style="display: none;"></div>
                            <small class="text-muted">Seleccione un paciente de la lista sugerida.</small>
                        </div>
                    </div>

                    <!-- Items Section -->
                    <div class="card mb-3 bg-light border-0">
                        <div class="card-body p-3">
                            <h6 class="font-weight-bold mb-3 text-secondary"><i class="fas fa-cart-plus"></i> Conceptos de Cobro</h6>
                            
                            <!-- Add Item Inputs -->
                            <div class="row align-items-end mb-3">
                                <div class="col-md-5">
                                    <label for="select_concepto_especialidad" class="small font-weight-bold">Especialidad (Servicio estándar)</label>
                                    <select class="form-control form-control-sm" id="select_concepto_especialidad">
                                        <option value="" data-precio="0">-- Seleccione una especialidad o añada personalizado --</option>
                                        <?php if (!empty($especialidades)): ?>
                                            <?php foreach ($especialidades as $e): ?>
                                                <option value="<?php echo htmlspecialchars($e->nombre); ?>" data-precio="<?php echo $e->costo_base ?? 0; ?>">
                                                    <?php echo htmlspecialchars($e->nombre); ?> (<?php echo number_format($e->costo_base ?? 0, 2); ?> Bs)
                                                </option>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label for="item_concepto_personalizado" class="small font-weight-bold">Concepto Personalizado</label>
                                    <input type="text" class="form-control form-control-sm" id="item_concepto_personalizado" placeholder="Ej: Examen de sangre...">
                                </div>
                                <div class="col-md-2">
                                    <label for="item_precio" class="small font-weight-bold">Precio (Bs) <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control form-control-sm" id="item_precio" placeholder="0.00" min="0" step="0.01">
                                </div>
                                <div class="col-md-1 text-right">
                                    <button type="button" class="btn btn-success btn-sm btn-block" id="btnAgregarItem" title="Agregar concepto">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                </div>
                            </div>

                            <!-- Selected Items Table -->
                            <div class="table-responsive">
                                <table class="table table-sm table-bordered bg-white text-center mb-0">
                                    <thead class="bg-secondary text-white">
                                        <tr>
                                            <th>Descripción</th>
                                            <th style="width: 100px;">Cantidad</th>
                                            <th style="width: 150px;">Precio Unitario (Bs)</th>
                                            <th style="width: 150px;">Total (Bs)</th>
                                            <th style="width: 50px;">Acción</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tabla_items_factura">
                                        <tr class="no-items">
                                            <td colspan="5" class="text-muted py-3">No hay conceptos agregados a la factura.</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Payment and calculation section -->
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="metodo_pago" class="font-weight-bold">Método de Pago <span class="text-danger">*</span></label>
                                <select class="form-control" id="metodo_pago" name="metodo_pago">
                                    <option value="">-- Seleccione método --</option>
                                    <option value="Pago Móvil">Pago Móvil</option>
                                    <option value="Efectivo">Efectivo</option>
                                    <option value="Transferencia">Transferencia</option>
                                    <option value="Tarjeta">Tarjeta de Débito/Crédito</option>
                                    <option value="Divisas">Divisas (USD / EUR)</option>
                                </select>
                            </div>
                            
                            <div class="form-group">
                                <label for="estado_pago" class="font-weight-bold">Estado de Pago <span class="text-danger">*</span></label>
                                <select class="form-control" id="estado_pago" name="estado_pago">
                                    <option value="Pendiente">Pendiente</option>
                                    <option value="Pagado">Pagado</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="notas" class="font-weight-bold">Notas Adicionales</label>
                                <textarea class="form-control" id="notas" name="notas" rows="2" placeholder="Información del pago, nro de referencia bancaria, etc..."></textarea>
                            </div>
                        </div>

                        <!-- Invoice Summary -->
                        <div class="col-md-6">
                            <div class="invoice-total-box">
                                <h6 class="font-weight-bold text-dark border-bottom pb-2 mb-3">Resumen de Totales</h6>
                                <div class="d-flex justify-content-between mb-2">
                                    <span>Subtotal:</span>
                                    <span class="font-weight-bold" id="lblSubtotal">0.00 Bs</span>
                                </div>
                                <div class="d-flex justify-content-between mb-2 align-items-center">
                                    <span>Descuento (Bs):</span>
                                    <input type="number" class="form-control form-control-sm text-right" id="txtDescuento" name="descuento" value="0.00" min="0" step="0.01" style="width: 120px;">
                                </div>
                                <div class="d-flex justify-content-between mb-2">
                                    <span>IVA (16%):</span>
                                    <span class="font-weight-bold text-muted" id="lblIVA">0.00 Bs</span>
                                </div>
                                <div class="d-flex justify-content-between border-top pt-2" style="font-size: 1.2rem;">
                                    <span class="font-weight-bold">Total Neto:</span>
                                    <span class="font-weight-bold text-primary" id="lblTotal">0.00 Bs</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer bg-light border-0 rounded-bottom">
                <button type="button" class="btn btn-secondary rounded-pill px-4" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-gradient-primary rounded-pill px-4" id="btnGuardarFactura">
                    <i class="fas fa-save"></i> Guardar Factura
                </button>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    console.log('=== GESTIÓN DE FACTURACIÓN ASISTENTE ===');
    
    let facturasList = [];
    let itemsFactura = [];
    let editMode = false;
    
    // Configurar recarga
    cargarFacturas();
    
    $('#btnRecargarFacturas').click(function() {
        cargarFacturas();
    });

    // Cambios en filtros
    $('#buscar_factura').on('keyup', function() {
        filtrarTabla();
    });
    
    $('#filtro_estado, #filtro_fecha').change(function() {
        filtrarTabla();
    });

    // Cargar facturas desde API
    function cargarFacturas() {
        $('#tabla_facturas').html(`
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
                console.log('Facturas recibidas:', response);
                
                // Manejar ApiResponse
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
                $('#tabla_facturas').html(`
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
                
                let btnEditarHTML = '';
                let btnAnularHTML = '';
                
                // Permitir editar y anular solo si no está anulada
                if (f.estado_pago !== 'Anulado') {
                    btnEditarHTML = `
                        <button class="btn btn-warning btn-sm btn-editar-fact" data-id="${f.id_factura}" title="Editar factura">
                            <i class="fas fa-edit"></i>
                        </button>
                    `;
                    btnAnularHTML = `
                        <button class="btn btn-danger btn-sm btn-anular-fact" data-id="${f.id_factura}" title="Anular factura">
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
                            <a href="${APP_URL}/facturacion/ver/${f.id_factura}" target="_blank" class="btn btn-info btn-sm" title="Ver / Imprimir">
                                <i class="fas fa-print"></i>
                            </a>
                            ${btnEditarHTML}
                            ${btnAnularHTML}
                        </td>
                    </tr>
                `;
            });
        }
        $('#tabla_facturas').html(html);
    }
    
    function filtrarTabla() {
        let busqueda = $('#buscar_factura').val().toLowerCase();
        let estado = $('#filtro_estado').val();
        let fecha = $('#filtro_fecha').val();
        
        let filtradas = facturasList.filter(f => {
            let matchBusqueda = f.numero_factura.toLowerCase().includes(busqueda) || 
                                f.paciente_nombre.toLowerCase().includes(busqueda) || 
                                f.cedula_paciente.includes(busqueda);
            
            let matchEstado = (estado === 'todos' || f.estado_pago === estado);
            let matchFecha = (!fecha || f.fecha_emision === fecha);
            
            return matchBusqueda && matchEstado && matchFecha;
        });
        
        renderizarFacturas(filtradas);
    }

    // ==================== AUTOCOMPLETE PACIENTES ====================
    let timeoutId;
    $('#buscar_paciente_fact').on('keyup', function() {
        let dato = $(this).val();
        clearTimeout(timeoutId);
        
        if (dato.length >= 2) {
            timeoutId = setTimeout(function() {
                $.ajax({
                    url: APP_URL + '/api/recetas/buscar-pacientes',
                    type: 'POST',
                    data: { dato: dato },
                    dataType: 'json',
                    success: function(pacientes) {
                        let html = '';
                        if (!pacientes || pacientes.length === 0) {
                            html = '<div class="disabled">No se encontraron pacientes</div>';
                        } else {
                            pacientes.forEach(p => {
                                html += `<div class="paciente-opt" data-id="${p.id_usuario}" data-nombre="${escapeHtml(p.nombre_completo)}" data-cedula="${escapeHtml(p.cedula)}">
                                            <strong>${escapeHtml(p.nombre_completo)}</strong> - Cédula: ${p.cedula}
                                         </div>`;
                            });
                        }
                        $('#autocomplete_pacientes').html(html).show();
                        
                        $('.paciente-opt').click(function() {
                            let id = $(this).data('id');
                            let nombre = $(this).data('nombre');
                            let cedula = $(this).data('cedula');
                            
                            $('#id_paciente_fact').val(id);
                            $('#buscar_paciente_fact').val(nombre + ' (CI: ' + cedula + ')');
                            $('#autocomplete_pacientes').hide();
                        });
                    }
                });
            }, 300);
        } else {
            $('#autocomplete_pacientes').hide();
        }
    });

    $(document).click(function(e) {
        if (!$(e.target).closest('#buscar_paciente_fact, #autocomplete_pacientes').length) {
            $('#autocomplete_pacientes').hide();
        }
    });

    // ==================== ESPECIALIDADES SELECT AUTO-FILL ====================
    $('#select_concepto_especialidad').change(function() {
        let selectedOption = $(this).find('option:selected');
        let precio = parseFloat(selectedOption.data('precio')) || 0;
        
        if ($(this).val() !== '') {
            $('#item_concepto_personalizado').val(''); // Vaciar personalizado
            $('#item_precio').val(precio.toFixed(2));
        } else {
            $('#item_precio').val('');
        }
    });

    $('#item_concepto_personalizado').on('input', function() {
        if ($(this).val() !== '') {
            $('#select_concepto_especialidad').val(''); // Vaciar especialidad
        }
    });

    // ==================== DETALLES DE ITEMS ====================
    $('#btnAgregarItem').click(function() {
        let concepto = '';
        let selectedEsp = $('#select_concepto_especialidad').val();
        let customConcept = $('#item_concepto_personalizado').val().trim();
        let precio = parseFloat($('#item_precio').val()) || 0;
        
        if (selectedEsp !== '') {
            concepto = selectedEsp;
        } else if (customConcept !== '') {
            concepto = customConcept;
        } else {
            alert('Debe seleccionar una especialidad o escribir un concepto personalizado.');
            return;
        }
        
        if (precio <= 0) {
            alert('El precio debe ser mayor a cero.');
            $('#item_precio').focus();
            return;
        }
        
        // Agregar a la lista
        itemsFactura.push({
            descripcion: concepto,
            cantidad: 1,
            precio_unitario: precio
        });
        
        // Limpiar inputs
        $('#select_concepto_especialidad').val('');
        $('#item_concepto_personalizado').val('');
        $('#item_precio').val('');
        
        actualizarTablaItems();
    });

    function actualizarTablaItems() {
        let html = '';
        if (itemsFactura.length === 0) {
            html = `<tr class="no-items"><td colspan="5" class="text-muted py-3">No hay conceptos agregados a la factura.</td></tr>`;
        } else {
            itemsFactura.forEach((item, index) => {
                let sub = item.cantidad * item.precio_unitario;
                html += `
                    <tr>
                        <td class="text-left font-weight-bold">${escapeHtml(item.descripcion)}</td>
                        <td>
                            <input type="number" class="form-control form-control-sm text-center change-qty" data-index="${index}" value="${item.cantidad}" min="1" style="width: 70px; margin: 0 auto;">
                        </td>
                        <td>
                            <input type="number" class="form-control form-control-sm text-right change-price" data-index="${index}" value="${item.precio_unitario.toFixed(2)}" min="0" step="0.01" style="width: 110px; margin: 0 auto;">
                        </td>
                        <td class="text-right"><strong>${sub.toFixed(2)} Bs</strong></td>
                        <td>
                            <button type="button" class="btn btn-danger btn-xs btn-remove-item" data-index="${index}">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </td>
                    </tr>
                `;
            });
        }
        $('#tabla_items_factura').html(html);
        recalcularTotales();
    }

    // Cambiar cantidad
    $(document).on('change', '.change-qty', function() {
        let idx = $(this).data('index');
        let val = parseInt($(this).val()) || 1;
        if (val < 1) val = 1;
        itemsFactura[idx].cantidad = val;
        actualizarTablaItems();
    });

    // Cambiar precio directamente en la tabla
    $(document).on('change', '.change-price', function() {
        let idx = $(this).data('index');
        let val = parseFloat($(this).val()) || 0;
        if (val < 0) val = 0;
        itemsFactura[idx].precio_unitario = val;
        actualizarTablaItems();
    });

    // Remover item
    $(document).on('click', '.btn-remove-item', function() {
        let idx = $(this).data('index');
        itemsFactura.splice(idx, 1);
        actualizarTablaItems();
    });

    // Descuento manual
    $('#txtDescuento').on('input', function() {
        recalcularTotales();
    });

    function recalcularTotales() {
        let subtotal = 0;
        itemsFactura.forEach(item => {
            subtotal += item.cantidad * item.precio_unitario;
        });
        
        let descuento = parseFloat($('#txtDescuento').val()) || 0;
        if (descuento < 0) descuento = 0;
        if (descuento > subtotal) {
            descuento = subtotal;
            $('#txtDescuento').val(descuento.toFixed(2));
        }
        
        let base_imponible = subtotal - descuento;
        let iva = base_imponible * 0.16; // 16% IVA
        let total = base_imponible + iva;
        
        $('#lblSubtotal').text(subtotal.toFixed(2) + ' Bs');
        $('#lblIVA').text(iva.toFixed(2) + ' Bs');
        $('#lblTotal').text(total.toFixed(2) + ' Bs');
    }

    // ==================== ABRIR MODAL CREACIÓN ====================
    $('#btnNuevaFactura').click(function() {
        resetFormulario();
        editMode = false;
        $('#modalTitleFactura').html('<i class="fas fa-file-invoice-dollar text-white"></i> Registrar Factura');
        $('#modalFactura').modal('show');
    });

    function resetFormulario() {
        $('#id_factura').val('');
        $('#buscar_paciente_fact').val('').prop('readonly', false);
        $('#id_paciente_fact').val('');
        $('#metodo_pago').val('');
        $('#estado_pago').val('Pendiente');
        $('#notas').val('');
        $('#txtDescuento').val('0.00');
        itemsFactura = [];
        actualizarTablaItems();
    }

    // ==================== GUARDAR FACTURA (CREAR / EDITAR) ====================
    $('#btnGuardarFactura').click(function() {
        let id_paciente = $('#id_paciente_fact').val();
        let metodo_pago = $('#metodo_pago').val();
        let estado_pago = $('#estado_pago').val();
        let notas = $('#notas').val();
        let descuento = parseFloat($('#txtDescuento').val()) || 0;
        
        if (!id_paciente) {
            alert('Debe buscar y seleccionar un paciente.');
            $('#buscar_paciente_fact').focus();
            return;
        }
        
        if (itemsFactura.length === 0) {
            alert('Debe agregar al menos un concepto a la factura.');
            return;
        }
        
        if (!metodo_pago) {
            alert('Debe seleccionar un método de pago.');
            $('#metodo_pago').focus();
            return;
        }
        
        let subtotal = 0;
        itemsFactura.forEach(i => {
            subtotal += i.cantidad * i.precio_unitario;
        });
        
        let base_imponible = subtotal - descuento;
        let iva = base_imponible * 0.16;
        let total = base_imponible + iva;
        
        let url = editMode ? (APP_URL + '/api/facturacion/editar') : (APP_URL + '/api/facturacion/crear');
        
        let postData = {
            id_paciente: id_paciente,
            subtotal: subtotal.toFixed(2),
            iva: iva.toFixed(2),
            descuento: descuento.toFixed(2),
            total: total.toFixed(2),
            metodo_pago: metodo_pago,
            estado_pago: estado_pago,
            notas: notas,
            items: JSON.stringify(itemsFactura),
            csrf_token: $('meta[name="csrf-token"]').attr('content')
        };
        
        if (editMode) {
            postData.id_factura = $('#id_factura').val();
        }
        
        $('#btnGuardarFactura').prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Guardando...');
        
        $.ajax({
            url: url,
            type: 'POST',
            data: postData,
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    alert(editMode ? 'Factura editada correctamente' : 'Factura registrada con éxito. Nro: ' + response.numero_factura);
                    $('#modalFactura').modal('hide');
                    cargarFacturas();
                } else {
                    alert('Error: ' + response.message);
                }
            },
            error: function(xhr, status, error) {
                console.error('Error guardando factura:', error);
                alert('Ocurrió un error al procesar la factura.');
            },
            complete: function() {
                $('#btnGuardarFactura').prop('disabled', false).html('<i class="fas fa-save"></i> Guardar Factura');
            }
        });
    });

    // ==================== EDITAR FACTURA ====================
    $(document).on('click', '.btn-editar-fact', function() {
        let id = $(this).data('id');
        resetFormulario();
        editMode = true;
        
        $.ajax({
            url: APP_URL + '/api/facturacion/obtener',
            type: 'POST',
            data: { id_factura: id },
            dataType: 'json',
            success: function(response) {
                console.log('Factura a editar cargada:', response);
                let f = response.factura;
                let det = response.detalles;
                
                $('#id_factura').val(f.id_factura);
                $('#id_paciente_fact').val(f.id_paciente);
                $('#buscar_paciente_fact').val(f.nombre_paciente + ' ' + f.apellido_paciente + ' (CI: ' + f.cedula_paciente + ')').prop('readonly', true);
                $('#metodo_pago').val(f.metodo_pago);
                $('#estado_pago').val(f.estado_pago);
                $('#notas').val(f.notas);
                $('#txtDescuento').val(parseFloat(f.descuento).toFixed(2));
                
                itemsFactura = det.map(d => ({
                    descripcion: d.descripcion,
                    cantidad: parseInt(d.cantidad),
                    precio_unitario: parseFloat(d.precio_unitario)
                }));
                
                actualizarTablaItems();
                
                $('#modalTitleFactura').html('<i class="fas fa-edit text-white"></i> Editar Factura N° ' + f.numero_factura);
                $('#modalFactura').modal('show');
            },
            error: function() {
                alert('No se pudo cargar la factura para edición.');
            }
        });
    });

    // ==================== ANULAR FACTURA ====================
    $(document).on('click', '.btn-anular-fact', function() {
        let id = $(this).data('id');
        if (confirm('¿Está seguro de que desea ANULAR esta factura? Esta acción cancelará la transacción financieramente y no se podrá deshacer.')) {
            $.ajax({
                url: APP_URL + '/api/facturacion/anular',
                type: 'POST',
                data: { id_factura: id },
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        alert('Factura anulada con éxito.');
                        cargarFacturas();
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
