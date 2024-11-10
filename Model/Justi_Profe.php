<?php
class JustificanteProfesor {
    private $conexion;

    public function __construct($conexion) {
        $this->conexion = $conexion;
    }

    public function insertarJustificanteProfesor($idJusti, $idProf) {
        $sql = "INSERT INTO justificante_profesor (idJusti, idProf) VALUES (?, ?)";
        
        // Prepara la declaración y verifica si fue exitosa
        $stmt = $this->conexion->prepare($sql);
        if (!$stmt) {
            die("Error al preparar la consulta en insertarJustificanteProfesor: " . $this->conexion->error);
        }
    
        // Vincula los parámetros y verifica si la vinculación fue exitosa
        if (!$stmt->bind_param("ii", $idJusti, $idProf)) {
            die("Error al vincular los parámetros en insertarJustificanteProfesor: " . $stmt->error);
        }
    
        // Devuelve el objeto stmt para que sea ejecutado en el código principal
        return $stmt;
    }
    
    // Obtener todos los justificantes para un profesor junto con la evidencia pdf generada
    public function obtenerJustificantesPorProfesor($idProf) {
        $query = "SELECT j.*, p.nombrePdf, p.rutaPdf 
                  FROM justificante AS j
                  LEFT JOIN pdf_generado AS p ON j.idJusti = p.idJusti
                  JOIN justificante_profesor AS jp ON jp.idJusti = j.idJusti
                  WHERE jp.idProf = ?";
        $stmt = $this->conexion->prepare($query);
        $stmt->bind_param("i", $idProf);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }
    

    //para el detalle del justificante con informcaión del alumno 
    public function obtenerJustificantePorId($idJusti) {
        $sql = "
            SELECT j.idJusti, j.cuatrimestre, j.grupo, j.carrera, j.periodoEscolar, j.motivo, j.fecha, 
                   j.horaInicio, j.horaFin, j.ausenteTodoDia, j.motivoExtra, j.estado, 
                   a.nombreAlu, a.matricula, e.ruta AS evidenciaRuta
            FROM justificante j
            JOIN alumno a ON j.idAlumno = a.idAlumno
            LEFT JOIN evidencia e ON j.idEvi = e.idEvi
            WHERE j.idJusti = ?
        ";

        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param("i", $idJusti);
        $stmt->execute();
        $resultado = $stmt->get_result();

        if ($resultado->num_rows > 0) {
            return $resultado->fetch_assoc(); // Retorna los datos del justificante
        } else {
            return null; // Si no se encuentra el justificante
        }
    }
}
?>
