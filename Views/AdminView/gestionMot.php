<?php
    include_once '../../Controller/MotivoController.php';
    
    $controller = new MotivoController();
    $motivos = $controller->obtenerMotivos();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Motivos</title>
</head>
<body>
    <h1>Gestión de Motivos</h1>

    <!-- Botón para agregar un nuevo motivo -->
    <button onclick="location.href='../../Controller/agregarMotivo.php'">Agregar Nuevo Motivo</button>
    
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Tipo</th>
            <th>Descripción</th>
            <th>Documento Solicitado</th>
            <th>Actualizar</th> <!-- Columna para los botones de acciones -->
            <th>Eliminar</th>
        </tr>
        <?php foreach ($motivos as $motivo): ?>
            <tr>
                <td><?php echo htmlspecialchars($motivo['idMotivo']); ?></td>
                <td><?php echo htmlspecialchars($motivo['tipo']); ?></td>
                <td><?php echo htmlspecialchars($motivo['descripcion']); ?></td>
                <td><?php echo htmlspecialchars($motivo['docSolicitado']); ?></td>
                <td>
                    <!-- Botón para editar el motivo -->
                    <button onclick="location.href='../../Controller/editarMotivo.php?id=<?php echo $motivo['idMotivo']; ?>'">Editar</button>
                </td>
                <td>
                    <!-- Botón para eliminar el motivo -->
                    <button onclick="eliminarMotivo(<?php echo $motivo['idMotivo']; ?>)">Eliminar</button>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>

    <script>
        // Función de confirmación para eliminar un motivo
        function eliminarMotivo(id) {
            if (confirm('¿Está seguro de que desea eliminar este motivo?')) {
                window.location.href = '../../Controller/eliminarMotivo.php?id=' + id; // El parámetro 'id' se mantiene
            }
        }
    </script>
</body>
</html>
