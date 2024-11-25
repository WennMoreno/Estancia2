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

    if ($solicitud['motivo'] === "NO APLICA"){
        echo "<p><strong>Motivo:</strong> " . htmlspecialchars($solicitud['motivoExtra']) . "</p>";
    }else{
        echo "<p><strong>Motivo:</strong> " . htmlspecialchars($solicitud['motivo']) . "</p>";
    }
    
//Instancio el modelo
$modeloAdmin= new Administrador($conexion);
$resultAdmin=$modeloAdmin->EsAdmin($idUser);

// Si el usuario existe en la tabla administrador
if ($resultAdmin===1) { 
        /*$pdfPath = $solicitud['ruta'];
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
        <?php*/

        $pdfPath = $solicitud['ruta'];

        // Normalizar las rutas
        $documentRoot = rtrim(str_replace('\\', '/', $_SERVER['DOCUMENT_ROOT']), '/');
        $pdfPath = str_replace('\\', '/', $pdfPath); // Convertir a barras diagonales hacia adelante

        // Verificar si la ruta desde la base de datos ya es absoluta
        if (stripos($pdfPath, $documentRoot) === 0) {
            // Si la ruta ya contiene DOCUMENT_ROOT, no hagas nada
            $fullPath = $pdfPath;
        } else {
            // Si la ruta no contiene DOCUMENT_ROOT, ajustarla
            $fullPath = $documentRoot . '/' . ltrim($pdfPath, '/');
        }

        // Depuración
        //echo "<p>DOCUMENT_ROOT: " . htmlspecialchars($documentRoot) . "</p>";
        //echo "<p>Ruta desde BD: " . htmlspecialchars($solicitud['ruta']) . "</p>";
        //echo "<p>Ruta procesada: " . htmlspecialchars($pdfPath) . "</p>";
        //echo "<p>Ruta completa resuelta: " . htmlspecialchars($fullPath) . "</p>";

        // Verificar si el archivo existe
       // var_dump(file_exists($fullPath));

        
        // Verificar si el archivo existe
        if ($fullPath && file_exists($fullPath)) {
            //echo "<p>Evidencia encontrada.</p>";
         $relativeUrl = str_replace($_SERVER['DOCUMENT_ROOT'], '', $fullPath);
         echo "<a href='" . htmlspecialchars($relativeUrl) . "' target='_blank' style='
         display: inline-block;
         padding: 10px 15px;
         margin: 5px;
         background-color: #007bff;
         color: white;
         text-decoration: none;
         border-radius: 5px;
         font-size: 14px;
         font-family: Arial, sans-serif;
         text-align: center;
     '>Ver Evidencia</a>";
     
     echo "<a href='" . htmlspecialchars($relativeUrl) . "' download style='
         display: inline-block;
         padding: 10px 15px;
         margin: 5px;
         background-color: #28a745;
         color: white;
         text-decoration: none;
         border-radius: 5px;
         font-size: 14px;
         font-family: Arial, sans-serif;
         text-align: center;
     '>Descargar Evidencia</a>";
        
        } else {
            echo "<p>El archivo de la evidencia no se encontró en el servidor.</p>";
            if (!file_exists($fullPath)) {
                echo "<p>El archivo realmente no existe en: " . htmlspecialchars($fullPath) . "</p>";
            }
        }      
        

        // Formulario para generar PDF
        ?>
        <style>

        .button {
            display: inline-block;
            padding: 10px 15px;
            margin: 5px;
            background-color: #28a745; /* Color verde para aceptar */
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 14px;
            font-family: Arial, sans-serif;
            text-align: center;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .button:hover {
            background-color: #218838; /* Verde más oscuro para hover */
        }

        .button-red {
            background-color: #dc3545; /* Color rojo para rechazar */
        }

        .button-red:hover {
            background-color: #c82333; /* Rojo más oscuro para hover */
        }
        </style>

        <form action="../../Static/fpdf/JustAlumRegu.php" method="POST">
            <input type="hidden" name="idJusti" value="<?php echo htmlspecialchars($solicitud['idJusti']); ?>">
            <button type="submit" class="button">Aceptar y Generar PDF</button>
        </form>

        <!-- Botón para rechazar la solicitud -->
        <button class="button button-red" onclick="cambiarEstado(<?= $solicitud['idJusti'] ?>, 'RECHAZADO')">Rechazar</button>
                <?php
    }
}else{
    echo "<p>No se encontraron datos para la solicitud.</p>";
}

// Cerrar la conexión a la base de datos
mysqli_close($conexion);
?>
