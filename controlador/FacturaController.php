<?php
// controlador/FacturaController.php

class FacturaController {
    private $factura;
    
    public function __construct() {
        // Verificar autenticación
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        if (!isset($_SESSION['usuario']) || !isset($_SESSION['rol'])) {
            if ($this->isAjax()) {
                jsonResponse(['error' => 'No autorizado'], 401);
            } else {
                redirect('login');
            }
            exit();
        }
        
        // Cargar el modelo
        require_once MODEL_PATH . '/Factura.php';
        $this->factura = new Factura();
    }
    
    private function isAjax() {
        return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && 
               strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
    }
    
    // ==================== VISTAS ====================
    
    /**
     * Vista principal de facturación
     */
    public function index() {
        $rol = $_SESSION['rol'];
        
        if (!in_array($rol, ['administrador', 'asistente', 'paciente'])) {
            redirect('login');
            return;
        }
        
        switch ($rol) {
            case 'administrador':
                $vista = 'administrador/adm_facturacion';
                $titulo = 'Administración de Facturación - BioVital';
                break;
            case 'asistente':
                $vista = 'asistente/asi_facturacion';
                $titulo = 'Gestión de Facturación - BioVital';
                break;
            case 'paciente':
                $vista = 'paciente/pac_facturacion';
                $titulo = 'Mis Facturas - BioVital';
                break;
            default:
                redirect('login');
                return;
        }
        
        // Cargar especialidades para el formulario de creación si es asistente
        $especialidades_list = [];
        if ($rol === 'asistente' || $rol === 'administrador') {
            require_once MODEL_PATH . '/Especialidad.php';
            $esp = new Especialidad();
            $especialidades_list = $esp->listar('', 'activas');
        }
        
        $options = [
            'title' => $titulo,
            'breadcrumbs' => [
                ['label' => 'Inicio', 'url' => APP_URL . '/panel/' . $rol],
                ['label' => 'Facturación']
            ],
            'active_page' => 'facturacion',
            'css' => '<link rel="stylesheet" href="' . APP_URL . '/css/dashboard-utils.css">'
        ];
        
        $data = [
            'nombre_usuario' => $_SESSION['nombre_us'] ?? 'Usuario',
            'especialidades' => $especialidades_list
        ];
        
        ViewHelper::renderDashboard($vista, $data, $options);
    }
    
    /**
     * Vista de detalle de factura (Imprimible)
     */
    public function verDetalle() {
        // El id viene del router dinámico de index.php que llena $_GET
        $id_factura = $_GET['id'] ?? 0;
        
        if (!$id_factura) {
            die("ID de factura no válido");
        }
        
        $factura_data = $this->factura->obtener($id_factura);
        if (!$factura_data) {
            http_response_code(404);
            die("Factura no encontrada");
        }
        
        // Si el usuario es un paciente, verificar que sea el propietario de la factura
        if ($_SESSION['rol'] === 'paciente' && $factura_data->id_paciente != $_SESSION['usuario']) {
            http_response_code(403);
            die("No tiene permisos para ver esta factura");
        }
        
        $detalles = $this->factura->obtenerDetalles($id_factura);
        
        $data = [
            'factura' => $factura_data,
            'detalles' => $detalles
        ];
        
        // Renderizar vista simple (sin cabecera del dashboard para poder imprimir con Ctrl+P)
        ViewHelper::renderSimple('documentos/factura_detalle', $data);
    }
    
    // ==================== API ENDPOINTS ====================
    
    /**
     * API para listar facturas
     */
    public function listar() {
        $rol = $_SESSION['rol'];
        $id_paciente = ($rol === 'paciente') ? $_SESSION['usuario'] : null;
        
        $busqueda = $_POST['busqueda'] ?? '';
        $fecha_inicio = $_POST['fecha_inicio'] ?? '';
        $fecha_fin = $_POST['fecha_fin'] ?? '';
        $estado = $_POST['estado'] ?? 'todos';
        
        try {
            $facturas = $this->factura->listar($busqueda, $fecha_inicio, $fecha_fin, $id_paciente, $estado);
            jsonResponse($facturas);
        } catch (Exception $e) {
            error_log("Error en API listar facturas: " . $e->getMessage());
            jsonResponse(['error' => 'Error al cargar las facturas'], 500);
        }
    }
    
    /**
     * API para obtener los datos completos de una factura
     */
    public function obtener() {
        $id_factura = $_POST['id_factura'] ?? 0;
        
        if (!$id_factura) {
            jsonResponse(['error' => 'ID de factura requerido'], 400);
            return;
        }
        
        try {
            $factura_data = $this->factura->obtener($id_factura);
            if (!$factura_data) {
                jsonResponse(['error' => 'Factura no encontrada'], 404);
                return;
            }
            
            // Si el usuario es un paciente, verificar que sea el propietario
            if ($_SESSION['rol'] === 'paciente' && $factura_data->id_paciente != $_SESSION['usuario']) {
                jsonResponse(['error' => 'No autorizado'], 403);
                return;
            }
            
            $detalles = $this->factura->obtenerDetalles($id_factura);
            
            jsonResponse([
                'factura' => $factura_data,
                'detalles' => $detalles
            ]);
        } catch (Exception $e) {
            error_log("Error en API obtener factura: " . $e->getMessage());
            jsonResponse(['error' => 'Error del servidor'], 500);
        }
    }
    
    /**
     * API para registrar una nueva factura
     */
    public function crear() {
        // Verificar permisos
        if (!in_array($_SESSION['rol'], ['asistente', 'administrador'])) {
            jsonResponse(['success' => false, 'message' => 'No autorizado para realizar esta acción']);
            return;
        }
        
        $id_paciente = $_POST['id_paciente'] ?? 0;
        $subtotal = $_POST['subtotal'] ?? 0;
        $iva = $_POST['iva'] ?? 0;
        $descuento = $_POST['descuento'] ?? 0;
        $total = $_POST['total'] ?? 0;
        $metodo_pago = $_POST['metodo_pago'] ?? '';
        $estado_pago = $_POST['estado_pago'] ?? 'Pendiente';
        $notas = $_POST['notas'] ?? '';
        
        // Decodificar items
        $items_raw = $_POST['items'] ?? '[]';
        $items = json_decode($items_raw, true);
        
        if (!$id_paciente || empty($items) || !$metodo_pago) {
            jsonResponse(['success' => false, 'message' => 'Datos incompletos. Debe seleccionar un paciente, al menos un concepto y un método de pago.']);
            return;
        }
        
        $id_asistente = ($_SESSION['rol'] === 'asistente') ? $_SESSION['usuario'] : null;
        
        try {
            $resultado = $this->factura->crear(
                $id_paciente, $id_asistente, $subtotal, $iva, $descuento, $total, $metodo_pago, $estado_pago, $notas, $items
            );
            jsonResponse($resultado);
        } catch (Exception $e) {
            error_log("Error al crear factura en API: " . $e->getMessage());
            jsonResponse(['success' => false, 'message' => 'Error al guardar la factura'], 500);
        }
    }
    
    /**
     * API para editar una factura existente (Autorizado para Asistente)
     */
    public function editar() {
        if (!in_array($_SESSION['rol'], ['asistente', 'administrador'])) {
            jsonResponse(['success' => false, 'message' => 'No autorizado para realizar esta acción']);
            return;
        }
        
        $id_factura = $_POST['id_factura'] ?? 0;
        $subtotal = $_POST['subtotal'] ?? 0;
        $iva = $_POST['iva'] ?? 0;
        $descuento = $_POST['descuento'] ?? 0;
        $total = $_POST['total'] ?? 0;
        $metodo_pago = $_POST['metodo_pago'] ?? '';
        $estado_pago = $_POST['estado_pago'] ?? '';
        $notas = $_POST['notas'] ?? '';
        
        $items_raw = $_POST['items'] ?? '[]';
        $items = json_decode($items_raw, true);
        
        if (!$id_factura || empty($items) || !$metodo_pago || !$estado_pago) {
            jsonResponse(['success' => false, 'message' => 'Datos de edición incompletos']);
            return;
        }
        
        try {
            $resultado = $this->factura->editar(
                $id_factura, $subtotal, $iva, $descuento, $total, $metodo_pago, $estado_pago, $notas, $items
            );
            jsonResponse($resultado);
        } catch (Exception $e) {
            error_log("Error al editar factura en API: " . $e->getMessage());
            jsonResponse(['success' => false, 'message' => 'Error al actualizar la factura'], 500);
        }
    }
    
    /**
     * API para anular una factura
     */
    public function anular() {
        if (!in_array($_SESSION['rol'], ['asistente', 'administrador'])) {
            jsonResponse(['success' => false, 'message' => 'No autorizado para realizar esta acción']);
            return;
        }
        
        $id_factura = $_POST['id_factura'] ?? 0;
        if (!$id_factura) {
            jsonResponse(['success' => false, 'message' => 'ID de factura requerido']);
            return;
        }
        
        try {
            $resultado = $this->factura->anular($id_factura);
            jsonResponse($resultado);
        } catch (Exception $e) {
            error_log("Error al anular factura en API: " . $e->getMessage());
            jsonResponse(['success' => false, 'message' => 'Error al anular la factura'], 500);
        }
    }
    
    /**
     * API para obtener estadísticas de facturación (Administrador)
     */
    public function estadisticas() {
        if ($_SESSION['rol'] !== 'administrador') {
            jsonResponse(['error' => 'No autorizado'], 403);
            return;
        }
        
        try {
            $stats = $this->factura->obtenerEstadisticas();
            jsonResponse($stats);
        } catch (Exception $e) {
            error_log("Error al obtener estadísticas de facturación: " . $e->getMessage());
            jsonResponse(['error' => 'Error al cargar las estadísticas'], 500);
        }
    }
}
?>
