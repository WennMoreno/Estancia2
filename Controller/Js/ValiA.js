// ValiA.js

// Función para validar que no exista una matrícula duplicada
function validarDuplicado(matricula, idActual = null) {
    return alumnos.some(alumno => 
        alumno.matricula.toLowerCase() === matricula.toLowerCase() && alumno.idAlumno !== idActual
    );
}

// Función para validar el formulario de agregar alumno
function validarFormularioAgregar() {
    const nombre = document.getElementById('nombre').value;
    const apellido = document.getElementById('apellido').value;
    const fechaNac = document.getElementById('fechaNac').value;
    const matricula = document.getElementById('matricula').value;
    const contrasena = document.getElementById('contrasena').value;
    const confirmacionContra = document.getElementById('confirmacionContra').value;

    // Validar si la matrícula ya existe
    if (validarDuplicado(matricula)) {
        alert('La matrícula ya existe. Por favor, ingrese una diferente.');
        return false; // Evita el envío del formulario
    }

    // Validar que las contraseñas coincidan
    if (contrasena !== confirmacionContra) {
        alert('Las contraseñas no coinciden. Por favor, verifique.');
        return false; // Evita el envío del formulario
    }

    // Validar que se ingresen los campos requeridos
    if (!nombre || !apellido || !fechaNac || !matricula || !contrasena) {
        alert('Por favor, complete todos los campos requeridos.');
        return false; // Evita el envío del formulario
    }

    return true; // Permite el envío del formulario
}

// Función para validar el formulario de editar alumno
function validarFormularioEditar() {
    const idActual = document.querySelector('input[name="idAlumno"]').value; // Obtener el ID del alumno actual
    const nombre = document.getElementById('edit_nombre').value;
    const apellido = document.getElementById('edit_apellido').value;
    const fechaNac = document.getElementById('edit_feNac').value;
    const matricula = document.getElementById('edit_matricula').value;
    const contrasena = document.getElementById('edit_contrasena').value;
    const confirmacionContra = document.getElementById('edit_confirmacionContra').value;

    // Validar si la matrícula ya existe, excluyendo al alumno que se está editando
    if (validarDuplicado(matricula, idActual)) {
        alert('La matrícula ya existe. Por favor, ingrese una diferente.');
        return false; // Evita el envío del formulario
    }

    // Validar que las contraseñas coincidan
    if (contrasena !== confirmacionContra) {
        alert('Las contraseñas no coinciden. Por favor, verifique.');
        return false; // Evita el envío del formulario
    }

    // Validar que se ingresen los campos requeridos
    if (!nombre || !apellido || !fechaNac || !matricula || !contrasena) {
        alert('Por favor, complete todos los campos requeridos.');
        return false; // Evita el envío del formulario
    }

    return true; // Permite el envío del formulario
}

// Función para eliminar alumno
function eliminarAlumno(id) {
    if (confirm("¿Estás seguro de que deseas eliminar este alumno?")) {
        window.location.href = "GestionAlum.php?delete_id=" + id;
    }
}
