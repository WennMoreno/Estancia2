<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Justificantes de Eventos</title>
    <link rel="stylesheet" href="../../Resources/CSS/styleJustiDAE.css">
</head>
<body>

<header>
    <div class="logo">
        <img src="../../Resources/img/logo.png" alt="Logo">
    </div>
    <h1>Justificantes de Eventos</h1>
    <nav class="back">
        <a href="InicioAdmin.php " class="cerrar">Regresar</a>
    </nav>
</header>

<?php
// Incluir el archivo del controlador
include '../../Controller/GestionJustificantes.php';
include '../../Model/Conexion.php';

// Instanciar el controlador
$gestionJustificante = new gestionJustificante($conexion);

// Llamar al método del controlador para obtener los eventos
$eventos = $gestionJustificante->mostrarJustificantesEventos();

// Obtener el evento seleccionado de la URL (si existe)
$eventoSeleccionado = isset($_GET['evento']) ? $_GET['evento'] : null;
?>

<div class="container">
    <div class="sidebar">
        <!-- Lista de eventos -->
        <?php if (!empty($eventos)): ?>
            <?php foreach ($eventos as $idJustiEvento => $evento): ?>
                <div class="evento-item">
                    <a href="?evento=<?php echo $idJustiEvento; ?>">
                        <h3><?php echo htmlspecialchars($evento['nombreEvento']); ?></h3>
                        <p>Fecha de Inicio: <?php echo htmlspecialchars($evento['fechaInicio']); ?></p>
                    </a>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No hay eventos disponibles.</p>
        <?php endif; ?>
    </div>

    <div class="content">
        <!-- Detalles del evento seleccionado -->
        <?php if ($eventoSeleccionado !== null && isset($eventos[$eventoSeleccionado])): ?>
            <?php $evento = $eventos[$eventoSeleccionado]; ?>
            <div class="evento-detalle">
                <h3>Evento: <?php echo htmlspecialchars($evento['nombreEvento']); ?></h3>
                <p><strong>Fecha de Inicio:</strong> <?php echo htmlspecialchars($evento['fechaInicio']); ?></p>
                <p><strong>Fecha de Fin:</strong> <?php echo htmlspecialchars($evento['fechaFin'] ?: 'Evento de un solo día'); ?></p>
                
                <h4>Alumnos Asociados:</h4>
                <ul>
                    <?php foreach ($evento['alumnos'] as $alumno): ?>
                        <li>
                            Nombre: <?php echo htmlspecialchars($alumno['nombreAlumno']); ?>, 
                            Matrícula: <?php echo htmlspecialchars($alumno['matricula']); ?>, 
                            Grado: <?php echo htmlspecialchars($alumno['grado']); ?>, 
                            Grupo: <?php echo htmlspecialchars($alumno['grupo']); ?>, 
                            Carrera: <?php echo htmlspecialchars($alumno['carrera']); ?>
                        </li>
                    <?php endforeach; ?>
                </ul>

                <!-- Botón de edición -->
                <a href="UpEvento.php?evento=<?php echo $eventoSeleccionado; ?>" class="btn-editar">Editar Justificante del Evento</a>
            </div>
        <?php else: ?>
            <p>Selecciona un evento para ver los detalles.</p>
        <?php endif; ?>
    </div>
</div>


</body>
</html>
