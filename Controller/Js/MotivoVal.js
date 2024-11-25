// Función para validar el formulario antes de enviarlo
function validarFormularioAgre() {
    var tipo = document.getElementById("tipo").value;
    var descripcion = document.getElementById("descripcion").value;
    var docSolicitado = document.getElementById("docSolicitado").value;
    var esValido = true;

    // Validar tipo
    if (tipo.trim() === "") {
        document.getElementById("errorTipo").style.display = "block";
        esValido = false;
    } else {
        document.getElementById("errorTipo").style.display = "none";
    }

    // Validar descripción
    if (descripcion.trim() === "") {
        document.getElementById("errorDescripcion").style.display = "block";
        esValido = false;
    } else {
        document.getElementById("errorDescripcion").style.display = "none";
    }

    // Validar documento solicitado
    if (docSolicitado.trim() === "") {
        document.getElementById("errorDocSolicitado").style.display = "block";
        esValido = false;
    } else {
        document.getElementById("errorDocSolicitado").style.display = "none";
    }

    return esValido;
}
