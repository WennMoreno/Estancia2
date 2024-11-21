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
echo "<table border='1'>";

// Mostrar el total al inicio
echo "<thead>";
echo "<tr><th colspan='10'>Total de justificantes del alumno con matrícula $matricula: $total</th></tr>";
echo "<tr>
        <th>ID Justificante</th>
        <th>Nombre</th>
        <th>Apellido</th>
        <th>Matrícula</th>
        <th>Periodo Escolar</th>
        <th>Grupo</th>
        <th>Carrera</th>
        <th>Motivo</th>
        <th>Fecha</th>
        <th>Estado</th>
      </tr>";
echo "</thead>";
echo "<tbody>";

// Iterar sobre los resultados y construir las filas de la tabla
while ($row = mysqli_fetch_assoc($result)) {
    echo "<tr>";
    echo "<td>" . htmlspecialchars($row['idJusti'], ENT_QUOTES, 'UTF-8') . "</td>";
    echo "<td>" . htmlspecialchars($row['nombreAlu'], ENT_QUOTES, 'UTF-8') . "</td>";
    echo "<td>" . htmlspecialchars($row['apellidoAlu'], ENT_QUOTES, 'UTF-8') . "</td>";
    echo "<td>" . htmlspecialchars($row['matricula'], ENT_QUOTES, 'UTF-8') . "</td>";
    echo "<td>" . htmlspecialchars($row['periodoEscolar'], ENT_QUOTES, 'UTF-8') . "</td>";
    echo "<td>" . htmlspecialchars($row['grupo'], ENT_QUOTES, 'UTF-8') . "</td>";
    echo "<td>" . htmlspecialchars($row['carrera'], ENT_QUOTES, 'UTF-8') . "</td>";
    echo "<td>" . htmlspecialchars($row['motivo'], ENT_QUOTES, 'UTF-8') . "</td>";
    echo "<td>" . htmlspecialchars($row['fecha'], ENT_QUOTES, 'UTF-8') . "</td>";
    echo "<td>" . htmlspecialchars($row['estado'], ENT_QUOTES, 'UTF-8') . "</td>";
    echo "</tr>";
}

// Cerrar la tabla
echo "</tbody>";
echo "</table>";

// Cerrar la conexión a la base de datos
mysqli_close($conexion);
?>
