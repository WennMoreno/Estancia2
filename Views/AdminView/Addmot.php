<?php
include_once '../../Controller/GestionMotivos.php';

// Cargar los motivos existentes
$controller = new MotivoController();
$motivos = $controller->obtenerMotivos(); // Asegúrate de tener un método para obtener los motivos

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tipo = $_POST['tipo'];
    $descripcion = $_POST['descripcion'];
    $docSolicitado = $_POST['docSolicitado'];

    // Verificación de duplicados antes de agregar
    $duplicado = false; 
    foreach ($motivos as $motivo) {
        if (strtolower($motivo['tipo']) === strtolower($tipo)) {
            $duplicado = true;
            break;
        }
    }
  
    if (!$duplicado) {
        if ($controller->agregarMotivo($tipo, $descripcion, $docSolicitado)) {
            header("Location: gestionMot.php?mensaje=Motivo agregado exitosamente");
            exit();
        } else {
            //echo "Error al agregar el motivo.";
        }
    } else {
      //  echo "El motivo ya existe.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Motivo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="../../Resources/CSS/styleAddMot.css">
    
</head>
<body>
<div class="container">
    <header>
        <h1>Agregar Nuevo Motivo</h1>
    </header>
    <div class="formulario">
        <form method="POST" action="" onsubmit="return validarFormularioAgregar();">
            <label for="tipo">Tipo:</label>
            <input type="text" id="tipo" name="tipo" required>
            <p class="alert alert-danger" id="errorTipo" style="display:none;">Ingresa un tipo válido.</p>

            <label for="descripcion">Descripción:</label>
            <input type="text" id="descripcion" name="descripcion" required>
            <p class="alert alert-danger" id="errorDescripcion" style="display:none;">Ingresa una descripción válida.</p>

            <label for="docSolicitado">Documento Solicitado:</label>
            <input type="text" id="docSolicitado" name="docSolicitado" required>
            <p class="alert alert-danger" id="errorDocSolicitado" style="display:none;">Ingresa un documento solicitado válido.</p>

            <button type="submit" onclick="validarFormularioAgre();"  >Agregar</button>
            <button type="button" onclick="location.href='gestionMot.php'">Cancelar</button>
        </form>
    </div>
</div>

<script src="../../Controller/Js/ValidarM.js"></script> <!-- Asegúrate de poner la ruta correcta -->
<script src="../../Controller/Js/MotivoVal.js"></script> <!-- Asegúrate de poner la ruta correcta -->

<script>
    // Cargar motivos en una variable para validaciones
    var motivos = <?php echo json_encode($motivos); ?>;
</script>
</body>
</html>