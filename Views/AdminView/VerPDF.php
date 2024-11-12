<?php
// Incluir archivo de conexión
include('../Model/conexion.php'); // Ajusta la ruta de acuerdo a tu estructura de archivos

// Obtener el ID del justificante desde la URL
if (isset($_GET['id'])) {
    $idJusti = $_GET['id'];

    // Consultar el PDF correspondiente con el ID
    $query = "SELECT * FROM pdf_generado WHERE idJusti = $idJusti";
    $result = mysqli_query($conexion, $query);

    if ($result) {
        $row = mysqli_fetch_assoc($result);
        $rutaPdf = $row['rutaPdf'];

        if (file_exists($rutaPdf)) {
            // Mostrar el PDF en el navegador
            header('Content-Type: application/pdf');
            header('Content-Disposition: inline; filename="' . basename($rutaPdf) . '"');
            readfile($rutaPdf);
        } else {
            echo "El archivo PDF no existe en la ruta especificada.";
        }
    } else {
        echo "Error al obtener el PDF: " . mysqli_error($conexion);
    }

    // Cerrar la conexión
    mysqli_close($conexion);
} else {
    echo "ID de justificante no especificado.";
}
?>
