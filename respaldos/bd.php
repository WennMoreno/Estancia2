<?php
// Primero requerimos el archivo de configuración
require_once __DIR__ . '/config.php';
$ruta = $_SERVER['DOCUMENT_ROOT'] . "/pruebasOfAllVerDul/respaldos/backup";
/*if (file_exists($ruta) && is_dir($ruta)) {
    echo "La ruta es válida y es un directorio.";
} else {
    echo "La ruta no es válida o no es un directorio.";
}*/
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <link rel="stylesheet" href="../Resources/CSS/res.css">
</head>
<body>
    <div class="buttons-container">
        <?php
        // Botón para realizar copia de seguridad
        echo '<a class="boton" href="generarRespaldo.php">Realizar copia de seguridad</a>';
        echo '<a class="boton" href="../Views/AdminView/InicioAdmin.php">Regresar</a>';
        ?>
    </div>

    <form class="formulario" action="Restaurar.php" method="POST" enctype="multipart/form-data">
        <?php
        // Etiqueta para seleccionar punto de restauración
        echo '<label>Selecciona un punto de restauración</label><br>';
        
        // Inicio del select
        echo '<select name="restorePoint">';

        // Opción estática de placeholder
        echo '<option value="" disabled selected>Selecciona un punto de restauración</option>';

        // Opciones dinámicas generadas con PHP
        if (is_dir($ruta)) {
            if ($aux = opendir($ruta)) {
                while (($archivo = readdir($aux)) !== false) {
                    if ($archivo != "." && $archivo != "..") {
                        $nombrearchivo = str_replace(".sql", "", $archivo);
                        $nombrearchivo = str_replace("-", ":", $nombrearchivo);
                        $ruta_completa = $ruta . "/" . $archivo;
                        if (!is_dir($ruta_completa)) {
                            // Genera una opción dinámica
                            echo '<option value="' . htmlspecialchars($ruta_completa, ENT_QUOTES, 'UTF-8') . '">' . htmlspecialchars($nombrearchivo, ENT_QUOTES, 'UTF-8') . '</option>';
                        }
                    }
                }
                closedir($aux);
            }
        } else {
            echo '<option value="">No es una ruta válida</option>';
        }

        // Cierre del select
        echo '</select>';
        ?>
        <!-- Botón para enviar el formulario -->
        <button type="submit">Restaurar</button>
    </form>
</body>
</html>
