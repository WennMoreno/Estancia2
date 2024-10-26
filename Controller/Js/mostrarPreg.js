// mostrarPreg.js
function mostrarPreguntas() {
    const preguntasAdicionales = document.getElementById("preguntasAdicionales");
    const calendarioHora = document.getElementById("calendarioHora");

    if (document.getElementById("si").checked) {
        preguntasAdicionales.classList.remove("hidden");
        calendarioHora.classList.add("hidden");
    } else if (document.getElementById("no").checked) {
        calendarioHora.classList.remove("hidden");
        preguntasAdicionales.classList.add("hidden");
        
    }
}
