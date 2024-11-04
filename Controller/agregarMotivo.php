<?php
// File: agregarMotivo.php

// Incluye la conexión a la base de datos y el modelo
include_once '../Model/Conexion.php';
include_once '../Model/MotivoModel.php'; // Asegúrate de que este archivo exista y tenga la clase MotivoModel

// Verifica si se ha enviado el formulario
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Crea una instancia del modelo
    $motivoModel = new MotivoModel($conexion); // Asegúrate de que MotivoModel acepte la conexión como argumento

    // Obtiene los datos del formulario
    $tipo = $_POST['tipo']; // Ajusta estos nombres según tu formulario
    $descripcion = $_POST['descripcion'];
    $docSolicitado = $_POST['docSolicitado'];

    // Llama al método para agregar el motivo
    if ($motivoModel->agregarMotivo($tipo, $descripcion, $docSolicitado)) {
        echo "Motivo agregado exitosamente.";
        // Redirigir a la página de gestión de motivos
        header('Location: ../Views/AdminView/gestionMot.php?mensaje=Motivo agregado exitosamente');
        exit();
    } else {
        echo "Error al agregar el motivo.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Motivo</title>
</head>
<body>
    <h1>Agregar Motivo</h1>
    <form method="POST" action="">
        <label for="tipo">Tipo:</label>
        <input type="text" name="tipo" required>
        
        <label for="descripcion">Descripción:</label>
        <input type="text" name="descripcion" required>
        
        <label for="docSolicitado">Documento Solicitado:</label>
        <input type="text" name="docSolicitado" required>
        
        <button type="submit">Agregar</button>
    </form>
</body>
</html>
