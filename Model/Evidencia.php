<?php
class Evidencia {
    private $conexion;

    public function __construct($conexion) {
        $this->conexion = $conexion;
    }

    public function insertarEvidencia($nombreArchivo, $rutaArchivo) {
        $stmt = $this->conexion->prepare("INSERT INTO evidencia (nomenclatura, ruta) VALUES (?, ?)");
        if (!$stmt) {
            die("Error al preparar la declaración: " . $this->conexion->error);
        }
        return $stmt; // Devuelve el objeto de declaración
    }
}
?>
