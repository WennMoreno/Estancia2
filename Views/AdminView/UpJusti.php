<?php
include_once '../../Controller/GestionJustificantes.php';
include '../../Model/Conexion.php';

$controller = new gestionJustificante($conexion);
$justificanteEditar = null;
$justificantes = $controller->obtenerJustificantes(); // Cargar todos los justificantes

if (isset($_GET['edit_id'])) {
    $id = $_GET['edit_id'];
    $justificanteEditar = $controller->obtenerJustificantePorId($id);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['idJusti'])) {
    $id = $_POST['idJusti'];
    $cuatrimestre = $_POST['cuatrimestre'];
    $grupo = $_POST['grupo'];
    $carrera = $_POST['carrera'];
    $periodoEscolar = $_POST['periodoEscolar'];
    $motivo = $_POST['motivo'];
    $motivoExtra = $_POST['motivoExtra'];
    $fecha = $_POST['fecha'];
    $horaInicio = $_POST['horaInicio'];
    $horaFin = $_POST['horaFin'];
    $estado = $_POST['estado'];

    // Validar duplicados antes de actualizar
    $duplicado = false;
    foreach ($justificantes as $justificante) {
        // Excluye el justificante actual de la verificación de duplicados
        if ($justificante['cuatrimestre'] === $cuatrimestre && $justificante['grupo'] === $grupo && $justificante['idJusti'] != $id) {
            $duplicado = true;
            break;
        }
    }

    if (!$duplicado) {
        if ($controller->modificarJustificante ($cuatrimestre, $grupo, $carrera, $periodoEscolar, $motivo, $motivoExtra, $fecha, $horaInicio, $horaFin, $estado,$id)) {
            header("Location: gestionJustiRegu.php?mensaje=Justificante actualizado exitosamente");
            exit();
        } else {
            echo "Error al actualizar el justificante.";
        }
    } else {
        echo "Ya existe un justificante con el mismo cuatrimestre y grupo. Por favor, elige uno diferente.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Justificante</title>
    <link rel="stylesheet" href="../../Resources/CSS/styleSolicitar.css">
</head>
<body>

<div class="container">
    <header>
        <h1>Editar Justificante</h1>
    </header>
    <div class="formulario">
        <?php if ($justificanteEditar): ?>
        <form method="POST" action="">
            <input type="hidden" name="idJusti" value="<?php echo $justificanteEditar['idJusti']; ?>">

            <label for="edit_cuatrimestre">Cuatrimestre:</label>
            <input type="text" id="edit_cuatrimestre" name="cuatrimestre" value="<?php echo $justificanteEditar['cuatrimestre']; ?>" required>

            <label for="edit_grupo">Grupo:</label>
            <input type="text" id="edit_grupo" name="grupo" value="<?php echo $justificanteEditar['grupo']; ?>" required>

            <label for="edit_carrera">Carrera:</label>
            <input type="text" id="edit_carrera" name="carrera" value="<?php echo $justificanteEditar['carrera']; ?>" required>

            <label for="edit_periodoEscolar">Período Escolar:</label>
            <input type="text" id="edit_periodoEscolar" name="periodoEscolar" value="<?php echo $justificanteEditar['periodoEscolar']; ?>" required>

            <label for="edit_motivo">Motivo:</label>
            <input type="text" id="edit_motivo" name="motivo" value="<?php echo $justificanteEditar['motivo']; ?>" required>

            <label for="edit_motivoExtra">Motivo Extra:</label>
            <input type="text" id="edit_motivoExtra" name="motivoExtra" value="<?php echo $justificanteEditar['motivoExtra']; ?>" required>

            <label for="edit_fecha">Fecha:</label>
            <input type="date" id="edit_fecha" name="fecha" value="<?php echo $justificanteEditar['fecha']; ?>" required>

            <label for="edit_horaInicio">Hora Inicio:</label>
            <input type="time" id="edit_horaInicio" name="horaInicio" value="<?php echo $justificanteEditar['horaInicio']; ?>" required>

            <label for="edit_horaFin">Hora Fin:</label>
            <input type="time" id="edit_horaFin" name="horaFin" value="<?php echo $justificanteEditar['horaFin']; ?>" required>

            <label for="edit_estado">Estado:</label>
            <input type="text" id="edit_estado" name="estado" value="<?php echo $justificanteEditar['estado']; ?>" required>

            <button type="submit">Actualizar</button>
            <button type="button" onclick="location.href='gestionJustiRegu.php'">Cancelar</button>
        </form>
    <?php endif; ?>

    </div>
</div>

<script src="../../Controller/Js/ValidarJ.js"></script> <!-- Asegúrate de poner la ruta correcta -->
<script>
    // Cargar justificantes en una variable para validaciones
    var justificantes = <?php echo json_encode($justificantes); ?>;
</script>
</body>
</html>
