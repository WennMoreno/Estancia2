<?php
// File: editarMotivo.php

// Incluye la conexión a la base de datos y el modelo
include_once '../Model/Conexion.php';
include_once '../Model/MotivoModel.php'; // Asegúrate de que este archivo exista y tenga la clase MotivoModel

// Verifica si se ha enviado el ID del motivo
if (isset($_GET['id'])) {
    $idMotivo = $_GET['id'];

    // Crea una instancia del modelo
    $motivoModel = new MotivoModel($conexion); // Asegúrate de que $conexion sea un objeto PDO

    // Obtiene el motivo existente
    $motivo = $motivoModel->obtenerMotivoPorId($idMotivo); // Llama al método para obtener el motivo

    // Verifica si el motivo existe
    if (!$motivo) {
        echo "Motivo no encontrado.";
        exit();
    }
} else {
    echo "No se ha especificado un ID de motivo.";
    exit();
}

// Verifica si se ha enviado el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recibe los datos del formulario
    $id = $_POST['idMotivo'];
    $tipo = $_POST['tipo'];
    $descripcion = $_POST['descripcion'];
    $docSolicitado = $_POST['docSolicitado'];

    // Lógica para actualizar el motivo
    $resultado = $motivoModel->modificarMotivo($id, $tipo, $descripcion, $docSolicitado); // Llama al método para modificar el motivo

    // Verifica si la actualización fue exitosa
    if ($resultado) {
        echo "Motivo actualizado exitosamente.";
        // Redirigir a la página de gestión de motivos
        header('Location: ../Views/AdminView/gestionMot.php?mensaje=Motivo actualizado exitosamente');
        exit();
    } else {
        echo "No se pudo actualizar el motivo.";
    }
}

// Cierra la conexión
// Si estás usando PDO, no es necesario cerrar la conexión manualmente
?>
