<?php
include_once '../../Controller/GestionProfesores.php';

$controller = new ProfesorController();
$profesores = $controller->obtenerProfesores();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombreProf = $_POST['nombreProf'];
    $apellidoProf = $_POST['apellidoProf'];
    $passwordProf = $_POST['passwordProf'];
    $correoElectronico = $_POST['correoElectronico'];

    $duplicado = false;
    foreach ($profesores as $profesor) {
        if (strtolower($profesor['correoElectronico']) === strtolower($correoElectronico)) {
            $duplicado = true;
            break;
        }
    }

    if (!$duplicado) {
        if ($controller->agregarProfesor($nombreProf, $apellidoProf, $passwordProf, $correoElectronico)) {
            header("Location: GestionProf.php?mensaje=Profesor agregado exitosamente");
            exit();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Profesor</title>
    <link rel="stylesheet" href="../../Resources/CSS/styleAddMot.css">
</head>
<body>
<div class="container">
    <header>
        <h1>Agregar Nuevo Profesor</h1>
    </header>

    <div class="formulario">
        <form method="POST" action="" onsubmit="return validarFormularioAgregar();">
            <label for="nombreProf">Nombre:</label>
            <input type="text" id="nombreProf" name="nombreProf" required>
            
            <label for="apellidoProf">Apellido:</label>
            <input type="text" id="apellidoProf" name="apellidoProf" required>
            
            <label for="passwordProf">Contraseña:</label>
            <input type="password" id="passwordProf" name="passwordProf" required>
            
            <label for="correoElectronico">Correo Electrónico:</label>
            <input type="email" id="correoElectronico" name="correoElectronico" required>
                        
            <button type="submit">Agregar</button>
            <button type="button" onclick="location.href='GestionProf.php'">Cancelar</button>
        </form>
    </div>
</div>

<script>
    var profesores = <?php echo json_encode($profesores); ?>;
</script>
<script src="../../Controller/Js/ValidarP.js"></script>
</body>
</html>
