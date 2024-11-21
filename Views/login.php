<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión</title>
    <link rel="stylesheet" href="../Resources/CSS/styleLogin.css">
</head>
<body>
    <div class="login-container">
        <div class="login-box">
        <h2>Iniciar Sesión</h2>
            <form method="POST" action="../Controller/Validar.php">

                <?php
                    // Verifica si hay un mensaje de error en la URL
                    if (isset($_GET['error'])) {
                        echo "<p style='color: red;'>" . htmlspecialchars($_GET['error']) . "</p>";
                    }
                ?>
                <div class="input-group">
                    <i class="fa-solid fa-user"></i> 
                    <input type="text" name="Usuario" placeholder="Nombre de Usuario" required >
                </div>

            <div class="input-group">
                <i class="fa-solid fa-unlock"></i>
                <input type="password" name="Contraseña" placeholder="Contraseña" required> 
            </div>
        
        <hr>
        <button type="submit" class="btn-login">Iniciar Sesión</button>
        <a href="StudentView/Registrarse.php" class="create-account">Crear cuenta</a>
    </form>
</body>
</html> 
