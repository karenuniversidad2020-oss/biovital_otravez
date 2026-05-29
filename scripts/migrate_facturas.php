<?php
// scripts/migrate_facturas.php
// Script temporal para correr la migración de base de datos para facturación

define('ROOT_PATH', dirname(__DIR__));
define('MODEL_PATH', ROOT_PATH . '/modelo');

require_once MODEL_PATH . '/Conexion.php';

try {
    echo "Iniciando migración...\n";
    $conexion = new Conexion();
    $pdo = $conexion->pdo;
    
    $sqlFile = ROOT_PATH . '/scripts/facturacion_schema.sql';
    if (!file_exists($sqlFile)) {
        throw new Exception("Archivo SQL no encontrado en: " . $sqlFile);
    }
    
    $sqlContent = file_get_contents($sqlFile);
    
    // Ejecutar el script SQL
    $pdo->exec($sqlContent);
    echo "¡Migración ejecutada con éxito! Las tablas 'facturas' y 'factura_detalles' han sido creadas.\n";
    
} catch (Exception $e) {
    echo "Error en la migración: " . $e->getMessage() . "\n";
}
?>
