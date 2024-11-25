<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../Resources/CSS/styleLogin.css">
    <script src="/pruebasOfAllVerDul/Controller/Js/validarCam.js" defer></script>
</head>
<body>
    <div class="login-container">
        <div class="login-box">
            <h2>Iniciar Sesión</h2>
            <form id="loginForm" method="POST" action="../Controller/Validar.php" enctype="multipart/form-data">
                <?php
                // Verifica si hay un mensaje de error en la URL
                if (isset($_GET["error"])) {
                    echo "<p style='color: red;'>" . htmlspecialchars($_GET['error']) . "</p>";
                }  
                ?>   
                <?php if(isset($_GET['success'])){ ?>
                <p class="success"><?php echo $_GET['success'] ?></p>
                <?php } ?> 

                <div class="input-group">
                    <i class="fa-solid fa-user"></i> 
                    <input type="text" id="Usuario" name="Usuario" placeholder="Nombre de Usuario" required>
                </div>
                <p class="alert alert-danger" id="errorUsu" style="display:none;">Ingresa un usuario válido.</p>

                <div class="input-group">
                    <i class="fa-solid fa-unlock"></i>
                    <input type="password" id="Contraseña" name="Contraseña" placeholder="Contraseña" required>
                </div>
                <p class="alert alert-danger" id="errorCon" style="display:none;">Ingresa una contraseña válida.</p>

                <hr>
                <button type="button" class="btn-login" onclick="validarLogin();">Iniciar Sesión</button>
                <a href="StudentView/Registrarse.php" class="create-account">Crear cuenta</a>
            </form>
        </div>
    </div>
</body>
</html>
