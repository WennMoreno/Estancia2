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
   
</head>
<body>
<header>
    <div class="logo">
        <img src="../../Resources/img/logo.png" alt="Logo">
    </div>
    <h1>Gestión de Administradores</h1>
    <nav>
        <a href="Gestiones.php" class="cerrar">Regresar</a>
    </nav>
</header>

<button class="btn-agregar" onclick="location.href='Addadmin.php'">Agregar Nuevo Administrador</button>
<button class="btn-descargar" onclick="location.href='../../Static/fpdf/ExcelAdmin.php'">Descargar Excel</button>

<div class="table-container"> 
    <table>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Apellido</th>
            <th>Correo</th>
            <th>Actualizar</th>
            <th>Eliminar</th>
        </tr>
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
    </table>
</div>
<script src="../../Controller/Js/AdVali.js"></script> <!-- Incluir el archivo JS para validación -->

<!-- Pasar datos de PHP a JavaScript -->
<script>
    var administradores = <?php echo json_encode($administradores); ?>;
</script>


</body>
</html>
