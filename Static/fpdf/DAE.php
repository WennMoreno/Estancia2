<?php
// Ocultar advertencias
error_reporting(E_ERROR | E_PARSE);

// Incluir FPDF
require_once('fpdf.php');

// Conectar a la base de datos
$host = 'localhost';
$usuario = 'root';
$clave = '';
$baseDeDatos = 'gestion_justificantes';

$conexion = mysqli_connect($host, $usuario, $clave, $baseDeDatos);

if (!$conexion) {
    die("Conexión fallida: " . mysqli_connect_error());
}

// Configuración de caracteres y formato de tiempo en español
mysqli_set_charset($conexion, "utf8");
mysqli_query($conexion, "SET lc_time_names = 'es_ES'");

// Obtener el idJustiEvento desde la URL
if (isset($_GET['evento'])) {
   $idJustiEvento = intval($_GET['evento']);  // Asegurarse de que es un número entero
  
   // Realizar la consulta para obtener los datos del evento y alumnos
   $queryEvento = "
   SELECT e.nombreEvento, e.fechaInicio, e.fechaFin 
   FROM justificante_evento e 
   WHERE e.idJustiEvento = $idJustiEvento";
   
   $queryAlumnos = "
   SELECT a.nombreAlumno, a.matricula, a.grado, a.grupo, a.carrera 
   FROM justificante_evento_alumno a 
   WHERE a.idJustiEvento = $idJustiEvento";

   $resultEvento = mysqli_query($conexion, $queryEvento);
   $resultAlumnos = mysqli_query($conexion, $queryAlumnos);

   if ($resultEvento && mysqli_num_rows($resultEvento) > 0) {
       $evento = mysqli_fetch_assoc($resultEvento);

       // Nombre y ruta del archivo PDF
       $nombrePdf = "UPEMOR_IIF-IET_{$idJustiEvento}_DIRECCION_DE_DESARROLLO_ACADEMICO.pdf";
       $directorio = "C:\Users\moren\OneDrive\Desktop\Justificantes\2025";

       // Crear el directorio si no existe
       if (!file_exists($directorio)) {
           mkdir($directorio, 0777, true);
       }

       $rutaPdf = "$directorio\\$nombrePdf";

       // Crear el directorio si no existe
       if (!file_exists($directorio)) {
           mkdir($directorio, 0777, true);
       }

       // Ruta completa del archivo PDF
       $rutaPdf = "$directorio\\$nombrePdf";

        // Clase para el PDF
        class PDF extends FPDF
        {
            private $evento;
            private $alumnos;

            function __construct($evento, $alumnos)
            {
                parent::__construct();
                $this->evento = $evento;
                $this->alumnos = $alumnos;
            }

            function Header()
            {
                $formatter = new IntlDateFormatter('es_ES', IntlDateFormatter::LONG, IntlDateFormatter::NONE);
                $fechaActual = $formatter->format(time());

                $this->Image('UPE.jpg', 90, 7, 50);
                $this->SetFont('Arial', 'B', 19);
                $this->Cell(45);
                $this->Cell(110, 15, '', 0, 1, 'C');
                $this->Ln(30);
                $this->SetTextColor(0, 0, 0);
                $this->Cell(110);
                $this->SetFont('Arial', '', 10);
                $this->Cell(96, 10, utf8_decode("Jiutepec, Mor. A {$fechaActual}"), 0, 0);
                $this->Ln(15);
                $this->Cell(10);
                $this->SetFont('Arial', 'B', 10);
                $this->Cell(0, 10, utf8_decode("PROFESORES DE DIRECCIÓN ACADÉMICA ITI-IET"), 0, 0);
                $this->Ln(5);
                $this->Cell(10);
                $this->SetFont('Arial', 'B', 10);
                $this->Cell(0, 10, "P R E S E N T E", 0, 0);
                $this->Ln(15);
            }

            function Body()
            {
                $this->SetFont('Arial', '', 10);
                $this->MultiCell(0, 10, utf8_decode("Solicitamos su valioso apoyo para justificar la inasistencia y diferir actividades y evaluaciones de los alumnos relacionados a continuación. Estas inasistencias que se generaron el dia "), 0, 'L');
                $this->Ln(5);

                // Mostrar fechas según disponibilidad
                $this->SetFont('Arial', 'B', 10); // Poner en negrita
                if (!empty($this->evento['fechaFin'])) {
                    // Mostrar fecha de inicio y fin si ambas están disponibles
                    $this->MultiCell(0, 10, utf8_decode("Fecha y horarios: {$this->evento['fechaInicio']} al {$this->evento['fechaFin']}"), 0, 'L');
                } else {
                    // Mostrar solo la fecha de inicio si fechaFin está vacía
                    $this->MultiCell(0, 10, utf8_decode("Fecha y horarios: {$this->evento['fechaInicio']}"), 0, 'L');
                }
                $this->SetFont('Arial', 'B', 10); // Poner en negrita
                $this->MultiCell(0, 10, utf8_decode("Motivo: {$this->evento['nombreEvento']}"), 0, 'L'); // Título

                // Tabla de alumnos
                $this->SetFont('Arial', 'B', 10);
                $this->SetFillColor(200, 200, 200); // Fondo gris claro
                $this->SetTextColor(0, 0, 0); // Texto negro
                $this->SetDrawColor(0); // Bordes negros
                $this->SetLineWidth(0.3);

                $this->Cell(40, 10, 'Nombre', 1, 0, 'C', true);
                $this->Cell(30, 10, 'Matrícula', 1, 0, 'C', true);
                $this->Cell(20, 10, 'Grado', 1, 0, 'C', true);
                $this->Cell(20, 10, 'Grupo', 1, 0, 'C', true);
                $this->Cell(50, 10, 'Carrera', 1, 0, 'C', true);
                $this->Ln();

                $this->SetFont('Arial', '', 10);
                $this->SetFillColor(245, 245, 245); // Fondo gris claro para las filas alternas
                $fill = false;

                foreach ($this->alumnos as $alumno) {
                    $this->Cell(40, 10, utf8_decode($alumno['nombreAlumno']), 1, 0, 'C', $fill);
                    $this->Cell(30, 10, utf8_decode($alumno['matricula']), 1, 0, 'C', $fill);
                    $this->Cell(20, 10, utf8_decode($alumno['grado']), 1, 0, 'C', $fill);
                    $this->Cell(20, 10, utf8_decode($alumno['grupo']), 1, 0, 'C', $fill);
                    $this->Cell(50, 10, utf8_decode($alumno['carrera']), 1, 0, 'C', $fill);
                    $this->Ln();
                    $fill = !$fill;
                }

                $this->SetFont('Arial', '', 10);
                $this->Ln(5);
                $this->MultiCell(0, 10, utf8_decode("Esperamos contar con su apoyo para la continuación del proceso académico."), 0, 'L');
                $this->Ln(20);
                $this->SetFont('Arial', '', 10);
                $this->Cell(0, 10, utf8_decode("A T E N T A M E N T E"), 0, 1, 'C');
                $this->Ln(7);
                $this->SetFont('Arial', 'B', 10);
                $this->Cell(0, 10, "MARIA FERNANDA DIAZ AYALA", 0, 1, 'C');
                $this->Cell(0, 10, "___________________________________", 0, 1, 'C');
                $this->Ln(0.5);
                $this->SetFont('Arial', '', 10);
                $this->Cell(0, 10, utf8_decode("DRA. MARIA FERNANDA DIAZ AYALA"), 0, 1, 'C');
                $this->Cell(0, 10, utf8_decode("DIRECTORA ACADÉMICA ITI-IET"), 0, 1, 'C');
            }
        }

        $pdf = new PDF($evento, $resultAlumnos);
        $pdf->AddPage();
        $pdf->Body();
        $pdf->Output('F', $rutaPdf);
        //echo "El archivo PDF se ha generado con éxito.<br>";
        echo "<a href='javascript:void(0);' onclick='confirmDownload()'>Haga clic aquí para descargar el archivo PDF</a>";
    } else {
        echo "No se encontró el evento.";
    }
} else {
    echo "No se ha proporcionado el parámetro idJustiEvento.";
}

mysqli_close($conexion);
?>

<script>
    function confirmDownload() {
        if (confirm("¿Estás seguro de que deseas descargar el archivo?")) {
            window.location.href = "<?php echo $rutaPdf; ?>";
        }
    }
</script>
