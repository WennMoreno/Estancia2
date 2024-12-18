<?php
// Ocultar advertencias
error_reporting(E_ERROR | E_PARSE);

// Incluir FPDF
require_once('fpdf.php');
require_once('consultas.php'); // Incluir el archivo de consultas

// Llamar a las consultas y obtener los datos
$data = include 'consultas.php';

if ($data) {
    $solicitud = $data['solicitud'];
    $secuencia = $data['secuencia'];
    $idSolicitud = $data['idSolicitud'];
    $conexion = $data['conexion'];

    // Definir el nombre y la ruta del archivo
    $matricula = $solicitud['matricula'];
    $nombrePdf = "UPEMOR_IIF-ITI_{$idSolicitud}_{$matricula}.pdf";
    $directorio = "C:\Users\Enrique\Desktop\Justificantes\\2025";
    
    if (!file_exists($directorio)) {
        mkdir($directorio, 0777, true);
    }
    $rutaPdf = "$directorio\\$nombrePdf";



    // Asegurarse de que la ruta del archivo sea correcta
    $rutaPdf = "$directorio/$nombrePdf";

    // Clase para el PDF
    class PDF extends FPDF
    {
        private $solicitud;

        function __construct($solicitud)
        {
            parent::__construct();
            $this->solicitud = $solicitud;
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
            $this->Ln(20);
            $this->Cell(10);
            $this->SetFont('Arial', 'B', 10);
            $this->Cell(59, 10, utf8_decode("PROFESORES DE DIRECCIÓN ACADÉMICA ITI-IET"), 0, 0);
            $this->Ln(5);
            $this->Cell(10);
            $this->SetFont('Arial', 'B', 10);
            $this->Cell(59, 10, "P R E S E N T E", 0, 0);
            $this->Ln(15);
            $this->Cell(10);
            $this->SetFont('Arial', '', 10);
            $this->Cell(59, 10, utf8_decode("Por medio de la presente, se notifica que el/la alumno(a) {$this->solicitud['nombre']} {$this->solicitud['ape']},"), 0, 0);
            $this->Ln(5);
            $this->Cell(10);
            $this->SetFont('Arial', '', 10);
            $this->Cell(85, 10, utf8_decode("inscrito(a) en el grupo {$this->solicitud['cuatrimestre']} {$this->solicitud['grupo']}, de la carrera {$this->solicitud['carrera']} con MATRICULA: {$this->solicitud['matricula']} no se presentó en el horario "), 0, 0);
            $this->Ln(5);
            $this->Cell(10);
            $this->SetFont('Arial', '', 10);
            $this->Cell(85, 10, utf8_decode("y día que se detallan a continuación, debido a la siguiente causa: {$this->solicitud['motivoFinal']}."), 0, 0);
            $this->Ln(25);
            $this->Cell(10);
            $this->SetFont('Arial', '', 10);

            $fecha = $this->solicitud['fecha'];
            $ausenteTodoDia = $this->solicitud['ausenteTodoDia'];
            $timestamp = strtotime($fecha);
            $mesYDia = $formatter->format($timestamp);

            if ($ausenteTodoDia == 1) {
                // Imprimir solo la fecha
                $this->Cell(85, 10, utf8_decode("Fecha: $mesYDia"), 0, 0);
                $this->Ln(5);
                $this->Cell(10);
                $this->SetFont('Arial', '', 10);
                $this->Cell(85, 10, utf8_decode("Se Ausento Todo el día"), 0, 0);
           
            } else {
                // Imprimir la fecha y el horario
                $this->Cell(85, 10, utf8_decode("Fecha: $mesYDia"), 0, 0);
                $this->Ln(5);
                $this->Cell(10);
                $this->SetFont('Arial', '', 10);
                $this->Cell(85, 10, utf8_decode("Horario: {$this->solicitud['horaInicio']} a {$this->solicitud['horaFin']}."), 0, 0);
            }

            $this->Ln(25);
            $this->Cell(10);
            $this->SetFont('Arial', '', 10);
            $this->Cell(85, 10, utf8_decode("De esta forma solicito de su apoyo para que el alumno(a) entregue trabajos y/o exámenes que "), 0, 0);
            $this->Ln(5);
            $this->Cell(10);
            $this->SetFont('Arial', '', 10);
            $this->Cell(85, 10, utf8_decode("se hayan generado en clase. Asimismo, justificar las faltas."), 0, 0);
            $this->Ln(10);
            $this->Cell(10);
            $this->SetFont('Arial', '', 10);
            $this->Cell(85, 10, utf8_decode("Esperando contar con su apoyo, reciban un cordial saludo."), 0, 0);
            $this->Ln(40);
            $this->SetFont('Arial', '', 10);
            $this->Ln(10);
            $this->SetFont('Arial', '', 10);
            $this->Cell(0, 10, utf8_decode("A T E N T A M E N T E"), 0, 1, 'C');
            $this->Ln(10);
            $this->SetFont('Arial', 'B', 10);
            $this->Cell(0, 10, "MARIA FERNANDA DIAZ AYALA", 0, 1, 'C');
            $this->Ln(0.5);
            $this->Cell(0, 10, "___________________________________", 0, 1, 'C');
            $this->Ln(0.5);
            $this->SetFont('Arial', '', 10);
            $this->Cell(0, 10, utf8_decode("DRA. MARIA FERNANDA DIAZ AYALA"), 0, 1, 'C');
            $this->Cell(0, 10, utf8_decode("DIRECTORA ACADÉMICA ITI-IET"), 0, 1, 'C');
        }

        function Footer(){
            $this->SetY(-15);
            $this->SetFont('Arial', 'I', 8);
            $this->Cell(0, 10, utf8_decode('Boulevard. Cuauhnáhuac No. 566 Col. Lomas del Texcal, C.P. 62550 Tel: (777) 2 29 04 68 Ext. 2106 ') . $this->PageNo(), 0, 0, 'C');
        }
    }

    // Crear y guardar el PDF
    $pdf = new PDF($solicitud);
    $pdf->AddPage();
    $pdf->Output('F', $rutaPdf);

    // Registrar en la base de datos
    $fechaGeneracion = date('Y-m-d H:i:s');
    $queryInsert = "INSERT INTO pdf_generado (nombrePdf, rutaPdf, idJusti, fechaGeneracion) VALUES ('$nombrePdf', '$rutaPdf', $idSolicitud, '$fechaGeneracion')";

    if (mysqli_query($conexion, $queryInsert)) {
        echo "<script>
            alert('PDF generado exitosamente');
            window.location.href = '../../Views/AdminView/SoliAluRegu.php';
        </script>";
    } else {
        echo "Error al insertar en pdf_generado: " . mysqli_error($conexion);
    }
} else {
    echo "Error al obtener los datos para el PDF.";
}

// Cerrar la conexión
mysqli_close($conexion);
?>