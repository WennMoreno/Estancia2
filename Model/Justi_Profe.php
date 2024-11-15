<?php
class JustificanteProfesor {
    private $conexion;

    public function __construct($conexion) {
        $this->conexion = $conexion;
    }
    public function obtenerIdJusPro($user) {
        // Consulta para obtener el ID del administrador basado en el correo
        $sql = "
            SELECT idProf FROM profesor WHERE correoElectronico = ? 
        ";
        
        // Prepara la consulta
        $stmt = $this->conexion->prepare($sql);
        
        // Vincula el correo como parámetro
        $stmt->bind_param("s", $user);
        
        // Ejecuta la consulta
        $stmt->execute();
        
        // Obtén el resultado
        $result = $stmt->get_result();
        
        // Si se encontró un registro, obtén el ID como entero
        if ($row = $result->fetch_assoc()) {
            return (int) $row['idProf']; // Retorna el ID como un entero
        }
        
        // Si no se encontró el administrador con ese correo, retorna null
        return null;
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

     // Método para obtener todos los registros de justificante_profesor
     public function obtenerJustificantesProfesores() {
        $query = "SELECT jp.idDetalle, jp.idJusti, jp.idProf, j.motivo, p.nombreProf, p.apellidoProf 
                  FROM justificante_profesor jp
                  JOIN justificante j ON jp.idJusti = j.idJusti
                  JOIN profesor p ON jp.idProf = p.idProf";
        
        $stmt = $this->conexion->prepare($query);
        $stmt->execute();
        
        $result = $stmt->get_result();  // Obtiene el conjunto de resultados
        $justificantes = [];
    
        // Recorre los resultados y los agrega al arreglo
        while ($row = $result->fetch_assoc()) {
            $justificantes[] = $row;
        }
        
        return $justificantes;
    }
    
    // Obtener los profesores asociados a un justificante específico
    public function obtenerTodosLosProfesores($idJustificante) {
        // Consulta para obtener todos los profesores, con una columna extra 'asociado'
        $sql = "SELECT p.idProf, p.nombreProf, p.apellidoProf,
                       CASE WHEN jp.idJusti IS NOT NULL THEN 1 ELSE 0 END AS asociado
                FROM profesor p
                LEFT JOIN justificante_profesor jp ON p.idProf = jp.idProf AND jp.idJusti = ?";

        // Preparamos la consulta
        $stmt = $this->conexion->prepare($sql);

        // Vinculamos el parámetro
        $stmt->bind_param('i', $idJustificante); // 'i' es para entero

        // Ejecutamos la consulta
        $stmt->execute();

        // Obtenemos el resultado
        $result = $stmt->get_result();

        // Devolvemos el resultado como un array asociativo
        return $result->fetch_all(MYSQLI_ASSOC);
    } 

    public function actualizarProfesoresJustificante($idJustificante, $profesores) {
        // Primero, eliminamos las relaciones existentes
        $sqlEliminar = "DELETE FROM justificante_profesor WHERE idJusti = ?";
        $stmtEliminar = $this->conexion->prepare($sqlEliminar);
        $stmtEliminar->bind_param('i', $idJustificante);
        $stmtEliminar->execute();

        // Insertamos las nuevas relaciones de profesores
        $sqlInsertar = "INSERT INTO justificante_profesor (idJusti, idProf) VALUES (?, ?)";
        $stmtInsertar = $this->conexion->prepare($sqlInsertar);

        foreach ($profesores as $profesor) {
            $stmtInsertar->bind_param('ii', $idJustificante, $profesor);
            $stmtInsertar->execute();
        }

        return true; // Si todo va bien, devolvemos true
    }
}
?>
