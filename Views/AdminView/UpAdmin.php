<?php
include_once '../../Controller/GestionAdmin.php'; // Incluye el controlador de Administrador

$controller = new AdministradorController();
$administradorEditar = null;
$administradores = $controller->obtenerAdministradores(); // Cargar todos los administradores

if (isset($_GET['edit_id'])) {
    $id = $_GET['edit_id'];
    $administradorEditar = $controller->obtenerAdministradorPorId($id); // Obtener administrador por ID
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['idAdmin'])) {
    $id = $_POST['idAdmin'];
    $nombreAdmin = $_POST['nombreAdmin'] ?? ''; // Uso del operador null coalescente
    $apellidoAdmin = $_POST['apellidoAdmin'] ?? '';
    $passAd = $_POST['passAd'] ?? ''; // Contraseña

    // Validar duplicados antes de actualizar
    $duplicado = false;
    foreach ($administradores as $admin) {
        // Excluye el administrador actual de la verificación de duplicados
        if (strtolower($admin['nombreAdmin']) === strtolower($nombreAdmin) && strtolower($admin['apellidoAdmin']) === strtolower($apellidoAdmin) && $admin['idAdmin'] != $id) {
            $duplicado = true;
            break;
        }
    }

    if (!$duplicado) {
        // Llama al método para actualizar el administrador
        if ($controller->modificarAdministrador($id, $nombreAdmin, $apellidoAdmin, $passAd)) {
            header("Location: GestionAdmin.php?mensaje=Administrador actualizado exitosamente");
            exit();
        } else {
            echo "Error al actualizar el administrador.";
        }
    } else {
        echo "El administrador con ese nombre y apellido ya existe. Por favor, elige uno diferente.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Administrador</title>
    <link rel="stylesheet" href="../../Resources/CSS/styleAddMot.css">
</head>
<body>
<div class="container">
    <header>
        <h1>Editar Administrador</h1>
    </header>

    <div class="formulario">
        <?php if ($administradorEditar): ?>
            <form method="POST" action="" onsubmit="return validarFormularioEditarAdministrador();">
            <input type="hidden" name="idAdmin" value="<?php echo htmlspecialchars($administradorEditar['idAdmin']); ?>">

                <label for="edit_nombreAdmin">Nombre:</label>
                <input type="text" id="edit_nombreAdmin" name="nombreAdmin" value="<?php echo htmlspecialchars($administradorEditar['nombreAdmin']); ?>" required>
                
                <label for="edit_apellidoAdmin">Apellido:</label>
                <input type="text" id="edit_apellidoAdmin" name="apellidoAdmin" value="<?php echo htmlspecialchars($administradorEditar['apellidoAdmin']); ?>" required>
                
                <label for="edit_passAd">Contraseña:</label>
                <input type="password" id="edit_passAd" name="edit_passAd" placeholder="Nueva Contraseña">

                <label for="confirmacionPassAd">Confirmar Contraseña:</label>
                <input type="password" id="edit_confirmarPassAd" name="edit_confirmarPassAd" placeholder="Confirmar Nueva Contraseña">
                <button type="submit">Actualizar</button>
                <button type="button" onclick="location.href='GestionAdmin.php'">Cancelar</button>
            </form>
        <?php endif; ?>
    </div>
</div>
<script src="../../Controller/Js/Adminvali.js"></script>
<script>
    // Cargar administradores en una variable para validaciones
    var administradores = <?php echo json_encode($administradores); ?>;
</script>
</body>
</html>
