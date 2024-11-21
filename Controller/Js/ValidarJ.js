
function eliminarJustificante(id) {
    if (confirm("¿Está seguro de que desea eliminar este justificante?")) {
        window.location.href = "gestionJustiRegu.php?delete_id=" + id;
    }
}
