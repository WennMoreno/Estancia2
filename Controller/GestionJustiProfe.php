<?php
// Incluir el archivo de conexión
include '../../Model/Conexion.php';
include '../../Model/Justi_Profe.php';

class gestionJustiProfe {
    private $conexion;

    public function __construct($conexion) {
        $this->conexion = $conexion;
    }

    // Mostrar los justificantes de un profesor
    public function mostrarJustificantesPorProfesor($idProf) {
        $justificanteProfesor = new JustificanteProfesor($this->conexion);
        return $justificanteProfesor->obtenerJustificantesPorProfesor($idProf);
    }
    

    public function mostrarDetallesJustificante($idJusti) {
        // Crear una nueva instancia de JustificanteProfesor
        $justificanteProfesor = new JustificanteProfesor($this->conexion);
        
        // Obtener los datos del justificante usando el método adecuado de la clase JustificanteProfesor
        $justificante = $justificanteProfesor->obtenerJustificantePorId($idJusti);
    
        if ($justificante) {
            // Si se encuentra el justificante, mostrar los detalles directamente en el controlador
            echo "<h3>Detalles del Justificante</h3>";
    
            echo "<p><strong>ID Justificante:</strong> " . htmlspecialchars($justificante['idJusti']) . "</p>";
            echo "<p><strong>Cuatrimestre:</strong> " . htmlspecialchars($justificante['cuatrimestre']) . "</p>";
            echo "<p><strong>Grupo:</strong> " . htmlspecialchars($justificante['grupo']) . "</p>";
            echo "<p><strong>Carrera:</strong> " . htmlspecialchars($justificante['carrera']) . "</p>";
            echo "<p><strong>Periodo Escolar:</strong> " . htmlspecialchars($justificante['periodoEscolar']) . "</p>";
            echo "<p><strong>Motivo:</strong> " . htmlspecialchars($justificante['motivo']) . "</p>";
            echo "<p><strong>Fecha:</strong> " . htmlspecialchars($justificante['fecha']) . "</p>";
    
            // Verificación si ausenteTodoDia es 1 o 0
            if ($justificante['ausenteTodoDia']) {
                echo "<p><strong>Estado:</strong> Ausente todo el día</p>";
            } else {
                echo "<p><strong>Hora de Inicio:</strong> " . htmlspecialchars($justificante['horaInicio']) . "</p>";
                echo "<p><strong>Hora de Fin:</strong> " . htmlspecialchars($justificante['horaFin']) . "</p>";
            }
    
            echo "<p><strong>Motivo Extra:</strong> " . htmlspecialchars($justificante['motivoExtra']) . "</p>";
            echo "<p><strong>Estado:</strong> " . htmlspecialchars($justificante['estado']) . "</p>";
    
            // Mostrar detalles del alumno
            echo "<h3>Detalles del Alumno</h3>";
            echo "<p><strong>Nombre:</strong> " . htmlspecialchars($justificante['nombreAlu']) . "</p>";
            echo "<p><strong>Matrícula:</strong> " . htmlspecialchars($justificante['matricula']) . "</p>";
            
    
            // Si hay evidencia, mostrar el enlace para verla
            if ($justificante['evidenciaRuta']) {
                echo "<p><strong>Evidencia:</strong> <a href='" . htmlspecialchars($justificante['evidenciaRuta']) . "' target='_blank'>Ver evidencia</a></p>";
            } else {
                echo "<p><strong>Evidencia:</strong> No disponible.</p>";
            }
    
        
        } else {
            echo "<p>No se encontró el justificante.</p>";
        }
    
    }
    
}
?>
