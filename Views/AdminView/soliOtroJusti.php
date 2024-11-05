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

    <label for="fecha">Fecha del Evento:</label>
    <input type="date" id="fecha" name="fecha" required>

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
                $gestionJustificante->otrosJusti(); // Llama a la función 
            }
        ?>



</body>
</html>
