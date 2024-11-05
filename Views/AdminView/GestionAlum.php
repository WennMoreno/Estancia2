<?php
include_once '../../Controller/GestionAlumno.php'; // Incluir el controlador de alumnos

$controller = new AlumnoController(); // Instancia del controlador
$alumnos = $controller->obtenerAlumnos(); // Obtener todos los alumnos

// Manejar la eliminación de alumnos
if (isset($_GET['delete_id'])) {
    $id = $_GET['delete_id'];
    if ($controller->eliminarAlumno($id)) {
        header("Location: GestionAlum.php?mensaje=Alumno eliminado exitosamente");
        exit();
    } else {
        echo "Error al eliminar el alumno.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Alumnos</title>
    <link rel="stylesheet" href="../../Resources/CSS/styleMotivo.css">
    <script src="../../Controller/Js/ValiA.js"></script> <!-- Incluir el archivo JS para validación -->

    <!-- Pasar datos de PHP a JavaScript -->
    <script>
        var alumnos = <?php echo json_encode($alumnos); ?>;
    </script>
</head>
<body>
<header>
    <div class="logo">
        <img src="../../Resources/img/logo.png" alt="Logo">
    </div>
    <h1>Gestión de Alumnos</h1>
    <nav>
        <a href="Gestiones.php" class="cerrar">Regresar</a>
    </nav>
</header>

<button class="btn-agregar" onclick="location.href='Addalum.php'">Agregar Nuevo Alumno</button>
<div class="table-container"> 
    <table>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Apellido</th>
            <th>Matrícula</th>
            
            <th>Actualizar</th>
            <th>Eliminar</th>
        </tr>
        <?php foreach ($alumnos as $alumno): ?>
            <tr>
                <td><?php echo htmlspecialchars($alumno['idAlumno']); ?></td>
                <td><?php echo htmlspecialchars($alumno['nombreAlu']); ?></td>
                <td><?php echo htmlspecialchars($alumno['apellidoAlu']); ?></td>
                <td><?php echo htmlspecialchars($alumno['matricula']); ?></td>
                <td>
                    <button class="btn-editar" onclick="location.href='Uppalum.php?edit_id=<?php echo $alumno['idAlumno']; ?>'">Editar</button>
                </td>
                <td>
                    <button class="btn-eliminar" onclick="eliminarAlumno(<?php echo $alumno['idAlumno']; ?>)">Eliminar</button>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</div>



</body>
</html>
