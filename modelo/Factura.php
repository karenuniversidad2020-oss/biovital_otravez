<?php
// modelo/Factura.php
include_once 'Conexion.php';

class Factura {
    private $acceso;
    
    public function __construct() {
        $db = new Conexion();
        $this->acceso = $db->pdo;
    }
    
    /**
     * Genera un número de factura secuencial (ej: FAC-00001)
     */
    private function generarNumeroFactura() {
        try {
            $sql = "SELECT MAX(id_factura) as max_id FROM facturas";
            $query = $this->acceso->query($sql);
            $resultado = $query->fetch(PDO::FETCH_OBJ);
            $next_id = ($resultado->max_id ?? 0) + 1;
            return 'FAC-' . str_pad($next_id, 5, '0', STR_PAD_LEFT);
        } catch (PDOException $e) {
            error_log("Error generando número de factura: " . $e->getMessage());
            return 'FAC-' . uniqid();
        }
    }
    
    /**
     * Registra una nueva factura con sus detalles en una transacción
     */
    public function crear($id_paciente, $id_asistente, $subtotal, $iva, $descuento, $total, $metodo_pago, $estado_pago, $notas, $items) {
        try {
            $this->acceso->beginTransaction();
            
            $numero_factura = $this->generarNumeroFactura();
            $fecha_emision = date('Y-m-d');
            
            $sql = "INSERT INTO facturas (
                        numero_factura, id_paciente, id_asistente, fecha_emision,
                        subtotal, iva, descuento, total, metodo_pago, estado_pago, notas
                    ) VALUES (
                        :numero_factura, :id_paciente, :id_asistente, :fecha_emision,
                        :subtotal, :iva, :descuento, :total, :metodo_pago, :estado_pago, :notas
                    )";
            
            $query = $this->acceso->prepare($sql);
            $resultado = $query->execute([
                ':numero_factura' => $numero_factura,
                ':id_paciente' => $id_paciente,
                ':id_asistente' => $id_asistente,
                ':fecha_emision' => $fecha_emision,
                ':subtotal' => $subtotal,
                ':iva' => $iva,
                ':descuento' => $descuento,
                ':total' => $total,
                ':metodo_pago' => $metodo_pago,
                ':estado_pago' => $estado_pago,
                ':notas' => $notas
            ]);
            
            if (!$resultado) {
                throw new Exception("Error al insertar cabecera de factura");
            }
            
            $id_factura = $this->acceso->lastInsertId();
            
            // Insertar detalles
            $sql_detalle = "INSERT INTO factura_detalles (id_factura, descripcion, cantidad, precio_unitario, subtotal) 
                            VALUES (:id_factura, :descripcion, :cantidad, :precio_unitario, :subtotal)";
            $query_detalle = $this->acceso->prepare($sql_detalle);
            
            foreach ($items as $item) {
                $item_subtotal = $item['cantidad'] * $item['precio_unitario'];
                $query_detalle->execute([
                    ':id_factura' => $id_factura,
                    ':descripcion' => $item['descripcion'],
                    ':cantidad' => $item['cantidad'],
                    ':precio_unitario' => $item['precio_unitario'],
                    ':subtotal' => $item_subtotal
                ]);
            }
            
            $this->acceso->commit();
            return ['success' => true, 'id_factura' => $id_factura, 'numero_factura' => $numero_factura];
            
        } catch (Exception $e) {
            $this->acceso->rollBack();
            error_log("Error al crear factura: " . $e->getMessage());
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }
    
    /**
     * Edita una factura existente y sus detalles
     */
    public function editar($id_factura, $subtotal, $iva, $descuento, $total, $metodo_pago, $estado_pago, $notas, $items) {
        try {
            $this->acceso->beginTransaction();
            
            // Actualizar cabecera
            $sql = "UPDATE facturas SET 
                        subtotal = :subtotal,
                        iva = :iva,
                        descuento = :descuento,
                        total = :total,
                        metodo_pago = :metodo_pago,
                        estado_pago = :estado_pago,
                        notas = :notas
                    WHERE id_factura = :id_factura";
            
            $query = $this->acceso->prepare($sql);
            $query->execute([
                ':id_factura' => $id_factura,
                ':subtotal' => $subtotal,
                ':iva' => $iva,
                ':descuento' => $descuento,
                ':total' => $total,
                ':metodo_pago' => $metodo_pago,
                ':estado_pago' => $estado_pago,
                ':notas' => $notas
            ]);
            
            // Eliminar detalles anteriores
            $sql_del = "DELETE FROM factura_detalles WHERE id_factura = :id_factura";
            $query_del = $this->acceso->prepare($sql_del);
            $query_del->execute([':id_factura' => $id_factura]);
            
            // Insertar nuevos detalles
            $sql_detalle = "INSERT INTO factura_detalles (id_factura, descripcion, cantidad, precio_unitario, subtotal) 
                            VALUES (:id_factura, :descripcion, :cantidad, :precio_unitario, :subtotal)";
            $query_detalle = $this->acceso->prepare($sql_detalle);
            
            foreach ($items as $item) {
                $item_subtotal = $item['cantidad'] * $item['precio_unitario'];
                $query_detalle->execute([
                    ':id_factura' => $id_factura,
                    ':descripcion' => $item['descripcion'],
                    ':cantidad' => $item['cantidad'],
                    ':precio_unitario' => $item['precio_unitario'],
                    ':subtotal' => $item_subtotal
                ]);
            }
            
            $this->acceso->commit();
            return ['success' => true];
            
        } catch (Exception $e) {
            $this->acceso->rollBack();
            error_log("Error al editar factura: " . $e->getMessage());
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }
    
    /**
     * Anula una factura lógicamente (cambia estado de pago a 'Anulado')
     */
    public function anular($id_factura) {
        try {
            $sql = "UPDATE facturas SET estado_pago = 'Anulado' WHERE id_factura = :id_factura";
            $query = $this->acceso->prepare($sql);
            $resultado = $query->execute([':id_factura' => $id_factura]);
            return $resultado ? ['success' => true] : ['success' => false, 'message' => 'No se pudo actualizar la factura'];
        } catch (PDOException $e) {
            error_log("Error al anular factura: " . $e->getMessage());
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }
    
    /**
     * Obtiene una factura por su ID junto con la información del paciente
     */
    public function obtener($id_factura) {
        try {
            $sql = "SELECT f.*, 
                           rp.nombre_paciente, rp.apellido_paciente, rp.cedula_paciente, rp.correo_paciente, rp.telefono_paciente, rp.direccion_paciente,
                           ra.nombre_asistente, ra.apellido_asistente
                    FROM facturas f
                    INNER JOIN registro_paciente rp ON f.id_paciente = rp.id_paciente
                    LEFT JOIN registro_asistente ra ON f.id_asistente = ra.id_asistente
                    WHERE f.id_factura = :id_factura";
            $query = $this->acceso->prepare($sql);
            $query->execute([':id_factura' => $id_factura]);
            return $query->fetch(PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            error_log("Error al obtener factura: " . $e->getMessage());
            return null;
        }
    }
    
    /**
     * Obtiene los detalles de una factura
     */
    public function obtenerDetalles($id_factura) {
        try {
            $sql = "SELECT * FROM factura_detalles WHERE id_factura = :id_factura";
            $query = $this->acceso->prepare($sql);
            $query->execute([':id_factura' => $id_factura]);
            return $query->fetchAll(PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            error_log("Error al obtener detalles de factura: " . $e->getMessage());
            return [];
        }
    }
    
    /**
     * Lista facturas con filtros aplicados (búsqueda, rango de fechas, id_paciente)
     */
    public function listar($busqueda = '', $fecha_inicio = '', $fecha_fin = '', $id_paciente = null, $estado = 'todos') {
        try {
            $sql = "SELECT f.*, 
                           CONCAT(rp.nombre_paciente, ' ', rp.apellido_paciente) as paciente_nombre, 
                           rp.cedula_paciente
                    FROM facturas f
                    INNER JOIN registro_paciente rp ON f.id_paciente = rp.id_paciente
                    WHERE 1=1";
            
            $params = [];
            
            if ($id_paciente !== null) {
                $sql .= " AND f.id_paciente = :id_paciente";
                $params[':id_paciente'] = $id_paciente;
            }
            
            if ($estado !== 'todos') {
                $sql .= " AND f.estado_pago = :estado";
                $params[':estado'] = $estado;
            }
            
            if (!empty($fecha_inicio)) {
                $sql .= " AND f.fecha_emision >= :fecha_inicio";
                $params[':fecha_inicio'] = $fecha_inicio;
            }
            
            if (!empty($fecha_fin)) {
                $sql .= " AND f.fecha_emision <= :fecha_fin";
                $params[':fecha_fin'] = $fecha_fin;
            }
            
            if (!empty($busqueda)) {
                $sql .= " AND (f.numero_factura LIKE :busqueda OR rp.nombre_paciente LIKE :busqueda OR rp.apellido_paciente LIKE :busqueda OR rp.cedula_paciente LIKE :busqueda)";
                $params[':busqueda'] = "%$busqueda%";
            }
            
            $sql .= " ORDER BY f.fecha_emision DESC, f.id_factura DESC";
            
            $query = $this->acceso->prepare($sql);
            $query->execute($params);
            return $query->fetchAll(PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            error_log("Error en listar facturas: " . $e->getMessage());
            return [];
        }
    }
    
    /**
     * Obtiene estadísticas financieras generales para el Administrador
     */
    public function obtenerEstadisticas() {
        try {
            $stats = [];
            
            // Total ingresado en el mes actual (excluyendo facturas anuladas)
            $sql = "SELECT SUM(total) as total_mes FROM facturas 
                    WHERE MONTH(fecha_emision) = MONTH(CURDATE()) 
                      AND YEAR(fecha_emision) = YEAR(CURDATE())
                      AND estado_pago = 'Pagado'";
            $query = $this->acceso->query($sql);
            $stats['ingresos_mes'] = $query->fetch(PDO::FETCH_OBJ)->total_mes ?? 0.00;
            
            // Cantidad de facturas emitidas en el mes actual
            $sql = "SELECT COUNT(*) as emitidas FROM facturas 
                    WHERE MONTH(fecha_emision) = MONTH(CURDATE()) 
                      AND YEAR(fecha_emision) = YEAR(CURDATE())";
            $query = $this->acceso->query($sql);
            $stats['facturas_mes'] = $query->fetch(PDO::FETCH_OBJ)->emitidas ?? 0;
            
            // Cantidad de facturas pendientes de pago
            $sql = "SELECT COUNT(*) as pendientes FROM facturas 
                    WHERE estado_pago = 'Pendiente'";
            $query = $this->acceso->query($sql);
            $stats['facturas_pendientes'] = $query->fetch(PDO::FETCH_OBJ)->pendientes ?? 0;
            
            // Desglose por método de pago (excluyendo anulados)
            $sql = "SELECT metodo_pago, SUM(total) as total, COUNT(*) as cantidad 
                    FROM facturas 
                    WHERE estado_pago = 'Pagado'
                    GROUP BY metodo_pago";
            $query = $this->acceso->query($sql);
            $stats['por_metodo'] = $query->fetchAll(PDO::FETCH_OBJ);
            
            // Ingresos mensuales históricos (últimos 6 meses)
            $sql = "SELECT DATE_FORMAT(fecha_emision, '%Y-%m') as mes, SUM(total) as total
                    FROM facturas
                    WHERE estado_pago = 'Pagado'
                      AND fecha_emision >= DATE_SUB(CURDATE(), INTERVAL 6 MONTH)
                    GROUP BY DATE_FORMAT(fecha_emision, '%Y-%m')
                    ORDER BY mes ASC";
            $query = $this->acceso->query($sql);
            $stats['historico'] = $query->fetchAll(PDO::FETCH_OBJ);
            
            return $stats;
        } catch (PDOException $e) {
            error_log("Error obteniendo estadísticas de facturación: " . $e->getMessage());
            return [
                'ingresos_mes' => 0.00,
                'facturas_mes' => 0,
                'facturas_pendientes' => 0,
                'por_metodo' => [],
                'historico' => []
            ];
        }
    }
}
?>
