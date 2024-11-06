<?php
class JustificanteProfesor {
    private $conexion;

    public function __construct($conexion) {
        $this->conexion = $conexion;
    }

    // Obtener todos los justificantes para un profesor
    public function obtenerJustificantesPorProfesor($idProf) {
        $sql = "
            SELECT j.idJusti, j.cuatrimestre, j.grupo, j.carrera, j.periodoEscolar, j.motivo, j.fecha, j.estado
            FROM justificante_profesor jp
            INNER JOIN justificante j ON jp.idJusti = j.idJusti
            WHERE jp.idProf = ?
        ";

        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param("i", $idProf); // Vincula el ID del profesor
        $stmt->execute();
        $resultado = $stmt->get_result();

        $justificantes = [];
        while ($fila = $resultado->fetch_assoc()) {
            $justificantes[] = $fila;
        }

        return $justificantes;
    } 
    //para el detalle del justificante
    public function obtenerJustificantePorId($idJusti) {
        $sql = "
            SELECT j.idJusti, j.cuatrimestre, j.grupo, j.carrera, j.periodoEscolar, j.motivo, j.fecha, 
                   j.horaInicio, j.horaFin, j.ausenteTodoDia, j.motivoExtra, j.estado, 
                   a.nombreAlu, a.matricula, a.carrera AS alumnoCarrera, e.ruta AS evidenciaRuta
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
