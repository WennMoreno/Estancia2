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
echo "<table border='1'>";
echo "<thead>";
echo "<tr>
        <th>Nombre del Alumno</th>
        <th>Apellido del Alumno</th>
        <th>Total de Justificantes</th>
      </tr>";
echo "</thead>";
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
