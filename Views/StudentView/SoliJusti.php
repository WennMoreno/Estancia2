<?php 
    include '../../Model/Motivo.php';
    include '../../Controller/GestionJustificantes.php'; 
    session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Solicitar Justificante</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../Resources/CSS/styleSolicitar.css">
    <script src="../../Controller/Js/mostrarPreg.js"></script> 
    <script src="../../Controller/Js/validarCampos.js"></script> 
    
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
            <h1>Solicitar Justificante</h1>
        </header>

        <form class="formulario" action="" method="POST" enctype="multipart/form-data" >
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
                <input type="number" name="Cuatri" id="Cuatri" placeholder="Cuatrimestre" min="1" max="10" >
            </div>
            <p class="alert alert-danger" id="errorCuatri" style="display:none;">Ingresa un cuatrimestre valido.</p>

            <div>
                <label>Grupo:</label>
                <input type="text" name="Grupo" id="Grupo" placeholder="Grupo" pattern="[A-Za-z]+" title="Solo se permiten letras" required>
            </div>
            <p class="alert alert-danger" id="errorGrupo" style="display:none;">Ingresa un grupo valido.</p>

            <div>
                <label for="Carrera">Carrera:</label>
                <select name="Carrera" id="Carrera" required>
                    <option value="" disabled selected>Selecciona tu carrera</option>
                    <option value="ITI">ITI</option>
                    <option value="IET">IET</option>
                </select>
            </div> 
            <p class="alert alert-danger" id="errorCarrera" style="display:none;">Selecciona una carrera.</p>

            <div>
                <label for="Periodo">Período:</label>
                <select name="peri" id="peri" required>
                    <option value="" disabled selected>Selecciona el Período</option>
                    <option value="Otoño 2025">Otoño 2025</option>
                    <option value="Invierno 2025">Invierno 2025</option>
                    <option value="Primavera 2025">Primavera 2025</option>
                </select>
            </div>
            <p class="alert alert-danger" id="errorPeriodo" style="display:none;">Selecciona un período.</p>

            <?php
            // Crear una nueva instancia y luego llamar al método
            $motivo = new Motivo($conexion);
            $motivos = $motivo->obtenerMotivos($conexion);

            ?>
            <label for="motivo">Motivo:</label>
            <select id="motivo" name="opciones" required>
            <option value="" disabled selected>Selecciona un motivo</option>
            <?php
                if (!empty($motivos)) {
                    foreach ($motivos as $motivo) {
                        echo '<option value="' . htmlspecialchars($motivo['tipo']) . '">' . htmlspecialchars($motivo['tipo']) . '</option>';
                    }
                } else {
                    echo '<option value="">No hay motivos disponibles</option>';
                }
                ?>
            </select>
            <p class="alert alert-danger" id="errorMotivo" style="display:none;">Selecciona un motivo.</p>

            <label>¿Te ausentaste todo el día?</label><br>
            <input type="radio" id="si" name="info" value="si" onclick="mostrarPreguntas()" required>
            <label for="si">Sí</label><br>
            <p class="alert alert-danger" id="errorAusente" style="display:none;">Selecciona una opción.</p>

            <input type="radio" id="no" name="info" value="no" onclick="mostrarPreguntas()" required>
            <label for="no">No</label><br>

            <!-- Preguntas adicionales si selecciona "Sí" -->
            <div id="preguntasAdicionales" class="hidden">
                <h3>Por favor, selecciona la fecha y los profesores con los que tuviste clase:</h3>
                <label for="fecha" required>Fecha:</label>
                <input type="date" name="fecha" id="fecha">
                <p class="alert alert-danger" id="errorFecha" style="display:none;">Ingresa una fecha válida.</p>

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
                <p class="alert alert-danger" id="errorProfesores" style="display:none;">Selecciona los profesores.</p>
            </div>

            <!-- Campos para fecha y hora si selecciona "No" -->
            <div id="calendarioHora" class="hidden" >
                <h3>Por favor, selecciona la fecha y hora:</h3>
                <label for="fecha2" required>Fecha:</label>
                <input type="date" id="fecha2" name="fecha2"><br>
                <p class="alert alert-danger" id="errorFecha2" style="display:none;">Ingresa una fecha válida.</p>

                <label for="hora" required>Hora inicio:</label>
                <input type="time" id="hora" name="hora" min="07:00" max="21:00"><br>

                <label for="horaFinal" required>Hora Final:</label>
                <input type="time" id="horaFinal" name="horaFinal" min="07:00" max="21:00">
                <p class="alert alert-danger" id="errorHora" style="display:none;">Ingresa una hora válida.</p>

            </div>

            <label for="evidencia" required>Sube una evidencia (imagen o PDF):</label>
            <input type="file" name="evidencia" accept=".jpg, .jpeg, .png, .pdf">

            <div class="botones">
                <button type="submit" class="btn-solicitar" onclick= "return validacionesFormu();" >Solicitar</button>
                <button type="button" class="btn-regresar"><a href="InicioAlumno.php">Regresar</button>
            </div>
            <p class="alert alert-danger" id="errorEvidencia" style="display:none;">Inserta una evidencia válida.</p>

        </form>

        <?php
            $gestionJustificante = new gestionJustificante($conexion);
                    
            //si se mando el formulario, se manda a llamar la función que incerta los justificantes
            if ($_SERVER["REQUEST_METHOD"] === "POST") { 

                /* Muestra todo el contenido de $_POST para verificar los datos enviados
                echo "vista";
                echo "<pre>";
                print_r($_POST);
                echo "</pre>";*/
    
                $gestionJustificante->procesarJusti(); // Llama a la función 
            }
        ?>

    </div>
</body>
</html>
