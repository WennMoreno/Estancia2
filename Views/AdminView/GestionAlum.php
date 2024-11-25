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
    <link rel="stylesheet" href="../../Resources/CSS/style.css">
    
    <script src="../../Controller/Js/ValiA.js"></script> 

    <!-- Pasar datos de PHP a JavaScript -->
    <script>
        var alumnos = <?php echo json_encode($alumnos); ?>;
    </script>
</head>
<body>
<!-- Sidebar -->
<div class="sidebar">
    <h2 style="color: white; padding-left: 20px;">GESTIONES</h2>
    <a href="Addalum.php">Agregar Alumno</a>
    <a href="#" onclick="toggleBusqueda()">Consulta</a>
    <a href="Gestiones.php">Regresar</a>
    <hr>
    <a href="GestionAdmin.php">Administradores</a>
    <a href="GestionProf.php" >Profesores</a>
    <a href="gestionMot.php">Motivos</a>
    <a href="ListaPDF.php">Oficios</a>
    <a href="gestionJustiRegu.php">Justificantes Regulares</a>
</div>



<!-- Contenido Principal -->
<div class="main-content">
    <header>
        <div class="logo">
            <img src="../../Resources/img/logo.png" alt="Logo">
        </div>
        <h1>Sistema para la gestión de Justificantes</h1>
    </header>

    <!-- Campo de búsqueda (inicialmente oculto) -->
    <div id="busquedaBox" class="search-container" style="display: none;">
        <label for="searchAlumno">Buscar por Matrícula o Apellido:</label>
        <input type="text" id="searchAlumno" placeholder="Escribe Matrícula o Apellido">
        <button onclick="generarExcel()">Descargar Excel Filtrado</button>
    </div>

    <div class="table-container">
        <table>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Matrícula</th>
                <th>Correo</th>
                <th>Actualizar</th>
                <th>Eliminar</th>
            </tr>
            <?php foreach ($alumnos as $alumno): ?>
                <tr>
                    <td><?php echo htmlspecialchars($alumno['idAlumno']); ?></td>
                    <td><?php echo htmlspecialchars($alumno['nombreAlu']); ?></td>
                    <td><?php echo htmlspecialchars($alumno['apellidoAlu']); ?></td>
                    <td><?php echo htmlspecialchars($alumno['matricula']); ?></td>
                    <td><?php echo htmlspecialchars($alumno['correoE']); ?></td>
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

<script>
    // Mostrar/Ocultar el campo de búsqueda
    function toggleBusqueda() {
        const busquedaBox = document.getElementById('busquedaBox');
        busquedaBox.style.display = busquedaBox.style.display === 'none' ? 'block' : 'none';
    }

    // Filtrar alumnos por matrícula o apellido
    /*document.getElementById('searchAlumno').addEventListener('input', function () {
        const filter = this.value.toLowerCase();
        const rows = document.querySelectorAll('table tbody tr');
        
        rows.forEach(row => {
            const apellido = row.cells[2].textContent.toLowerCase();
            const matricula = row.cells[3].textContent.toLowerCase();
            
            row.style.display = apellido.includes(filter) || matricula.includes(filter) ? '' : 'none';
        });
    });*/

    function generarExcel() {
        const filtro = document.getElementById('searchAlumno').value;
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '../../Static/fpdf/ExcelAlum.php';

        const inputFiltro = document.createElement('input');
        inputFiltro.type = 'hidden';
        inputFiltro.name = 'filtro';
        inputFiltro.value = filtro;

        form.appendChild(inputFiltro);
        document.body.appendChild(form);
        form.submit();
    }

</script>



</body>
</html>
