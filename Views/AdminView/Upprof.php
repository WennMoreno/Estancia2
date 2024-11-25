<?php
include_once '../../Controller/GestionProfesores.php';

$controller = new ProfesorController();
$profesorEditar = null;
$profesores = $controller->obtenerProfesores(); // Cargar todos los profesores

if (isset($_GET['edit_id'])) {
    $id = $_GET['edit_id'];
    $profesorEditar = $controller->obtenerProfesorPorId($id);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['idProfesor'])) {
    $id = $_POST['idProfesor'];
    $nombreProf = $_POST['nombreProf'];
    $apellidoProf = $_POST['apellidoProf'];
    $puesto = $_POST['puesto'];
    $passwordProf = $_POST['passwordProf'];
    $correoElectronico = $_POST['correoElectronico'];

    // Validar duplicados antes de actualizar
    $duplicado = false;
    foreach ($profesores as $profesor) {
        // Excluye el profesor actual de la verificación de duplicados
        if (strtolower($profesor['correoElectronico']) === strtolower($correoElectronico) && $profesor['idProf'] != $id) {
            $duplicado = true;
            break;
        }
    }

    if (!$duplicado) {
        if ($controller->modificarProfesor($id, $nombreProf, $apellidoProf, $puesto, $passwordProf, $correoElectronico)) {
            header("Location: GestionProf.php?mensaje=Profesor actualizado exitosamente");
            exit();
        } else {
            echo "Error al actualizar el profesor.";
        }
    } else {
        echo "El correo electrónico ya existe. Por favor, elige uno diferente.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Profesor</title>
    <link rel="stylesheet" href="../../Resources/CSS/styleAddMot.css">
    
</head>
<body>
<div class="container">
    <header>
        <h1>Editar Profesor</h1>
    </header>

    <div class="formulario">
        <?php if ($profesorEditar): ?>
            <form method="POST" action="" onsubmit="return validarFormularioEditarProfesor();">
            <input type="hidden" name="idProfesor" value="<?php echo htmlspecialchars($profesorEditar['idProf']); ?>">

                <label for="edit_nombreProf">Nombre:</label>
                <input type="text" id="edit_nombreProf" name="nombreProf" value="<?php echo htmlspecialchars($profesorEditar['nombreProf']); ?>" required>
                
                <label for="edit_apellidoProf">Apellido:</label>
                <input type="text" id="edit_apellidoProf" name="apellidoProf" value="<?php echo htmlspecialchars($profesorEditar['apellidoProf']); ?>" required>
                
                <label for="puesto">Puesto/Cargo:</label>
                <input type="text" id="puesto" name="puesto" value="<?php echo htmlspecialchars($profesorEditar['puesto']); ?>" required>

                <label for="edit_passwordProf">Contraseña:</label>
                <input type="text" id="edit_passwordProf" name="passwordProf" value="<?php echo htmlspecialchars($profesorEditar['passwordProf']); ?>" required>
                
                <label for="edit_correoElectronico">Correo Electrónico:</label>
                <input type="email" id="edit_correoElectronico" name="correoElectronico" value="<?php echo htmlspecialchars($profesorEditar['correoElectronico']); ?>" required>
                
                <button type="submit">Actualizar</button>
                <button type="button" onclick="location.href='GestionProf.php'">Cancelar</button>
            </form>
        <?php endif; ?>
    </div>
</div>
<script src="../../Controller/Js/ValidarP.js"></script> 
    <script>
        // Cargar profesores en una variable para validaciones
        var profesores = <?php echo json_encode($profesores); ?>;
    </script>
</body>
</html>
