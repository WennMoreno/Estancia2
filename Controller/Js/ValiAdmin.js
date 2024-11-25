function validarNombre() {
    const nombre = document.getElementById("nombreAdmin").value.trim();
    if (!nombre || nombre.length < 3) {
        return "El nombre debe tener al menos 3 caracteres.";
    }
    return null;
}

function validarApellido() {
    const apellido = document.getElementById("apellidoAdmin").value.trim();
    if (!apellido || apellido.length < 3) {
        return "El apellido debe tener al menos 3 caracteres.";
    }
    return null;
}

function validarCorreo() {
    const correo = document.getElementById("correoE").value.trim();
    const correoRegex = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
    if (!correo || !correoRegex.test(correo)) {
        return "Ingresa un correo electrónico válido.";
    }
    return null;
}

function validarContraseña() {
    const contraseña = document.getElementById("passAd").value.trim();
    if (!contraseña || contraseña.length < 6) {
        return "La contraseña debe tener al menos 6 caracteres.";
    }
    return null;
}

function validarFormularioAgre() {
    let esValido = true;

    // Validar nombre
    const errorNombre = validarNombre();
    if (errorNombre) {
        document.getElementById("errorNombre").textContent = errorNombre;
        document.getElementById("errorNombre").style.display = "block";
        esValido = false;
    } else {
        document.getElementById("errorNombre").style.display = "none";
    }

    // Validar apellido
    const errorApellido = validarApellido();
    if (errorApellido) {
        document.getElementById("errorApellido").textContent = errorApellido;
        document.getElementById("errorApellido").style.display = "block";
        esValido = false;
    } else {
        document.getElementById("errorApellido").style.display = "none";
    }

    // Validar correo
    const errorCorreo = validarCorreo();
    if (errorCorreo) {
        document.getElementById("errorCorreo").textContent = errorCorreo;
        document.getElementById("errorCorreo").style.display = "block";
        esValido = false;
    } else {
        document.getElementById("errorCorreo").style.display = "none";
    }

    // Validar contraseña
    const errorPass = validarContraseña();
    if (errorPass) {
        document.getElementById("errorPass").textContent = errorPass;
        document.getElementById("errorPass").style.display = "block";
        esValido = false;
    } else {
        document.getElementById("errorPass").style.display = "none";
    }

    // Solo enviar formulario si todos los campos son válidos
    return esValido;
}
