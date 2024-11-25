<?php
// Ocultar advertencias
error_reporting(E_ERROR | E_PARSE);

// Incluir el archivo de conexión
include '../../Model/Conexion.php';

// Verificar si la conexión se estableció correctamente
if (!$conexion) {
    die("Error en la conexión a la base de datos.");
}

// Obtener el término de búsqueda si está presente en la URL
$searchTerm = isset($_GET['searchTerm']) ? $_GET['searchTerm'] : '';

// Configuración de cabeceras para la descarga en formato Excel
header('Content-Type: application/vnd.ms-excel; charset=UTF-8');
header('Content-Disposition: attachment; filename="Administradores.xls"');

// Ajustar la consulta según el término de búsqueda
$query = "SELECT idAdmin, nombreAdmin, apellidoAdmin, CorreoEle FROM administrador WHERE 
          (nombreAdmin LIKE '%$searchTerm%' OR apellidoAdmin LIKE '%$searchTerm%' OR CorreoEle LIKE '%$searchTerm%')";

// Ejecutar la consulta
$result = mysqli_query($conexion, $query);

// Verificar si la consulta fue exitosa
if (!$result) {
    die("Error en la consulta: " . mysqli_error($conexion));
}

// Inicia la tabla de datos en formato Excel
echo "<table border='1'>";
echo "<thead>";
echo "<tr><th>ID</th><th>Nombre</th><th>Apellido</th><th>Correo</th></tr>";
echo "</thead>";
echo "<tbody>";

// Iterar sobre los resultados y construir las filas de la tabla
while ($row = mysqli_fetch_assoc($result)) {
    echo "<tr>";
    echo "<td>" . htmlspecialchars($row['idAdmin'], ENT_QUOTES, 'UTF-8') . "</td>";
    echo "<td>" . htmlspecialchars($row['nombreAdmin'], ENT_QUOTES, 'UTF-8') . "</td>";
    echo "<td>" . htmlspecialchars($row['apellidoAdmin'], ENT_QUOTES, 'UTF-8') . "</td>";
    echo "<td>" . htmlspecialchars($row['CorreoEle'], ENT_QUOTES, 'UTF-8') . "</td>";
    echo "</tr>";
}

// Cerrar la tabla
echo "</tbody>";
echo "</table>";

// Cerrar la conexión a la base de datos
mysqli_close($conexion);
?>
