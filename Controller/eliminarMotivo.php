<?php
// File: eliminarMotivo.php

// Incluye la conexión a la base de datos
include_once '../Model/Conexion.php';

// Verifica si se ha enviado el ID del motivo a eliminar
if (isset($_GET['id'])) { // Cambiado de 'idMotivo' a 'id'
    $idMotivo = $_GET['id']; // Cambiado de 'idMotivo' a 'id'

    // Lógica para eliminar el motivo
    $query = "DELETE FROM motivo WHERE idMotivo = ?";
    $stmt = $conexion->prepare($query);

    if ($stmt) {
        $stmt->bind_param('i', $idMotivo); // 'i' para entero
        $stmt->execute();

        // Verifica si la eliminación fue exitosa
        if ($stmt->affected_rows > 0) {
            echo "Motivo eliminado exitosamente.";
        } else {
            echo "No se pudo eliminar el motivo o el motivo no existe.";
        }

        $stmt->close(); // Cierra la declaración
    } else {
        echo "Error en la preparación de la consulta.";
    }
} else {
    echo "No se ha especificado un ID de motivo.";
}

// Cierra la conexión
$conexion->close();
?>
