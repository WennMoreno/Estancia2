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

    public function EsAdmin($usuario) {
        $adminQuery = "SELECT idAdmin FROM administrador WHERE idAdmin = ?";
        $stmt = mysqli_prepare($this->conexion, $adminQuery);
    
        // Vincular el parámetro
        mysqli_stmt_bind_param($stmt, 's', $usuario);
    
        // Ejecutar la consulta
        mysqli_stmt_execute($stmt);
    
        // Almacenar el resultado
        mysqli_stmt_store_result($stmt);
    
        // Verificar si hay resultados
        if (mysqli_stmt_num_rows($stmt) > 0) {
            // Si existe el administrador
            return true;
        } else {
            // Si no existe el administrador
            return false;
        }
    }
    
}   

include_once __DIR__ . '/../Model/Conexion.php'; 
class AdministradorModel {
    private $conexion;

    public function __construct() {
        global $conexion; // Utiliza la conexión global
        $this->conexion = $conexion;
    }

    // Función para obtener todos los administradores
    public function obtenerAdministradores() {
        $consulta = "SELECT * FROM administrador ORDER BY idAdmin ASC"; // Ordenar por ID ascendente
        $resultado = $this->conexion->query($consulta);

        $administradores = [];
        while ($fila = $resultado->fetch_assoc()) {
            $administradores[] = $fila;
        }

        return $administradores;
    }

    // Función para agregar un administrador
    public function agregarAdministrador($nombreAdmin, $apellidoAdmin, $passAd) {
        $query = "INSERT INTO administrador (nombreAdmin, apellidoAdmin, passAd) VALUES (?, ?, ?)";
        $stmt = $this->conexion->prepare($query);

        if ($stmt) {
            $stmt->bind_param('sss', $nombreAdmin, $apellidoAdmin, $passAd);
            $resultado = $stmt->execute();
            $stmt->close();
            return $resultado;
        }

        return false;
    }

    // Función para obtener un administrador por ID
    public function obtenerAdministradorPorId($idAdmin) {
        $query = "SELECT * FROM administrador WHERE idAdmin = ?";
        $stmt = $this->conexion->prepare($query);

        if ($stmt) {
            $stmt->bind_param('i', $idAdmin);
            $stmt->execute();
            $resultado = $stmt->get_result();
            $administrador = $resultado->fetch_assoc();
            $stmt->close();
            return $administrador;
        }

        return null;
    }

    // Función para modificar un administrador
    public function modificarAdministrador($idAdmin, $nombreAdmin, $apellidoAdmin, $passAd) {
        $query = "UPDATE administrador SET nombreAdmin = ?, apellidoAdmin = ?, passAd = ? WHERE idAdmin = ?";
        $stmt = $this->conexion->prepare($query);

        if ($stmt) {
            $stmt->bind_param('sssi', $nombreAdmin, $apellidoAdmin, $passAd, $idAdmin);
            $resultado = $stmt->execute();
            $stmt->close();
            return $resultado;
        }

        return false;
    }

    // Función para eliminar un administrador
    public function eliminarAdministrador($idAdmin) {
        $query = "DELETE FROM administrador WHERE idAdmin = ?";
        $stmt = $this->conexion->prepare($query);

        if ($stmt) {
            $stmt->bind_param('i', $idAdmin);
            $stmt->execute();
            $resultado = $stmt->affected_rows > 0;
            $stmt->close();
            return $resultado;
        }

        return false;
    }
}
?>

