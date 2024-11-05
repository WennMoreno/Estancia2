<?php
include_once __DIR__ . '/../Model/Motivo.php'; // Incluye el modelo

class MotivoController {
    private $motivoModel;

    public function __construct() {
        $this->motivoModel = new MotivoModel(); // Instancia del modelo
    }

    public function obtenerMotivos() {
        return $this->motivoModel->obtenerMotivos(); // Llama al método del modelo
    }

    public function agregarMotivo($tipo, $descripcion, $docSolicitado) {
        return $this->motivoModel->agregarMotivo($tipo, $descripcion, $docSolicitado); // Llama al método del modelo
    }

    public function obtenerMotivoPorId($idMotivo) {
        return $this->motivoModel->obtenerMotivoPorId($idMotivo); // Llama al método del modelo
    }

    public function modificarMotivo($idMotivo, $tipo, $descripcion, $docSolicitado) {
        return $this->motivoModel->modificarMotivo($idMotivo, $tipo, $descripcion, $docSolicitado); // Llama al método del modelo
    }

    public function eliminarMotivo($idMotivo) {
        return $this->motivoModel->eliminarMotivo($idMotivo); // Llama al método del modelo
    }
}
?>
