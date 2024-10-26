<?php
session_start();  // Siempre inicia la sesión al comienzo

// Ahora puedes acceder a las variables de sesión
if (isset($_SESSION['nombre'])) {
    $nombre = $_SESSION['nombre'];
    $apellido = $_SESSION['apellido'];
    $matricula = $_SESSION['identificador'];
} else {
    // Si la sesión no está iniciada, puedes redirigir al login
    header('Location: login.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Alumno</title>
    <link rel="stylesheet" href="../../Resources/CSS/styleDashAlu.css">
</head>
<body>
    <header>
        <div class="logo">
            <img src="../../Resources/img/logo.png" alt="Logo">
        </div>
        <nav>
            <a href="#">Mi cuenta</a>
            <a href="../CerrarSesion.php">Cerrar Sesión</a>
        </nav>
    </header>
    <div class="main-container">
        <aside class="sidebar">
            <div class="profile-picture">
                <img src="../../Resources/img/user.png" alt="Usuario">
            </div>
            <div class="profile-info">
                <p>Usuario: <?php echo $nombre . $apellido?></p>
                <p>Matrícula: <?php echo $matricula ?></p>
            </div>
        </aside>
        <section class="content"> 
            <button class="btn-action"> <a href="SoliJusti.php"> Solicitar Justificantes</button>
            <button class="btn-action"y>Consultar Justificantes</button>
        </section>
    </div>
</body>
</html>