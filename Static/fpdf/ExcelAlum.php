<?php
// Ocultar advertencias
error_reporting(E_ERROR | E_PARSE);

// Incluir el archivo de conexión
include '../../Model/Conexion.php';

// Verificar si la conexión se estableció correctamente
if (!$conexion) {
    die("Error en la conexión a la base de datos.");
}

// Obtener el filtro de búsqueda desde el formulario
$filtro = isset($_POST['filtro']) ? $_POST['filtro'] : '';

// Configuración de cabeceras para la descarga en formato Excel
header('Content-Type: application/vnd.ms-excel; charset=UTF-8');
header('Content-Disposition: attachment; filename="Alumnos.xls"');

// Construir la consulta SQL con el filtro (si existe)
if ($filtro) {
    $query = "SELECT idAlumno, nombreAlu, apellidoAlu, feNac, matricula, correoE FROM alumno WHERE matricula LIKE '%$filtro%' OR apellidoAlu LIKE '%$filtro%'";
} else {
    $query = "SELECT idAlumno, nombreAlu, apellidoAlu, feNac, matricula, correoE FROM alumno";
}

$result = mysqli_query($conexion, $query);

// Verificar si la consulta fue exitosa
if (!$result) {
    die("Error en la consulta: " . mysqli_error($conexion));
}
?>

<h1>Listado de Alumnos</h1>
<table border="1">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Apellido</th>
            <th>Fecha de Nacimiento</th>
            <th>Matrícula</th>
            <th>Correo</th>
        </tr>
    </thead>
    <tbody>
        <?php
        // Iterar sobre los resultados y construir las filas de la tabla
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($row['idAlumno'], ENT_QUOTES, 'UTF-8') . "</td>";
            echo "<td>" . htmlspecialchars($row['nombreAlu'], ENT_QUOTES, 'UTF-8') . "</td>";
            echo "<td>" . htmlspecialchars($row['apellidoAlu'], ENT_QUOTES, 'UTF-8') . "</td>";
            echo "<td>" . htmlspecialchars($row['feNac'], ENT_QUOTES, 'UTF-8') . "</td>";
            echo "<td>" . htmlspecialchars($row['matricula'], ENT_QUOTES, 'UTF-8') . "</td>";
            echo "<td>" . htmlspecialchars($row['correoE'], ENT_QUOTES, 'UTF-8') . "</td>";
            echo "</tr>";
        }
        ?>
    </tbody>
</table>
