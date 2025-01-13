function showMovementDetails(id, startDate, endDate, place) {
    Swal.fire({
        title: 'Editar/Borrar moviment',
        html: `
            <form id="editMovementForm" class="edit-movement-form">
                <label for="start_date">Data Inici:</label>
                <input type="date" id="start_date" name="start_date" value="${startDate}">

                <label for="end_date">Data Finalització:</label>
                <input type="date" id="end_date" name="end_date" value="${endDate}">

                <label for="place">Destí:</label>
                <input type="text" id="place" name="place" value="${place}">
            </form>
        `,
        showDenyButton: true,
        showCancelButton: true,
        confirmButtonText: 'Guardar',
        denyButtonText: 'Eliminar',
        cancelButtonText: 'Cancelar',
        customClass: {
            confirmButton: 'swal2-confirm',
            denyButton: 'swal2-deny',
            cancelButton: 'swal2-cancel',
        },
        preConfirm: () => {
            const start_date = document.getElementById('start_date').value;
            const end_date = document.getElementById('end_date').value;
            const place = document.getElementById('place').value;

            if (!start_date || !end_date || !place) {
                Swal.showValidationMessage('Todos los campos son obligatorios');
                return false;
            }

            return { id, start_date, end_date, place };
        }
    }).then((result) => {
        if (result.isConfirmed) {
            saveMovement(result.value);
        } else if (result.isDenied) {
            deleteMovement(id);
        }
    });
}

function saveMovement(data) {
    fetch('controllers/MovementsController.php?editMovement', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(data)
    }).then(response => response.text())
        .then(responseText => {
            console.log(responseText);
            try {
                const responseData = JSON.parse(responseText);
                Swal.fire('Guardado', 'El movimiento se ha actualizado correctamente', 'success')
                    .then(() => window.location.reload());
            } catch (error) {
                console.error('Error parsing JSON:', error);
                Swal.fire('Error', 'Error en la respuesta del servidor', 'error');
            }
        });
}

function deleteMovement(id) {
    fetch(`controllers/MovementsController.php?deleteMovement`, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(id)
    }).then(response => response.text())
        .then(responseText => {
            console.log(responseText);
            try {
                const responseData = JSON.parse(responseText);
                Swal.fire('Eliminado', 'El movimiento ha sido eliminado correctamente.', 'success').then(() => window.location.reload());
            } catch (error) {
                console.error('Error parsing JSON:', error);
                Swal.fire('Error', 'Error en la respuesta del servidor', 'error');
            }
        }).catch(error => {
            console.error('Error fetching:', error);
            Swal.fire('Error', 'Error al eliminar el movimiento', 'error');
        });
}
