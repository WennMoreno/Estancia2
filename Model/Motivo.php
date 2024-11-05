<?php
class Motivo {
    private $conexion;

    public function __construct($conexion) {
        $this->conexion = $conexion;
    }

    public function obtenerMotivos() {
        $sql = "SELECT tipo FROM motivo";
        $result = mysqli_query($this->conexion, $sql);
        return $result;
    }
} 

include_once __DIR__ . '/../Model/Conexion.php'; // Ajusta la ruta según la ubicación del archivo de conexión
class MotivoModel {
    private $conexion;

    public function __construct() {
        global $conexion; // Utiliza la conexión global
        $this->conexion = $conexion;
    }


    
    public function obtenerMotivos() {
        $consulta = "SELECT * FROM motivo ORDER BY idMotivo ASC"; // Ordenar por ID ascendente
        $resultado = $this->conexion->query($consulta);
        
        $motivos = [];
        while ($fila = $resultado->fetch_assoc()) {
            $motivos[] = $fila;
        }
        
        return $motivos;
    }

    // Función para agregar un motivo
    public function agregarMotivo($tipo, $descripcion, $docSolicitado) {
        $query = "INSERT INTO motivo (tipo, descripcion, docSolicitado) VALUES (?, ?, ?)";
        $stmt = $this->conexion->prepare($query);

        if ($stmt) {
            $stmt->bind_param('sss', $tipo, $descripcion, $docSolicitado);
            $resultado = $stmt->execute();
            $stmt->close();
            return $resultado;
        }
        
        return false;
    }

    // Función para obtener un motivo por ID
    public function obtenerMotivoPorId($idMotivo) {
        $query = "SELECT * FROM motivo WHERE idMotivo = ?";
        $stmt = $this->conexion->prepare($query);
        
        if ($stmt) {
            $stmt->bind_param('i', $idMotivo);
            $stmt->execute();
            $resultado = $stmt->get_result();
            $motivo = $resultado->fetch_assoc();
            $stmt->close();
            return $motivo;
        }
        
        return null;
    }

    // Función para modificar un motivo
    public function modificarMotivo($idMotivo, $tipo, $descripcion, $docSolicitado) {
        $query = "UPDATE motivo SET tipo = ?, descripcion = ?, docSolicitado = ? WHERE idMotivo = ?";
        $stmt = $this->conexion->prepare($query);

        if ($stmt) {
            $stmt->bind_param('sssi', $tipo, $descripcion, $docSolicitado, $idMotivo);
            $resultado = $stmt->execute();
            $stmt->close();
            return $resultado;
        }
        
        return false;
    }

    // Función para eliminar un motivo
    public function eliminarMotivo($idMotivo) {
        $query = "DELETE FROM motivo WHERE idMotivo = ?";
        $stmt = $this->conexion->prepare($query);

        if ($stmt) {
            $stmt->bind_param('i', $idMotivo);
            $stmt->execute();
            $resultado = $stmt->affected_rows > 0;
            $stmt->close();
            return $resultado;
        }
        
        return false;
    }
}
?>
