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
?>
