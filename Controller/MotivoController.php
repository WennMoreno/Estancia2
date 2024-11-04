<?php
    include_once __DIR__ . '/../Model/Conexion.php';// Ajusta la ruta según la ubicación del archivo de conexión

    class MotivoController {
        private $conexion;

        public function __construct() {
            global $conexion; // Utiliza la conexión global
            $this->conexion = $conexion;
        }

        public function obtenerMotivos() {
            $consulta = "SELECT * FROM motivo";
            $resultado = $this->conexion->query($consulta);

            $motivos = [];
            while ($fila = $resultado->fetch_assoc()) {
                $motivos[] = $fila;
            }

            return $motivos;
        }
    }
?>
