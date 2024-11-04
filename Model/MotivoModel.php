<?php
// File: MotivoModel.php
class MotivoModel {
    private $db;

    public function __construct($database) {
        $this->db = $database; // Almacena la conexión a la base de datos
    }

    // Obtener todos los motivos
    public function obtenerMotivos() {
        $query = "SELECT * FROM motivo";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC); // Obtiene todos los registros
    }

    // Obtener un motivo por su ID
    public function obtenerMotivoPorId($id) {
        $query = "SELECT * FROM motivo WHERE idMotivo = ?";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$id]); // Ejecuta la consulta pasando el ID
        return $stmt->fetch(PDO::FETCH_ASSOC); // Obtiene un único registro
    }

    // Agregar un nuevo motivo
    public function agregarMotivo($tipo, $descripcion, $docSolicitado) {
        $query = "INSERT INTO motivo (tipo, descripcion, docSolicitado) VALUES (?, ?, ?)";
        $stmt = $this->db->prepare($query);
        return $stmt->execute([$tipo, $descripcion, $docSolicitado]); // Inserta el nuevo motivo
    }

    // Modificar un motivo existente
    public function modificarMotivo($id, $tipo, $descripcion, $docSolicitado) {
        $query = "UPDATE motivo SET tipo = ?, descripcion = ?, docSolicitado = ? WHERE idMotivo = ?";
        $stmt = $this->db->prepare($query);
        return $stmt->execute([$tipo, $descripcion, $docSolicitado, $id]); // Actualiza el motivo
    }

    // Eliminar un motivo
    public function eliminarMotivo($id) {
        $query = "DELETE FROM motivo WHERE idMotivo = ?";
        $stmt = $this->db->prepare($query);
        return $stmt->execute([$id]); // Elimina el motivo
    }
}
?>
