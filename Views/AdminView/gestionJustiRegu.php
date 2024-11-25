<?php
include_once '../../Controller/GestionJustificantes.php';
include_once '../../Controller/GestionJustiProfe.php';
include '../../Model/Conexion.php';

$controller = new gestionJustificante($conexion);
$justificantes = $controller->obtenerJustificantes(); 


$controllerPro = new gestionJustiProfe($conexion);
$justificantesPro = $controllerPro->mostrarJustificantesProfesores(); 

// Manejar la eliminación de justificantes
if (isset($_GET['delete_id'])) {
    $id = $_GET['delete_id'];
    if ($controller->eliminarJustificante($id)) {
        header("Location: gestionJustiRegu.php?mensaje=Justificante eliminado exitosamente");
        exit();
    } else {
        echo "Error al eliminar el justificante.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Justificantes</title>
    <link rel="stylesheet" href="../../Resources/CSS/styleMotivo2.css">
    <link rel="stylesheet" href="../../Resources/CSS/styleReportes.css">
</head>
<body>

<div class="sidebar">
    <h2 style="color: white; padding-left: 20px;">GESTIONES</h2>

    <a href="#" onclick="toggleReportesMenu()">Reportes</a>

    <!-- Este es el div del menú de reportes, inicialmente oculto -->
    <div id="reportesMenu" style="display: none;">
        <a href="#" onclick="showReport('report1')">Justificante por profesor</a>
        <a href="#" onclick="showReport('report2')">Justificantes por Estado</a>
        <a href="#" onclick="showReport('report3')">Justificantes por alumno</a>
        <a href="#" onclick="showReport('report4')">Justificantes por Periodo</a>
        <a href="#" onclick="showReport('report5')">Justificantes por Fecha de Inicio y Fin</a>
    </div>

    <a href="Gestiones.php">Regresar</a>
    <hr>
    <a href="GestionAlum.php">Alumnos</a>
    <a href="GestionAdmin.php">Administradores</a>
    <a href="GestionProf.php">Profesores</a>
    <a href="gestionMot.php">Motivos</a>
    <a href="ListaPDF.php">Oficios</a>
</div>

<!-- Contenido Principal -->
<div class="main-content">
    <header>
        <div class="logo">
            <img src="../../Resources/img/logo.png" alt="Logo">
        </div>
        <h1>Sistema para la gestión de Justificantes</h1>
    </header>

    <div id="reportContent" style="margin-top: 20px;">
        <!-- Aquí se mostrarán los reportes seleccionados -->
    </div>


    <h1 align="center">Listado de Justificantes</h1>
    <div class="table-container">
        <table>
            <tr>
                <th>ID</th>
                <th>Alumno</th>
                <th>Cuatrimestre</th>
                <th>Grupo</th>
                <th>Carrera</th>
                <th>Período Escolar</th>
                <th>Motivo</th>
                <th>Motivo Extra</th>
                <th>Fecha</th>
                <th>¿Se ausentó todo el día?</th>
                <th>Hora Inicio</th>
                <th>Hora Fin</th>
                <th>Estado</th>   
                <th>Actualizar</th>
                <th>Eliminar</th>
            </tr>
            <?php foreach ($justificantes as $justificante): ?>
                <tr>
                    <td><?php echo htmlspecialchars($justificante['idJusti']); ?></td>
                    <td><?php echo htmlspecialchars($justificante['nombreAlu'] . ' ' . $justificante['apellidoAlu']); ?></td>
                    <td><?php echo htmlspecialchars($justificante['cuatrimestre']); ?></td>
                    <td><?php echo htmlspecialchars($justificante['grupo']); ?></td>
                    <td><?php echo htmlspecialchars($justificante['carrera']); ?></td>
                    <td><?php echo htmlspecialchars($justificante['periodoEscolar']); ?></td>   
                    <td><?php echo htmlspecialchars($justificante['motivo']); ?></td>
                    <td><?php echo htmlspecialchars($justificante['motivoExtra']); ?></td>
                    <td><?php echo htmlspecialchars($justificante['fecha']); ?></td>
                    <td><?php echo htmlspecialchars($justificante['ausenteTodoDia']); ?></td>
                    <td><?php echo htmlspecialchars($justificante['horaInicio']); ?></td>
                    <td><?php echo htmlspecialchars($justificante['horaFin']); ?></td>
                    <td><?php echo htmlspecialchars($justificante['estado']); ?></td>
                    <td>
                        <button class="btn-editar" onclick="location.href='UpJusti.php?edit_id=<?php echo $justificante['idJusti']; ?>'">Editar</button>
                    </td>
                    <td>
                        <button class="btn-eliminar" onclick="if(confirm('¿Estás seguro de que quieres eliminar este justificante?')) location.href='gestionJustiRegu.php?delete_id=<?php echo $justificante['idJusti']; ?>'">Eliminar</button>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>

    <h1 align="center">Listado de Justificantes por Profesor</h1>
    <div class="table-container">
    <table border="1" align="center">
        <thead>
            <tr>
                <th>ID Justificante</th>
                <th>Motivo Justificante</th>
                <th>Nombre Profesor</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($justificantesPro as $item): ?>
                <tr>
                    <td><?= htmlspecialchars($item['idJusti']) ?></td>
                    <td><?= htmlspecialchars($item['motivo']) ?></td>
                    <td><?= htmlspecialchars($item['nombreProf'] . ' ' . $item['apellidoProf']) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

    

<script src="../../Controller/Js/ValidarJ.js"></script>
<script>
    // Función para alternar la visibilidad del menú de reportes y cargar los reportes
function toggleReportesMenu() {
    var menu = document.getElementById('reportesMenu');
    var reportContent = document.getElementById('reportContent');
    
    // Verifica si el menú está oculto
    if (menu.style.display === "none" || menu.style.display === "") {
        menu.style.display = "block"; // Muestra el menú
        // Cargar contenido predeterminado para cuando se muestra el menú
        reportContent.innerHTML = "<h2>Seleccione un reporte para mostrar</h2>";
    } else {
        menu.style.display = "none"; // Oculta el menú
        // No limpiar el contenido de los reportes aquí
    }
}

// Función para mostrar un reporte específico
function showReport(reportId) {
    var reportContent = document.getElementById('reportContent');
    
    switch(reportId) {
        case 'report1':
            // Mostrar el formulario para generar el reporte
            reportContent.innerHTML = `
                <h1>Generar Reporte de Justificantes por Profesor</h1>
                <!-- Formulario de entrada -->
                <form method="GET" action="../../Static/fpdf/Reporte1.php">
                    <label for="nombreProfesor">Nombre del Profesor:</label>
                    <input type="text" id="nombreProfesor" name="nombreProfesor" required><br><br>

                    <label for="fechaInicio">Fecha de Inicio:</label>
                    <input type="date" id="fechaInicio" name="fechaInicio" required><br><br>

                    <label for="fechaFin">Fecha de Fin:</label>
                    <input type="date" id="fechaFin" name="fechaFin" required><br><br>

                    <label for="estado">Estado:</label>
                    <select id="estado" name="estado" required>
                        <option value="ACEPTADA">Aceptada</option>
                        <option value="PENDIENTE">Pendiente</option>
                        <option value="RECHAZADO">Rechazada</option>
                    </select><br><br>

                    <button type="submit">Generar Reporte</button>
                </form>
            `;
            break;
        case 'report2':
            reportContent.innerHTML = `
                <h1>Generar Reporte de Justificantes</h1>
                <!-- Formulario de entrada -->
                <form method="GET" action="../../Static/fpdf/Reporte2.php">
                    <!-- Estado del justificante -->
                    <label for="estado">Estado del Justificante:</label>
                    <select id="estado" name="estado" required>
                        <option value="ACEPTADA">Aceptada</option>
                        <option value="PENDIENTE">Pendiente</option>
                        <option value="RECHAZADO">Rechazada</option>
                    </select><br><br>

                    <!-- Fecha de inicio -->
                    <label for="fechaInicio">Fecha de Inicio:</label>
                    <input type="date" id="fechaInicio" name="fechaInicio" required><br><br>

                    <!-- Fecha de fin -->
                    <label for="fechaFin">Fecha de Fin:</label>
                    <input type="date" id="fechaFin" name="fechaFin" required><br><br>

                    <!-- Botón para generar el reporte -->
                    <button type="submit">Generar Reporte</button>
                </form>
            `;            
        break;
        case 'report3':
            reportContent.innerHTML = `
                <div id="reportContent">
                <h1>Generar Reporte de Justificantes</h1>
                <!-- Formulario de entrada -->
                <form method="GET" action="../../Static/fpdf/Reporte3.php">
                    
                    <label for="matricula">Matrícula:</label>
                    <input type="text" id="matricula" name="matricula" placeholder="Opcional (Matrícula del Alumno)"><br><br>

                    <label for="fechaInicio">Fecha de Inicio:</label>
                    <input type="date" id="fechaInicio" name="fechaInicio" required><br><br>

                    <label for="fechaFin">Fecha de Fin:</label>
                    <input type="date" id="fechaFin" name="fechaFin" required><br><br>

                    <label for="estado">Estado:</label>
                    <select id="estado" name="estado" required>
                        <option value="ACEPTADA">Aceptada</option>
                        <option value="PENDIENTE">Pendiente</option>
                        <option value="RECHAZADO">Rechazada</option>
                    </select><br><br>

                    <button type="submit">Generar Reporte</button>
                </form>
            </div>
            `;    
             break;
        case 'report4':
            reportContent.innerHTML = `
                <div id="reportContent">
                <h1>Consulta de Justificantes por Periodo, Carrera y Grupo</h1>
    
                <!-- Formulario para seleccionar el periodo escolar, carrera y grupo -->
                <form action="../../Static/fpdf/Reporte4.php" method="GET">
                    
                    <label for="periodoEscolar">Periodo Escolar:</label>
                    <select id="periodoEscolar" name="periodoEscolar" required>
                        <option value="OTOÑO 2025">Otoño 2025</option>
                        <option value="PRIMAVERA 2025">Primavera 2025</option>
                        <option value="INVIERNO 2025">Invierno 2025</option>
                    </select><br><br>

                    <label for="carrera">Carrera:</label>
                    <select id="carrera" name="carrera" required>
                        <option value="ITI">ITI</option>
                        <option value="IET">IET</option>
                    </select><br><br>
                    <label for="grupo">Grupo:</label>
                    <input type="text" id="grupo" name="grupo" placeholder="Ejemplo: A1" required><br><br>

                    <button type="submit">Generar Reporte</button>
                </form>
            </div>
            `;                break;
        case 'report5':
            reportContent.innerHTML = `
                <div id="reportContent">
                <h1>Consulta de Justificantes por Fecha de Inicio y Fecha de Fin</h1>
                <form action="../../Static/fpdf/Reporte5.php" method="GET">
                    <label for="fechaInicio">Fecha de Inicio:</label>
                    <input type="date" id="fechaInicio" name="fechaInicio" required><br><br>

                    <label for="fechaFin">Fecha de Fin:</label>
                    <input type="date" id="fechaFin" name="fechaFin" required><br><br>

                    <button type="submit">Generar  Reporte</button>
                </form>
            </div>
            `;              
              break;
        default:
            reportContent.innerHTML = "<h2>Reporte no encontrado</h2>";
            break;
    }
}

    
</script>
</body>
</html>