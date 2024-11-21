<?php
// Iniciar sesión y verificar si el usuario está en sesión
session_start();
if (!isset($_SESSION['identificador'])) {
    header("Location: ../login.php");
    exit;
}

include '../../Model/Conexion.php';
include '../../Controller/GestionJustificantes.php';

// Obtener el id del alumno que está en la sesión
$modeloAlumno = new Alumno($conexion);
$idAlumno = $modeloAlumno->obtenerIdAlumnoPorMatricula($conexion);

// Obtener los justificantes del alumno en sesión
$gestionJustificante = new gestionJustificante($conexion);
$justificantes = $gestionJustificante->mostrarJustiAlum($idAlumno);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Solicitudes de Justificantes</title>
    <link rel="stylesheet" href="../../Resources/CSS/styleConsuJustAlum.css">
</head>
<body>
    <header>
        <div class="logo">
            <img src="../../Resources/img/logo.png" alt="Logo">
        </div>
        <nav>
            <a href="InicioAlumno.php" class="cerrar">Regresar</a>
        </nav>
    </header>

    <div class="container">
        <div class="sidebar">
            <h2>Mis Justificantes</h2>
            <?php if (!empty($justificantes)) : ?>
                <?php foreach ($justificantes as $justificante): ?>
                    <div class="solicitud-item" data-id="<?php echo $justificante['idJusti']; ?>">
                        <strong><?php echo htmlspecialchars($justificante['motivo']); ?></strong><br>
                        <small><?php echo htmlspecialchars($justificante['fecha']); ?> | <?php echo htmlspecialchars($justificante['horaInicio']); ?></small><br>
                        <span><?php echo htmlspecialchars($justificante['estado']); ?></span>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>No hay justificantes para este alumno.</p>
            <?php endif; ?>
        </div>

        <div class="content">
            <h2>Detalles de la Solicitud</h2>
            <div id="detallesSolicitud">
                <p>Seleccione una solicitud para ver más detalles.</p>
            </div>
        </div>
    </div>

    <script>
        // Función para mostrar los detalles de la solicitud cuando se hace clic
        const solicitudItems = document.querySelectorAll('.solicitud-item');
        solicitudItems.forEach(item => {
            item.addEventListener('click', function() {
                const solicitudId = this.getAttribute('data-id');

                // Quitar clase 'active' de cualquier solicitud previamente seleccionada
                solicitudItems.forEach(i => i.classList.remove('active'));
                this.classList.add('active');

                fetch('../../Controller/detallesSoli.php?id=' + solicitudId)
                .then(response => response.text()) 
                .then(html => {
                    const detallesDiv = document.getElementById('detallesSolicitud');
                    detallesDiv.innerHTML = html; 
                })
                .catch(error => {
                    console.error("Error al obtener los detalles:", error);
                    const detallesDiv = document.getElementById('detallesSolicitud');
                    detallesDiv.innerHTML = `<p>Error al cargar los detalles de la solicitud.</p>`;
                });
            });
        });
    </script>
</body>
</html>
