<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start(); // Solo se inicia si no hay una sesión activa
}

include_once '../../Controller/GestionJustiProfe.php';
if (isset($_SESSION['identificador'])) {
    $idProf = $_SESSION['identificador'];
    echo $idProf;
} else {
    echo "No se ha encontrado el ID del profesor.";
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal del Profesor</title>
    <link rel="stylesheet" href="../../Resources/CSS/styleProfeConsu.css">
</head>
<body>
    <div class="header">
        <h1>Justificantes Pendientes</h1>
    </div>

    <div class="justificantes">
        <?php
        // Crear una instancia del controlador
        $gestionJustiProfe = new gestionJustiProfe();
        $gestionJustiProfe->mostrarJustificantesProfesor($idProf); // Pasar el ID del profesor a la función
        
        // Verificar si 'idJusti' está presente en la URL para mostrar los detalles
        if (isset($_GET['idJusti'])) {
            $idJusti = $_GET['idJusti']; // Obtiene el valor de 'idJusti' desde la URL

            // Llamar a la función para mostrar los detalles del justificante
            $gestionJustiProfe->mostrarDetallesJustificante($idJusti);
        }
        ?>
        
        <?php
        // Si hay justificantes, mostrarlos
        if ($gestionJustiProfe) {
            foreach ($gestionJustiProfe as $justificante) {
                echo "<div class='justificante-item'>";
                echo "<p><strong>Justificante #" . htmlspecialchars($justificante['idJusti']) . "</strong></p>";
                echo "<p>Motivo: " . htmlspecialchars($justificante['motivo']) . "</p>";
                echo "<p><a href='detalleJustificante.php?idJusti=" . htmlspecialchars($justificante['idJusti']) . "'>Ver detalles</a></p>";
                echo "</div>";
            }
        } else {
            echo "<p>No tienes justificantes pendientes.</p>";
        }
        ?>
    </div>

</body>
</html>
