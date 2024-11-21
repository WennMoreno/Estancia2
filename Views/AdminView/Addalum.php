<?php
include_once '../../Controller/GestionAlumno.php';

// Cargar los alumnos existentes
$controller = new AlumnoController();
$alumnos = $controller->obtenerAlumnos(); // Asegúrate de tener un método para obtener los alumnos

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $fechaNac = $_POST['fechaNac'];
    $matricula = $_POST['matricula'];
    $correo = $_POST['correo']; // Obtener el correo electrónico
    $contrasena = $_POST['contrasena'];
    $confirmacionContra=$_POST['confirmacionContra'];
    // Verificación de duplicados antes de agregar
    $duplicado = false;
    foreach ($alumnos as $alumno) {
        if (strtolower($alumno['matricula']) === strtolower($matricula)) {
            $duplicado = true;
            break;
        }
    }  

    if (!$duplicado) {
        if ($controller->agregarAlumno($nombre, $apellido, $fechaNac, $matricula, $correo, $contrasena,$confirmacionContra)) {
            header("Location: GestionAlum.php?mensaje=Alumno agregado exitosamente");
            exit();
        } else {
           // echo "Error al agregar el alumno.";
        }
    } else {
       // echo "La matrícula ya existe.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Alumno</title>
    <link rel="stylesheet" href="../../Resources/CSS/styleAddMot.css"> <!-- Asegúrate de poner la ruta correcta -->
    
</head>
<body>
<div class="container">
    <header>
        <h1>Agregar Nuevo Alumno</h1>
    </header>
    <div class="formulario">
        <form method="POST" action="" onsubmit="return validarFormularioAgregar();">
            <label for="nombre">Nombre:</label>
            <input type="text" id="nombre" name="nombre" required>

            <label for="apellido">Apellido:</label>
            <input type="text" id="apellido" name="apellido" required>

            <label for="fechaNac">Fecha de Nacimiento:</label>
            <input type="date" id="fechaNac" name="fechaNac" required>

            <label for="matricula">Matrícula:</label>
            <input type="text" id="matricula" name="matricula" required>

            <label for="correo">Correo:</label>
            <input type="email" id="correo" name="correo" required>

            <label for="contrasena">Contraseña:</label>
            <input type="password" id="contrasena" name="contrasena" required>

            <label for="confirmacion_contrasena">Confirmar Contraseña:</label>
            <input type="password" id="confirmacionContra" name="confirmacionContra" required>

            <button type="submit">Agregar</button>
            <button type="button" onclick="location.href='GestionAlum.php'">Cancelar</button>
        </form>
    </div>
</div>
</body>
<script src="../../Controller/Js/ValiA.js" defer></script> <!-- Asegúrate de poner la ruta correcta -->
    <script>
        // Cargar alumnos en una variable para validaciones
        var alumnos = <?php echo json_encode($alumnos); ?>;
    </script>
</html>
