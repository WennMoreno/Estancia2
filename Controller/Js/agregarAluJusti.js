function agregarAlumno() {
    const container = document.getElementById('alumnos-container');
    const alumnoEntry = document.createElement('div');
    alumnoEntry.className = 'alumno-entry';

    alumnoEntry.innerHTML = `
        <input type="text" name="nombreAlu[]" placeholder="Nombre del Alumno" required>
        <input type="text" name="matricula[]" placeholder="Matrícula" required>
        <input type="text" name="grado[]" placeholder="Grado" required>
        <input type="text" name="grupo[]" placeholder="Grupo" required>
        <input type="text" name="carrera[]" placeholder="Carrera" required>
        <button type="button" onclick="eliminarAlumno(this)">Eliminar</button>
    `;
    
    container.appendChild(alumnoEntry);
}

function eliminarAlumno(button) {
    button.parentElement.remove();
} 


function mostrarRangoFechas() {
    document.getElementById('rangoFechas').style.display = 'block';  // Muestra el rango de fechas
    document.getElementById('fechaEvento').style.display = 'none'; // Oculta la fecha única del evento
    document.getElementById('fechaInicio').required = true; // Hace obligatoria la fecha de inicio
    document.getElementById('fechaFin').required = true; // Hace obligatoria la fecha de fin
    document.getElementById('fecha').required = false; // La fecha del evento no es obligatoria en este caso
}

// Función para mostrar la fecha única del evento y ocultar los campos de fecha inicio y fin
function ocultarRangoFechas() {
    document.getElementById('rangoFechas').style.display = 'none'; // Oculta el rango de fechas
    document.getElementById('fechaEvento').style.display = 'block'; // Muestra la fecha única del evento
    document.getElementById('fecha').required = true; // La fecha del evento es obligatoria
    document.getElementById('fechaInicio').required = false; // No es obligatoria la fecha de inicio
    document.getElementById('fechaFin').required = false; // No es obligatoria la fecha de fin
}

//PARA EDICIÓN
function agregarAlumnoUpdate() {
    var container = document.getElementById("alumnos-container");
    var index = container.children.length;  // Calcular el índice para el nuevo alumno
    var nuevoAlumno = `
        <div class="alumno-entry">
            <input type="text" name="alumnos[${index}][nombreAlumno]" placeholder="Nombre del Alumno" required>
            <input type="text" name="alumnos[${index}][matricula]" placeholder="Matrícula" required>
            <input type="text" name="alumnos[${index}][grado]" placeholder="Grado" required>
            <input type="text" name="alumnos[${index}][grupo]" placeholder="Grupo" required>
            <input type="text" name="alumnos[${index}][carrera]" placeholder="Carrera" required>
            <button type="button" onclick="eliminarAlumno(this)">Eliminar Alumno</button>
        </div>
    `;
    container.innerHTML += nuevoAlumno;  // Añadir el nuevo campo al contenedor
}

function mostrarRangoFechasUpdate() {
    document.getElementById('rangoFechas').style.display = 'block'; // Muestra el contenedor de fechas
    document.getElementById('fechaEvento').style.display = 'none'; // Oculta el contenedor de fecha única
}

function ocultarRangoFechasUpdate() {
    document.getElementById('rangoFechas').style.display = 'none'; // Oculta el contenedor de fechas
    document.getElementById('fechaEvento').style.display = 'block'; // Muestra el contenedor de fecha única
}
