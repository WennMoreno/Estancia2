<?php
// Ocultar advertencias
error_reporting(E_ERROR | E_PARSE);

// Incluir el archivo de conexión
include '../../Model/Conexion.php';

// Verificar si la conexión se estableció correctamente
if (!$conexion) {
    die("Error en la conexión a la base de datos.");
}

// Obtener los parámetros del formulario de búsqueda
$nombreProfesor = isset($_GET['nombreProfesor']) ? $_GET['nombreProfesor'] : '';
$fechaInicio = isset($_GET['fechaInicio']) ? $_GET['fechaInicio'] : '';
$fechaFin = isset($_GET['fechaFin']) ? $_GET['fechaFin'] : '';
$estado = isset($_GET['estado']) ? $_GET['estado'] : '';

// Configuración de cabeceras para la descarga en formato Excel
header('Content-Type: application/vnd.ms-excel; charset=UTF-8');
header('Content-Disposition: attachment; filename="Justificantes_Profesor_' . $nombreProfesor . '.xls"');

// Consulta SQL para obtener los justificantes según los parámetros proporcionados
$query = "SELECT j.idJusti, p.nombreProf, p.puesto, j.fecha, j.estado, j.motivo
          FROM justificante_profesor jp
          JOIN justificante j ON jp.idJusti = j.idJusti
          JOIN profesor p ON jp.idProf = p.idProf
          WHERE p.nombreProf LIKE '%$nombreProfesor%' 
          AND j.fecha BETWEEN '$fechaInicio' AND '$fechaFin'
          AND j.estado = '$estado'";

// Ejecutar la consulta
$result = mysqli_query($conexion, $query);

// Verificar si la consulta fue exitosa
if (!$result) {
    die("Error en la consulta: " . mysqli_error($conexion));
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
// Encabezado principal
echo "<td colspan='5' style='text-align:center; font-size:20px; font-weight:bold; background-color:#f2f2f2;'>Reporte de Justificantes de Profesores</td>";
echo "</tr>";
echo "<tr><td colspan='5' style='text-align:center; font-size:14px; background-color:#f9f9f9;'>Generado el: " . date('Y-m-d H:i:s') . "</td></tr>";
echo "</tr>";
echo "</tr>";
echo "</thead>";

// Encabezados de columna
echo "<thead style='background-color:#d9edf7; font-weight:bold; text-align:center;'>";
echo "<tr>";
// Ahora los encabezados de columna empiezan desde la segunda celda y usan colspan para cubrir el espacio
echo "<th style='padding:8px;'>ID Justificante</th>";
echo "<th style='padding:8px;'>Nombre Profesor</th>";
echo "<th style='padding:8px;'>Puesto</th>";
echo "<th style='padding:8px;'>Fecha</th>";
echo "<th style='padding:8px;'>Estado</th>";
echo "<th style='padding:8px;'>Motivo</th>";
echo "</tr>";
echo "</thead>";
echo "<tbody>";

// Iterar sobre los resultados y construir las filas de la tabla
while ($row = mysqli_fetch_assoc($result)) {
    echo "<tr style='text-align:center;'>";
    echo "<td style='padding:8px;'>" . htmlspecialchars($row['idJusti'], ENT_QUOTES, 'UTF-8') . "</td>";
    echo "<td style='padding:8px;'>" . htmlspecialchars($row['nombreProf'], ENT_QUOTES, 'UTF-8') . "</td>";
    echo "<td style='padding:8px;'>" . htmlspecialchars($row['puesto'], ENT_QUOTES, 'UTF-8') . "</td>";
    echo "<td style='padding:8px;'>" . htmlspecialchars($row['fecha'], ENT_QUOTES, 'UTF-8') . "</td>";
    echo "<td style='padding:8px;'>" . htmlspecialchars($row['estado'], ENT_QUOTES, 'UTF-8') . "</td>";
    echo "<td style='padding:8px;'>" . htmlspecialchars($row['motivo'], ENT_QUOTES, 'UTF-8') . "</td>";
    echo "</tr>";
}

// Cerrar la tabla
echo "</tbody>";
echo "</table>";

// Cerrar la conexión a la base de datos
mysqli_close($conexion);
?>
