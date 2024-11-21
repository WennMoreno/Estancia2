<?php

include_once $_SERVER['DOCUMENT_ROOT'] . '/pruebasOfAllVerDul/Model/conexion.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/pruebasOfAllVerDul/Model/Justificante.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/pruebasOfAllVerDul/Model/Administrador.php';


if (isset($_GET['id'])) {
    echo "<p>ID recibido: " . htmlspecialchars($_GET['id']) . "</p>";
} else {
    echo "<p>No se proporcionó el ID de la solicitud.</p>";
    exit();
}
session_start();
 
//almacena el id de la solicitud
$idSolicitud = intval($_GET['id']);

//almacena el id del usuario 
$correo = $_SESSION['identificador'];
//Instancio el modelo para obtener el id del admin
$modeloAd= new Administrador($conexion);
$idUser=$modeloAd->obtenerIdAd($correo);

// Verificar la conexión a la base de datos
if (!$conexion) {
    echo "<p>Error en la conexión a la base de datos.</p>";
    exit();
}

//Instancio el modelo
$modeloJustifi= new Justificante($conexion);
$result=$modeloJustifi->showJusti($idSolicitud);

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
    
//Instancio el modelo
$modeloAdmin= new Administrador($conexion);
$resultAdmin=$modeloAdmin->EsAdmin($idUser);

// Si el usuario existe en la tabla administrador
if ($resultAdmin===1) { 
        $pdfPath = $solicitud['ruta'];
        $pdfPath = str_replace(' ', '%20', $pdfPath); // Reemplazar espacios por %20
        echo "<p>Ruta desde la base de datos: " . htmlspecialchars($pdfPath) . "</p>";
        echo "<p>URL del PDF: " . htmlspecialchars($pdfPath) . "</p>";

        // Formulario para generar PDF o rechazar
        ?>
        <form action="../../Static/fpdf/JustAlumRegu.php" method="POST">
            <input type="hidden" name="idJusti" value="<?php echo htmlspecialchars($solicitud['idJusti']); ?>">
            <button type="submit">Aceptar y Generar PDF</button>
        </form>
        
        <!-- Formulario para rechazar la solicitud -->
        <button class="btn btn-success" onclick="cambiarEstado(<?= $solicitud['idJusti'] ?>, 'Rechazada')">Rechazar</button>
        <?php
    }
}else{
    
}

// Cerrar la conexión a la base de datos
mysqli_close($conexion);
?>
