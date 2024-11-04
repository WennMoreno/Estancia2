<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../Resources/CSS/styleConsuJustAlum.css">
    <title>Consultar Justificantes</title>
</head>
<body>
    <div class="container">
        <?php
            // Iniciar sesión y verificar si el usuario está en sesión
            session_start();
            if (!isset($_SESSION['identificador'])) {
                header("Location: ../login.php");
                exit;
            }
            include '../../Model/Conexion.php';
            include '../../Controller/GestionJustificantes.php';
            //obtener el id del alumno que esta en la sesión
            $modeloAlumno= new Alumno($conexion);
            $idAlumno = $modeloAlumno->obtenerIdAlumnoPorMatricula($conexion);
            // Incluir la conexión y el controlador
        

            // Crear la instancia del controlador y obtener los justificantes
            $gestionJustificante = new gestionJustificante($conexion);
            $justificantes = $gestionJustificante->mostrarJustiAlum($idAlumno);
        ?>


        <?php if (!empty($justificantes)) : ?>
            <?php foreach ($justificantes as $justificante): ?>
                <div class="justificante-card">
                    <div class="justificante-header">
                        <div class="justificante-motivo"><?php echo htmlspecialchars($justificante['motivo']); ?></div>
                        <div class="justificante-fecha"><?php echo htmlspecialchars($justificante['fecha']); ?></div>
                    </div>
                    <div class="justificante-estado 
                        <?php 
                            echo ($justificante['estado'] == 'pendiente') ? 'estado-pendiente' : 
                                 (($justificante['estado'] == 'aprobado') ? 'estado-aprobado' : 'estado-rechazado'); 
                        ?>">
                        <?php echo htmlspecialchars($justificante['estado']); ?>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No hay justificantes para este alumno.</p>
        <?php endif; ?>

        <p><a href="InicioAlumno.php">Volver</a></p>
    </div>
</body>
</html>
