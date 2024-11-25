<?php
include_once '../../Controller/GestionAdmin.php'; // Incluir el controlador de administradores

$controller = new AdministradorController(); // Instancia del controlador
$administradores = $controller->obtenerAdministradores(); // Obtener todos los administradores

// Manejar la eliminación de administradores
if (isset($_GET['delete_id'])) {
    $id = $_GET['delete_id'];
    if ($controller->eliminarAdministrador($id)) {
        header("Location: GestionAdmin.php?mensaje=Administrador eliminado exitosamente");
        exit();
    } else {
        echo "Error al eliminar el administrador.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Administradores</title>
    <link rel="stylesheet" href="../../Resources/CSS/styleMotivo.css">
    <link rel="stylesheet" href="../../Resources/CSS/style.css">
</head>
<body>
<!-- Sidebar -->
<div class="sidebar">
<h2 style="color: white; padding-left: 20px;">GESTIONES</h2>
   <a href="Addadmin.php">Agregar Administrador</a>
    <a href="#" onclick="toggleBusqueda()">Consulta</a>
    <a href="Gestiones.php">Regresar</a>
    <hr>
        <a href="GestionAlum.php" >Alumnos</a>
        <a href="GestionProf.php" >Profesores</a>
        <a href="gestionMot.php" class="btn-action">Motivos</a>
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

    <!-- Campo de búsqueda (inicialmente oculto) -->
    <div id="busquedaBox" class="search-container" style="display: none;">
        <label for="searchAdmin">Buscar por Nombre, Apellido o Correo:</label>
        <input type="text" id="searchAdmin" placeholder="Escribe aquí">
        
        <!-- Botón de descarga (sin botón de filtrar) -->
        <button id="btnDescargar" class="btn-descargar" onclick="descargarExcel()">Descargar Excel</button>
    </div>

    <!-- Tabla de administradores -->
    <div class="table-container">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Apellido</th>
                    <th>Correo</th>
                    <th>Actualizar</th>
                    <th>Eliminar</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($administradores as $administrador): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($administrador['idAdmin']); ?></td>
                        <td><?php echo htmlspecialchars($administrador['nombreAdmin']); ?></td>
                        <td><?php echo htmlspecialchars($administrador['apellidoAdmin']); ?></td>
                        <td><?php echo htmlspecialchars($administrador['CorreoEle']); ?></td>
                        <td>
                            <button class="btn-editar" onclick="location.href='UpAdmin.php?edit_id=<?php echo $administrador['idAdmin']; ?>'">Editar</button>
                        </td>
                        <td>
                            <button class="btn-eliminar" onclick="eliminarAdministrador(<?php echo $administrador['idAdmin']; ?>)">Eliminar</button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<script src="../../Controller/Js/AdVali.js"></script> <!-- Incluir el archivo JS para validación -->
<script>
    // Mostrar/Ocultar el campo de búsqueda y el botón de descarga
    function toggleBusqueda() {
        const busquedaBox = document.getElementById('busquedaBox');
        busquedaBox.style.display = busquedaBox.style.display === 'none' ? 'block' : 'none';
    }
    function descargarExcel() {
        // Obtener el valor del campo de búsqueda
        var searchTerm = document.getElementById('searchAdmin').value;

        // Redirigir al archivo PHP con el término de búsqueda en la URL
        window.location.href = '../../Static/fpdf/ExcelAdmin.php?searchTerm=' + encodeURIComponent(searchTerm);
    }
</script>

<!-- Pasar datos de PHP a JavaScript -->
<script>
    var administradores = <?php echo json_encode($administradores); ?>;
</script>

</body>
</html>

