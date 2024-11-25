<?php
include_once __DIR__ . '/../Model/Profesor.php'; // Incluye el modelo de Profesor

class ProfesorController {
    private $profesorModel;

    public function __construct() {
        $this->profesorModel = new ProfesorModel(); // Instancia del modelo de Profesor
    }

    public function obtenerProfesores() {
        return $this->profesorModel->obtenerProfesores(); // Llama al método del modelo para obtener todos los profesores
    }

    public function agregarProfesor($nombre, $apellido,$puesto, $password, $correoElectronico) {
        return $this->profesorModel->agregarProfesor($nombre, $apellido,$puesto, $password, $correoElectronico); // Llama al método para agregar un profesor
    }

    public function obtenerProfesorPorId($idProf) {
        return $this->profesorModel->obtenerProfesorPorId($idProf); // Llama al método para obtener un profesor por ID
    }

    public function modificarProfesor($idProf, $nombre, $apellido,$puesto, $password, $correoElectronico) {
        return $this->profesorModel->modificarProfesor($idProf, $nombre, $apellido,$puesto, $password, $correoElectronico); // Llama al método para modificar un profesor
    }

    public function eliminarProfesor($idProf) {
        return $this->profesorModel->eliminarProfesor($idProf); // Llama al método para eliminar un profesor
    } 

    public function verJustificantes() {
        if (isset($_SESSION['idProfesor'])) {
            $idProfesor = $_SESSION['idProfesor'];
            $profesorModel = new Profesor($this->conexion);
            $justificantes = $profesorModel->consultarJustificantes($idProfesor);
            return $justificantes;
        } else {
            return []; // Retorna un array vacío si no hay idProfesor en la sesión
        }
    }
}
?>
