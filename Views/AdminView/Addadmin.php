<?php
include_once '../../Controller/GestionAdmin.php'; // Incluye el controlador de Administrador

// Cargar los administradores existentes
$controller = new AdministradorController();
$administradores = $controller->obtenerAdministradores(); // Asegúrate de tener un método para obtener los administradores

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombreAdmin'];
    $apellido = $_POST['apellidoAdmin'];
    $password = $_POST['passAd'];
    $confirmacionPassword = $_POST['confirmacionPassAd'];

    // Verificación de duplicados antes de agregar
    $duplicado = false;
    foreach ($administradores as $admin) {
        if (strtolower($admin['nombreAdmin']) === strtolower($nombre) && strtolower($admin['apellidoAdmin']) === strtolower($apellido)) {
            $duplicado = true;
            break;
        }
    }

    if (!$duplicado) {
        if ($controller->agregarAdministrador($nombre, $apellido, $password, $confirmacionPassword)) {
            header("Location: GestionAdmin.php?mensaje=Administrador agregado exitosamente");
            exit();
        } else {
            // echo "Error al agregar el administrador.";
        }
    } else {
        // echo "El administrador ya existe.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Administrador</title>
    <link rel="stylesheet" href="../../Resources/CSS/styleAddMot.css"> <!-- Asegúrate de poner la ruta correcta -->
</head>
<body>
<div class="container">
    <header>
        <h1>Agregar Nuevo Administrador</h1>
    </header>
    <div class="formulario">
        <form method="POST" action="" onsubmit="return validarFormularioAgregar();">
            <label for="nombreAdmin">Nombre:</label>
            <input type="text" id="nombreAdmin" name="nombreAdmin" required>

            <label for="apellidoAdmin">Apellido:</label>
            <input type="text" id="apellidoAdmin" name="apellidoAdmin" required>

            <label for="passAd">Contraseña:</label>
            <input type="password" id="passAd" name="passAd" placeholder="Contraseña" required>



            <label for="confirmacionPassAd">Confirmar Contraseña:</label>
            <input type="password" id="confirmarPassAd" name="confirmarPassAd" placeholder="Confirmar Contraseña" required>

            <button type="submit">Agregar</button>
            <button type="button" onclick="location.href='GestionAdmin.php'">Cancelar</button>
        </form>
    </div>
</div>
</body>
<script src="../../Controller/Js/Adminvali.js" defer></script> <!-- Asegúrate de poner la ruta correcta -->
<script>
    // Cargar administradores en una variable para validaciones
    var administradores = <?php echo json_encode($administradores); ?>;
</script>
</html>
