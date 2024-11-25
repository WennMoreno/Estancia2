<?php 
// Ocultar advertencias
error_reporting(E_ERROR | E_PARSE);

// Incluir el archivo de conexión
include '../../Model/Conexion.php';

// Verificar si la conexión se estableció correctamente
if (!$conexion) {
    die("Error en la conexión a la base de datos.");
}

// Obtener los parámetros del formulario de forma segura
$periodoEscolar = isset($_GET['periodoEscolar']) ? $_GET['periodoEscolar'] : '';
$carrera = isset($_GET['carrera']) ? $_GET['carrera'] : '';
$grupo = isset($_GET['grupo']) ? $_GET['grupo'] : '';

// Construir la consulta con filtros opcionales de manera segura
$query = "SELECT 
            j.periodoEscolar,
            j.carrera,
            j.grupo,
            COUNT(j.idJusti) AS total_justificantes,
            j.cuatrimestre
          FROM justificante j
          WHERE 1=1";

// Aplicar los filtros opcionales
$params = [];
$types = "";

// Filtrar por periodoEscolar
if (!empty($periodoEscolar)) {
    $query .= " AND j.periodoEscolar = ?";
    $params[] = $periodoEscolar;
    $types .= "s";  // 's' para string
}

// Filtrar por carrera
if (!empty($carrera)) {
    $query .= " AND j.carrera = ?";
    $params[] = $carrera;
    $types .= "s";  // 's' para string
}

// Filtrar por grupo
if (!empty($grupo)) {
    $query .= " AND j.grupo = ?";
    $params[] = $grupo;
    $types .= "s";  // 's' para string
}

// Continuar la consulta
$query .= " GROUP BY j.periodoEscolar, j.carrera, j.grupo, j.cuatrimestre
             ORDER BY j.periodoEscolar, j.carrera, j.grupo";

// Preparar la consulta
$stmt = mysqli_prepare($conexion, $query);

// Verificar si la preparación fue exitosa
if ($stmt === false) {
    die("Error en la preparación de la consulta: " . mysqli_error($conexion));
}

// Vincular los parámetros
if (!empty($params)) {
    mysqli_stmt_bind_param($stmt, $types, ...$params);
}

// Ejecutar la consulta
mysqli_stmt_execute($stmt);

// Obtener los resultados
$result = mysqli_stmt_get_result($stmt);

// Verificar si la consulta fue exitosa
if (!$result) {
    die("Error en la consulta: " . mysqli_error($conexion));
}

// Configuración de cabeceras para la descarga en formato Excel
header('Content-Type: application/vnd.ms-excel; charset=UTF-8');
header('Content-Disposition: attachment; filename="Justificantes_por_Grupo.xls"');

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
echo "<td colspan='6' style='text-align:center; font-size:20px; font-weight:bold; background-color:#f2f2f2;'>Reporte de Justificantes</td>";
echo "</tr>";
echo "<tr><td colspan='6' style='text-align:center; font-size:14px; background-color:#f9f9f9;'>Generado el: " . date('Y-m-d H:i:s') . "</td></tr>";
echo "<tr><td colspan='6' style='text-align:center; font-size:14px; background-color:#f9f9f9;'>Total de justificantes por grupo</td></tr>";
echo "</thead>";

// Encabezados de columna
echo "<thead style='background-color:#d9edf7; font-weight:bold; text-align:center;'>";
echo "<tr>";
// Encabezados de las columnas
echo "<th style='padding:8px;'>Periodo Escolar</th>";
echo "<th style='padding:8px;'>Cuatrimestre</th>";
echo "<th style='padding:8px;'>Carrera</th>";
echo "<th style='padding:8px;'>Grupo</th>";
echo "<th style='padding:8px;'>Total de Justificantes</th>";
echo "</tr>";
echo "</thead>";

echo "<tbody>";

// Iterar sobre los resultados y construir las filas de la tabla
while ($row = mysqli_fetch_assoc($result)) {
    echo "<tr>";
    echo "<td>" . htmlspecialchars($row['periodoEscolar'], ENT_QUOTES, 'UTF-8') . "</td>";
    echo "<td>" . htmlspecialchars($row['cuatrimestre'], ENT_QUOTES, 'UTF-8') . "</td>";
    echo "<td>" . htmlspecialchars($row['carrera'], ENT_QUOTES, 'UTF-8') . "</td>";
    echo "<td>" . htmlspecialchars($row['grupo'], ENT_QUOTES, 'UTF-8') . "</td>";
    echo "<td>" . htmlspecialchars($row['total_justificantes'], ENT_QUOTES, 'UTF-8') . "</td>";
    echo "</tr>";
}

// Cerrar la tabla
echo "</tbody>";
echo "</table>";

// Cerrar la conexión a la base de datos
mysqli_stmt_close($stmt);
mysqli_close($conexion);
?>
