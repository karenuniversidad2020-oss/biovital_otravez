<?php
// modelo/Asistente.php - Versión limpia sin conflictos
include_once 'Conexion.php';

class Asistente {
    public $objetos;
    public $acceso;
    
    public function __construct() {
        $db = new Conexion();
        $this->acceso = $db->pdo;
    }
    
    // ==================== MÉTODOS PRINCIPALES ====================
    
    public function obtener_datos($id) {
        try {
            $sql = "SELECT ra.*, tp.nombre_tipo 
                    FROM registro_asistente ra
                    INNER JOIN tipo_paciente tp ON ra.asistente_tipo = tp.id_tipo_us 
                    WHERE ra.id_asistente = :id";
            $query = $this->acceso->prepare($sql);
            $query->execute(array(':id' => $id));
            $this->objetos = $query->fetchAll();
            return $this->objetos;
        } catch(PDOException $e) {
            error_log("Error en obtener_datos: " . $e->getMessage());
            return array();
        }
    }
    
    public function editar($id_asistente, $telefono, $direccion, $correo, $sexo, $adicional) {
        try {
            $sql = "UPDATE registro_asistente SET 
                    telefono_asistente = :telefono,
                    direccion_asistente = :direccion,
                    correo_asistente = :correo,
                    sexo_asistente = :sexo,
                    adicional_asistente = :adicional 
                    WHERE id_asistente = :id";
            $query = $this->acceso->prepare($sql);
            $resultado = $query->execute(array(
                ':id' => $id_asistente,
                ':telefono' => $telefono,
                ':direccion' => $direccion,
                ':correo' => $correo,
                ':sexo' => $sexo,
                ':adicional' => $adicional
            ));
            
            if ($resultado) {
                return ['success' => true, 'message' => 'editado'];
            } else {
                return ['success' => false, 'message' => 'error_actualizacion'];
            }
        } catch(PDOException $e) {
            error_log("Error en editar asistente: " . $e->getMessage());
            return ['success' => false, 'message' => 'error_bd'];
        }
    }
    
    public function cambiar_photo($id_asistente, $nombre) {
        try {
            $sql = "SELECT avatar_asistente FROM registro_asistente WHERE id_asistente = :id";
            $query = $this->acceso->prepare($sql);
            $query->execute(array(':id' => $id_asistente));
            $resultado = $query->fetch(PDO::FETCH_OBJ);
            
            $avatar_anterior = $resultado ? $resultado->avatar_asistente : 'avatarDES.jpg';
            
            $sql = "UPDATE registro_asistente SET avatar_asistente = :nombre WHERE id_asistente = :id";
            $query = $this->acceso->prepare($sql);
            $query->execute(array(':id' => $id_asistente, ':nombre' => $nombre));
            
            return $avatar_anterior;
        } catch(PDOException $e) {
            error_log("Error en cambiar_photo: " . $e->getMessage());
            return 'avatarDES.jpg';
        }
    }
    
    public function crear($datos) {
        try {
            $nombre = $datos['nombre'] ?? '';
            $apellidos = $datos['apellidos'] ?? '';
            $fecha_nacimiento = $datos['fecha_nacimiento'] ?? '';
            $cedula = $datos['cedula'] ?? '';
            $telefono = $datos['telefono'] ?? '';
            $direccion = $datos['direccion'] ?? '';
            $correo = $datos['correo'] ?? '';
            $sexo = $datos['sexo'] ?? '';
            $adicional = $datos['adicional'] ?? '';
            $password_hash = $datos['password_hash'] ?? '';
            $tipo = $datos['tipo'] ?? 3;
            $avatar = $datos['avatar'] ?? 'avatarDES.jpg';
            
            $sql = "SELECT id_asistente FROM registro_asistente 
                    WHERE cedula_asistente = :cedula OR correo_asistente = :correo";
            $query = $this->acceso->prepare($sql);
            $query->execute(array(':cedula' => $cedula, ':correo' => $correo));
            $existe = $query->fetchAll();
            
            if(!empty($existe)) {
                return ['success' => false, 'message' => 'existe'];
            }
            
            $sql = "INSERT INTO registro_asistente(
                nombre_asistente, apellido_asistente, fecha_nacimiento_asistente, 
                cedula_asistente, telefono_asistente, direccion_asistente, 
                correo_asistente, sexo_asistente, adicional_asistente, 
                avatar_asistente, asistente_tipo
            ) VALUES (
                :nombre, :apellidos, :fecha_nacimiento,
                :cedula, :telefono, :direccion,
                :correo, :sexo, :adicional,
                :avatar, :tipo
            )";
            $query = $this->acceso->prepare($sql);
            $resultado = $query->execute(array(
                ':nombre' => $nombre,
                ':apellidos' => $apellidos,
                ':fecha_nacimiento' => $fecha_nacimiento,
                ':cedula' => $cedula,
                ':telefono' => $telefono,
                ':direccion' => $direccion,
                ':correo' => $correo,
                ':sexo' => $sexo,
                ':adicional' => $adicional,
                ':avatar' => $avatar,
                ':tipo' => $tipo
            ));
            
            if($resultado) {
                $id_asistente = $this->acceso->lastInsertId();
                $loginResult = $this->crearLogin($id_asistente, $password_hash);
                
                if ($loginResult['success']) {
                    return ['success' => true, 'message' => 'add', 'id' => $id_asistente];
                } else {
                    error_log("Error al crear login para asistente ID: $id_asistente");
                    return ['success' => false, 'message' => 'error_login'];
                }
            } else {
                return ['success' => false, 'message' => 'error_bd'];
            }
        } catch(PDOException $e) {
            error_log("Error en crear asistente: " . $e->getMessage());
            return ['success' => false, 'message' => 'error_exception'];
        }
    }
    
    public function crearLogin($id_asistente, $password_hash) {
        try {
            $sql = "INSERT INTO login_asistente(id_asistente, password_hash, status) 
                    VALUES (:id_asistente, :password_hash, 'activo')";
            $query = $this->acceso->prepare($sql);
            $resultado = $query->execute(array(
                ':id_asistente' => $id_asistente,
                ':password_hash' => $password_hash
            ));
            
            if ($resultado) {
                return ['success' => true, 'message' => 'login_creado'];
            } else {
                return ['success' => false, 'message' => 'error_login'];
            }
        } catch(PDOException $e) {
            error_log("Error en crearLogin: " . $e->getMessage());
            return ['success' => false, 'message' => 'error_bd'];
        }
    }
    
    // ==================== MÉTODOS PARA ESTADÍSTICAS ====================
    
    public function contarRecetasGestionadas($id_asistente) {
        try {
            $sql = "SELECT COUNT(*) as total FROM recetas WHERE estado = 1";
            $query = $this->acceso->prepare($sql);
            $query->execute();
            $resultado = $query->fetch(PDO::FETCH_OBJ);
            return $resultado->total ?? 0;
        } catch(PDOException $e) {
            error_log("Error en contarRecetasGestionadas: " . $e->getMessage());
            return 0;
        }
    }
    
    public function contarPacientesHoy() {
        try {
            $sql = "SELECT COUNT(DISTINCT id_paciente) as total 
                    FROM recetas 
                    WHERE DATE(fecha_receta) = CURDATE() AND estado = 1";
            $query = $this->acceso->prepare($sql);
            $query->execute();
            $resultado = $query->fetch(PDO::FETCH_OBJ);
            return $resultado->total ?? 0;
        } catch(PDOException $e) {
            error_log("Error en contarPacientesHoy: " . $e->getMessage());
            return 0;
        }
    }
    
    public function contarRecetasHoy() {
        try {
            $sql = "SELECT COUNT(*) as total 
                    FROM recetas 
                    WHERE DATE(fecha_receta) = CURDATE() AND estado = 1";
            $query = $this->acceso->prepare($sql);
            $query->execute();
            $resultado = $query->fetch(PDO::FETCH_OBJ);
            return $resultado->total ?? 0;
        } catch(PDOException $e) {
            error_log("Error en contarRecetasHoy: " . $e->getMessage());
            return 0;
        }
    }
    
    public function obtenerEstadisticas($id_asistente) {
        try {
            $stats = [];
            
            $sql = "SELECT COUNT(*) as total FROM recetas WHERE estado = 1";
            $query = $this->acceso->prepare($sql);
            $query->execute();
            $stats['total_recetas'] = $query->fetch(PDO::FETCH_OBJ)->total ?? 0;
            
            $sql = "SELECT COUNT(*) as total FROM recetas 
                    WHERE estado = 1 
                    AND MONTH(fecha_receta) = MONTH(CURDATE()) 
                    AND YEAR(fecha_receta) = YEAR(CURDATE())";
            $query = $this->acceso->prepare($sql);
            $query->execute();
            $stats['recetas_mes'] = $query->fetch(PDO::FETCH_OBJ)->total ?? 0;
            
            $sql = "SELECT COUNT(DISTINCT id_paciente) as total FROM recetas WHERE estado = 1";
            $query = $this->acceso->prepare($sql);
            $query->execute();
            $stats['total_pacientes'] = $query->fetch(PDO::FETCH_OBJ)->total ?? 0;
            
            return $stats;
        } catch(PDOException $e) {
            error_log("Error en obtenerEstadisticas: " . $e->getMessage());
            return [
                'total_recetas' => 0,
                'recetas_mes' => 0,
                'total_pacientes' => 0
            ];
        }
    }
    
    // ==================== MÉTODOS DE GESTIÓN ====================
    
    public function listarPacientesRecientes($limit = 10) {
        try {
            $sql = "SELECT rp.id_paciente, rp.nombre_paciente, rp.apellido_paciente, 
                           rp.cedula_paciente, rp.telefono_paciente, rp.correo_paciente,
                           MAX(r.fecha_receta) as ultima_receta
                    FROM registro_paciente rp
                    LEFT JOIN recetas r ON rp.id_paciente = r.id_paciente AND r.estado = 1
                    WHERE rp.paciente_tipo = 1
                    GROUP BY rp.id_paciente
                    ORDER BY ultima_receta DESC
                    LIMIT :limit";
            $query = $this->acceso->prepare($sql);
            $query->bindValue(':limit', $limit, PDO::PARAM_INT);
            $query->execute();
            return $query->fetchAll();
        } catch(PDOException $e) {
            error_log("Error en listarPacientesRecientes: " . $e->getMessage());
            return array();
        }
    }
    
    public function listarRecetasRecientes($limit = 10) {
        try {
            $sql = "SELECT r.*, 
                           CONCAT(rp.nombre_paciente, ' ', rp.apellido_paciente) as paciente,
                           CONCAT(rm.nombre_medico, ' ', rm.apellido_medico) as medico
                    FROM recetas r
                    LEFT JOIN registro_paciente rp ON r.id_paciente = rp.id_paciente
                    LEFT JOIN registro_medico rm ON r.id_medico = rm.id_medico
                    WHERE r.estado = 1
                    ORDER BY r.fecha_receta DESC
                    LIMIT :limit";
            $query = $this->acceso->prepare($sql);
            $query->bindValue(':limit', $limit, PDO::PARAM_INT);
            $query->execute();
            return $query->fetchAll();
        } catch(PDOException $e) {
            error_log("Error en listarRecetasRecientes: " . $e->getMessage());
            return array();
        }
    }
    
    public function obtenerResumenDia() {
        try {
            $resumen = [];
            
            $sql = "SELECT COUNT(*) as total FROM recetas 
                    WHERE DATE(fecha_receta) = CURDATE() AND estado = 1";
            $query = $this->acceso->prepare($sql);
            $query->execute();
            $resumen['recetas_hoy'] = $query->fetch(PDO::FETCH_OBJ)->total ?? 0;
            
            $sql = "SELECT COUNT(DISTINCT id_paciente) as total FROM recetas 
                    WHERE DATE(fecha_receta) = CURDATE() AND estado = 1";
            $query = $this->acceso->prepare($sql);
            $query->execute();
            $resumen['pacientes_hoy'] = $query->fetch(PDO::FETCH_OBJ)->total ?? 0;
            
            $sql = "SELECT COUNT(DISTINCT id_medico) as total FROM recetas 
                    WHERE DATE(fecha_receta) = CURDATE() AND estado = 1";
            $query = $this->acceso->prepare($sql);
            $query->execute();
            $resumen['medicos_activos'] = $query->fetch(PDO::FETCH_OBJ)->total ?? 0;
            
            return $resumen;
        } catch(PDOException $e) {
            error_log("Error en obtenerResumenDia: " . $e->getMessage());
            return [
                'recetas_hoy' => 0,
                'pacientes_hoy' => 0,
                'medicos_activos' => 0
            ];
        }
    }
    
    // ==================== MÉTODOS DE BÚSQUEDA ====================
    
    public function buscar($termino, $limit = 10) {
        try {
            $sql = "SELECT id_asistente, nombre_asistente, apellido_asistente, 
                           cedula_asistente, telefono_asistente, correo_asistente
                    FROM registro_asistente 
                    WHERE (nombre_asistente LIKE :termino 
                           OR apellido_asistente LIKE :termino 
                           OR cedula_asistente LIKE :termino)
                    AND asistente_tipo = 3
                    LIMIT :limit";
            $query = $this->acceso->prepare($sql);
            $query->bindValue(':termino', "%$termino%", PDO::PARAM_STR);
            $query->bindValue(':limit', $limit, PDO::PARAM_INT);
            $query->execute();
            return $query->fetchAll();
        } catch(PDOException $e) {
            error_log("Error en buscar: " . $e->getMessage());
            return array();
        }
    }
    
    public function obtenerPorCedula($cedula) {
        try {
            $sql = "SELECT id_asistente, nombre_asistente, apellido_asistente, 
                           cedula_asistente, telefono_asistente, correo_asistente, 
                           direccion_asistente
                    FROM registro_asistente 
                    WHERE cedula_asistente = :cedula AND asistente_tipo = 3";
            $query = $this->acceso->prepare($sql);
            $query->execute(array(':cedula' => $cedula));
            return $query->fetch(PDO::FETCH_OBJ);
        } catch(PDOException $e) {
            error_log("Error en obtenerPorCedula: " . $e->getMessage());
            return null;
        }
    }
    
    public function existe($cedula, $correo) {
        try {
            $sql = "SELECT id_asistente FROM registro_asistente 
                    WHERE cedula_asistente = :cedula OR correo_asistente = :correo";
            $query = $this->acceso->prepare($sql);
            $query->execute(array(':cedula' => $cedula, ':correo' => $correo));
            return $query->rowCount() > 0;
        } catch(PDOException $e) {
            error_log("Error en existe: " . $e->getMessage());
            return false;
        }
    }
    
    // ==================== MÉTODOS DE ACTIVIDAD ====================
    
    public function registrarActividad($id_asistente, $accion, $detalle = null) {
        try {
            error_log("Actividad Asistente ID: $id_asistente - Acción: $accion - Detalle: $detalle");
            return ['success' => true, 'message' => 'actividad_registrada'];
        } catch(PDOException $e) {
            error_log("Error en registrarActividad: " . $e->getMessage());
            return ['success' => false, 'message' => 'error_bd'];
        }
    }
    
    public function obtenerActividadReciente($id_asistente, $limit = 10) {
        try {
            return [];
        } catch(PDOException $e) {
            error_log("Error en obtenerActividadReciente: " . $e->getMessage());
            return array();
        }
    }
}
?>
