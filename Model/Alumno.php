<?php
class Alumno {
    private $conexion;

    public function __construct($conexion) {
        $this->conexion = $conexion;
    }
    //inicio de sesión
    public function validarAlumno($usuario,$clave) {
        $sql = "
            SELECT 'alumno' AS tipo_usuario, matricula AS identificador, nombreAlu, apellidoAlu
            FROM alumno 
            WHERE matricula = ? AND contrasena = ?
        ";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param("ss", $usuario,$clave);
        $stmt->execute();
        return $stmt->get_result();
    } 
    //registros nuevos
    public function validarAlumnoRe($usuario) {
        $sql = "
            SELECT 'alumno' AS tipo_usuario, matricula AS identificador, nombreAlu, apellidoAlu
            FROM alumno 
            WHERE matricula = ?
        ";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param("s", $usuario);
        $stmt->execute();
        return $stmt->get_result();
    }
    

    public function insertarAlumno($nombre, $apellido, $fechaNacimiento, $matricula, $contrasena, $confirmacionContrasena) {
        $sql = "INSERT INTO alumno (nombreAlu, apellidoAlu, feNac, matricula, contrasena, confirmacionContra) 
                VALUES (?, ?, ?, ?, ?, ?)";
        
        $stmt = $this->conexion->prepare($sql);
        
        if ($stmt === false) {
            die("Error en la preparación de la declaración: " . $this->conexion->error);
        }

        // Encriptar la contraseña
        $contrasenaEncrip = md5($contrasena);

        // Vincula los parámetros
        $stmt->bind_param("ssssss", $nombre, $apellido, $fechaNacimiento, $matricula, $contrasena, $contrasenaEncrip);

        // Ejecuta la consulta
        return $stmt->execute();
    }

    function obtenerIdAlumnoPorMatricula($conexion) {
        // Verifica si la matrícula está definida en la sesión
        if (isset($_SESSION['identificador'])) {
            $matricula = $_SESSION['identificador'];
    
            // Prepara la consulta para obtener el idAlumno usando la matrícula
            $sql = "SELECT idAlumno FROM alumno WHERE matricula = ?";
            $stmt = $conexion->prepare($sql);
    
            if ($stmt === false) {
                die("Error en la preparación de la declaración: " . $conexion->error);
            }
    
            // Vincula el parámetro
            $stmt->bind_param("s", $matricula);
    
            // Ejecuta la consulta
            $stmt->execute();
    
            // Obtiene el resultado
            $result = $stmt->get_result();
    
            // Verifica si se encontró el alumno
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                return $row['idAlumno']; // Retorna el idAlumno
            } else {
                return null; // Matrícula no encontrada
            }
    
            // Cierra la declaración
            $stmt->close();
        } else {
            return null; // No hay matrícula en la sesión
        }
    }
    
    //para la busqueda de "otros justificantes".
    public function buscarAlumnos($busqueda) {
        $query = "SELECT * FROM alumno WHERE CONCAT(nombreAlu, ' ', apellidoAlu) LIKE ?";
        $stmt = $this->conexion->prepare($query);
        $like = "%$busqueda%";
        $stmt->bind_param("s", $like);
        $stmt->execute();
        return $stmt->get_result();
    }
} 

include_once __DIR__ . '/../Model/Conexion.php'; // Ajusta la ruta según la ubicación del archivo de conexión
class AlumnoModel {
    private $conexion;

    public function __construct() {
        global $conexion; // Utiliza la conexión global
        $this->conexion = $conexion;
    }

    // Obtener todos los alumnos
    public function obtenerAlumnos() {
        $consulta = "SELECT * FROM alumno ORDER BY idAlumno ASC";
        $resultado = $this->conexion->query($consulta);
        
        $alumnos = [];
        while ($fila = $resultado->fetch_assoc()) {
            $alumnos[] = $fila;
        }
        
        return $alumnos;
    }

    // Agregar un nuevo alumno
    public function agregarAlumno($nombreAlu, $apellidoAlu, $feNac, $matricula, $contrasena) {
        // Hash de la contraseña
        $hashContrasena = password_hash($contrasena, PASSWORD_DEFAULT);
        
        $query = "INSERT INTO alumno (nombreAlu, apellidoAlu, feNac, matricula, contrasena) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->conexion->prepare($query);

        if ($stmt) {
            $stmt->bind_param('sssss', $nombreAlu, $apellidoAlu, $feNac, $matricula, $hashContrasena);
            $resultado = $stmt->execute();
            $stmt->close();
            return $resultado;
        }
        
        return false;
    }

    // Obtener un alumno por ID
    public function obtenerAlumnoPorId($idAlumno) {
        $query = "SELECT * FROM alumno WHERE idAlumno = ?";
        $stmt = $this->conexion->prepare($query);
        
        if ($stmt) {
            $stmt->bind_param('i', $idAlumno);
            $stmt->execute();
            $resultado = $stmt->get_result();
            $alumno = $resultado->fetch_assoc();
            $stmt->close();
            return $alumno; // Retorna el alumno o null si no existe
        }
        
        return null;
    }

    // Modificar un alumno
    public function modificarAlumno($idAlumno, $nombreAlu, $apellidoAlu, $feNac, $matricula, $contrasena) {
        $hashContrasena = password_hash($contrasena, PASSWORD_DEFAULT);
        $query = "UPDATE alumno SET nombreAlu = ?, apellidoAlu = ?, feNac = ?, matricula = ?, contrasena = ? WHERE idAlumno = ?";
        $stmt = $this->conexion->prepare($query);

        if ($stmt) {
            $stmt->bind_param('sssssi', $nombreAlu, $apellidoAlu, $feNac, $matricula, $hashContrasena, $idAlumno);
            $resultado = $stmt->execute();
            $stmt->close();
            return $resultado;
        }
        
        return false;
    }

    // Eliminar un alumno
    public function eliminarAlumno($idAlumno) {
        $query = "DELETE FROM alumno WHERE idAlumno = ?";
        $stmt = $this->conexion->prepare($query);

        if ($stmt) {
            $stmt->bind_param('i', $idAlumno);
            $stmt->execute();
            $resultado = $stmt->affected_rows > 0;
            $stmt->close();
            return $resultado;
        }
        
        return false;
    }
}

?>
