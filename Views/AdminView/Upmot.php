<?php
include_once '../../Controller/GestionMotivos.php';

$controller = new MotivoController();
$motivoEditar = null;
$motivos = $controller->obtenerMotivos(); // Cargar todos los motivos

if (isset($_GET['edit_id'])) {
    $id = $_GET['edit_id'];
    $motivoEditar = $controller->obtenerMotivoPorId($id);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['idMotivo'])) {
    $id = $_POST['idMotivo'];
    $tipo = $_POST['tipo'];
    $descripcion = $_POST['descripcion'];
    $docSolicitado = $_POST['docSolicitado'];

    // Validar duplicados antes de actualizar
    $duplicado = false;
    foreach ($motivos as $motivo) {
        // Excluye el motivo actual de la verificación de duplicados
        if (strtolower($motivo['tipo']) === strtolower($tipo) && $motivo['idMotivo'] != $id) {
            $duplicado = true;
            break;
        }
    }

    if (!$duplicado) {
        if ($controller->modificarMotivo($id, $tipo, $descripcion, $docSolicitado)) {
            header("Location: gestionMot.php?mensaje=Motivo actualizado exitosamente");
            exit();
        } else {
            echo "Error al actualizar el motivo.";
        }
    } else {
        echo "El tipo ya existe. Por favor, elige uno diferente.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Motivo</title>
    <link rel="stylesheet" href="../../Resources/CSS/styleAddMot.css">
    
</head>
<body>

    <div class="container">
    <header>
            <h1>Editar Motivo</h1>
        </header>
    <div class="formulario">
    <?php if ($motivoEditar): ?>
        <form method="POST" action="" onsubmit="return validarFormularioEditar();">
            <input type="hidden" name="idMotivo" value="<?php echo htmlspecialchars($motivoEditar['idMotivo']); ?>">
            
            <label for="edit_tipo">Tipo:</label>
            <input type="text" id="edit_tipo" name="tipo" value="<?php echo htmlspecialchars($motivoEditar['tipo']); ?>" required>
            
            <label for="edit_descripcion">Descripción:</label>
            <input type="text" id="edit_descripcion" name="descripcion" value="<?php echo htmlspecialchars($motivoEditar['descripcion']); ?>" required>
            
            <label for="edit_docSolicitado">Documento Solicitado:</label>
            <input type="text" id="edit_docSolicitado" name="docSolicitado" value="<?php echo htmlspecialchars($motivoEditar['docSolicitado']); ?>" required>
            
            <button type="submit">Actualizar</button>
            <button type="button" onclick="location.href='gestionMot.php'">Cancelar</button>
        </form>
    <?php endif; ?>
    </div>
    </div>
    <script src="../../Controller/Js/ValidarM.js"></script>  <!-- Asegúrate de poner la ruta correcta -->
    <script>
        // Cargar motivos en una variable para validaciones
        var motivos = <?php echo json_encode($motivos); ?>;
    </script>
</body>
</html>
