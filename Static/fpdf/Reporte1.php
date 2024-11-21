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
echo "<table border='1'>";
echo "<thead>";
echo "<tr><th>ID Justificante</th><th>Nombre Profesor</th><th>Puesto</th><th>Fecha</th><th>Estado</th><th>Motivo</th></tr>";
echo "</thead>";
echo "<tbody>";

// Iterar sobre los resultados y construir las filas de la tabla
while ($row = mysqli_fetch_assoc($result)) {
    echo "<tr>";
    echo "<td>" . htmlspecialchars($row['idJusti'], ENT_QUOTES, 'UTF-8') . "</td>";
    echo "<td>" . htmlspecialchars($row['nombreProf'], ENT_QUOTES, 'UTF-8') . "</td>";
    echo "<td>" . htmlspecialchars($row['puesto'], ENT_QUOTES, 'UTF-8') . "</td>";
    echo "<td>" . htmlspecialchars($row['fecha'], ENT_QUOTES, 'UTF-8') . "</td>";
    echo "<td>" . htmlspecialchars($row['estado'], ENT_QUOTES, 'UTF-8') . "</td>";
    echo "<td>" . htmlspecialchars($row['motivo'], ENT_QUOTES, 'UTF-8') . "</td>";
    echo "</tr>";
}

// Cerrar la tabla
echo "</tbody>";
echo "</table>";

// Cerrar la conexión a la base de datos
mysqli_close($conexion);
?>
