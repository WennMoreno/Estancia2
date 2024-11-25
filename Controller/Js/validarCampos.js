// Funciones de validación individuales
function validarNombre() {
    const nombreInput = document.querySelector('input[name="nombre"]');
    const nombreRegex = /^[a-zA-ZáéíóúÁÉÍÓÚñÑ ]+$/;
    if (!nombreInput.value) {
        return "El nombre es obligatorio.";
    }
    if (!nombreRegex.test(nombreInput.value)) {
        return "El nombre solo puede contener letras y espacios.";
    }
    return null;
}

function validarApellido() {
    const apellidoInput = document.querySelector('input[name="ape"]');
    const apellidoRegex = /^[a-zA-ZáéíóúÁÉÍÓÚñÑ ]+$/;
    if (!apellidoInput.value) {
        return "El apellido es obligatorio.";
    }
    if (!apellidoRegex.test(apellidoInput.value)) {
        return "El apellido solo puede contener letras y espacios.";
    }
    return null;
}

function validarFechaNacimiento() {
    const fechaInput = document.querySelector('input[name="feNac"]');
    const fechaActual = new Date().toISOString().split("T")[0];
    if (!fechaInput.value) {
        return "La fecha de nacimiento es obligatoria.";
    }
    if (fechaInput.value > fechaActual) {
        return "La fecha de nacimiento no puede ser en el futuro.";
    }
    return null;
}

function validarMatricula() {
    const matriculaInput = document.querySelector('input[name="matricula"]');
    const matriculaRegex = /^\w{5,20}$/;
    if (!matriculaInput.value) {
        return "La matrícula es obligatoria.";
    }
    if (!matriculaRegex.test(matriculaInput.value)) {
        return "La matrícula debe tener entre 5 y 20 caracteres alfanuméricos.";
    }
    return null;
}

function validarCorreo() {
    const correoInput = document.querySelector('input[name="correo"]');
    const correoRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!correoInput.value) {
        return "El correo electrónico es obligatorio.";
    }
    if (!correoRegex.test(correoInput.value)) {
        return "El correo electrónico no es válido.";
    }
    return null;
}

function validarContrasenas() {
    const contrasenaInput = document.querySelector('input[name="clave"]');
    const confirmarContrasenaInput = document.querySelector('input[name="Rclave"]');
    if (!contrasenaInput.value) {
        return "La contraseña es obligatoria.";
    }
    if (contrasenaInput.value.length < 8) {
        return "La contraseña debe tener al menos 8 caracteres.";
    }
    if (contrasenaInput.value !== confirmarContrasenaInput.value) {
        return "Las contraseñas no coinciden.";
    }
    return null;
}


function validarFormulario() {
    // Validar Nombre
    const nombreError = validarNombre();
    if (nombreError) {
        document.getElementById("errornombre").textContent = nombreError;
        document.getElementById("errornombre").style.display = "block";
        return false;
    } else {
        document.getElementById("errornombre").style.display = "none";
    }

    // Validar Apellido
    const apellidoError = validarApellido();
    if (apellidoError) {
        document.getElementById("errorape").textContent = apellidoError;
        document.getElementById("errorape").style.display = "block";
        return false;
    } else {
        document.getElementById("errorape").style.display = "none";
    }

    // Validar Fecha de Nacimiento
    const fechaError = validarFechaNacimiento();
    if (fechaError) {
        document.getElementById("errorFeNaci").textContent = fechaError;
        document.getElementById("errorFeNaci").style.display = "block";
        return false;
    } else {
        document.getElementById("errorFeNaci").style.display = "none";
    }

    // Validar Matrícula
    const matriculaError = validarMatricula();
    if (matriculaError) {
        document.getElementById("errormatricula").textContent = matriculaError;
        document.getElementById("errormatricula").style.display = "block";
        return false;
    } else {
        document.getElementById("errormatricula").style.display = "none";
    }

    // Validar Correo Electrónico
    const correoError = validarCorreo();
    if (correoError) {
        document.getElementById("erroremail").textContent = correoError;
        document.getElementById("erroremail").style.display = "block";
        return false;
    } else {
        document.getElementById("erroremail").style.display = "none";
    }

    // Validar Contraseñas
    const contrasenaError = validarContrasenas();
    if (contrasenaError) {
        alert(contrasenaError);
        return false;
    }

    // Si todas las validaciones pasan
    return true;
}




function validarCuatrimestre() {
    const cuatri = document.querySelector('input[name="Cuatri"]');
    if (!cuatri.value || cuatri.value < 1 || cuatri.value > 10) {
        return "El cuatrimestre debe ser un número entre 1 y 10.";
    }
    return null;
}

function validarGrupo() {
    const grupo = document.querySelector('input[name="Grupo"]');
    if (!grupo.value || !/^[A-Za-z]+$/.test(grupo.value)) {
        return "El grupo solo debe contener letras.";
    }
    return null;
}

function validarCarrera() {
    const carrera = document.querySelector('select[name="Carrera"]');
    if (!carrera.value) {
        return "Por favor, selecciona una carrera.";
    }
    return null;
}

function validarPeriodo() {
    const periodo = document.querySelector('select[name="peri"]');
    if (!periodo.value) {
        return "Por favor, selecciona un período.";
    }
    return null;
}

function validarMotivo() {
    const motivo = document.querySelector('select[name="opciones"]');
    if (!motivo.value) {
        return "Por favor, selecciona un motivo.";
    }
    return null;
}

function validarEvidencia() {
    const evidencia = document.querySelector('input[name="evidencia"]');
    if (!evidencia.value) {
        return "Por favor, sube una evidencia.";
    }
    return null;
}

    
    function validacionesFormu() {
        // Validar Cuatrimestre
        const cuatrimestreError = validarCuatrimestre();
        if (cuatrimestreError) {
            document.getElementById("errorCuatri").textContent = cuatrimestreError;
            document.getElementById("errorCuatri").style.display = "block";
            return false;
        } else {
            document.getElementById("errorCuatri").style.display = "none";
        }
    
        // Validar Grupo
        const grupoError = validarGrupo();
        if (grupoError) {
            document.getElementById("errorGrupo").textContent = grupoError;
            document.getElementById("errorGrupo").style.display = "block";
            return false;
        } else {
            document.getElementById("errorGrupo").style.display = "none";
        }
    
        // Validar Carrera
        const carreraError = validarCarrera();
        if (carreraError) {
            document.getElementById("errorCarrera").textContent = carreraError;
            document.getElementById("errorCarrera").style.display = "block";
            return false;
        } else {
            document.getElementById("errorCarrera").style.display = "none";
        }
    
        // Validar Período
        const periodoError = validarPeriodo();
        if (periodoError) {
            document.getElementById("errorPeriodo").textContent = periodoError;
            document.getElementById("errorPeriodo").style.display = "block";
            return false;
        } else {
            document.getElementById("errorPeriodo").style.display = "none";
        }
    
        // Validar Motivo
        const motivoError = validarMotivo();
        if (motivoError) {
            document.getElementById("errorMotivo").textContent = motivoError;
            document.getElementById("errorMotivo").style.display = "block";
            return false;
        } else {
            document.getElementById("errorMotivo").style.display = "none";
        }
    
        // Validar Evidencia
        const evidenciaError = validarEvidencia();
        if (evidenciaError) {
            document.getElementById("errorEvidencia").textContent = evidenciaError;
            document.getElementById("errorEvidencia").style.display = "block";
            return false;
        } else {
            document.getElementById("errorEvidencia").style.display = "none";
        }
    
        // Validaciones adicionales según el contexto (ausente todo el día)
        const ausenteTodoDia = document.querySelector('input[name="info"]:checked');
        if (!ausenteTodoDia) {
            document.getElementById("errorAusente").textContent = "Por favor, selecciona si te ausentaste todo el día.";
            document.getElementById("errorAusente").style.display = "block";
            return false;
        } else {
            document.getElementById("errorAusente").style.display = "none";
    
            if (ausenteTodoDia.value === "si") {
                // Validar fecha de ausencia
                const fechaAusencia = document.getElementById("fecha").value.trim();
                if (!fechaAusencia) {
                    document.getElementById("errorFecha").textContent = "Por favor, selecciona la fecha de ausencia.";
                    document.getElementById("errorFecha").style.display = "block";
                    return false;
                } else {
                    document.getElementById("errorFecha").style.display = "none";
                }
    
                // Validar selección de profesores
                const profesores = document.getElementById("profesores").selectedOptions;
                if (!profesores.length) {
                    document.getElementById("errorProfesores").textContent = "Por favor, selecciona al menos un profesor.";
                    document.getElementById("errorProfesores").style.display = "block";
                    return false;
                } else {
                    document.getElementById("errorProfesores").style.display = "none";
                }
            } else {
                // Validar fecha y hora si selecciona "No"
                const fechaHoraInicio = document.getElementById("fecha2").value.trim();
                const horaInicio = document.getElementById("hora").value.trim();
                const horaFin = document.getElementById("horaFinal").value.trim();
    
                if (!fechaHoraInicio) {
                    document.getElementById("errorFecha2").textContent = "Por favor, selecciona la fecha.";
                    document.getElementById("errorFecha2").style.display = "block";
                    return false;
                } else {
                    document.getElementById("errorFecha2").style.display = "none";
                }
    
                if (!horaInicio || !horaFin || horaInicio >= horaFin) {
                    document.getElementById("errorHora").textContent = "Por favor, selecciona un rango de horas válido.";
                    document.getElementById("errorHora").style.display = "block";
                    return false;
                } else {
                    document.getElementById("errorHora").style.display = "none";
                }
            }
        }
    
        // Si todas las validaciones pasan
        return true;
    }
    
    







