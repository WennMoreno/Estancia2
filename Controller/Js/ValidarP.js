// Función para eliminar profesor
function eliminarProfesor(id) {
    if (confirm('¿Está seguro de que desea eliminar este profesor?')) {
        window.location.href = 'GestionProf.php?delete_id=' + id;
    }
}

// Función para validar duplicados al agregar un nuevo profesor
function validarDuplicado(correo) {
    return profesores.some(profesor => 
        profesor.correoElectronico.toLowerCase() === correo.toLowerCase()
    );
}

// Función para validar el formulario al agregar un nuevo profesor
function validarFormularioAgregar() {
    const correoElectronico = document.getElementById('correoElectronico').value;

    // Validar si el correo ya existe
    if (validarDuplicado(correoElectronico)) {
        alert('Ya existe un profesor con el mismo correo electrónico. Por favor, ingrese uno diferente.');
        return false; // Evita el envío del formulario
    }
    return true; // Permite el envío del formulario
}

// Función para validar duplicados al editar un profesor (excluye al profesor actual)
function validarDuplicadoEditar(correo, idActual) {
    return profesores.some(profesor => 
        profesor.correoElectronico.toLowerCase() === correo.toLowerCase() &&
        profesor.idProf != idActual // Excluir al profesor actual de la verificación
    );
}

// Función para validar el formulario al editar un profesor
function validarFormularioEditarProfesor() {
    const correoElectronico = document.getElementById('edit_correoElectronico').value;
    const idProfesor = document.querySelector('input[name="idProfesor"]').value;

    // Verificar si el correo ya está en uso por otro profesor
    if (validarDuplicadoEditar(correoElectronico, idProfesor)) {
        alert('Ya existe un profesor con el mismo correo electrónico. Por favor, ingrese uno diferente.');
        return false; // Evita el envío del formulario
    }
    return true; // Permite el envío del formulario si no hay duplicados
}
