// Función para confirmar y ejecutar la eliminación de un administrador
function eliminarAdministrador(id) {
    if (confirm("¿Estás seguro de que deseas eliminar este administrador?")) {
        window.location.href = "GestionAdmin.php?delete_id=" + id;
    }
}

// Validar si un administrador ya existe para evitar duplicados basados solo en el correo
function validarDuplicado(correo, idActual) {
    return administradores.some(admin => 
        admin.CorreoEle.toLowerCase() === correo.toLowerCase() && admin.idAdmin != idActual // Excluyendo el administrador actual
    );
}

// Validación del formulario al agregar un administrador
function validarFormularioAgregar() {
    const correo = document.getElementById('correoE').value;

    // Validar si el correo ya existe
    if (validarDuplicado(correo)) {
        alert('Este correo electrónico ya está registrado. Por favor, ingrese uno diferente.');
        return false; // Evita el envío del formulario
    }

    return true; // Permite el envío del formulario
}

// Validación del formulario al editar un administrador
function validarFormularioEditarAdministrador() {
    const correo = document.getElementById('edit_correo').value;
    const idAdmin = document.querySelector('input[name="idAdmin"]').value; // Obtener el ID del administrador actual

    // Validar si el correo ya existe
    if (validarDuplicado(correo, idAdmin)) {
        alert('Este correo electrónico ya está registrado. Por favor, ingrese uno diferente.');
        return false; // Evita el envío del formulario
    }

    return true; // Permite el envío del formulario
}

// Asegurarse de que el script está cargado correctamente
console.log("Archivo AdVali.js cargado correctamente.");
