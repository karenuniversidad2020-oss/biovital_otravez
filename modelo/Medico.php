<?php
<<<<<<< HEAD

=======
>>>>>>> d2039bf34adef6d12dd6c79371df596a3d39fedb
include_once 'Conexion.php';

class Medico {
    var $objetos;
    var $acceso;
    
    public function __construct() {
        $db = new Conexion();
        $this->acceso = $db->pdo;
    }
<<<<<<< HEAD
    
    // ==================== MÉTODOS PRINCIPALES ====================
    
   
    function obtener_datos($id) {
        try {
            $sql = "SELECT rm.*, tp.nombre_tipo 
                    FROM registro_medico rm
                    INNER JOIN tipo_paciente tp ON rm.medico_tipo = tp.id_tipo_us 
                    WHERE rm.id_medico = :id";
            $query = $this->acceso->prepare($sql);
            $query->execute(array(':id' => $id));
            $this->objetos = $query->fetchAll();
            return $this->objetos;
        } catch(PDOException $e) {
            error_log("Error en obtener_datos: " . $e->getMessage());
            return array();
        }
    }
    
  
    function editar($id_medico, $telefono, $direccion, $correo, $sexo, $adicional) {
        try {
            $sql = "UPDATE registro_medico SET 
                    telefono_medico = :telefono,
                    direccion_medico = :direccion,
                    correo_medico = :correo,
                    sexo_medico = :sexo,
                    adicional_medico = :adicional 
                    WHERE id_medico = :id";
            $query = $this->acceso->prepare($sql);
            $resultado = $query->execute(array(
                ':id' => $id_medico,
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
            error_log("Error en editar medico: " . $e->getMessage());
            return ['success' => false, 'message' => 'error_bd'];
        }
    }
    
   
    function cambiar_photo($id_medico, $nombre) {
        try {
            // Primero obtener el avatar actual
            $sql = "SELECT avatar_medico FROM registro_medico WHERE id_medico = :id";
            $query = $this->acceso->prepare($sql);
            $query->execute(array(':id' => $id_medico));
            $resultado = $query->fetch(PDO::FETCH_OBJ);
            
            $avatar_anterior = $resultado ? $resultado->avatar_medico : 'avatarDES.jpg';
            
            // Actualizar con el nuevo avatar
            $sql = "UPDATE registro_medico SET avatar_medico = :nombre WHERE id_medico = :id";
            $query = $this->acceso->prepare($sql);
            $query->execute(array(':id' => $id_medico, ':nombre' => $nombre));
            
            // Retornar el nombre del avatar anterior como string
            return $avatar_anterior;
        } catch(PDOException $e) {
            error_log("Error en cambiar_photo: " . $e->getMessage());
            return 'avatarDES.jpg';
        }
    }
    
   
    function crear($datos) {
        try {
            // Extraer datos del array
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
            $tipo = $datos['tipo'] ?? 2; // Tipo 2 = Médico
            $avatar = $datos['avatar'] ?? 'avatarDES.jpg';
            
            // Verificar si ya existe un médico con esta cédula o correo
            $sql = "SELECT id_medico FROM registro_medico WHERE cedula_medico = :cedula OR correo_medico = :correo";
            $query = $this->acceso->prepare($sql);
            $query->execute(array(':cedula' => $cedula, ':correo' => $correo));
            $existe = $query->fetchAll();
            
            if(!empty($existe)) {
                return ['success' => false, 'message' => 'existe'];
            }
            
            // Insertar el nuevo médico
=======
      function crear($nombre, $apellidos, $fecha_nacimiento, $cedula, $telefono, $direccion, $correo, $sexo, $adicional, $password_hash, $tipo, $avatar) {
        try {
            $sql = "SELECT id_medico FROM registro_medico WHERE cedula_medico = :cedula OR correo_medico = :correo";
            $query = $this->acceso->prepare($sql);
            $query->execute(array(':cedula' => $cedula, ':correo' => $correo));
            $this->objetos = $query->fetchAll();
            
            if(!empty($this->objetos)) {
                echo 'existe';
                return;
            }
            
>>>>>>> d2039bf34adef6d12dd6c79371df596a3d39fedb
            $sql = "INSERT INTO registro_medico(
                nombre_medico, apellido_medico, fecha_nacimiento_medico, 
                cedula_medico, telefono_medico, direccion_medico, 
                correo_medico, sexo_medico, adicional_medico, 
                avatar_medico, medico_tipo
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
                $id_medico = $this->acceso->lastInsertId();
<<<<<<< HEAD
                $loginResult = $this->crearLogin($id_medico, $password_hash);
                
                if ($loginResult['success']) {
                    return ['success' => true, 'message' => 'add', 'id' => $id_medico];
                } else {
                    // Si falla la creación del login, se podría revertir, pero por ahora solo registramos
                    error_log("Error al crear login para médico ID: $id_medico");
                    return ['success' => false, 'message' => 'error_login'];
                }
            } else {
                return ['success' => false, 'message' => 'error_bd'];
            }
        } catch(PDOException $e) {
            error_log("Error en crear medico: " . $e->getMessage());
            return ['success' => false, 'message' => 'error_exception'];
        }
    }
    
    function crearLogin($id_medico, $password_hash) {
        try {
            $sql = "INSERT INTO login_medico(id_medico, password_hash, status) 
                    VALUES (:id_medico, :password_hash, 'activo')";
            $query = $this->acceso->prepare($sql);
            $resultado = $query->execute(array(
                ':id_medico' => $id_medico,
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
    
    function contarRecetas($id_medico) {
        try {
            $sql = "SELECT COUNT(*) as total FROM recetas WHERE id_medico = :id_medico AND estado = 1";
            $query = $this->acceso->prepare($sql);
            $query->execute(array(':id_medico' => $id_medico));
            $resultado = $query->fetch(PDO::FETCH_OBJ);
            return $resultado->total ?? 0;
        } catch(PDOException $e) {
            error_log("Error en contarRecetas: " . $e->getMessage());
            return 0;
        }
    }
    
    function contarPacientes($id_medico) {
        try {
            $sql = "SELECT COUNT(DISTINCT id_paciente) as total 
                    FROM recetas 
                    WHERE id_medico = :id_medico AND estado = 1 AND id_paciente IS NOT NULL";
            $query = $this->acceso->prepare($sql);
            $query->execute(array(':id_medico' => $id_medico));
            $resultado = $query->fetch(PDO::FETCH_OBJ);
            return $resultado->total ?? 0;
        } catch(PDOException $e) {
            error_log("Error en contarPacientes: " . $e->getMessage());
            return 0;
        }
    }
    
    function listarPacientes($id_medico) {
        try {
            $sql = "SELECT DISTINCT 
                        rp.id_paciente, 
                        rp.nombre_paciente as nombre, 
                        rp.apellido_paciente as apellidos, 
                        rp.cedula_paciente as cedula, 
                        rp.telefono_paciente as telefono, 
                        rp.correo_paciente as correo
                    FROM recetas r
                    INNER JOIN registro_paciente rp ON r.id_paciente = rp.id_paciente
                    WHERE r.id_medico = :id_medico AND r.estado = 1
                    ORDER BY rp.nombre_paciente ASC";
            $query = $this->acceso->prepare($sql);
            $query->execute(array(':id_medico' => $id_medico));
            return $query->fetchAll();
        } catch(PDOException $e) {
            error_log("Error en listarPacientes: " . $e->getMessage());
            return array();
        }
    }
    
    // ==================== MÉTODOS DE BÚSQUEDA ====================
    
    function buscar($termino, $limit = 10) {
        try {
            $sql = "SELECT id_medico, nombre_medico, apellido_medico, cedula_medico, 
                           telefono_medico, correo_medico
                    FROM registro_medico 
                    WHERE (nombre_medico LIKE :termino 
                           OR apellido_medico LIKE :termino 
                           OR cedula_medico LIKE :termino)
                    AND medico_tipo = 2
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
    
    function obtenerPorCedula($cedula) {
        try {
            $sql = "SELECT id_medico, nombre_medico, apellido_medico, cedula_medico,
                           telefono_medico, correo_medico, direccion_medico
                    FROM registro_medico 
                    WHERE cedula_medico = :cedula AND medico_tipo = 2";
            $query = $this->acceso->prepare($sql);
            $query->execute(array(':cedula' => $cedula));
            return $query->fetch(PDO::FETCH_OBJ);
        } catch(PDOException $e) {
            error_log("Error en obtenerPorCedula: " . $e->getMessage());
            return null;
        }
    }
    
   
    function existe($cedula, $correo) {
        try {
            $sql = "SELECT id_medico FROM registro_medico 
                    WHERE cedula_medico = :cedula OR correo_medico = :correo";
            $query = $this->acceso->prepare($sql);
            $query->execute(array(':cedula' => $cedula, ':correo' => $correo));
            return $query->rowCount() > 0;
        } catch(PDOException $e) {
            error_log("Error en existe: " . $e->getMessage());
            return false;
        }
    }
    
    // ==================== MÉTODOS PARA ESPECIALIDADES ====================
    
   
    function obtenerEspecialidades($id_medico) {
        try {
            $sql = "SELECT e.*, em.tarifa, em.exp_anios, em.domicilio, em.extra
                    FROM especialidad_medicos em
                    INNER JOIN especialidades e ON em.id_especialidad = e.id_especialidad
                    WHERE em.id_medico = :id_medico AND em.activo = 1 AND e.activo = 1";
            $query = $this->acceso->prepare($sql);
            $query->execute(array(':id_medico' => $id_medico));
            return $query->fetchAll();
        } catch(PDOException $e) {
            error_log("Error en obtenerEspecialidades: " . $e->getMessage());
            return array();
        }
    }
    
   
    function asignarEspecialidad($id_medico, $id_especialidad, $tarifa = 0, $exp_anios = 0, $domicilio = false, $extra = 0) {
        try {
            // Verificar si ya existe la asignación
            $sql = "SELECT id FROM especialidad_medicos 
                    WHERE id_medico = :id_medico AND id_especialidad = :id_especialidad AND activo = 1";
            $query = $this->acceso->prepare($sql);
            $query->execute(array(':id_medico' => $id_medico, ':id_especialidad' => $id_especialidad));
            
            if ($query->rowCount() > 0) {
                return ['success' => false, 'message' => 'ya_asignado'];
            }
            
            $sql = "INSERT INTO especialidad_medicos(
                        id_medico, id_especialidad, tarifa, exp_anios, domicilio, extra, fecha_asignacion
                    ) VALUES (
                        :id_medico, :id_especialidad, :tarifa, :exp_anios, :domicilio, :extra, CURDATE()
                    )";
            $query = $this->acceso->prepare($sql);
            $resultado = $query->execute(array(
                ':id_medico' => $id_medico,
                ':id_especialidad' => $id_especialidad,
                ':tarifa' => $tarifa,
                ':exp_anios' => $exp_anios,
                ':domicilio' => $domicilio ? 1 : 0,
                ':extra' => $extra
            ));
            
            if ($resultado) {
                return ['success' => true, 'message' => 'asignado'];
            } else {
                return ['success' => false, 'message' => 'error_asignacion'];
            }
        } catch(PDOException $e) {
            error_log("Error en asignarEspecialidad: " . $e->getMessage());
            return ['success' => false, 'message' => 'error_bd'];
        }
    }
    
   
    function removerEspecialidad($id_asignacion) {
        try {
            $sql = "UPDATE especialidad_medicos SET activo = 0 WHERE id = :id";
            $query = $this->acceso->prepare($sql);
            $resultado = $query->execute(array(':id' => $id_asignacion));
            
            if ($resultado) {
                return ['success' => true, 'message' => 'removido'];
            } else {
                return ['success' => false, 'message' => 'error_remocion'];
            }
        } catch(PDOException $e) {
            error_log("Error en removerEspecialidad: " . $e->getMessage());
            return ['success' => false, 'message' => 'error_bd'];
        }
    }
    
    // ==================== MÉTODOS PARA HORARIOS ====================
    
   
    function obtenerHorarios($id_medico) {
        try {
            $sql = "SELECT ch.*, c.nombre as consultorio_nombre
                    FROM consultorio_horarios ch
                    INNER JOIN consultorios c ON ch.id_consultorio = c.id_consultorio
                    WHERE ch.id_medico = :id_medico AND ch.activo = 1
                    ORDER BY FIELD(ch.dia_semana, 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo'), ch.turno";
            $query = $this->acceso->prepare($sql);
            $query->execute(array(':id_medico' => $id_medico));
            return $query->fetchAll();
        } catch(PDOException $e) {
            error_log("Error en obtenerHorarios: " . $e->getMessage());
            return array();
        }
    }
    
    // ==================== MÉTODOS PARA CONSULTORIOS ====================
    
   
    function obtenerConsultorios($id_medico) {
        try {
            $sql = "SELECT c.*, cm.fecha_asignacion
                    FROM consultorio_medicos cm
                    INNER JOIN consultorios c ON cm.id_consultorio = c.id_consultorio
                    WHERE cm.id_medico = :id_medico AND cm.activo = 1 AND c.activo = 1";
            $query = $this->acceso->prepare($sql);
            $query->execute(array(':id_medico' => $id_medico));
            return $query->fetchAll();
        } catch(PDOException $e) {
            error_log("Error en obtenerConsultorios: " . $e->getMessage());
            return array();
        }
    }
}
?>
=======
                $this->crearLogin($id_medico, $password_hash);
                echo 'add';
            } else {
                echo 'error_bd';
            }
        } catch(PDOException $e) {
            error_log("Error en crear medico: " . $e->getMessage());
            echo 'error_exception';
        }
    }
    
   function obtener_datos($id) {
    $sql = "SELECT rm.*, tp.nombre_tipo 
            FROM registro_medico rm
            INNER JOIN tipo_paciente tp ON rm.medico_tipo = tp.id_tipo_us 
            WHERE rm.id_medico = :id";
    $query = $this->acceso->prepare($sql);
    $query->execute(array(':id' => $id));
    $this->objetos = $query->fetchAll();
    return $this->objetos;
}
    
    function editar($id_medico, $telefono, $direccion, $correo, $sexo, $adicional) {
        $sql = "UPDATE registro_medico SET 
                telefono_medico = :telefono,
                direccion_medico = :direccion,
                correo_medico = :correo,
                sexo_medico = :sexo,
                adicional_medico = :adicional 
                WHERE id_medico = :id";
        $query = $this->acceso->prepare($sql);
        $query->execute(array(
            ':id' => $id_medico,
            ':telefono' => $telefono,
            ':direccion' => $direccion,
            ':correo' => $correo,
            ':sexo' => $sexo,
            ':adicional' => $adicional
        ));
    }
    
    function cambiar_photo($id_medico, $nombre) {   
        $sql = "SELECT avatar_medico FROM registro_medico WHERE id_medico = :id";
        $query = $this->acceso->prepare($sql);
        $query->execute(array(':id' => $id_medico));
        $this->objetos = $query->fetchAll();    
        
        $sql = "UPDATE registro_medico SET avatar_medico = :nombre WHERE id_medico = :id";
        $query = $this->acceso->prepare($sql);
        $query->execute(array(':id' => $id_medico, ':nombre' => $nombre));  
        return $this->objetos;   
    }
    
    function buscar() {
        if(!empty($_POST['consulta'])) {
            $consulta = $_POST['consulta'];
            $sql = "SELECT rm.*, tp.nombre_tipo 
                    FROM registro_medico rm 
                    JOIN tipo_paciente tp ON rm.medico_tipo = tp.id_tipo_us 
                    WHERE rm.nombre_medico LIKE :consulta";
            $query = $this->acceso->prepare($sql);
            $query->execute(array(':consulta' => "%$consulta%"));
            $this->objetos = $query->fetchAll();
            return $this->objetos;
        } else {         
            $sql = "SELECT rm.*, tp.nombre_tipo 
                    FROM registro_medico rm 
                    JOIN tipo_paciente tp ON rm.medico_tipo = tp.id_tipo_us 
                    WHERE rm.nombre_medico NOT LIKE '' 
                    ORDER BY rm.id_medico LIMIT 25";
            $query = $this->acceso->prepare($sql);
            $query->execute();
            $this->objetos = $query->fetchAll();
            return $this->objetos;
        }
    }
    
   
    
    function crearLogin($id_medico, $password_hash) {
        $sql = "INSERT INTO login_medico(id_medico, password_hash, status) 
                VALUES (:id_medico, :password_hash, 'activo')";
        $query = $this->acceso->prepare($sql);
        $query->execute(array(
            ':id_medico' => $id_medico,
            ':password_hash' => $password_hash
        ));
    }
        // Contar recetas del médico
function contarRecetas($id_medico) {
    try {
        $sql = "SELECT COUNT(*) as total FROM recetas WHERE id_medico = :id_medico AND estado = 1";
        $query = $this->acceso->prepare($sql);
        $query->execute(array(':id_medico' => $id_medico));
        $resultado = $query->fetch();
        return $resultado->total ?? 0;
    } catch(PDOException $e) {
        return 0;
    }
}

// Contar pacientes del médico
function contarPacientes($id_medico) {
    try {
        $sql = "SELECT COUNT(DISTINCT id_paciente) as total FROM recetas WHERE id_medico = :id_medico AND estado = 1 AND id_paciente IS NOT NULL";
        $query = $this->acceso->prepare($sql);
        $query->execute(array(':id_medico' => $id_medico));
        $resultado = $query->fetch();
        return $resultado->total ?? 0;
    } catch(PDOException $e) {
        return 0;
    }
}

// Listar pacientes del médico
function listarPacientes($id_medico) {
    try {
        $sql = "SELECT DISTINCT 
                    rp.id_paciente, 
                    rp.nombre_paciente as nombre, 
                    rp.apellido_paciente as apellidos, 
                    rp.cedula_paciente as cedula, 
                    rp.telefono_paciente as telefono, 
                    rp.correo_paciente as correo
                FROM recetas r
                INNER JOIN registro_paciente rp ON r.id_paciente = rp.id_paciente
                WHERE r.id_medico = :id_medico AND r.estado = 1
                ORDER BY rp.nombre_paciente ASC";
        $query = $this->acceso->prepare($sql);
        $query->execute(array(':id_medico' => $id_medico));
        return $query->fetchAll();
    } catch(PDOException $e) {
        return array();
    }
}
}
?>
>>>>>>> d2039bf34adef6d12dd6c79371df596a3d39fedb
