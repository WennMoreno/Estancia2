<?php
include_once '../../Controller/GestionAlumno.php';

$controller = new AlumnoController();
$alumnoEditar = null;
$alumnos = $controller->obtenerAlumnos(); // Cargar todos los alumnos

if (isset($_GET['edit_id'])) {
    $id = $_GET['edit_id'];
    $alumnoEditar = $controller->obtenerAlumnoPorId($id);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['idAlumno'])) {
    $id = $_POST['idAlumno'];
    $nombre = $_POST['nombreAlu'];
    $apellido = $_POST['apellidoAlu'];
    $fechaNac = $_POST['feNac'];
    $matricula = $_POST['matricula'];
    $correo = $_POST['correo']; // Obtener el correo electrónico
    $contrasena = $_POST['contrasena'];
    $confirmacionContra = $_POST['confirmacionContra'];
  
    // Validar si las contraseñas coinciden
    if ($contrasena !== $confirmacionContra) {
        echo "Las contraseñas no coinciden. Por favor, intenta de nuevo.";
    } else {
        // Validar duplicados antes de actualizar
        $duplicado = false;
        foreach ($alumnos as $alumno) {
            // Excluye el alumno actual de la verificación de duplicados
            if (strtolower($alumno['matricula']) === strtolower($matricula) && $alumno['idAlumno'] != $id) {
                $duplicado = true;
                break;
            }
        }

        if (!$duplicado) {
            if ($controller->modificarAlumno($id, $nombre, $apellido, $fechaNac, $matricula,$correo, $contrasena, $confirmacionContra)) {
                header("Location: GestionAlum.php?mensaje=Alumno actualizado exitosamente");
                exit();
            } else {
                //echo "Error al actualizar el alumno.";
            }
        } else {
            //echo "La matrícula ya existe. Por favor, elige una diferente.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Alumno</title>
    <link rel="stylesheet" href="../../Resources/CSS/styleAddMot.css">
    
</head>
<body>

    <div class="container">
        <header>
            <h1>Editar Alumno</h1>
        </header>
        <div class="formulario">
            <?php if ($alumnoEditar): ?>
                <form method="POST" action="" onsubmit="return validarFormularioEditar();">
                    <input type="hidden" name="idAlumno" value="<?php echo htmlspecialchars($alumnoEditar['idAlumno']); ?>">
                    
                    <label for="edit_nombre">Nombre:</label>
                    <input type="text" id="edit_nombre" name="nombreAlu" value="<?php echo htmlspecialchars($alumnoEditar['nombreAlu']); ?>" required>
                    
                    <label for="edit_apellido">Apellido:</label>
                    <input type="text" id="edit_apellido" name="apellidoAlu" value="<?php echo htmlspecialchars($alumnoEditar['apellidoAlu']); ?>" required>
                    
                    <label for="edit_feNac">Fecha de Nacimiento:</label>
                    <input type="date" id="edit_feNac" name="feNac" value="<?php echo htmlspecialchars($alumnoEditar['feNac']); ?>" required>
                    
                    <label for="edit_matricula">Matrícula:</label>
                    <input type="text" id="edit_matricula" name="matricula" value="<?php echo htmlspecialchars($alumnoEditar['matricula']); ?>" required>
                    
                    <label for="edit_correo">Correo:</label>
                    <input type="email" id="edit_correo" name="correo" value="<?php echo htmlspecialchars($alumnoEditar['correo'] ?? ''); ?>" required>


                    <label for="edit_contrasena">Contraseña:</label>
                    <input type="password" id="edit_contrasena" name="contrasena" required>
                    
                    <label for="edit_confirmacionContra">Confirmación de Contraseña:</label>
                    <input type="password" id="edit_confirmacionContra" name="confirmacionContra" required>
                    
                    <button type="submit">Actualizar</button>
                    <button type="button" onclick="location.href='GestionAlum.php'">Cancelar</button>
                </form>
            <?php endif; ?>
        </div>
    </div>
    
</body>
<script src="../../Controller/Js/ValiA.js" defer></script> <!-- Asegúrate de poner la ruta correcta -->
    <script>
        // Cargar alumnos en una variable para validaciones
        var alumnos = <?php echo json_encode($alumnos); ?>;
    </script>

</html>
