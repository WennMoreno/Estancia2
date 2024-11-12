<?php
include_once '../../Controller/GestionProfesores.php';

$controller = new ProfesorController();
$profesores = $controller->obtenerProfesores();

// Manejar la eliminación de profesores
if (isset($_GET['delete_id'])) {
    $id = $_GET['delete_id'];
    if ($controller->eliminarProfesor($id)) {
        header("Location: GestionProf.php?mensaje=Profesor eliminado exitosamente");
        exit();
    } else {
        echo "Error al eliminar el profesor.";
    }
}
?>
  
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Profesores</title>
    <link rel="stylesheet" href="../../Resources/CSS/styleMotivo.css">
    
</head>
<body>
    <header>
        <div class="logo">
            <img src="../../Resources/img/logo.png" alt="Logo">
        </div>
        <h1>Gestión de Profesores</h1>
        <nav>
            <a href="Gestiones.php" class="cerrar">Regresar</a>
        </nav>
    </header>

    <button class="btn-agregar" onclick="location.href='Addprof.php'">Agregar Nuevo Profesor</button>
    <button class="btn-descargar" onclick="location.href='../../Static/fpdf/ExcelProf.php'">Descargar Excel</button>
    <div class="table-container"> 
        <table>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Correo Electrónico</th>
                <th>Actualizar</th>
                <th>Eliminar</th>
            </tr>
            <?php foreach ($profesores as $profesor): ?>
            <tr>
                <td><?php echo htmlspecialchars($profesor['idProf'] ?? ''); ?></td>
                <td><?php echo htmlspecialchars($profesor['nombreProf'] ?? ''); ?></td> <!-- Cambiado a 'nombreProf' -->
                <td><?php echo htmlspecialchars($profesor['apellidoProf'] ?? ''); ?></td> <!-- Cambiado a 'apellidoProf' -->
                <td><?php echo htmlspecialchars($profesor['correoElectronico'] ?? ''); ?></td>
                <td>
                    <button class="btn-editar" onclick="location.href='Upprof.php?edit_id=<?php echo isset($profesor['idProf']) ? $profesor['idProf'] : ''; ?>'">Editar</button>
                </td>
                <td>
                    <button class="btn-eliminar" onclick="eliminarProfesor(<?php echo isset($profesor['idProf']) ? $profesor['idProf'] : ''; ?>)">Eliminar</button>
                </td>
            </tr>
        <?php endforeach; ?>
        </table>
    </div>

    <script src="../../Controller/Js/ValidarP.js"></script> 

    <!-- Pasar datos de PHP a JavaScript -->
    <script>
        var profesores = <?php echo json_encode($profesores); ?>;
    </script>
</body>
</html>
