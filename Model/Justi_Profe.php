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
    
}
?>
