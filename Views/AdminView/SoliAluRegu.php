<?php include '../../Model/Conexion.php'; ?>

<?php
// Obtener todas las solicitudes pendientes con el nombre del alumno
$query = "SELECT justificante.*, alumno.nombreAlu, alumno.apellidoAlu 
          FROM justificante
          JOIN alumno ON justificante.idAlumno = alumno.idAlumno
          WHERE justificante.estado = 'Pendiente'";
$result = mysqli_query($conexion, $query);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Solicitudes Pendientes</title>
    <!-- Vincular el archivo CSS -->
    <link rel="stylesheet" href="../../Resources/CSS/styleAdminConsul.css">
</head>
<body>
<header>
        <div class="logo">
            <img src="../../Resources/img/logo.png" alt="Logo">
        </div>
        <nav>
            <a href="InicioAdmin.php " class="cerrar">Regresar</a>
        </nav>
    </header>

<div class="container">
    <div class="sidebar">
        <h2>Solicitudes Pendientes</h2>

        <?php
        // Mostrar la lista de solicitudes
        while ($row = mysqli_fetch_assoc($result)) {
            echo '<div class="solicitud-item" data-id="' . $row['idJusti'] . '">';
            echo '<strong>' . $row['nombreAlu'] . ' ' . $row['apellidoAlu'] . '</strong><br>';
            echo '<small>' . $row['fecha'] . ' | ' . $row['horaInicio'] . '</small><br>';
            echo '<span>' . $row['motivo'] . '</span>';
            echo '</div>';
        }
        ?>
    </div>

    <div class="content">
        <h2>Detalles de la Solicitud</h2>
        <div id="detallesSolicitud">
            <p>Seleccione una solicitud para ver más detalles.</p>
        </div>
    </div>
</div>

<script>
    // Función para mostrar los detalles de la solicitud cuando se hace clic
    const solicitudItems = document.querySelectorAll('.solicitud-item');
    solicitudItems.forEach(item => {
        item.addEventListener('click', function() {
            const solicitudId = this.getAttribute('data-id');

            // Quitar clase 'active' de cualquier solicitud previamente seleccionada
            solicitudItems.forEach(i => i.classList.remove('active'));
            this.classList.add('active');

            fetch('../../Controller/detallesSoli.php?id=' + solicitudId)
            .then(response => response.text()) 
            .then(html => {
                const detallesDiv = document.getElementById('detallesSolicitud');
                detallesDiv.innerHTML = html; 
            })
            .catch(error => {
                console.error("Error al obtener los detalles:", error);
                const detallesDiv = document.getElementById('detallesSolicitud');
                detallesDiv.innerHTML = `<p>Error al cargar los detalles de la solicitud.</p>`;
            });
        });
    });

    // Función para aceptar la solicitud
    function aceptarSolicitud(idSolicitud) {
        if (confirm("¿Desea aceptar esta solicitud y generar el PDF?")) {
            const formData = new FormData();
            formData.append('idJusti', idSolicitud); 

            fetch('aceptar_solicitud.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.text())
            .then(data => {
                document.getElementById('detallesSolicitud').innerHTML = data;
                location.reload(); 
            })
            .catch(error => {
                console.error("Error al aceptar la solicitud:", error);
                alert("Error al aceptar la solicitud.");
            });
        }
    }
</script>

</body>
</html>
