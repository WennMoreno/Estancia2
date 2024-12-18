<?php
include_once '../../Controller/GestionJustificantes.php';
include_once '../../Controller/GestionJustiProfe.php';
include '../../Model/Conexion.php';

$controller = new gestionJustificante($conexion);
$justificantes = $controller->obtenerJustificantes(); 


$controllerPro = new gestionJustiProfe($conexion);
$justificantesPro = $controllerPro->mostrarJustificantesProfesores(); 

// Manejar la eliminación de justificantes
if (isset($_GET['delete_id'])) {
    $id = $_GET['delete_id'];
    if ($controller->eliminarJustificante($id)) {
        header("Location: gestionJustiRegu.php?mensaje=Justificante eliminado exitosamente");
        exit();
    } else {
        echo "Error al eliminar el justificante.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Justificantes</title>
    <link rel="stylesheet" href="../../Resources/CSS/styleMotivo.css">
</head>
<body>
<header>
    <div class="logo">
        <img src="../../Resources/img/logo.png" alt="Logo">
    </div>
    <h1>Gestión de Justificantes</h1>
    <nav>
        <a href="Gestiones.php" class="cerrar">Regresar</a>
    </nav>
</header>


<button class="btn-descargar" onclick="location.href='../../Static/fpdf/ExportarExcelJustificantes.php'">Descargar Excel</button>

<h1 align="center">Listado de Justificantes</h1>
<div class="table-container">
    <table>
        <tr>
            <th>ID</th>
            <th>Alumno</th>
            <th>Cuatrimestre</th>
            <th>Grupo</th>
            <th>Carrera</th>
            <th>Período Escolar</th>
            <th>Motivo</th>
            <th>Motivo Extra</th>
            <th>Fecha</th>
            <th>¿Se ausentó todo el día?</th>
            <th>Hora Inicio</th>
            <th>Hora Fin</th>
            <th>Estado</th>
            <th>Actualizar</th>
            <th>Eliminar</th>
        </tr>
        <?php foreach ($justificantes as $justificante): ?>
            <tr>
                <td><?php echo htmlspecialchars($justificante['idJusti']); ?></td>
                <td><?php echo htmlspecialchars($justificante['nombreAlu'] . ' ' . $justificante['apellidoAlu']); ?></td>
                <td><?php echo htmlspecialchars($justificante['cuatrimestre']); ?></td>
                <td><?php echo htmlspecialchars($justificante['grupo']); ?></td>
                <td><?php echo htmlspecialchars($justificante['carrera']); ?></td>
                <td><?php echo htmlspecialchars($justificante['periodoEscolar']); ?></td>   
                <td><?php echo htmlspecialchars($justificante['motivo']); ?></td>
                <td><?php echo htmlspecialchars($justificante['motivoExtra']); ?></td>
                <td><?php echo htmlspecialchars($justificante['fecha']); ?></td>
                <td><?php echo htmlspecialchars($justificante['ausenteTodoDia']); ?></td>
                <td><?php echo htmlspecialchars($justificante['horaInicio']); ?></td>
                <td><?php echo htmlspecialchars($justificante['horaFin']); ?></td>
                <td><?php echo htmlspecialchars($justificante['estado']); ?></td>
                <td>
                    <button class="btn-editar" onclick="location.href='UpJusti.php?edit_id=<?php echo $justificante['idJusti']; ?>'">Editar</button>
                </td>
                <td>
                    <button class="btn-eliminar" onclick="eliminarJustificante(<?php echo $justificante['idJusti']; ?>)">Eliminar</button>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</div>

<h1 align="center">Listado de Justificantes por Profesor</h1>
    <table border="1" align="center">
        <thead>
            <tr>
                <th>ID Justificante</th>
                <th>Motivo Justificante</th>
                <th>Nombre Profesor</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($justificantesPro as $item): ?>
                <tr>
                    <td><?= htmlspecialchars($item['idJusti']) ?></td>
                    <td><?= htmlspecialchars($item['motivo']) ?></td>
                    <td><?= htmlspecialchars($item['nombreProf'] . ' ' . $item['apellidoProf']) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

<script src="../../Controller/Js/ValidarJ.js"></script>
</body>
</html>
