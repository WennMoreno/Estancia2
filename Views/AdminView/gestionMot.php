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
    <link rel="stylesheet" href="../../Resources/CSS/style.css">

</head>
<body>
<div class="sidebar">
        <h2 style="color: white; padding-left: 20px;">GESTIONES</h2>
        <a href="Addmot.php">Agregar Motivo</a>
        <a href="#" onclick="toggleConsulta()">Consulta</a>
        <a href="Gestiones.php">Regresar</a>
    <hr>
    <a href="GestionAlum.php" >Alumnos</a>
    <a href="GestionAdmin.php">Administradores</a>
    <a href="GestionProf.php" >Profesores</a>
    <a href="ListaPDF.php">Oficios</a>
    <a href="gestionJustiRegu.php" class="btn-action">Justificantes Regulares</a>
    
</div>

    
<!-- Contenido Principal -->
<div class="main-content">
    <header>
        <div class="logo">
            <img src="../../Resources/img/logo.png" alt="Logo">
        </div>
        <h1>Sistema para la gestión de Justificantes</h1>
    </header>

    

    <!-- Campo de búsqueda -->
    <div id="consultaBox" class="search-container" style="display: none;">
        <label for="searchInput">Buscar por Documento Solicitado:</label>
        <input type="text" id="searchInput" placeholder="Escribe aquí (PDF, Foto, etc.)">
        <button onclick="generarExcel()">Descargar Excel Filtrado</button>
    </div>


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
    <script>
        // Filtrar resultados en la tabla según la búsqueda
        document.getElementById('searchInput').addEventListener('input', function () {
            const filter = this.value.toLowerCase();
            const rows = document.querySelectorAll('#motivosTable tbody tr');
            rows.forEach(row => {
                const docSolicitado = row.cells[3].textContent.toLowerCase();
                row.style.display = docSolicitado.includes(filter) ? '' : 'none';
            });
        });

        // Generar Excel Filtrado
        function generarExcel() {
            const filtro = document.getElementById('searchInput').value;
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '../../Static/fpdf/ExportarExcel.php';

            const inputFiltro = document.createElement('input');
            inputFiltro.type = 'hidden';
            inputFiltro.name = 'filtro';
            inputFiltro.value = filtro;

            form.appendChild(inputFiltro);
            document.body.appendChild(form);
            form.submit();
        }
        function toggleConsulta() {
            const consultaBox = document.getElementById("consultaBox");
            const searchBox = document.getElementById("searchBox");

            // Alternar la visibilidad de ambos contenedores
            if (consultaBox.style.display === "none") {
                consultaBox.style.display = "block";
                searchBox.style.display = "block";
            } else {
                consultaBox.style.display = "none";
                searchBox.style.display = "none";
            }
        }
        </script>
    <script src="../../Controller/Js/ValidarM.js"></script> <!-- Incluir el archivo JS aquí -->

    <!-- Pasar datos de PHP a JavaScript -->
    <script>
        var motivos = <?php echo json_encode($motivos); ?>;
    </script>
</body>
</html>