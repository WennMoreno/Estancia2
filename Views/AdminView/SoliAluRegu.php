<?php 
include '../../Model/Conexion.php'; 
include '../../Model/Justificante.php'; 

// Obtener todas las solicitudes pendientes con el nombre del alumno
    $modeloJusti= new Justificante($conexion);
    $result= $modeloJusti->justiPendiente();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Solicitudes Pendientes</title>
    <!-- Vincular el archivo CSS -->
    <link rel="stylesheet" href="../../Resources/CSS/styleAdminConsul.css">
</head>
<body>
<header>
        <div class="logo">
            <img src="../../Resources/img/logo.png" alt="Logo">
        </div>
        <nav>
            <a href="InicioAdmin.php " class="cerrar">Regresar</a>
        </nav>
    </header>

    <div class="container">
    <div class="sidebar">
        <h2>Solicitudes Pendientes</h2>

        <?php
        // Mostrar la lista de solicitudes
        while ($row = mysqli_fetch_assoc($result)) {
            echo '<div class="solicitud-item" data-id="' . $row['idJusti'] . '">';
            echo '<strong>' . $row['nombreAlu'] . ' ' . $row['apellidoAlu'] . '</strong><br>';
            echo '<small>' . $row['fecha'] . ' | ' . $row['horaInicio'] . '</small><br>';
            echo '<span>' . $row['motivo'] . '</span>';
            echo '</div>';
        }
        ?>
    </div>

    <div class="content">
        <h2>Detalles de la Solicitud</h2>
        <div id="detallesSolicitud">
            <p>Seleccione una solicitud para ver más detalles.</p>
        </div>
    </div>
</div>

<!-- Vincular el archivo JS -->
<script src="/pruebasOfAllVerDul/Controller/Js/aceptarSoli.js"></script>


</body>
</html>
