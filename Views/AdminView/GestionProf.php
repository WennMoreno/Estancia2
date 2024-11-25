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
    <link rel="stylesheet" href="../../Resources/CSS/style.css">

</head>
<body>
    <div class="sidebar">
        <h2 style="color: white; padding-left: 20px;">GESTIONES</h2>
        <a href="Addprof.php">Agregar Profesor</a>
        <a href="#" onclick="toggleConsulta()">Consulta</a>
        <a href="Gestiones.php">Regresar</a>
        <hr>
        <a href="GestionAlum.php" >Alumnos</a>
        <a href="GestionAdmin.php">Administradores</a>
        <a href="gestionMot.php" class="btn-action">Motivos</a>
        <a href="ListaPDF.php">Oficios</a>
        <a href="gestionJustiRegu.php" class="btn-action">Justificantes Regulares</a>
    </div>

    
</div>
    <!-- Contenido Principal -->
    <div class="main-content">
        <header>
            <div class="logo">
                <img src="../../Resources/img/logo.png" alt="Logo">
            </div>
            <h1>Sistema para la gestion de Jestificantes</h1>
        </header>

        <!-- Contenedor del ComboBox (inicialmente oculto) -->
        <div id="consultaBox" class="combo-box-container">
            <form action="../../Static/fpdf/ExcelProf.php" method="POST">
                <label for="consultaTipo">Seleccione una opción:</label>
                <select name="consultaTipo" id="consultaTipo">
                    <option value="PA">PA</option>
                    <option value="PTC">PTC</option>
                </select>
                <button type="submit" class="btn-descargar">Generar Excel</button>
            </form>
        </div>



    <div class="table-container"> 
        <table>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Puesto</th>
                <th>Correo Electrónico</th>
                <th>Actualizar</th>
                <th>Eliminar</th>
            </tr>
            <?php foreach ($profesores as $profesor): ?>
            <tr>
                <td><?php echo htmlspecialchars($profesor['idProf'] ?? ''); ?></td>
                <td><?php echo htmlspecialchars($profesor['nombreProf'] ?? ''); ?></td> <!-- Cambiado a 'nombreProf' -->
                <td><?php echo htmlspecialchars($profesor['apellidoProf'] ?? ''); ?></td> <!-- Cambiado a 'apellidoProf' -->
                <td><?php echo htmlspecialchars($profesor['puesto'] ?? ''); ?></td>
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

    <!-- Script para mostrar/ocultar el ComboBox -->
    <script>
        function toggleConsulta() {
            var consultaBox = document.getElementById("consultaBox");
            if (consultaBox.style.display === "none" || consultaBox.style.display === "") {
                consultaBox.style.display = "block";
            } else {
                consultaBox.style.display = "none";
            }
        }
    </script>

    <script src="../../Controller/Js/ValidarP.js"></script> 

    <!-- Pasar datos de PHP a JavaScript -->
    <script>
        var profesores = <?php echo json_encode($profesores); ?>;
    </script>
</body>
</html>
