function validarUsuario() {
    const usuario = document.getElementById("Usuario").value.trim();
    if (!usuario || usuario.length < 10) {
        return "El usuario debe tener al menos 10 caracteres.";
    }
    return null;
}

function validarContraseña() {
    const contraseña = document.getElementById("Contraseña").value.trim();
    if (!contraseña || contraseña.length < 4) {
        return "La contraseña debe tener al menos 4 caracteres.";
    }
    return null;
}

function validarLogin() {
    let isValid = true;

    // Validar usuario
    const usuarioError = validarUsuario();
    if (usuarioError) {
        document.getElementById("errorUsu").textContent = usuarioError;
        document.getElementById("errorUsu").style.display = "block";
        isValid = false;
    } else {
        document.getElementById("errorUsu").style.display = "none";
    }

    // Validar contraseña
    const contraseñaError = validarContraseña();
    if (contraseñaError) {
        document.getElementById("errorCon").textContent = contraseñaError;
        document.getElementById("errorCon").style.display = "block";
        isValid = false;
    } else {
        document.getElementById("errorCon").style.display = "none";
    }

    // Solo enviar formulario si todos los campos son válidos
    if (isValid) {
        document.getElementById("loginForm").submit();
    }
}
