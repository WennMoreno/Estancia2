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
    
    







