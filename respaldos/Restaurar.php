<?php
require_once __DIR__ . '/config.php';

// Verificar si se seleccionó un archivo y si el formulario se envió correctamente
if (isset($_FILES['fileUpload']) && $_FILES['fileUpload']['error'] === UPLOAD_ERR_OK) {
    // Archivo subido correctamente, obtén la ruta temporal
    $uploadTmpPath = $_FILES['fileUpload']['tmp_name'];
    $uploadFileName = $_FILES['fileUpload']['name'];
    
    // Mover el archivo a la carpeta de respaldos (opcional)
    $destinationPath = $_SERVER['DOCUMENT_ROOT'] . "/pruebasOfAllVerDul/respaldos/backup/" . $uploadFileName;
    if (move_uploaded_file($uploadTmpPath, $destinationPath)) {
        echo "El archivo se ha subido correctamente.<br>";
    } else {
        echo "Error al mover el archivo subido.<br>";
    }
} else {
    // No se subió ningún archivo, tomar el valor del select
    if (!isset($_POST['restorePoint']) || empty($_POST['restorePoint'])) {
        echo "<script>alert('No se seleccionó un archivo de restauración.'); window.location.href='index.php';</script>";
        exit();
    }
    
    // Usar el archivo seleccionado del select
    $restorePoint = $_POST['restorePoint'];
}

// Validar si el archivo de restauración existe
if (!file_exists($restorePoint)) {
    die("Error: El archivo de respaldo no existe en la ruta especificada.");
}

$sqlContent = file_get_contents($restorePoint);
$sqlContent = str_replace("CREATE TABLE ", "CREATE TABLE IF NOT EXISTS ", $sqlContent);
$sql = explode(";", $sqlContent);

set_time_limit(300);

$con = mysqli_connect(SERVER, USER, PASS, BD);
$con->query("SET FOREIGN_KEY_CHECKS=0");

// Vaciar todas las tablas de la base de datos
$tables = $con->query("SHOW TABLES");
while ($table = $tables->fetch_array()) {
    $con->query("TRUNCATE TABLE `" . $table[0] . "`");
}

// Ejecutar las consultas de restauración
$totalErrors = 0;
for ($i = 0; $i < (count($sql) - 1); $i++) {
    if (!$con->query($sql[$i] . ";")) {
        $totalErrors++;
        echo "Error en la consulta {$i}: " . mysqli_error($con) . "<br>";
    }
}

$con->query("SET FOREIGN_KEY_CHECKS=1");
$con->close();

if ($totalErrors <= 0) {
    echo "<script>alert('Restauración completada con éxito.'); window.location.href='bd.php';</script>";
} else {
    echo "<script>alert('La restauración no se pudo completar.'); window.location.href='bd.php';</script>";
}
?>
