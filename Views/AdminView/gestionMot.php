<?php
include_once '../../Controller/GestionMotivos.php';

$controller = new MotivoController();
$motivos = $controller->obtenerMotivos();

// Manejar la eliminación de motivos
if (isset($_GET['delete_id'])) {
    $id = $_GET['delete_id'];
    if ($controller->eliminarMotivo($id)) {
        header("Location: gestionMot.php?mensaje=Motivo eliminado exitosamente");
        exit();
    } else {
        echo "Error al eliminar el motivo.";
    }
}  
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Motivos</title>
    <link rel="stylesheet" href="../../Resources/CSS/styleMotivo.css">
    
</head>
<body>
<header>
        <div class="logo">
            <img src="../../Resources/img/logo.png" alt="Logo">
        </div>
        <h1>Gestión de Motivos</h1>
        <nav>
            <a href="Gestiones.php " class="cerrar">Regresar</a>
        </nav>
    </header>
    

    <button class="btn-agregar" onclick="location.href='Addmot.php'">Agregar Nuevo Motivo</button>
<button class="btn-descargar" onclick="location.href='../../Static/fpdf/ExportarExcel.php'">Descargar Excel</button>

    <div class="table-container"> 
        <table >
            <tr>
                <th>ID</th>
                <th>Tipo</th>
                <th>Descripción</th>
                <th>Documento Solicitado</th>
                <th>Actualizar</th>
                <th>Eliminar</th>
            </tr>
            <?php foreach ($motivos as $motivo): ?>
                <tr>
                    <td><?php echo htmlspecialchars($motivo['idMotivo']); ?></td>
                    <td><?php echo htmlspecialchars($motivo['tipo']); ?></td>
                    <td><?php echo htmlspecialchars($motivo['descripcion']); ?></td>
                    <td><?php echo htmlspecialchars($motivo['docSolicitado']); ?></td>
                    <td>
                        <button class="btn-editar"  onclick="location.href='Upmot.php?edit_id=<?php echo $motivo['idMotivo']; ?>'">Editar</button>
                    </td>
                    <td>
                        <button class="btn-eliminar"  onclick="eliminarMotivo(<?php echo $motivo['idMotivo']; ?>)">Eliminar</button>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
    <script src="../../Controller/Js/ValidarM.js"></script> <!-- Incluir el archivo JS aquí -->

    <!-- Pasar datos de PHP a JavaScript -->
    <script>
        var motivos = <?php echo json_encode($motivos); ?>;
    </script>
</body>
</html>
