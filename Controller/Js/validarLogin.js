// Función para obtener el parámetro de error de la URL
function getUrlParameter(name) {
    name = name.replace(/[\[]/, '\\[').replace(/[\]]/, '\\]');
    var regex = new RegExp('[\\?&]' + name + '=([^&#]*)');
    var results = regex.exec(location.search);
    return results === null ? '' : decodeURIComponent(results[1].replace(/\+/g, ' '));
}

// Al cargar la página, verificar si hay un mensaje de error
window.onload = function() {
    var errorMessage = getUrlParameter('error');
    if (errorMessage) {
        // Crear un elemento para mostrar el mensaje de error
        var errorDiv = document.createElement('div');
        errorDiv.className = 'error-message';
        errorDiv.innerText = errorMessage;
        document.querySelector('.login-box').insertBefore(errorDiv, document.querySelector('.input-group'));
    }
};
