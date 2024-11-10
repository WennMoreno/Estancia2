<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start(); // Solo se inicia si no hay una sesión activa
}

include_once '../../Controller/GestionJustiProfe.php';
include '../../Model/Conexion.php';

if (isset($_SESSION['identificador'])) {
    $idProf = $_SESSION['identificador'];
    echo $idProf; 

    $gestionJustiProfe = new gestionJustiProfe($conexion); // Instancia del controlador
    // Obtén los justificantes relacionados con el profesor
    $justificantes = $gestionJustiProfe->mostrarJustificantesPorProfesor($idProf);
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
        <a href="../CerrarSesion.php" class="btn-cerrar-sesion">Cerrar Sesión</a>
    </div>

    <div class="container">
        <!-- Panel de resumen de justificantes -->
        <div class="summary-panel">
            <h2>Justificantes</h2>
            <ul>
                <?php foreach ($justificantes as $justificante): ?>
                    <!-- Cada elemento tiene un botón para ver detalles -->
                    <li>
                        <span><?= $justificante['fecha']; ?></span>
                        <span><?= $justificante['motivo']; ?></span>
                        <span><?= $justificante['estado']; ?></span>
                        <!-- Formulario oculto para enviar el ID del justificante -->
                        <form method="post" action="InicioProfesor.php">
                            <input type="hidden" name="idJusti" value="<?= $justificante['idJusti']; ?>">
                            <button type="submit" name="verDetalles">Ver Detalles</button>
                        </form>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>

        <!-- Panel de detalles del justificante -->
        <div class="details-panel">
            <h2>Detalles del Justificante</h2>
            <?php
            // Mostrar detalles si se ha seleccionado un justificante
            if (isset($_POST['verDetalles'])) {
                $idJusti = $_POST['idJusti'];
                $detallesJustificante = $gestionJustiProfe->mostrarDetallesJustificante($idJusti);
                if ($detallesJustificante) {
                    echo "<h3>Motivo: " . $detallesJustificante['motivo'] . "</h3>";
                    echo "<p><strong>Fecha:</strong> " . $detallesJustificante['fecha'] . "</p>";
                    echo "<p><strong>Estado:</strong> " . $detallesJustificante['estado'] . "</p>";
                    echo "<p><strong>Motivo Extra:</strong> " . $detallesJustificante['motivoExtra'] . "</p>";
                    echo "<a href='" . $detallesJustificante['rutaPdf'] . "' target='_blank'>Ver PDF</a>";
                } else {
                    echo "<p>No se encontraron detalles para este justificante.</p>";
                }
            } else {
                echo "<p>Selecciona un justificante para ver los detalles.</p>";
            }
            ?>
        </div>
    </div>
</body>
</html>
