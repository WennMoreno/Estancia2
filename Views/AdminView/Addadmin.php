<?php
include_once '../../Controller/GestionAdmin.php'; // Incluye el controlador de Administrador

// Cargar los administradores existentes
$controller = new AdministradorController();
$administradores = $controller->obtenerAdministradores(); // Asegúrate de tener un método para obtener los administradores

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombreAdmin'];
    $apellido = $_POST['apellidoAdmin'];
    $correo = $_POST['correoE'];
    $password = $_POST['passAd'];

    // Verificación de duplicados antes de agregar
    $duplicado = false;
    foreach ($administradores as $admin) {
        if (strtolower($admin['nombreAdmin']) === strtolower($nombre) && strtolower($admin['apellidoAdmin']) === strtolower($apellido)) {
            $duplicado = true;
            break;
        }
    }

    if (!$duplicado) {
        if ($controller->agregarAdministrador($nombre, $apellido, $password,  $correo)) {
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

            
            <label for="passAd">Correo Electrónico:</label>
            <input type="email" id="correoE" name="correoE" placeholder="Correo Electrónico" required>


            <label for="passAd">Contraseña:</label>
            <input type="password" id="passAd" name="passAd" placeholder="Contraseña" required>


            <button type="submit">Agregar</button>
            <button type="button" onclick="location.href='GestionAdmin.php'">Cancelar</button>
        </form>
    </div>
</div>
</body>
<script src="../../Controller/Js/AdVali.js"></script> <!-- Incluir el archivo JS para validación -->

<!-- Pasar datos de PHP a JavaScript -->
<script>
    var administradores = <?php echo json_encode($administradores); ?>;
    console.log(administradores); // Verifica en la consola si los datos se pasaron correctamente
</script>
</html>
