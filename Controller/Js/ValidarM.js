// Valimot.js

// Función para confirmar y ejecutar la eliminación de un motivo
function eliminarMotivo(id) {
    if (confirm("¿Estás seguro de que deseas eliminar este motivo?")) {
        window.location.href = "gestionMot.php?delete_id=" + id;
    }
}

// Validar si un tipo de motivo ya existe para evitar duplicados
function validarDuplicado(tipo) {
    return motivos.some(motivo => 
        motivo.tipo.toLowerCase() === tipo.toLowerCase()
    );
}

// Validación del formulario al agregar un motivo
function validarFormularioAgregar() {
    const tipo = document.getElementById('tipo').value;

    // Validar si el tipo ya existe
    if (validarDuplicado(tipo)) {
        alert('Este tipo de motivo ya existe. Por favor, ingrese uno diferente.');
        return false; // Evita el envío del formulario
    }
    return true; // Permite el envío del formulario
}

// Validación del formulario al editar un motivo
function validarFormularioEditar() {
    const tipo = document.getElementById('edit_tipo').value;
    const idActual = document.querySelector('input[name="idMotivo"]').value; // Obtener el ID del motivo actual

    // Validar si el tipo ya existe
    if (validarDuplicado(tipo, idActual)) {
        alert('Este tipo de motivo ya existe. Por favor, ingrese uno diferente.');
        return false; // Evita el envío del formulario
    }
    return true; // Permite el envío del formulario
}

// Asegurarse de que el script está cargado correctamente
console.log("Archivo Valimot.js cargado correctamente.");
