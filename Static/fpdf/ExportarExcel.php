<?php
// Ocultar advertencias
error_reporting(E_ERROR | E_PARSE);

// Incluir el archivo de conexión
include '../../Model/Conexion.php';

// Verificar si la conexión se estableció correctamente
if (!$conexion) {
    die("Error en la conexión a la base de datos.");
}

// Configuración de cabeceras para la descarga en formato Excel
header('Content-Type: application/vnd.ms-excel; charset=UTF-8');
header('Content-Disposition: attachment; filename="Motivos.xls"');

// Consulta a la base de datos
$query = "SELECT idMotivo, tipo, descripcion, docSolicitado FROM motivo";
$result = mysqli_query($conexion, $query);

// Verificar si la consulta fue exitosa
if (!$result) {
    die("Error en la consulta: " . mysqli_error($conexion));
}
?>

<h1>Listado de Motivos</h1>
<table border="1">
    <thead>
        <tr>
            <th>ID</th>
            <th>Tipo</th>
            <th>Descripción</th>
            <th>Documento Solicitado</th>
        </tr>
    </thead>
    <tbody>
        <?php
        // Iterar sobre los resultados y construir las filas de la tabla
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($row['idMotivo'], ENT_QUOTES, 'UTF-8') . "</td>";
            echo "<td>" . htmlspecialchars($row['tipo'], ENT_QUOTES, 'UTF-8') . "</td>";
            echo "<td>" . htmlspecialchars($row['descripcion'], ENT_QUOTES, 'UTF-8') . "</td>";
            echo "<td>" . htmlspecialchars($row['docSolicitado'], ENT_QUOTES, 'UTF-8') . "</td>";
            echo "</tr>";
        }
        ?>
    </tbody>
</table>
