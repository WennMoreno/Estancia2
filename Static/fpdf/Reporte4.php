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
$periodoEscolar = isset($_GET['periodoEscolar']) ? $_GET['periodoEscolar'] : '';
$carrera = isset($_GET['carrera']) ? $_GET['carrera'] : '';
$grupo = isset($_GET['grupo']) ? $_GET['grupo'] : '';

// Construir la consulta con filtros opcionales
$query = "SELECT 
            j.periodoEscolar,
            j.carrera,
            j.grupo,
            COUNT(j.idJusti) AS total_justificantes
          FROM justificante j
          WHERE 1=1";

if (!empty($periodoEscolar)) {
    $query .= " AND j.periodoEscolar = '$periodoEscolar'";
}

if (!empty($carrera)) {
    $query .= " AND j.carrera = '$carrera'";
}

if (!empty($grupo)) {
    $query .= " AND j.grupo = '$grupo'";
}

$query .= " GROUP BY j.periodoEscolar, j.carrera, j.grupo
             ORDER BY j.periodoEscolar, j.carrera, j.grupo";

// Ejecutar la consulta
$result = mysqli_query($conexion, $query);

// Verificar si la consulta fue exitosa
if (!$result) {
    die("Error en la consulta: " . mysqli_error($conexion));
}

// Configuración de cabeceras para la descarga en formato Excel
header('Content-Type: application/vnd.ms-excel; charset=UTF-8');
header('Content-Disposition: attachment; filename="Justificantes_por_Grupo.xls"');

// Inicia la tabla de datos en formato Excel
echo "<table border='1'>";
echo "<thead>";
echo "<tr>
        <th>Periodo Escolar</th>
        <th>Carrera</th>
        <th>Grupo</th>
        <th>Total de Justificantes</th>
      </tr>";
echo "</thead>";
echo "<tbody>";

// Iterar sobre los resultados y construir las filas de la tabla
while ($row = mysqli_fetch_assoc($result)) {
    echo "<tr>";
    echo "<td>" . htmlspecialchars($row['periodoEscolar'], ENT_QUOTES, 'UTF-8') . "</td>";
    echo "<td>" . htmlspecialchars($row['carrera'], ENT_QUOTES, 'UTF-8') . "</td>";
    echo "<td>" . htmlspecialchars($row['grupo'], ENT_QUOTES, 'UTF-8') . "</td>";
    echo "<td>" . htmlspecialchars($row['total_justificantes'], ENT_QUOTES, 'UTF-8') . "</td>";
    echo "</tr>";
}

// Cerrar la tabla
echo "</tbody>";
echo "</table>";

// Cerrar la conexión a la base de datos
mysqli_close($conexion);
?>
