<?php
// vista/documentos/factura_detalle.php
// Plantilla imprimible para el detalle de la factura
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Factura <?php echo htmlspecialchars($factura->numero_factura); ?> - BioVital</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        body {
            font-family: 'Inter', Arial, sans-serif;
            background-color: #f4f6f9;
            color: #333;
        }
        .invoice-box {
            max-width: 800px;
            margin: 30px auto;
            padding: 30px;
            border-radius: 16px;
            background-color: #fff;
            box-shadow: 0 4px 20px rgba(0,0,0,0.08);
        }
        .invoice-header {
            border-bottom: 2px solid #007bff;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }
        .company-logo {
            font-size: 24px;
            font-weight: 800;
            color: #007bff;
            letter-spacing: 1px;
        }
        .invoice-title {
            font-size: 28px;
            font-weight: 700;
            color: #4a5568;
            margin-bottom: 5px;
        }
        .badge-status {
            font-size: 0.85rem;
            padding: 6px 12px;
            border-radius: 20px;
            font-weight: 600;
        }
        .badge-status-pagado { background-color: #d1fae5; color: #065f46; }
        .badge-status-pendiente { background-color: #fef3c7; color: #92400e; }
        .badge-status-anulado { background-color: #fee2e2; color: #991b1b; }
        
        .totals-table td {
            padding: 5px 10px;
            border: none !important;
        }
        
        @media print {
            body {
                background-color: #fff;
                color: #000;
            }
            .invoice-box {
                box-shadow: none;
                margin: 0;
                padding: 0;
                width: 100%;
                max-width: 100%;
            }
            .no-print {
                display: none !important;
            }
            .invoice-header {
                border-bottom: 2px solid #000;
            }
        }
    </style>
</head>
<body>

<div class="container">
    <!-- Action buttons for browser -->
    <div class="no-print text-center my-4">
        <button onclick="window.print();" class="btn btn-primary btn-lg rounded-pill px-4 shadow-sm mr-2">
            <i class="fas fa-print"></i> Imprimir Factura
        </button>
        <button onclick="window.close();" class="btn btn-secondary btn-lg rounded-pill px-4 shadow-sm">
            <i class="fas fa-times"></i> Cerrar Ventana
        </button>
    </div>

    <!-- Invoice Sheet -->
    <div class="invoice-box">
        <!-- Header Section -->
        <div class="invoice-header">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <div class="company-logo">
                        <i class="fas fa-heartbeat"></i> BIOVITAL
                    </div>
                    <address class="text-muted mt-2 small">
                        Av. Panteón, Edif. Centro Clínico, Piso 2.<br>
                        San Bernardino, Caracas - Venezuela.<br>
                        Teléfono: (0212) 555-1122<br>
                        R.I.F.: J-12345678-9
                    </address>
                </div>
                <div class="col-md-6 text-md-right">
                    <div class="invoice-title">FACTURA</div>
                    <div class="h5 font-weight-bold text-primary"><?php echo htmlspecialchars($factura->numero_factura); ?></div>
                    <div class="text-muted small">Fecha Emisión: <strong><?php echo $factura->fecha_emision; ?></strong></div>
                    <?php 
                        $badgeClass = '';
                        if ($factura->estado_pago === 'Pagado') $badgeClass = 'badge-status-pagado';
                        else if ($factura->estado_pago === 'Pendiente') $badgeClass = 'badge-status-pendiente';
                        else if ($factura->estado_pago === 'Anulado') $badgeClass = 'badge-status-anulado';
                    ?>
                    <div class="mt-2">
                        <span class="badge-status <?php echo $badgeClass; ?>"><?php echo $factura->estado_pago; ?></span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Information Section -->
        <div class="row mb-4">
            <div class="col-md-6">
                <h6 class="font-weight-bold text-secondary border-bottom pb-1 mb-2">PACIENTE:</h6>
                <div class="font-weight-bold" style="font-size: 1.1rem;">
                    <?php echo htmlspecialchars($factura->nombre_paciente . ' ' . $factura->apellido_paciente); ?>
                </div>
                <div class="text-muted small mt-1">
                    <i class="fas fa-id-card fa-fw"></i> C.I.: <?php echo htmlspecialchars($factura->cedula_paciente); ?><br>
                    <i class="fas fa-phone fa-fw"></i> Teléfono: <?php echo htmlspecialchars($factura->telefono_paciente ?? 'N/A'); ?><br>
                    <i class="fas fa-envelope fa-fw"></i> Correo: <?php echo htmlspecialchars($factura->correo_paciente ?? 'N/A'); ?><br>
                    <i class="fas fa-map-marker-alt fa-fw"></i> Dirección: <?php echo htmlspecialchars($factura->direccion_paciente ?? 'N/A'); ?>
                </div>
            </div>
            <div class="col-md-6 text-md-right mt-3 mt-md-0">
                <h6 class="font-weight-bold text-secondary border-bottom pb-1 mb-2">PAGO & ATENCIÓN:</h6>
                <div class="text-muted small mt-1">
                    Método de Pago: <strong><?php echo htmlspecialchars($factura->metodo_pago); ?></strong><br>
                    Atendido por: <strong><?php echo htmlspecialchars(($factura->nombre_asistente ?? 'Administrador') . ' ' . ($factura->apellido_asistente ?? '')); ?></strong><br>
                    ID Transacción: <strong><?php echo $factura->id_factura; ?></strong>
                </div>
            </div>
        </div>

        <!-- Invoice Details Table -->
        <div class="table-responsive mb-4">
            <table class="table table-striped table-bordered text-center">
                <thead class="bg-primary text-white">
                    <tr>
                        <th>Descripción del Concepto</th>
                        <th style="width: 100px;">Cant.</th>
                        <th style="width: 150px;">Precio Unitario</th>
                        <th style="width: 180px;">Total (Bs)</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($detalles as $d): ?>
                        <tr>
                            <td class="text-left font-weight-bold"><?php echo htmlspecialchars($d->descripcion); ?></td>
                            <td><?php echo $d->cantidad; ?></td>
                            <td><?php echo number_format($d->precio_unitario, 2); ?> Bs</td>
                            <td class="text-right"><strong><?php echo number_format($d->subtotal, 2); ?> Bs</strong></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <!-- Summary and Footer -->
        <div class="row">
            <div class="col-md-7">
                <?php if (!empty($factura->notas)): ?>
                    <div class="p-3 bg-light rounded" style="border-left: 4px solid #17a2b8; font-size: 0.85rem;">
                        <h6 class="font-weight-bold text-info"><i class="fas fa-info-circle"></i> Observaciones de Pago:</h6>
                        <p class="mb-0 text-muted"><?php echo nl2br(htmlspecialchars($factura->notas)); ?></p>
                    </div>
                <?php endif; ?>
            </div>
            <div class="col-md-5">
                <table class="table totals-table text-right font-weight-bold">
                    <tr>
                        <td class="text-muted">Subtotal:</td>
                        <td style="width: 150px;"><?php echo number_format($factura->subtotal, 2); ?> Bs</td>
                    </tr>
                    <?php if ($factura->descuento > 0): ?>
                        <tr>
                            <td class="text-danger">Descuento:</td>
                            <td class="text-danger">- <?php echo number_format($factura->descuento, 2); ?> Bs</td>
                        </tr>
                    <?php endif; ?>
                    <tr>
                        <td class="text-muted">I.V.A. (16%):</td>
                        <td><?php echo number_format($factura->iva, 2); ?> Bs</td>
                    </tr>
                    <tr class="border-top" style="font-size: 1.15rem;">
                        <td class="text-primary">Total Neto:</td>
                        <td class="text-primary font-weight-bold" style="border-bottom: 2px double #007bff;"><?php echo number_format($factura->total, 2); ?> Bs</td>
                    </tr>
                </table>
            </div>
        </div>

        <!-- Greetings footer -->
        <div class="text-center text-muted border-top pt-4 mt-5 small">
            <p>¡Gracias por confiar tu salud en el equipo de <strong>BioVital</strong>!</p>
            <p class="mb-0">Este recibo es un comprobante formal de la transacción médica realizada.</p>
        </div>
    </div>
</div>

</body>
</html>
