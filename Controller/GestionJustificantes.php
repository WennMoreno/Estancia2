<?php
include '../../Model/Conexion.php';
include '../../Model/Justificante.php';
include '../../Model/Evidencia.php';
include '../../Model/Profesor.php';
include '../../Model/Justi_Profe.php';
include '../../Model/Alumno.php';
include '../../Model/JustiEvento.php';

class gestionJustificante {
    private $conexion;

    public function __construct($conexion) {
        $this->conexion = $conexion;
    }

    public function mostrarJustiAlum($id) {
        $modeloJustificante = new Justificante($this->conexion);
        return $modeloJustificante->getJustificantesPorAlumno($id);
    }

    public function procesarJusti(){
        /*Mostrar los datos enviados y los archivos subidos*/
        echo "Controlador";
        echo '<pre>';
        print_r($_POST); // Ver todos los datos del formulario
        print_r($_FILES); // Ver la información del archivo subido
        echo '</pre>';

        // Procesar datos del formulario
        $cuatrimestre = $_POST['Cuatri'];
        $grupo = $_POST['Grupo'];
        $carrera = $_POST['Carrera'];
        $periodo = $_POST['peri'];
        $motivo = $_POST['opciones'];
        $ausenteTodoDia =  $_POST['info'] == "si" ? true : false;
        $fecha = $ausenteTodoDia ? $_POST['fecha'] : $_POST['fecha2'];
        $horaInicio = $_POST['hora'];
        $horaFin = $_POST['horaFinal'];
        $motivoExtra = "No aplica";

        $modeloAlumno= new Alumno($this->conexion);
        $idAlumno = $modeloAlumno->obtenerIdAlumnoPorMatricula($this->conexion);
        if ($idAlumno !== null) {
            echo "El ID del alumno en sesión es: " . $idAlumno;
        } else {
            echo "No se encontró un alumno con la matrícula proporcionada.";
        }

        $rutaEstatica = "C:/wamp64/www/pruebasOfAllVerDul/proyEstancia2"; 

        if (isset($_FILES['evidencia']) && $_FILES['evidencia']['error'] == UPLOAD_ERR_OK) {
            // Manejar la subida de la evidencia
            $nombreArchivo = $_FILES['evidencia']['name'];
            $rutaArchivo = $rutaEstatica . "/" . basename($nombreArchivo);
            $tipoArchivo = strtolower(pathinfo($rutaArchivo, PATHINFO_EXTENSION));
    
            // Verificar el tipo de archivo (imagen o PDF)
            $tiposPermitidos = array("jpg", "jpeg", "png", "pdf");
            if (!in_array($tipoArchivo, $tiposPermitidos)) {
                die("Error: Solo se permiten archivos JPG, JPEG, PNG, y PDF.");
            }
    
            // Verificar el tamaño del archivo
            $tamañoArchivo = $_FILES['evidencia']['size'];
            if ($tamañoArchivo > 1024 * 1024 * 5) { // 5MB
                die("Error: El archivo es demasiado grande.");
            }
    
            // Verificar si el archivo es una imagen
            if (in_array($tipoArchivo, array("jpg", "jpeg", "png"))) {
                $imagen = getimagesize($_FILES['evidencia']['tmp_name']);
                if (!$imagen) {
                    die("Error: El archivo no es una imagen válida.");
                }
            }

            // Intentar mover el archivo subido a la carpeta de destino
            if (move_uploaded_file($_FILES['evidencia']['tmp_name'], $rutaArchivo)) {
                echo "El archivo se ha subido exitosamente.";
                // Instanciar modelos
                $modeloEvidencia = new Evidencia($this->conexion);
                $modeloJustificante = new Justificante($this->conexion);
                $modeloJustificanteProfesor = new JustificanteProfesor($this->conexion); 
                $modeloProfesor = new Profesor($this->conexion); 

                $stmtEvidencia= $modeloEvidencia->insertarEvidencia($nombreArchivo, $rutaArchivo);
                $stmtEvidencia->bind_param("ss", $nombreArchivo, $rutaArchivo);
                $stmtEvidencia->execute();
                $idEvi = $this->conexion->insert_id; // Obtener el ID de la evidencia insertada


                // Insertar justificante
                $idJusti =$modeloJustificante->insertarJustificante($cuatrimestre, $grupo, $carrera, $periodo, $motivo, $fecha, $horaInicio, $horaFin, $ausenteTodoDia, $motivoExtra, $idEvi, $idAlumno);  

                if ($idJusti) {
                    echo "Justificante solicitado exitosamente con ID: $idJusti";
                } else {
                    echo "Hubo un problema al solicitar el justificante.";
                }

                // Si el estudiante faltó todo el día, insertar los profesores seleccionados en `justificante_profesor`
                if ($ausenteTodoDia && !empty($_POST['profesores'])) {
                    foreach ($_POST['profesores'] as $nombreProfesor) {
                    // Obtener el ID del profesor seleccionado
                        $idProfesor=$modeloProfesor->obtenerIdProfesor($nombreProfesor);
                        
                        if ($idProfesor !== null) {
                            // Si el ID del profesor es válido, procede con la inserción
                            $stmtJustificanteProfesor = $modeloJustificanteProfesor->insertarJustificanteProfesor($idJusti, $idProfesor); 
                            $stmtJustificanteProfesor->bind_param("ii", $idJusti, $idProfesor);
                            $stmtJustificanteProfesor->execute();
                        } else {
                            echo "No se encontró el profesor con el nombre proporcionado.";
                        }
                    }
                }
                echo "Justificante solicitado exitosamente.";
            } else {
                echo "Error al mover el archivo. Verifica la ruta de destino y permisos.";
            }

        } else {
            echo "Error en la subida del archivo. Código de error: " . $_FILES['evidencia']['error'];
        }
    }

    public function procesarOtroJusti(){
       /*Mostrar los datos enviados y los archivos subidos*/
       echo "Controlador";
       echo '<pre>';
       print_r($_POST); // Ver todos los datos del formulario
       print_r($_FILES); // Ver la información del archivo subido
       echo '</pre>';

        // Procesar datos del formulario
        $cuatrimestre = $_POST['Cuatri'];
        $grupo = $_POST['Grupo'];
        $carrera = $_POST['Carrera'];
        $periodo = $_POST['peri'];
        $motivo = "No aplica";
        $ausenteTodoDia =  $_POST['info'] == "si" ? true : false;
        $fecha = $ausenteTodoDia ? $_POST['fecha'] : $_POST['fecha2'];
        $horaInicio = $_POST['hora'];
        $horaFin = $_POST['horaFinal'];
        $motivoExtra = $_POST['otroMotivo'];

        // obtenerl el id del alumno mediante la selección del alumno en el perfil del administrador
        $idAlumno = $_GET['idAlumno']; 
        if ($idAlumno !== null) {
            echo "El ID del alumno seleccionado es: " . $idAlumno;
        } else {
            echo "No se encontró un alumno con el nombre proporcionado.";
        }

        $rutaEstatica = "C:/wamp64/www/pruebasOfAllVerDul/proyEstancia2"; 

        if (isset($_FILES['evidencia']) && $_FILES['evidencia']['error'] == UPLOAD_ERR_OK) {
            // Manejar la subida de la evidencia
            $nombreArchivo = $_FILES['evidencia']['name'];
            $rutaArchivo = $rutaEstatica . "/" . basename($nombreArchivo);
            $tipoArchivo = strtolower(pathinfo($rutaArchivo, PATHINFO_EXTENSION));
    
            // Verificar el tipo de archivo (imagen o PDF)
            $tiposPermitidos = array("jpg", "jpeg", "png", "pdf");
            if (!in_array($tipoArchivo, $tiposPermitidos)) {
                die("Error: Solo se permiten archivos JPG, JPEG, PNG, y PDF.");
            }
    
            // Verificar el tamaño del archivo
            $tamañoArchivo = $_FILES['evidencia']['size'];
            if ($tamañoArchivo > 1024 * 1024 * 5) { // 5MB EN CUANTO TAMAÑO
                die("Error: El archivo es demasiado grande.");
            }
    
            // Verificar si el archivo es una imagen
            if (in_array($tipoArchivo, array("jpg", "jpeg", "png"))) {
                $imagen = getimagesize($_FILES['evidencia']['tmp_name']);
                if (!$imagen) {
                    die("Error: El archivo no es una imagen válida.");
                }
            }

            // Intentar mover el archivo subido a la carpeta de destino
            if (move_uploaded_file($_FILES['evidencia']['tmp_name'], $rutaArchivo)) {
                echo "El archivo se ha subido exitosamente.";
                // Instanciar modelos
                $modeloEvidencia = new Evidencia($this->conexion);
                $modeloJustificante = new Justificante($this->conexion);
                $modeloJustificanteProfesor = new JustificanteProfesor($this->conexion); 
                $modeloProfesor = new Profesor($this->conexion); 

                $stmtEvidencia= $modeloEvidencia->insertarEvidencia($nombreArchivo, $rutaArchivo);
                $stmtEvidencia->bind_param("ss", $nombreArchivo, $rutaArchivo);
                $stmtEvidencia->execute();
                $idEvi = $this->conexion->insert_id; // Obtener el ID de la evidencia insertada


                // Insertar justificante
                $idJusti =$modeloJustificante->insertarJustificante($cuatrimestre, $grupo, $carrera, $periodo, $motivo, $fecha, $horaInicio, $horaFin, $ausenteTodoDia, $motivoExtra, $idEvi, $idAlumno);  

                if ($idJusti) {
                    echo "Justificante solicitado exitosamente con ID: $idJusti";
                } else {
                    echo "Hubo un problema al solicitar el justificante.";
                }

                // Si el estudiante faltó todo el día, insertar los profesores seleccionados en `justificante_profesor`
                if ($ausenteTodoDia && !empty($_POST['profesores'])) {
                    foreach ($_POST['profesores'] as $nombreProfesor) {
                    // Obtener el ID del profesor seleccionado
                        $idProfesor=$modeloProfesor->obtenerIdProfesor($nombreProfesor);
                        
                        if ($idProfesor !== null) {
                            // Si el ID del profesor es válido, procede con la inserción
                            $stmtJustificanteProfesor = $modeloJustificanteProfesor->insertarJustificanteProfesor($idJusti, $idProfesor); 
                            $stmtJustificanteProfesor->bind_param("ii", $idJusti, $idProfesor);
                            $stmtJustificanteProfesor->execute();
                        } else {
                            echo "No se encontró el profesor con el nombre proporcionado.";
                        }
                    }
                }
                echo "Justificante solicitado exitosamente.";
            } else {
                echo "Error al mover el archivo. Verifica la ruta de destino y permisos.";
            }

        } else {
            echo "Error en la subida del archivo. Código de error: " . $_FILES['evidencia']['error'];
        }
    } 

    public function JustiDAE() {
        // Crear instancia del modelo JustificanteEvento
        $justificanteEvento = new JustificanteEvento($this->conexion);
    
        // Recoger datos del formulario
        $nombreEvento = $_POST['evento'];
        $duracion = $_POST['duracion'];
        
        // Definir variables de fecha según la duración del evento
        if ($duracion === 'si') {
            // Si el evento duró varios días, obtener las fechas de inicio y fin
            $fechaInicio = $_POST['fechaInicio'];
            $fechaFin = $_POST['fechaFin'];
        } else {
            // Si el evento es de un solo día, usar solo `fechaInicio` y dejar `fechaFin` en null
            $fechaInicio = $_POST['fecha'];
            $fechaFin = "No aplica";
        }
    
        // Insertar el evento en la base de datos y obtener el ID del evento
        $idJustiEvento = $justificanteEvento->insertarEvento($nombreEvento, $fechaInicio, $fechaFin);
    
        if ($idJustiEvento) {
            // Insertar los datos de los alumnos asociados al evento en la tabla justificante_evento_alumno
            if (!empty($_POST['nombreAlu'])) {
                foreach ($_POST['nombreAlu'] as $index => $nombreAlu) {
                    $matricula = $_POST['matricula'][$index];
                    $grado = $_POST['grado'][$index];
                    $grupo = $_POST['grupo'][$index];
                    $carrera = $_POST['carrera'][$index];
    
                    // Llamar al método para insertar el alumno en el evento
                    $justificanteEvento->insertarAlumnoEnEvento($nombreAlu, $matricula, $grado, $grupo, $carrera, $idJustiEvento);
                }
            }
    
            echo "Justificante de evento generado exitosamente.";
        } else {
            echo "Error al generar el justificante del evento.";
        }
    }
    
    public function mostrarJustificantesEventos() {
        // Crear instancia del modelo JustificanteEvento
        $justificanteEvento = new JustificanteEvento($this->conexion);
    
        // Obtener justificantes de eventos
        $eventos = $justificanteEvento->obtenerJustificantesEventos();
        return $eventos;
    }
    
    public function editarEvento($eventoId, $nombreEvento, $fechaInicio, $fechaFin, $alumnos) {
        $justificanteEvento = new JustificanteEvento($this->conexion); 

        $justificanteEvento->editarEventoCompleto($eventoId, $nombreEvento, $fechaInicio, $fechaFin, $alumnos);


    }

    public function obtenerEventoPorId($eventoId) {
        var_dump($eventoId); // Verifica que el ID esté llegando correctamente
        $justificanteEvento = new JustificanteEvento($this->conexion);
        $evento = $justificanteEvento->obtenerEvento($eventoId);
        var_dump($evento); // Verifica el contenido de $evento antes de devolverlo
        return $evento;
    }
    
    


}

?>
