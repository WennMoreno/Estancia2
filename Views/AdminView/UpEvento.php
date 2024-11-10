<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Justificante de Evento</title>
    <link rel="stylesheet" href="../../Resources/CSS/styleJustiDAE.css">
    <script src="../../Controller/Js/agregarAluJusti.js"></script>
</head>
<body>

<header>
    <div class="logo">
        <img src="../../Resources/img/logo.png" alt="Logo">
    </div>
    <h1>Editar Justificante de Evento</h1>
    <nav class="back">
        <a href="JustificantesDAE.php " class="cerrar">Regresar</a>
    </nav>
</header>

<?php
    include '../../Controller/GestionJustificantes.php';
    include '../../Model/Conexion.php';

    $gestionJustificante = new gestionJustificante($conexion);
    $eventoId = $_GET['evento'] ?? null;
    $evento = $gestionJustificante->obtenerEventoPorId($eventoId);
    $fechaInicio = $evento['fechaInicio']; // Fecha de inicio
    $fechaFin = $evento['fechaFin']; // Fecha de fin
    $duracion = ($fechaFin && $fechaFin != '0000-00-00') ? 'si' : 'no'; // Determina si es "Sí" o "No" dependiendo de la fecha de fin
?>

<div>
    <form method="POST" action="">
        <h3>Editar Evento</h3>
        <label for="nombreEvento">Nombre del Evento:</label>
        <input type="text" id="nombreEvento" name="nombreEvento" value="<?php echo htmlspecialchars($evento['nombreEvento']); ?>" required>

        <h3>¿El Evento Duró Varios Días?</h3>
        <label for="duracion">Duración del Evento:</label>
        <input type="radio" id="si" name="duracion" value="si" onclick="mostrarRangoFechasUpdate()" <?php echo $duracion == 'si' ? 'checked' : ''; ?>> Sí
        <input type="radio" id="no" name="duracion" value="no" onclick="ocultarRangoFechasUpdate()" <?php echo $duracion == 'no' ? 'checked' : ''; ?>> No

        <!-- Contenedor para una sola fecha del evento -->
        <div id="fechaEvento" style="<?php echo $duracion == 'no' ? 'display:block;' : 'display:none;'; ?>">
            <label for="fecha">Fecha del Evento:</label>
            <input type="date" id="fecha" name="fecha" value="<?php echo htmlspecialchars($fechaInicio); ?>">
        </div>

        <!-- Contenedor para rango de fechas -->
        <div id="rangoFechas" style="<?php echo $duracion == 'si' ? 'display:block;' : 'display:none;'; ?>">
            <label for="fechaInicio">Fecha de Inicio:</label>
            <input type="date" id="fechaInicio" name="fechaInicio" value="<?php echo htmlspecialchars($fechaInicio); ?>">

            <label for="fechaFin">Fecha de Fin:</label>
            <input type="date" id="fechaFin" name="fechaFin" value="<?php echo htmlspecialchars($fechaFin); ?>">
        </div>

        <h4>Alumnos Asociados:</h4>
        <div id="alumnos-container">
            <?php foreach ($evento['alumnos'] as $index => $alumno): ?>
                <div class="alumno-entry">
                    <input type="text" name="alumnos[<?php echo $index; ?>][nombreAlumno]" placeholder="Nombre del Alumno" value="<?php echo htmlspecialchars($alumno['nombreAlumno']); ?>" required>
                    <input type="text" name="alumnos[<?php echo $index; ?>][matricula]" placeholder="Matrícula" value="<?php echo htmlspecialchars($alumno['matricula']); ?>" required>
                    <input type="text" name="alumnos[<?php echo $index; ?>][grado]" placeholder="Grado" value="<?php echo htmlspecialchars($alumno['grado']); ?>" required>
                    <input type="text" name="alumnos[<?php echo $index; ?>][grupo]" placeholder="Grupo" value="<?php echo htmlspecialchars($alumno['grupo']); ?>" required>
                    <input type="text" name="alumnos[<?php echo $index; ?>][carrera]" placeholder="Carrera" value="<?php echo htmlspecialchars($alumno['carrera']); ?>" required>
                    <button type="button" onclick="eliminarAlumno(this)">Eliminar Alumno</button>
                </div>
            <?php endforeach; ?>
        </div>
        <button type="button" onclick="agregarAlumnoUpdate()">Agregar Alumno</button>
        <button type="submit" name="guardar">Guardar Cambios</button>
    </form>
</div>

<?php
    if (isset($_POST['guardar'])) {
        $nombreEvento = $_POST['nombreEvento'];
        $duracion = $_POST['duracion']; // 'si' o 'no'
    
        if ($duracion == 'si') {
            // Si el evento dura varios días, capturamos el rango de fechas
            $fechaInicio = $_POST['fechaInicio'];
            $fechaFin = $_POST['fechaFin'];
            $fecha = null;  // No se usa la fecha única
        } else {
            // Si el evento dura solo un día, capturamos la fecha única
            $fecha = $_POST['fecha'];
            $fechaInicio = null; // No se usa el rango de fechas
            $fechaFin = null; // No se usa el rango de fechas
        }

        $alumnos = $_POST['alumnos'] ?? [];

        // Verificar si los datos de los alumnos están llegando correctamente
        var_dump($alumnos);

        $gestionJustificante->editarEvento($eventoId, $nombreEvento, $fechaInicio, $fechaFin, $alumnos);
    }
?>

</body>
</html>
