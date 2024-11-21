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
$estado = isset($_GET['estado']) ? $_GET['estado'] : '';
$fechaInicio = isset($_GET['fechaInicio']) ? $_GET['fechaInicio'] : '';
$fechaFin = isset($_GET['fechaFin']) ? $_GET['fechaFin'] : '';

// Configuración de cabeceras para la descarga en formato Excel
header('Content-Type: application/vnd.ms-excel; charset=UTF-8');
header('Content-Disposition: attachment; filename="Justificantes_Estado_' . $estado . '.xls"');

// Consulta para contar el total de registros según el estado y el rango de fechas
$countQuery = "SELECT COUNT(*) as total
               FROM justificante j
               WHERE j.estado = '$estado' 
               AND j.fecha BETWEEN '$fechaInicio' AND '$fechaFin'";

$countResult = mysqli_query($conexion, $countQuery);

// Verificar si la consulta de conteo fue exitosa
if (!$countResult) {
    die("Error en la consulta de conteo: " . mysqli_error($conexion));
}

// Obtener el total de registros
$total = mysqli_fetch_assoc($countResult)['total'];

// Consulta para obtener los justificantes según los parámetros proporcionados
$query = "SELECT j.idJusti, a.nombreAlu, a.matricula, j.fecha, j.estado, j.cuatrimestre
          FROM justificante j
          JOIN alumno a ON j.idAlumno = a.idAlumno
          WHERE j.estado = '$estado' 
          AND j.fecha BETWEEN '$fechaInicio' AND '$fechaFin'";

// Ejecutar la consulta principal
$result = mysqli_query($conexion, $query);

// Verificar si la consulta principal fue exitosa
if (!$result) {
    die("Error en la consulta: " . mysqli_error($conexion));
}

// Inicia la tabla de datos en formato Excel
echo "<table border='1'>";

// Mostrar el total al inicio
echo "<thead>";
echo "<tr><th colspan='6'>Total de justificantes con estado $estado: $total</th></tr>";
echo "<tr><th>ID Justificante</th><th>Nombre Alumno</th><th>Matrícula</th><th>Fecha</th><th>Estado</th><th>Cuatrimestre</th></tr>";
echo "</thead>";
echo "<tbody>";

// Iterar sobre los resultados y construir las filas de la tabla
while ($row = mysqli_fetch_assoc($result)) {
    echo "<tr>";
    echo "<td>" . htmlspecialchars($row['idJusti'], ENT_QUOTES, 'UTF-8') . "</td>";
    echo "<td>" . htmlspecialchars($row['nombreAlu'], ENT_QUOTES, 'UTF-8') . "</td>";
    echo "<td>" . htmlspecialchars($row['matricula'], ENT_QUOTES, 'UTF-8') . "</td>";
    echo "<td>" . htmlspecialchars($row['fecha'], ENT_QUOTES, 'UTF-8') . "</td>";
    echo "<td>" . htmlspecialchars($row['estado'], ENT_QUOTES, 'UTF-8') . "</td>";
    echo "<td>" . htmlspecialchars($row['cuatrimestre'], ENT_QUOTES, 'UTF-8') . "</td>";
    echo "</tr>";
}

// Cerrar la tabla
echo "</tbody>";
echo "</table>";

// Cerrar la conexión a la base de datos
mysqli_close($conexion);
?>
