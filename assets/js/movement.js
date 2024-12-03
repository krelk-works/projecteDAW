
function showMovementDetails(title, startDate, endDate, place) {
    Swal.fire({
        title: 'Detalls del Moviment',
        html: `
            <strong>Títol:</strong> ${title}<br>
            <strong>Data Inici:</strong> ${startDate}<br>
            <strong>Data Finalització:</strong> ${endDate}<br>
            <strong>Destí:</strong> ${place}<br>
        `,
        showCancelButton: true,
        confirmButtonText: 'Editar',
        cancelButtonText: 'Eliminar',
        showCloseButton: true,
    }).then((result) => {
        if (result.isConfirmed) {
            // Lógica para editar
            window.location.href = `/edit-movement?title=${encodeURIComponent(title)}`;
        } else if (result.dismiss === Swal.DismissReason.cancel) {
            // Lógica para eliminar
            window.location.href = `/delete-movement?title=${encodeURIComponent(title)}`;
        }
    });
}

