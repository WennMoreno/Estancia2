<?php 
    include '../../Controller/GestionAlumno.php'; 
 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../Resources/CSS/styleCrearCuenta.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" 
    integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" 
    crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="../../Controller/Js/validarCampos.js"></script> 
    <title>Registrarse</title>
</head>
<body>
    <div action="" class="contenedor">
        <div class="encabezado">
            <img src="../../Resources/img/logo.png" alt="Logo" class="logo">
            <h1>Crear cuenta</h1>
        </div>
       
        <div class="formulario">
            <form  method="POST">
            <h1>Registrarse</h1>
            <hr>
                <?php if(isset($_GET['error'])){ ?>
                    <p class="error"><?php echo $_GET['error'] ?></p>
                <?php } ?>

                <br>

                <?php if(isset($_GET['success'])){ ?>
                    <p class="success"><?php echo $_GET['success'] ?></p>
                <?php } ?>

                <br>

                <label><i class="fa-solid fa-users"></i>
                    Nombres 
                </label>
                <input type="text" placeholder="Ingrese Nombres" name="nombre" >
                <p class="alert alert-danger" id="errornombre" style="display:none;">Ingresa un nombre valido.</p>

                <label>
                    <i class="fa-solid fa-users"></i>
                    Apellidos 
                </label>
                <input type="text" placeholder="Ingrese Apellidos" name="ape" >
                <p class="alert alert-danger" id="errorape" style="display:none;">Ingresa un apellido valido.</p>

                <label>
                    <i class="fa-solid fa-users"></i>
                    Fecha de Nacimiento (dd/mm/yyyy)
                </label>
                <input type="date" name="feNac" placeholder="Seleccione la Fecha de Nacimiento" >
                <p class="alert alert-danger" id="errorFeNaci" style="display:none;">Ingresa una fecha de nacimiento valida.</p>

                <label>
                    <i class="fa-solid fa-user"></i>
                    Matrícula
                </label>
                <input type="text" placeholder="Ingrese Usuario" name="matricula" >
                <p class="alert alert-danger" id="errormatricula" style="display:none;">Ingresa una matrícula valida.</p>

                <label>
                    <i class="fa-solid fa-envelope"></i>
                    Correo Electrónico
                </label>
                <input type="email" placeholder="Ingrese Correo Electrónico" name="correo" >
                <p class="alert alert-danger" id="erroremail" style="display:none;">Ingresa un correo valido.</p>

                <label>
                    <i class="fa-solid fa-key"></i>
                    Contraseña
                </label>
                <input type="text" placeholder="Ingrese Contraseña" name="clave" >
                
                <label>
                    <i class="fa-solid fa-key"></i>
                    Confirmar Contraseña
                </label>
                <input type="password" placeholder="Confirmar Contraseña" name="Rclave" >

                <div class="botones">
                    <button type="submit" class="btn registrar" onclick= "return validarFormulario();" >Registrarse</button>
                </div>

                <a href="../login.php" class="Boton_Ingresar">Ingresar</a>         
            </form> 
        </div>

        <?php
            $gestionAlumno = new gestionAlumno($conexion);
                    
            //si se mando el formulario, se manda a llamar la función que registra al alumno
            if ($_SERVER["REQUEST_METHOD"] === "POST") {
                $gestionAlumno->altaAlumno(); // Llama a la función 
            }
        ?>
    </div>  
</body>
</html>