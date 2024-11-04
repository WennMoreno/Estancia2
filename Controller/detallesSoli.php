<?php
include('../Model/conexion.php');

// Verificar si se proporcionó el ID de la solicitud
if (!isset($_GET['id'])) {
    echo "<p>No se proporcionó el ID de la solicitud.</p>";
    exit();
}

$idSolicitud = intval($_GET['id']);

// Verificar la conexión a la base de datos
if (!$conexion) {
    echo "<p>Error en la conexión a la base de datos.</p>";
    exit();
}

// Consulta para obtener los detalles de la solicitud
$query = "
    SELECT justificante.*, alumno.nombreAlu AS nombre, alumno.matricula, justificante.carrera, evidencia.ruta
    FROM justificante
    JOIN alumno ON justificante.idAlumno = alumno.idAlumno
    LEFT JOIN evidencia ON justificante.idEvi = evidencia.idEvi
    WHERE justificante.idJusti = $idSolicitud
";

$result = mysqli_query($conexion, $query);

// Verificar si la consulta fue exitosa
if (!$result) {
    echo "<p>Error en la consulta a la base de datos: " . mysqli_error($conexion) . "</p>";
    exit();
}

// Obtener los datos de la solicitud
$solicitud = mysqli_fetch_assoc($result);

if ($solicitud) {
    // Mostrar detalles de la solicitud
    echo "<h3>Solicitud #" . htmlspecialchars($solicitud['idJusti']) . "</h3>";
    echo "<p><strong>Nombre:</strong> " . htmlspecialchars($solicitud['nombre']) . "</p>";
    echo "<p><strong>Matrícula:</strong> " . htmlspecialchars($solicitud['matricula']) . "</p>";
    echo "<p><strong>Carrera:</strong> " . htmlspecialchars($solicitud['carrera']) . "</p>";
    echo "<p><strong>Fecha:</strong> " . htmlspecialchars($solicitud['fecha']) . "</p>";

    // Verificar el estado de ausenteTodoDia
    if ($solicitud['ausenteTodoDia'] == 1) {
        // Si ausenteTodoDia es 1, solo mostrar la fecha
        echo "<p><strong>Estado:</strong> Ausente todo el día</p>";
    } else {
        // Si ausenteTodoDia es 0, mostrar la fecha y horas
        echo "<p><strong>Hora Inicio:</strong> " . htmlspecialchars($solicitud['horaInicio']) . "</p>";
        echo "<p><strong>Hora Fin:</strong> " . htmlspecialchars($solicitud['horaFin']) . "</p>";
    }

    echo "<p><strong>Motivo:</strong> " . htmlspecialchars($solicitud['motivo']) . "</p>";

    // Mostrar ruta del archivo
    $pdfPath = $solicitud['ruta'];
    $pdfPath = str_replace(' ', '%20', $pdfPath); // Reemplazar espacios por %20
    echo "<p>Ruta desde la base de datos: " . htmlspecialchars($pdfPath) . "</p>"; 
    echo "<p>URL del PDF: " . htmlspecialchars($pdfPath) . "</p>"; // Línea de depuración adicional

    // Formulario para generar PDF o rechazar
    ?>
    <form action="../../Static/fpdf/JustAlumRegu.php" method="POST">
        <input type="hidden" name="idJusti" value="<?php echo htmlspecialchars($solicitud['idJusti']); ?>">
        <button type="submit">Aceptar y Generar PDF</button>
    </form>

    <!-- Botón de rechazo -->
    <button class="rechazar">Rechazar</button>
    <?php
}

// Cerrar la conexión a la base de datos
mysqli_close($conexion);
?>
