<?php
    include '../../Controller/GestionJustificantes.php'; 
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Generar Justificante de Evento</title>
    <link rel="stylesheet" href="../../Resources/CSS/styleSoliOtros.css">
    
</head>
<body>

<form method="POST">
<h2>Generar Justificante de Evento</h2>
    <label for="evento">Nombre del Evento:</label>
    <input type="text" id="evento" name="evento" required>

    <h3>¿El Evento Duró Varios Días?</h3>
    <label for="duracion">Duración del Evento:</label>
    <input type="radio" id="si" name="duracion" value="si" onclick="mostrarRangoFechas()" required> Sí
    <input type="radio" id="no" name="duracion" value="no" onclick="ocultarRangoFechas()" checked> No

    <!-- Contenedor para una sola fecha del evento -->
    <div id="fechaEvento" style="display:block;">
        <label for="fecha">Fecha del Evento:</label>
        <input type="date" id="fecha" name="fecha">
    </div>

    <!-- Contenedor para rango de fechas -->
    <div id="rangoFechas" style="display:none;">
        <label for="fechaInicio">Fecha de Inicio:</label>
        <input type="date" id="fechaInicio" name="fechaInicio">

        <label for="fechaFin">Fecha de Fin:</label>
        <input type="date" id="fechaFin" name="fechaFin">
    </div>

    <h3>Datos de los Alumnos</h3>
    <div id="alumnos-container">
        <div class="alumno-entry">
            <input type="text" name="nombreAlu[]" placeholder="Nombre del Alumno" required>
            <input type="text" name="matricula[]" placeholder="Matrícula" required>
            <input type="text" name="grado[]" placeholder="Grado" required>
            <input type="text" name="grupo[]" placeholder="Grupo" required>
            <input type="text" name="carrera[]" placeholder="Carrera" required>
            <button type="button" onclick="eliminarAlumno(this)">Eliminar</button>
        </div>
    </div>

    <button type="button" onclick="agregarAlumno()">Agregar Alumno</button>
    <button type="submit">Generar Justificante</button>
    <script src="../../Controller/Js/agregarAluJusti.js"></script> 
</form>

<?php
            $gestionJustificante = new gestionJustificante($conexion);
                    
            //si se mando el formulario, se manda a llamar la función que incerta los justificantes
            if ($_SERVER["REQUEST_METHOD"] === "POST") {
                $gestionJustificante->JustiDAE(); // Llama a la función 
            }
        ?>



</body>
</html>
