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