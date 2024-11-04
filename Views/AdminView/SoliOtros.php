<?php
   include('../../Controller/GestionAlumno.php');
   include('../../Model/Conexion.php');
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buscar Alumno</title>
    <link rel="stylesheet" href="../../Resources/CSS/styleBusqueAlu.css">
</head>
<body>
<header>
    <div class="logo">
        <img src="../../Resources/img/logo.png" alt="Logo">
    </div>
    <nav>
        <a href="InicioAdmin.php" class="cerrar">Regresar</a>
    </nav>
</header>

<div class="container">
    <h2>Buscar Alumno</h2>
    <?php
        // Llamar al controlador para realizar la búsqueda
        $gestionAlumno = new GestionAlumno($conexion);
        $result = $gestionAlumno->barraDeBusqueda($conexion); // Pasar la conexión si es necesario
        $busqueda = isset($_POST['busqueda']) ? $_POST['busqueda'] : '';
    ?>

    <!-- Formulario de búsqueda -->
    <form method="POST" action="">
        <label for="busqueda">Ingrese el nombre o apellido del alumno:</label>
        <input type="text" name="busqueda" id="busqueda" placeholder="Buscar alumno..." value="<?php echo htmlspecialchars($busqueda); ?>">
        <button type="submit">Buscar</button>
    </form> 

    <h3>Resultados:</h3>
    <table>
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['nombreAlu']) . ' ' . htmlspecialchars($row['apellidoAlu']); ?></td>
                    <td>
                        <a href="crear_justificante.php?idAlumno=<?php echo $row['idAlumno']; ?>">Crear Justificante</a>
                    </td>
                </tr>
            <?php endwhile; ?>
            <?php if (mysqli_num_rows($result) == 0): ?>
                <tr>
                    <td colspan="2">No se encontraron alumnos.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table> 
</div>

</body>
</html>
