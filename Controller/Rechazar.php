<?php
include('../Model/conexion.php');  // Incluye el archivo de conexión
session_start();

// Verificar que se haya enviado el ID de la solicitud y el nuevo estado
if (isset($_POST['idJusti']) && isset($_POST['nuevoEstado'])) {
    $idJusti = $_POST['idJusti'];
    $nuevoEstado = $_POST['nuevoEstado'];

    // Prepara la consulta SQL para actualizar el estado de la solicitud
    $query = "UPDATE justificante SET estado = ? WHERE idJusti = ?";

    // Usa un prepared statement para evitar inyecciones SQL
    if ($stmt = mysqli_prepare($conexion, $query)) {
        // Vincula los parámetros
        mysqli_stmt_bind_param($stmt, 'si', $nuevoEstado, $idJusti);

        // Ejecuta la consulta
        if (mysqli_stmt_execute($stmt)) {
            // Si la actualización es exitosa
            echo json_encode(['success' => true, 'message' => 'Estado actualizado']);
        } else {
            // Si hubo un error al ejecutar la consulta
            echo json_encode(['success' => false, 'message' => 'Error al actualizar el estado']);
        }

        // Cierra la sentencia preparada
        mysqli_stmt_close($stmt);
    } else {
        // Si no se pudo preparar la consulta
        echo json_encode(['success' => false, 'message' => 'Error al preparar la consulta']);
    }

} else {
    // Si no se enviaron los datos necesarios
    echo json_encode(['success' => false, 'message' => 'Faltan parámetros']);
}

mysqli_close($conexion);  // Cierra la conexión
?>
