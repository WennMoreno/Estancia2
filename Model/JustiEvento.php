<?php
class JustificanteEvento {
    private $conexion;

    public function __construct($conexion) {
        $this->conexion = $conexion;
    }

    public function insertarEvento($nombreEvento, $fechaInicio, $fechaFin) {
        // Consulta para insertar un nuevo evento con rango de fechas
        $sql = "INSERT INTO justificante_evento (nombreEvento, fechaInicio, fechaFin) VALUES (?, ?, ?)";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param("sss", $nombreEvento, $fechaInicio, $fechaFin);

        if ($stmt->execute()) {
            $idJustiEvento = $stmt->insert_id; // ID del evento insertado
            $stmt->close();
            return $idJustiEvento; // Devolver el ID para usarlo en las relaciones
        } else {
            echo "Error al insertar el justificante de evento: " . $stmt->error;
            $stmt->close();
            return false;
        }
    }

    public function insertarAlumnoEnEvento($nombreAlumno, $matricula, $grado, $grupo, $carrera, $idJustiEvento) {
        // Consulta para insertar un alumno relacionado con el evento
        $sql = "INSERT INTO justificante_evento_alumno (nombreAlumno, matricula, grado, grupo, carrera, idJustiEvento) 
                VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param("ssissi", $nombreAlumno, $matricula, $grado, $grupo, $carrera, $idJustiEvento);

        if ($stmt->execute()) {
            $stmt->close();
            return true;
        } else {
            //echo "Error al insertar el alumno en el evento: " . $stmt->error;
            $stmt->close();
            return false;
        }
    }

    public function obtenerJustificantesEventos() {
        // Consulta para obtener los eventos y los alumnos asociados
        $sql = "SELECT 
                    je.idJustiEvento, 
                    je.nombreEvento, 
                    je.fechaInicio, 
                    je.fechaFin, 
                    ja.nombreAlumno, 
                    ja.matricula, 
                    ja.grado, 
                    ja.grupo, 
                    ja.carrera 
                FROM justificante_evento AS je
                LEFT JOIN justificante_evento_alumno AS ja ON je.idJustiEvento = ja.idJustiEvento
                ORDER BY je.idJustiEvento, ja.nombreAlumno";
        
        $resultado = $this->conexion->query($sql);
    
        // Array para almacenar los datos
        $eventos = [];
        
        if ($resultado) {
            while ($fila = $resultado->fetch_assoc()) {
                $idEvento = $fila['idJustiEvento'];
                
                // Si el evento no está en el array, se agrega como clave
                if (!isset($eventos[$idEvento])) {
                    $eventos[$idEvento] = [
                        'nombreEvento' => $fila['nombreEvento'],
                        'fechaInicio' => $fila['fechaInicio'],
                        'fechaFin' => $fila['fechaFin'],
                        'alumnos' => []
                    ];
                }
                
                // Agregar los datos del alumno al evento
                $eventos[$idEvento]['alumnos'][] = [
                    'nombreAlumno' => $fila['nombreAlumno'],
                    'matricula' => $fila['matricula'],
                    'grado' => $fila['grado'],
                    'grupo' => $fila['grupo'],
                    'carrera' => $fila['carrera']
                ];
            }
        }
        return $eventos;
    }
    
        
    public function actualizarEvento($eventoId, $nombreEvento, $fechaInicio, $fechaFin) {
        /* Preparar la consulta SQL para actualizar el evento
        $sql = "UPDATE justificante_evento SET nombreEvento = ?, fechaInicio = ?, fechaFin = ? WHERE idJustiEvento = ?";
        
        // Preparar la sentencia
        $stmt = $this->conexion->prepare($sql);
        
        // Vincular los parámetros
        $stmt->bind_param("sssi", $nombreEvento, $fechaInicio, $fechaFin, $eventoId);
        
        // Ejecutar la consulta
        if ($stmt->execute()) {
            // Si la actualización es exitosa, retornar verdadero
            return true;
        } else {
            // Si hubo un error, retornar falso
            return false;
        }*/

        if ($fechaInicio && $fechaFin) {
            // Si el evento tiene un rango de fechas
            $sql = "UPDATE justificante_evento SET nombreEvento = ?, fechaInicio = ?, fechaFin = ? WHERE idJustiEvento = ?";
            $stmt = $this->conexion->prepare($sql);
            $stmt->bind_param("sssi", $nombreEvento, $fechaInicio, $fechaFin, $eventoId);
        } else {
            // Si el evento tiene solo una fecha
            $sql = "UPDATE justificante_evento SET nombreEvento = ?, fechaInicio = ? WHERE idJustiEvento = ?";
            $stmt = $this->conexion->prepare($sql);
            $stmt->bind_param("ssi", $nombreEvento, $fecha, $eventoId);
        }
        $stmt->execute(); 

        if ($stmt->execute()) {
            // Si la actualización es exitosa, retornar verdadero
            return true;
        } else {
            // Si hubo un error, retornar falso
            return false;
        }
    
    } 

    public function obtenerEvento($eventoId) {
         // Obtener los detalles básicos del evento
    $sqlEvento = "SELECT idJustiEvento, nombreEvento, fechaInicio, fechaFin FROM justificante_evento WHERE idJustiEvento = ?";
    $stmtEvento = $this->conexion->prepare($sqlEvento);
    $stmtEvento->bind_param("i", $eventoId);
    $stmtEvento->execute();
    $resultadoEvento = $stmtEvento->get_result();
    
    if ($resultadoEvento->num_rows > 0) {
        $evento = $resultadoEvento->fetch_assoc();
        
        // Inicializar el array de alumnos
        $evento['alumnos'] = [];
        
        // Obtener los alumnos asociados al evento
        $sqlAlumnos = "SELECT nombreAlumno, matricula, grado, grupo, carrera 
                       FROM justificante_evento_alumno 
                       WHERE idJustiEvento = ?";
        $stmtAlumnos = $this->conexion->prepare($sqlAlumnos);
        $stmtAlumnos->bind_param("i", $eventoId);
        $stmtAlumnos->execute();
        $resultadoAlumnos = $stmtAlumnos->get_result();

        while ($alumno = $resultadoAlumnos->fetch_assoc()) {
            $evento['alumnos'][] = $alumno;
        }
        
        return $evento;
    }
    
    return null;  // Si no se encuentra el evento
    }
    
    // Función para eliminar los alumnos asociados a un evento
    public function eliminarAlumnosEvento($eventoId) {
        $sql = "DELETE FROM justificante_evento_alumno WHERE idJustiEvento = ?";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param("i", $eventoId);
        if ($stmt->execute()) {
           // echo "Alumnos eliminados correctamente.<br>";
        } else {
            echo "Error al eliminar alumnos: " . $stmt->error . "<br>";
        }
        return $stmt->execute();
    }
    

    // Función para insertar los alumnos asociados a un evento desde la edición
    public function insertarAlumnos($alumnos, $eventoId) {
        $sql = "INSERT INTO justificante_evento_alumno (nombreAlumno, matricula, grado, grupo, carrera, idJustiEvento) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $this->conexion->prepare($sql);
        
        foreach ($alumnos as $alumno) {
            $stmt->bind_param(
                "ssissi",
                $alumno['nombreAlumno'],
                $alumno['matricula'],
                $alumno['grado'],
                $alumno['grupo'],
                $alumno['carrera'],
                $eventoId
            );
            if ($stmt->execute()) {
                //echo "Alumno insertado correctamente: " . $alumno['nombreAlumno'] . "<br>";
            } else {
                echo "Error al insertar alumno: " . $stmt->error . "<br>";
            }
        }
    }
     

    // Función para editar completamente un evento y sus alumnos
    public function editarEventoCompleto($eventoId, $nombreEvento, $fechaInicio, $fechaFin, $alumnos) {
        // Primero actualizamos el evento
        $this->actualizarEvento($eventoId, $nombreEvento, $fechaInicio, $fechaFin);
        
        // Luego eliminamos los alumnos anteriores
        $this->eliminarAlumnosEvento($eventoId);
        
        // Finalmente insertamos los alumnos nuevos
        $this->insertarAlumnos($alumnos, $eventoId);
    }

}
?>