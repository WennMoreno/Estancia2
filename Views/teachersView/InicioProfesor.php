<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio</title>
</head>
<body>
    <?php 
    session_start();//para que la sesión del usuario no se rompa

    $user = $_SESSION['identificador'];

    if(isset($_SESSION['identificador'])){
        ?>
        <center><h1>HOME profesor</h1></center>
        <a href="../CerrarSesion.php">Cerrar Sesion</a>
   <?php
    }else{
        header("Location: ../login.php");
    }
?>
</body>
</html>