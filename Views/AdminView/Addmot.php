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
        
        <label for="descripcion">Descripción:</label>
        <input type="text" id="descripcion" name="descripcion" required>
        
        <label for="docSolicitado">Documento Solicitado:</label>
        <input type="text" id="docSolicitado" name="docSolicitado" required>
        
        <button type="submit">Agregar</button>
        <button type="button" onclick="location.href='gestionMot.php'">Cancelar</button>
    </form>
</div>
</div>
<script src="../../Controller/Js/ValidarM.js"></script> <!-- Asegúrate de poner la ruta correcta -->
    <script>
        // Cargar motivos en una variable para validaciones
        var motivos = <?php echo json_encode($motivos); ?>;
    </script>
</body>
</html>