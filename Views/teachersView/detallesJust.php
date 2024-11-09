<?php
// Iniciar sesión si no se ha iniciado
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Incluir el controlador
include_once '../../Controller/GestionJustiProfe.php';

// Verificar que se recibió el idJusti en la URL
if (isset($_GET['idJusti'])) {
    $idJusti = $_GET['idJusti'];
    
    // Crear instancia del controlador
    $gestionJustiProfe = new gestionJustiProfe();
    
    // Mostrar los detalles del justificante
    $gestionJustiProfe->mostrarDetallesJustificante($idJusti);
} else {
    echo "<p>Error: No se especificó ningún justificante.</p>";
}
?>
