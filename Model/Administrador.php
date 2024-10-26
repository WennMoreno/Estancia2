<?php
class Administrador {
    private $conexion;

    public function __construct($conexion) {
        $this->conexion = $conexion;
    }

    public function validarAdmin($usuario, $clave) {
        $sql = "
            SELECT 'administrador' AS tipo_usuario, idAdmin AS identificador, nombreAdmin, apellidoAdmin, passAd
            FROM administrador 
            WHERE nombreAdmin = ? AND passAd = ?
        ";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param("ss", $usuario, $clave);
        $stmt->execute();
        return $stmt->get_result();
    }
}
?>
