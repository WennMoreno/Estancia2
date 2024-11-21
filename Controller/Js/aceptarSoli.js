// Función para mostrar los detalles de la solicitud cuando se hace clic
const solicitudItems = document.querySelectorAll('.solicitud-item');
solicitudItems.forEach(item => {
    item.addEventListener('click', function() {
        const solicitudId = this.getAttribute('data-id');

        // Quitar clase 'active' de cualquier solicitud previamente seleccionada
        solicitudItems.forEach(i => i.classList.remove('active'));
        this.classList.add('active');

        fetch('../../Controller/detallesSoli.php?id=' + solicitudId)
        .then(response => response.text()) 
        .then(html => {
            const detallesDiv = document.getElementById('detallesSolicitud');
            detallesDiv.innerHTML = html; 
        })
        .catch(error => {
            console.error("Error al obtener los detalles:", error);
            const detallesDiv = document.getElementById('detallesSolicitud');
            detallesDiv.innerHTML = `<p>Error al cargar los detalles de la solicitud.</p>`;
        });
    });
});

// Función para aceptar la solicitud
function aceptarSolicitud(idSolicitud) {
    if (confirm("¿Desea aceptar esta solicitud y generar el PDF?")) {
        const formData = new FormData();
        formData.append('idJusti', idSolicitud); 

        fetch('aceptar_solicitud.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.text())
        .then(data => {
            document.getElementById('detallesSolicitud').innerHTML = data;
            location.reload(); 
        })
        .catch(error => {
            console.error("Error al aceptar la solicitud:", error);
            alert("Error al aceptar la solicitud.");
        });
    }
}
 

function cambiarEstado(idJusti, nuevoEstado) {
    // Verificar el idJusti y el nuevoEstado recibidos
    console.log("ID de la solicitud:", idJusti); // Aquí imprimes el ID de la solicitud
    console.log("Nuevo estado:", nuevoEstado); // Aquí imprimes el nuevo estado

    // Confirmar la acción con el usuario
    if (confirm("¿Estás seguro de que deseas rechazar esta solicitud?")) {
        // Crear los datos que se van a enviar
        const data = new FormData();
        data.append('idJusti', idJusti);
        data.append('nuevoEstado', nuevoEstado);

        // Enviar la solicitud AJAX
        fetch('/pruebasOfAllVerDul/Controller/Rechazar.php', {
            method: 'POST',
            body: data,
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert(data.message); // Mensaje de éxito
                location.reload(); // Recarga la página para ver el cambio
            } else {
                alert(data.message); // Mensaje de error
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert("Hubo un error al procesar la solicitud.");
        });
    }
}



