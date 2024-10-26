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
?>
