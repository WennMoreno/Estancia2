<?php
// Ocultar advertencias
error_reporting(E_ERROR | E_PARSE);

// Conectar a la base de datos
$host = 'localhost';
$usuario = 'root';
$clave = '';
$baseDeDatos = 'gestion_justificantes';

$conexion = mysqli_connect($host, $usuario, $clave, $baseDeDatos);

if (!$conexion) {
    die("Conexión fallida: " . mysqli_connect_error());
}

// Configuración de caracteres y formato de tiempo en español
mysqli_set_charset($conexion, "utf8");
mysqli_query($conexion, "SET lc_time_names = 'es_ES'");

// Verificar si se ha recibido el ID de la solicitud
if (isset($_POST['idJusti'])) {
    $idSolicitud = intval($_POST['idJusti']);

    // Actualizar el estado de la solicitud
    $query = "UPDATE justificante SET estado = 'ACEPTADA' WHERE idJusti = $idSolicitud";
    if (mysqli_query($conexion, $query)) {
        // Obtener detalles de la solicitud
        $queryDetalles = "SELECT justificante.*, alumno.nombreAlu AS nombre, alumno.apellidoAlu AS ape, 
                                 alumno.matricula, justificante.carrera,
                                 IF(justificante.motivo = 'No aplica', justificante.motivoExtra, 
                                    IF(justificante.motivoExtra = 'No aplica', justificante.motivo, justificante.motivoExtra)) AS motivoFinal
                          FROM justificante
                          JOIN alumno ON justificante.idAlumno = alumno.idAlumno
                          WHERE justificante.idJusti = $idSolicitud";
        $result = mysqli_query($conexion, $queryDetalles);

        if ($result && mysqli_num_rows($result) > 0) {
            $solicitud = mysqli_fetch_assoc($result);
            // Agregar más datos necesarios
            $secuencia = "001"; // Cambia esto según tus necesidades
            return ['solicitud' => $solicitud, 'secuencia' => $secuencia, 'idSolicitud' => $idSolicitud, 'conexion' => $conexion];
        } else {
            echo "Error al obtener los detalles de la solicitud: " . mysqli_error($conexion);
        }
    } else {
        echo "Error al actualizar el estado de la solicitud: " . mysqli_error($conexion);
    }
} else {
    echo "ID de la solicitud no recibido.";
}


?>