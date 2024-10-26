<?php
class Alumno {
    private $conexion;

    public function __construct($conexion) {
        $this->conexion = $conexion;
    }

    public function validarAlumno($usuario, $clave) {
        $sql = "
            SELECT 'alumno' AS tipo_usuario, matricula AS identificador, nombreAlu, apellidoAlu, contrasena
            FROM alumno 
            WHERE matricula = ? AND contrasena = ?
        ";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param("ss", $usuario, $clave);
        $stmt->execute();
        return $stmt->get_result();
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
}
?>
