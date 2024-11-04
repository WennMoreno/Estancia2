<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio</title>
    <link rel="stylesheet" href="../../Resources/CSS/styleDashAdmin.css">
</head>
<body>
    <?php 
    session_start(); //para que la sesión del usuario no se rompa

    if (isset($_SESSION['identificador'])) {
        $user = $_SESSION['identificador'];
    ?>
        <header>
        <div class="logo">
            <img src="../../Resources/img/logo.png" alt="Logo">
        </div>
        <nav>
            <a href="InicioAdmin.php " class="cerrar">Regresar</a>
        </nav>
    </header>

        <div >
            <div >
                <!--
                <div >
                    <p>Bienvenido, <?php echo htmlspecialchars($user); ?></p>
                </div>
                --->
            </div>
            <div class="content">
            <div class="opcion">
                    <p><a href="" class="btn-action">Reportes</a></p>
                </div>
                <div class="opcion">
                    <p><a href="" class="btn-action">Alumnos</a></p> 
                </div>
                <div class="opcion">
                    <p><a href="" class="btn-action">Profesores</a></p> 
                </div>
                <div class="opcion">
                    <p><a href="" class="btn-action">Justificantes</a></p>
                </div>
                <div class="opcion">
                    <p><a href="gestionMot.php" class="btn-action">Motivos</a></p>
                </div>
                <div class="opcion">
                    <p><a href="" class="btn-action">Oficios</a></p>
                </div>
                
            </div>
        </div>
    <?php
    } else {
        header("Location: ../login.php");
    }
    ?>
</body>
</html>
