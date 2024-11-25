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
            
            <a href="../CerrarSesion.php " class="cerrar">Cerrar Sesión</a>
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
                    <p><a href="SoliAluRegu.php" class="btn-actionSoli">SOLICITUD DE JUSTIFICANTES REGULARES</a></p> 
                </div>
                <div class="opcion">
                    <p><a href="SoliOtros.php" class="btn-action">GENERAR OTRO TIPO DE JUSTIFICANTES</a></p>
                </div>
                <div class="opcion">
                    <p><a href="soliOtroJusti" class="btn-action">GENERAR JUSTIFICANTE DE DAE</a></p> 
                </div>
                <div class="opcion">
                    <p><a href="JustificantesDAE" class="btn-actionSoli">SOLICITUD DE JUSTIFICANTES DE DAE</a></p>
                </div>
                <div class="opcion">
                    <p><a href="Gestiones.php" class="btn-action">GESTIONES</a></p>
                </div>
                <div class="opcion">
                    <a href="gestionJustiRegu.php" class="btn-action">REPORTES</a>
                </div>
                <div class="opcion">
                    <p><a href="../../respaldos/bd.php" class="btn-actionRes">RESPALDO DE LA BASE DE DATOS</a></p>
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
