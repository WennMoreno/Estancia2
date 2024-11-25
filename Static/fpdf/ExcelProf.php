<?php
// Ocultar advertencias
error_reporting(E_ERROR | E_PARSE);

// Incluir el archivo de conexión
include '../../Model/Conexion.php';

// Verificar si la conexión se estableció correctamente
if (!$conexion) {
    die("Error en la conexión a la base de datos.");
}

// Obtener el tipo de consulta (PA o PCT) desde POST
$tipoConsulta = isset($_POST['consultaTipo']) ? $_POST['consultaTipo'] : '';

// Configuración de cabeceras para la descarga en formato Excel
header('Content-Type: application/vnd.ms-excel; charset=UTF-8');
header('Content-Disposition: attachment; filename="Profesores_' . $tipoConsulta . '.xls"');

// Validar el tipo de consulta
if ($tipoConsulta === 'PA' || $tipoConsulta === 'PTC') {
    // Construir la consulta basada en el puesto
    $query = "SELECT idProf, nombreProf, apellidoProf, puesto, correoElectronico 
              FROM profesor 
              WHERE puesto = '$tipoConsulta'";
} else {
    die("Tipo de consulta no válido.");
}

// Ejecutar la consulta
$result = mysqli_query($conexion, $query);

// Verificar si la consulta fue exitosa
if (!$result) {
    die("Error en la consulta: " . mysqli_error($conexion));
}
?>

<h1>Listado de Profesores - <?php echo htmlspecialchars($tipoConsulta, ENT_QUOTES, 'UTF-8'); ?></h1>
<table border="1">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Apellido</th>
            <th>Puesto</th>
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
            echo "<td>" . htmlspecialchars($row['puesto'], ENT_QUOTES, 'UTF-8') . "</td>";
            echo "<td>" . htmlspecialchars($row['correoElectronico'], ENT_QUOTES, 'UTF-8') . "</td>";
            echo "</tr>";
        }
        ?>
    </tbody>
</table>
