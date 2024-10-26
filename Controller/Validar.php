<?php
include '../Model/Conexion.php';
include '../Model/Alumno.php';
include '../Model/Profesor.php';
include '../Model/Administrador.php';

session_start();

if (isset($_POST['Usuario']) && isset($_POST['Contraseña'])) {
    function validate($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    $usuario = validate($_POST['Usuario']);
    $clave = validate($_POST['Contraseña']);

    if (empty($usuario)) {
        header("Location: ../Views/login.php?error=El Usuario es Requerido");
        exit();
    } elseif (empty($clave)) {
        header("Location: ../Views/login.php?error=La Contraseña es Requerida");
        exit();
    } else {

        // Crear instancia de cada modelo
        $alumnoModel = new Alumno($conexion);
        $profesorModel = new Profesor($conexion);
        $adminModel = new Administrador($conexion);

        // Validar credenciales de cada tipo de usuario
        $resultAlumno = $alumnoModel->validarAlumno($usuario, $clave);
        $resultProfesor = $profesorModel->validarProfesor($usuario, $clave);
        $resultAdmin = $adminModel->validarAdmin($usuario, $clave);

        // Validación para alumnos
        if ($resultAlumno->num_rows === 1) {
            $row = $resultAlumno->fetch_assoc();
            $_SESSION['identificador'] = $row['identificador'];
            $_SESSION['nombre'] = $row['nombreAlu'];
            $_SESSION['apellido'] = $row['apellidoAlu'];
            $_SESSION['tipo_usuario'] = 'alumno';
            header("Location: ../Views/StudentView/InicioAlumno.php");
            exit();
        } elseif ($resultProfesor->num_rows === 1) {
            // Validación para profesores
            $row = $resultProfesor->fetch_assoc();
            $_SESSION['identificador'] = $row['identificador'];
            $_SESSION['nombre'] = $row['nombreProf'];
            $_SESSION['apellido'] = $row['apellidoProf'];
            $_SESSION['tipo_usuario'] = 'profesor';
            header("Location: ../Views/teachersView/InicioProfesor.php");
            exit();
        } elseif ($resultAdmin->num_rows === 1) {
            // Validación para administradores
            $row = $resultAdmin->fetch_assoc();
            $_SESSION['identificador'] = $row['identificador'];
            $_SESSION['nombre'] = $row['nombreAdmin'];
            $_SESSION['apellido'] = $row['apellidoAdmin'];
            $_SESSION['tipo_usuario'] = 'administrador';
            header("Location: ../Views/AdminView/InicioAdmin.php");
            exit();
        } else {
            // Si no se encuentra el usuario
            header("Location: ../Views/login.php?error=El usuario o contraseña son incorrectos");
            exit();
        }
    }
} else {
    header("Location: ../Views/login.php");
    exit();
}
?>
