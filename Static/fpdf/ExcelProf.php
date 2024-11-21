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
header('Content-Disposition: attachment; filename="Profesores.xls"');

// Consulta a la base de datos
$query = "SELECT idProf, nombreProf, apellidoProf, passwordProf, correoElectronico FROM profesor";
$result = mysqli_query($conexion, $query);

// Verificar si la consulta fue exitosa
if (!$result) {
    die("Error en la consulta: " . mysqli_error($conexion));
}
?>

<h1>Listado de Profesores</h1>
<table border="1">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Apellido</th>
            
            <th>Correo Electrónico</th>
        </tr>
    </thead>
    <tbody>
        <?php
        // Iterar sobre los resultados y construir las filas de la tabla
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($row['idProf'], ENT_QUOTES, 'UTF-8') . "</td>";
            echo "<td>" . htmlspecialchars($row['nombreProf'], ENT_QUOTES, 'UTF-8') . "</td>";
            echo "<td>" . htmlspecialchars($row['apellidoProf'], ENT_QUOTES, 'UTF-8') . "</td>";
            //echo "<td>" . htmlspecialchars($row['passwordProf'], ENT_QUOTES, 'UTF-8') . "</td>";
            echo "<td>" . htmlspecialchars($row['correoElectronico'], ENT_QUOTES, 'UTF-8') . "</td>";
            echo "</tr>";
        }
        ?>
    </tbody>
</table>