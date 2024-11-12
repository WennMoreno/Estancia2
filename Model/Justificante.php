<?php
include 'Conexion.php';

class Justificante {

    private $conexion;

    public function __construct($conexion) {
        $this->conexion = $conexion;
    }

    public function insertarJustificante($cuatrimestre, $grupo, $carrera, $periodo, $motivo, $fecha, $horaInicio, $horaFin, $ausenteTodoDia, $motivoExtra, $idEvi, $idAlumno) {
        $sql = "INSERT INTO justificante (cuatrimestre, grupo, carrera, periodoEscolar, motivo, fecha, horaInicio, horaFin, ausenteTodoDia, motivoExtra, estado, idEvi, idAlumno)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'Pendiente', ?, ?)";
    
        $stmt = $this->conexion->prepare($sql);
    
        // Verifica si la preparación de la declaración fue exitosa
        if ($stmt === false) {
            die("Error en la preparación de la declaración: " . $this->conexion->error);
        }
    
        $stmt->bind_param("isssssssissi", $cuatrimestre, $grupo, $carrera, $periodo, $motivo, $fecha, $horaInicio, $horaFin, $ausenteTodoDia, $motivoExtra, $idEvi, $idAlumno);
    
        // Ejecutar la declaración
        if ($stmt->execute()) {
            return $this->conexion->insert_id; // Retorna el ID del justificante insertado
        } else {
            die("Error al ejecutar la declaración: " . $stmt->error);
        }
    
        // Cierra la declaración
        $stmt->close();
    }
    
    public function getJustificantesPorAlumno($id) {
        $sql = "SELECT * FROM justificante WHERE idAlumno = ?";
        $stmt = $this->conexion->prepare($sql);

        if ($stmt) {
            $stmt->bind_param("s", $id);
            $stmt->execute();
            $resultado = $stmt->get_result();
            return $resultado->fetch_all(MYSQLI_ASSOC);
        } else {
            return [];
        }
    }  

    public function showJusti($id){
        $query = "
            SELECT justificante.*, alumno.nombreAlu AS nombre, alumno.matricula, justificante.carrera, evidencia.ruta
            FROM justificante
            JOIN alumno ON justificante.idAlumno = alumno.idAlumno
            LEFT JOIN evidencia ON justificante.idEvi = evidencia.idEvi
            WHERE justificante.idJusti = $id
        ";
        $result = mysqli_query($this->conexion, $query);
        return $result;

    }
   
    public function justiPendiente(){
        $query = "SELECT justificante.*, alumno.nombreAlu, alumno.apellidoAlu 
          FROM justificante
          JOIN alumno ON justificante.idAlumno = alumno.idAlumno
          WHERE justificante.estado = 'Pendiente'"; 

        $result = mysqli_query($this->conexion, $query);
        return $result;
    }
}
?>
