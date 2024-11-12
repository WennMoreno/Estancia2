<?php
// Verifica si el parámetro 'file' está presente en la URL
if (isset($_GET['file'])) {
    // Escapar el nombre del archivo para evitar inyecciones
    $fileName = basename($_GET['file']);
    
    // Ruta completa al archivo en el escritorio
    $filePath = "C:/Users/Enrique/Desktop/Justificantes/2025/" . $fileName;
    
    // Verifica si el archivo existe
    if (file_exists($filePath)) {
        // Establece los encabezados apropiados para indicar que es un archivo PDF
        header('Content-Type: application/pdf');
        header('Content-Disposition: inline; filename="' . $fileName . '"');
        readfile($filePath);
        exit;
    } else {
        echo "El archivo no existe.";
    }
} else {
    echo "No se proporcionó un archivo.";
}
?>
