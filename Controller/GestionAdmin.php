<?php
include_once __DIR__ . '/../Model/Administrador.php'; // Incluye el modelo de Administrador

class AdministradorController {
    private $administradorModel;

    public function __construct() {
        $this->administradorModel = new AdministradorModel(); // Instancia del modelo de Administrador
    }

    // Método para obtener todos los administradores
    public function obtenerAdministradores() {
        return $this->administradorModel->obtenerAdministradores(); // Llama al método del modelo para obtener todos los administradores
    }

    // Método para agregar un administrador
    public function agregarAdministrador($nombreAdmin, $apellidoAdmin, $passAd) {
        return $this->administradorModel->agregarAdministrador($nombreAdmin, $apellidoAdmin, $passAd); // Llama al método para agregar un administrador
    }

    // Método para obtener un administrador por ID
    public function obtenerAdministradorPorId($idAdmin) {
        return $this->administradorModel->obtenerAdministradorPorId($idAdmin); // Llama al método para obtener un administrador por ID
    }

    // Método para modificar un administrador
    public function modificarAdministrador($idAdmin, $nombreAdmin, $apellidoAdmin, $passAd) {
        return $this->administradorModel->modificarAdministrador($idAdmin, $nombreAdmin, $apellidoAdmin, $passAd); // Llama al método para modificar un administrador
    }

    // Método para eliminar un administrador
    public function eliminarAdministrador($idAdmin) {
        return $this->administradorModel->eliminarAdministrador($idAdmin); // Llama al método para eliminar un administrador
    }
}
?>
