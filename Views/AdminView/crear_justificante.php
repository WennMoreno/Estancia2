<?php 
    include '../../Model/Motivo.php';
    include '../../Controller/GestionJustificantes.php'; 

    session_unset();
    // obtenerl el id del alumno mediante la selección del alumno en el perfil del administrador
    $idAlumno = $_GET['idAlumno']; 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Solicitar Justificante</title>
    <link rel="stylesheet" href="../../Resources/CSS/styleSolicitar.css">
    <script src="../../Controller/Js/mostrarPreg.js"></script> 

    <style>
        .hidden {
        display: none;
    }
    </style>

</head>

<body>
    <div class="container">
        <header>
            <img src="../../Resources/img/logo.png" alt="Logo" class="logo">
            <h1>Generar Justificante</h1>
        </header>

        <form class="formulario" action="" method="POST" enctype="multipart/form-data">
            <?php if(isset($_GET['error'])){ ?>
                <p class="error"><?php echo $_GET['error'] ?></p>
            <?php } ?>

            <br>

            <?php if(isset($_GET['success'])){ ?>
                <p class="success"><?php echo $_GET['success'] ?></p>
            <?php } ?> 
            

            <!-- Información del estudiante -->
            <div>
                <label>Cuatrimestre (Número):</label>
                <input type="number" name="Cuatri" placeholder="Cuatrimestre" required>
            </div>

            <div>
                <label>Grupo:</label>
                <input type="text" name="Grupo" placeholder="Grupo" required>
            </div>

            <div>
                <label for="Carrera">Carrera:</label>
                <select name="Carrera" id="Carrera">
                    <option value="" disabled selected>Selecciona tu carrera</option>
                    <option value="ITI">ITI</option>
                    <option value="IET">IET</option>
                </select>
            </div>

            <div>
                <label for="Periodo">Período:</label>
                <select name="peri" id="peri">
                    <option value="" disabled selected>Selecciona el Período</option>
                    <option value="Otoño 2025">Otoño 2025</option>
                    <option value="Invierno 2025">Invierno 2025</option>
                    <option value="Primavera 2025">Primavera 2025</option>
                </select>
            </div>

            <div>
                <label>Especifique el motivo:</label>
                <input type="text" id="otroMotivo" name="otroMotivo" placeholder="Ingrese el motivo aquí">
            </div>

            <label>¿El alumno de ausento todo el día?</label><br>
            <input type="radio" id="si" name="info" value="si" onclick="mostrarPreguntas()">
            <label for="si">Sí</label><br>

            <input type="radio" id="no" name="info" value="no" onclick="mostrarPreguntas()">
            <label for="no">No</label><br>

            <!-- Preguntas adicionales si selecciona "Sí" -->
            <div id="preguntasAdicionales" class="hidden">
                <h3>Por favor, selecciona la fecha y los profesores con los que el alumno tuvo clase:</h3>
                <label for="fecha">Fecha:</label>
                <input type="date" name="fecha" id="fecha">

                <?php
                    // Crear una nueva instancia y luego llamar al método
                $profesor = new Profesor($conexion);
                $profesores = $profesor->obtenerProfesores($conexion);
                ?>
                <div>
                <?php
                    if (!empty($profesores)) {
                        foreach ($profesores as $profesor) {
                            $nombreCompleto = $profesor['nombreProf'] . " " . $profesor['apellidoProf'];
                            echo "<input type='checkbox' name='profesores[]' value='$nombreCompleto'> $nombreCompleto <br>";
                        }
                    } else {
                        echo "No se encontraron profesores.";
                    }
                    ?>
                    </div>
            </div>

           <!-- Campos para fecha y hora si selecciona "No" -->
           <div id="calendarioHora" class="hidden">
                <h3>Por favor, selecciona la fecha y hora:</h3>
                <label for="fecha2">Fecha:</label>
                <input type="date" id="fecha2" name="fecha2"><br>

                <label for="hora">Hora inicio:</label>
                <input type="time" id="hora" name="hora" min="07:00" max="21:00"><br>

                <label for="horaFinal">Hora Final:</label>
                <input type="time" id="horaFinal" name="horaFinal" min="07:00" max="21:00">
            </div>

            <label for="evidencia">Sube una evidencia (imagen o PDF):</label>
            <input type="file" name="evidencia" accept=".jpg, .jpeg, .png, .pdf">

            <div class="botones">
                <button type="submit" class="btn-solicitar">Solicitar</button>
                <button type="button" class="btn-regresar"><a href="InicioAdmin.php">Regresar</button>
            </div>

        </form>

        <?php
            $gestionJustificante = new gestionJustificante($conexion);
                    
            //si se mando el formulario, se manda a llamar la función que incerta los justificantes
            if ($_SERVER["REQUEST_METHOD"] === "POST") {

                 //Muestra todo el contenido de $_POST para verificar los datos enviados
                echo "vista";
                echo "<pre>";
                print_r($_POST);
                echo "</pre>";
                $gestionJustificante->procesarOtroJusti(); // Llama a la función 
            }
        ?>

    </div>
</body>
</html>
