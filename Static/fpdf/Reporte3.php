<?php
// Ocultar advertencias
error_reporting(E_ERROR | E_PARSE);

// Incluir el archivo de conexión
include '../../Model/Conexion.php';

// Verificar si la conexión se estableció correctamente
if (!$conexion) {
    die("Error en la conexión a la base de datos.");
}

// Obtener los parámetros del formulario
$matricula = isset($_GET['matricula']) ? $_GET['matricula'] : '';

// Configuración de cabeceras para la descarga en formato Excel
header('Content-Type: application/vnd.ms-excel; charset=UTF-8');
header('Content-Disposition: attachment; filename="Justificantes_Alumno_' . $matricula . '.xls"');

// Consulta para contar el total de justificantes del alumno
$countQuery = "SELECT COUNT(*) as total 
               FROM justificante j 
               JOIN alumno a ON j.idAlumno = a.idAlumno 
               WHERE a.matricula = '$matricula'";

$countResult = mysqli_query($conexion, $countQuery);

// Verificar si la consulta de conteo fue exitosa
if (!$countResult) {
    die("Error en la consulta de conteo: " . mysqli_error($conexion));
}

// Obtener el total de justificantes
$total = mysqli_fetch_assoc($countResult)['total'];

// Consulta principal para obtener los justificantes del alumno
$query = "SELECT 
            j.idJusti, 
            a.nombreAlu, 
            a.apellidoAlu, 
            a.matricula, 
            j.periodoEscolar, 
            j.grupo, 
            j.carrera, 
            j.motivo, 
            j.fecha, 
            j.estado 
          FROM justificante j
          JOIN alumno a ON j.idAlumno = a.idAlumno
          WHERE a.matricula = '$matricula'
          ORDER BY j.fecha DESC";

$result = mysqli_query($conexion, $query);

// Verificar si la consulta principal fue exitosa
if (!$result) {
    die("Error en la consulta principal: " . mysqli_error($conexion));
}

// Inicia la tabla de datos en formato Excel
echo "<table border='1' style='border-collapse:collapse;'>";

// Encabezado con logo y título
echo "<thead>";
echo "<tr>";
// Columna del logo
echo "<td colspan='1' rowspan='6' style='text-align:center; vertical-align:middle; height:150px; width:150px;'>
        <img src='https://www.upemor.edu.mx/sitio_web/img/LOGO_U4.png' alt='Logo' 
        style='width:100px; height:100px;'>
      </td>";
// Título del reporte
echo "<td colspan='5' style='text-align:center; font-size:20px; font-weight:bold; background-color:#f2f2f2;'>Reporte de Justificantes</td>";
echo "</tr>";
echo "<tr><td colspan='5' style='text-align:center; font-size:14px; background-color:#f9f9f9;'>Generado el: " . date('Y-m-d H:i:s') . "</td></tr>";
echo "<tr><td colspan='5' style='text-align:center; font-size:14px; background-color:#f9f9f9;'>Total de justificantes del alumno con matrícula $matricula: $total</td></tr>";
echo "</thead>";

// Encabezados de columna
echo "<thead style='background-color:#d9edf7; font-weight:bold; text-align:center;'>";
echo "<tr>";
// Encabezados de las columnas
echo "<th style='padding:8px;'>ID Justificante</th>";
echo "<th style='padding:8px;'>Nombre</th>";
echo "<th style='padding:8px;'>Apellido</th>";
echo "<th style='padding:8px;'>Matrícula</th>";
echo "<th style='padding:8px;'>Periodo Escolar</th>";
echo "<th style='padding:8px;'>Grupo</th>";
echo "<th style='padding:8px;'>Carrera</th>";
echo "<th style='padding:8px;'>Motivo</th>";
echo "<th style='padding:8px;'>Fecha</th>";
echo "<th style='padding:8px;'>Estado</th>";
echo "</tr>";
echo "</thead>";

echo "<tbody>";

// Iterar sobre los resultados y construir las filas de la tabla
while ($row = mysqli_fetch_assoc($result)) {
    echo "<tr>";
    echo "<td style='padding:8px;'>" . htmlspecialchars($row['idJusti'], ENT_QUOTES, 'UTF-8') . "</td>";
    echo "<td style='padding:8px;'>" . htmlspecialchars($row['nombreAlu'], ENT_QUOTES, 'UTF-8') . "</td>";
    echo "<td style='padding:8px;'>" . htmlspecialchars($row['apellidoAlu'], ENT_QUOTES, 'UTF-8') . "</td>";
    echo "<td style='padding:8px;'>" . htmlspecialchars($row['matricula'], ENT_QUOTES, 'UTF-8') . "</td>";
    echo "<td style='padding:8px;'>" . htmlspecialchars($row['periodoEscolar'], ENT_QUOTES, 'UTF-8') . "</td>";
    echo "<td style='padding:8px;'>" . htmlspecialchars($row['grupo'], ENT_QUOTES, 'UTF-8') . "</td>";
    echo "<td style='padding:8px;'>" . htmlspecialchars($row['carrera'], ENT_QUOTES, 'UTF-8') . "</td>";
    echo "<td style='padding:8px;'>" . htmlspecialchars($row['motivo'], ENT_QUOTES, 'UTF-8') . "</td>";
    echo "<td style='padding:8px;'>" . htmlspecialchars($row['fecha'], ENT_QUOTES, 'UTF-8') . "</td>";
    echo "<td style='padding:8px;'>" . htmlspecialchars($row['estado'], ENT_QUOTES, 'UTF-8') . "</td>";
    echo "</tr>";
}

// Cerrar la tabla
echo "</tbody>";
echo "</table>";

// Cerrar la conexión a la base de datos
mysqli_close($conexion);
?>
