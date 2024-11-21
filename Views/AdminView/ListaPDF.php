<?php 
// Asegúrate de incluir el archivo de conexión correctamente
include('../../Model/conexion.php'); // Cambia la ruta según corresponda

// Verifica si la conexión se estableció correctamente
if (!$conexion) {
    die("Conexión fallida: " . mysqli_connect_error());
}

// Obtener el término de búsqueda si se ha enviado el formulario
$searchTerm = '';
if (isset($_POST['search'])) {
    $searchTerm = mysqli_real_escape_string($conexion, $_POST['search']);
}

// Consulta a la base de datos con un filtro de búsqueda si se proporcionó un término
$query = "SELECT * FROM pdf_generado WHERE nombrePdf LIKE '%$searchTerm%'";
$result = mysqli_query($conexion, $query);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de PDFs</title>
    <!-- Aquí agregas el enlace al archivo CSS -->
    <link rel="stylesheet" href="../../Resources/CSS/PDFstyle.css"> <!-- Asegúrate de que la ruta sea correcta -->
</head>
<body>
<h3>SISTEMA PARA LA GESTIÓN DE JUSTIFICANTES</h3>
<header>

    <div class="logo">
        <img src="../../Resources/img/logo.png" alt="Logo">
    </div>
    <h1>JUSTIFICANTES</h1>
    <nav>
        <a href="Gestiones.php" class="cerrar">Regresar</a>
    </nav>
</header>

<!-- Barra de búsqueda -->
<form method="POST" action="" class="barra">
    <input type="text" name="search" value="<?php echo htmlspecialchars($searchTerm); ?>" placeholder="Buscar justificante..." />
    <button type="submit">Buscar</button>
</form>

<div class="pdf-list">
    <?php
    if ($result) {
        if (mysqli_num_rows($result) > 0) {
            // Mostrar los resultados de la búsqueda
            while ($row = mysqli_fetch_assoc($result)) {
                // Enlace que llama al script PHP de descarga
                echo "<a href='descargar.php?file={$row['nombrePdf']}' class='pdf-link'>{$row['nombrePdf']}</a><br>";
            }
        } else {
            // Mensaje cuando no se encuentran resultados
            echo "No se encontraron resultados para tu búsqueda.";
        }
    } else {
        echo "Error al ejecutar la consulta: " . mysqli_error($conexion);
    }

    // Cerrar la conexión
    mysqli_close($conexion);
    ?>
</div>
</body>
</html>
