<?php
class Profesor {
    private $conexion;

    public function __construct($conexion) {
        $this->conexion = $conexion;
    }

    public function validarProfesor($usuario, $clave) {
        $sql = "
            SELECT 'profesor' AS tipo_usuario, idProf AS identificador, nombreProf, apellidoProf, passwordProf AS contraseña
            FROM profesor
            WHERE nombreProf = ? AND passwordProf = ?
        ";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param("ss", $usuario, $clave);
        $stmt->execute();
        return $stmt->get_result();
    } 

    public function obtenerProfesores() {
        $sql = "SELECT nombreProf, apellidoProf FROM profesor";
        $result = mysqli_query($this->conexion, $sql);
        return $result;
    } 

    public function obtenerIdProfesor($nombreProfesor) {
        $stmtProfesor = $this->conexion->prepare("SELECT idProf FROM profesor WHERE CONCAT(nombreProf, ' ', apellidoProf) = ?");
        
        // Verificar si `prepare` fue exitoso
        if (!$stmtProfesor) {
            die("Error en la preparación de la consulta: " . $this->conexion->error);
        }
    
        // Verificar si `bind_param` fue exitoso
        if (!$stmtProfesor->bind_param("s", $nombreProfesor)) {
            die("Error en bind_param: " . $stmtProfesor->error);
        }
        
        // Ejecutar y verificar si `execute` fue exitoso
        if (!$stmtProfesor->execute()) {
            die("Error en la ejecución de la consulta: " . $stmtProfesor->error);
        }
        
        $resultProfesor = $stmtProfesor->get_result();
        $idProf = $resultProfesor->fetch_assoc()['idProf'] ?? null; // Extraer `idProf` o devolver `null` si no se encuentra
    
        return $idProf; // Devolver el ID o `null`
    }
    
    
} 

include_once __DIR__ . '/../Model/Conexion.php'; // Ajusta la ruta según la ubicación del archivo de conexión

class ProfesorModel {
    private $conexion;

    public function __construct() {
        global $conexion; // Utiliza la conexión global
        $this->conexion = $conexion;
    }

    
    
    // Función para obtener todos los profesores
    public function obtenerProfesores() {
        $consulta = "SELECT * FROM profesor ORDER BY idProf ASC"; // Ordenar por ID ascendente
        $resultado = $this->conexion->query($consulta);

        $profesores = [];
        while ($fila = $resultado->fetch_assoc()) {
            $profesores[] = $fila;
        }

        return $profesores;
    }

    // Función para agregar un profesor
    public function agregarProfesor($nombreProf, $apellidoProf, $passwordProf, $correoElectronico) {
        $query = "INSERT INTO profesor (nombreProf, apellidoProf, passwordProf, correoElectronico) VALUES (?, ?, ?, ?)";
        $stmt = $this->conexion->prepare($query);

        if ($stmt) {
            $stmt->bind_param('ssss', $nombreProf, $apellidoProf, $passwordProf, $correoElectronico);
            $resultado = $stmt->execute();
            $stmt->close();
            return $resultado;
        }

        return false;
    }

    // Función para obtener un profesor por ID
    public function obtenerProfesorPorId($idProf) {
        $query = "SELECT * FROM profesor WHERE idProf = ?";
        $stmt = $this->conexion->prepare($query);

        if ($stmt) {
            $stmt->bind_param('i', $idProf);
            $stmt->execute();
            $resultado = $stmt->get_result();
            $profesor = $resultado->fetch_assoc();
            $stmt->close();
            return $profesor;
        }

        return null;
    }

    // Función para modificar un profesor
    public function modificarProfesor($idProf, $nombreProf, $apellidoProf, $passwordProf, $correoElectronico) {
        $query = "UPDATE profesor SET nombreProf = ?, apellidoProf = ?, passwordProf = ?, correoElectronico = ? WHERE idProf = ?";
        $stmt = $this->conexion->prepare($query);

        if ($stmt) {
            $stmt->bind_param('ssssi', $nombreProf, $apellidoProf, $passwordProf, $correoElectronico, $idProf);
            $resultado = $stmt->execute();
            $stmt->close();
            return $resultado;
        }

        return false;
    }

    // Función para eliminar un profesor
    public function eliminarProfesor($idProf) {
        $query = "DELETE FROM profesor WHERE idProf = ?";
        $stmt = $this->conexion->prepare($query);

        if ($stmt) {
            $stmt->bind_param('i', $idProf);
            $stmt->execute();
            $resultado = $stmt->affected_rows > 0;
            $stmt->close();
            return $resultado;
        }

        return false;
    }
}
?>
