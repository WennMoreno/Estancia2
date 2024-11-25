<?php
// Ocultar advertencias
error_reporting(E_ERROR | E_PARSE);

// Incluir el archivo de conexión
include '../../Model/Conexion.php';

// Verificar si la conexión se estableció correctamente
if (!$conexion) {
    die("Error en la conexión a la base de datos.");
}

// Obtener los parámetros del formulario (Fecha de Inicio y Fecha de Fin)
$fechaInicio = isset($_GET['fechaInicio']) ? $_GET['fechaInicio'] : '';
$fechaFin = isset($_GET['fechaFin']) ? $_GET['fechaFin'] : '';

// Si no se seleccionan las fechas, mostrar un mensaje y detener el script
if (empty($fechaInicio) || empty($fechaFin)) {
    die("Por favor, seleccione la fecha de inicio y la fecha de fin.");
}

// Construir la consulta con los filtros por fecha de inicio y fin
$query = "SELECT   
            a.nombreAlu,
            a.apellidoAlu,
            COUNT(j.idJusti) AS total_justificantes
          FROM justificante j
          JOIN alumno a ON j.idAlumno = a.idAlumno
          WHERE j.fecha BETWEEN '$fechaInicio' AND '$fechaFin'
          GROUP BY a.idAlumno
          HAVING COUNT(j.idJusti) > 0
          ORDER BY total_justificantes DESC";

// Ejecutar la consulta
$result = mysqli_query($conexion, $query);

// Verificar si la consulta fue exitosa
if (!$result) {
    die("Error en la consulta: " . mysqli_error($conexion));
}

// Configuración de cabeceras para la descarga en formato Excel
header('Content-Type: application/vnd.ms-excel; charset=UTF-8');
header('Content-Disposition: attachment; filename="Justificantes_' . $fechaInicio . '_a_' . $fechaFin . '.xls"');

// Inicia la tabla de datos en formato Excel
echo "<table border='1' style='border-collapse:collapse;'>";

// Encabezado con logo y título
echo "<thead>";
echo "<tr>";
// Columna del logo
echo "<td colspan='1' rowspan='6' style='text-align:center; vertical-align:middle; height:150px; width:150px;'>
        <img src='https://www.upemor.edu.mx/sitio_web/img/LOGO_U4.png' alt='Logo' style='width:100px; height:100px;'>
      </td>";
// Encabezado principal
echo "<td colspan='5' style='text-align:center; font-size:20px; font-weight:bold; background-color:#f2f2f2;'>Reporte de Justificantes de Alumnos</td>";
echo "</tr>";
echo "<tr><td colspan='5' style='text-align:center; font-size:14px; background-color:#f9f9f9;'>Generado el: " . date('Y-m-d H:i:s') . "</td></tr>";
echo "</thead>";

// Encabezados de columna
echo "<thead style='background-color:#d9edf7; font-weight:bold; text-align:center;'>";
echo "<tr>";
echo "<th style='padding:8px;'>Nombre del Alumno</th>";
echo "<th style='padding:8px;'>Apellido del Alumno</th>";
echo "<th style='padding:8px;'>Total de Justificantes</th>";
echo "</tr>";
echo "</thead>";

// Cuerpo de la tabla con los datos
echo "<tbody>";
// Iterar sobre los resultados y construir las filas de la tabla
while ($row = mysqli_fetch_assoc($result)) {
    echo "<tr>";
    echo "<td>" . htmlspecialchars($row['nombreAlu'], ENT_QUOTES, 'UTF-8') . "</td>";
    echo "<td>" . htmlspecialchars($row['apellidoAlu'], ENT_QUOTES, 'UTF-8') . "</td>";
    echo "<td>" . htmlspecialchars($row['total_justificantes'], ENT_QUOTES, 'UTF-8') . "</td>";
    echo "</tr>";
}

// Cerrar la tabla
echo "</tbody>";
echo "</table>";

// Cerrar la conexión a la base de datos
mysqli_close($conexion);
?>
