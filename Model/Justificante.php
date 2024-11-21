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

    public function obtenerTodosLosJustificantes() {
        $query = "SELECT j.*, a.nombreAlu, a.apellidoAlu
                  FROM justificante j
                  JOIN alumno a ON j.idAlumno = a.idAlumno";
        
        $result = $this->conexion->query($query);
    
        $justificantes = [];
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $justificantes[] = $row;
            }
        }
        return $justificantes;
    }

    public function eliminarJustificantePorId($idJusti) {
        $query = "DELETE FROM justificante WHERE idJusti = ?";
        
        // Preparar la declaración
        $stmt = $this->conexion->prepare($query);
    
        if ($stmt === false) {
            // Error al preparar la declaración
            return false;
        }
    
        // Vincular el parámetro
        $stmt->bind_param("i", $idJusti);
    
        // Ejecutar la declaración
        $result = $stmt->execute();
    
        // Cerrar la declaración
        $stmt->close();
    
        // Retornar el resultado de la ejecución
        return $result;
    }
    
    // Método para cambiar el estado de un justificante
    public function actualizarEstado($idJusti, $nuevoEstado) {
        // Preparar la consulta SQL para actualizar el estado del justificante
        $sql = "UPDATE justificante SET estado = ? WHERE idJusti = ?";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param("si", $nuevoEstado, $idJusti);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }

        $stmt->close();
    }
}
?>
