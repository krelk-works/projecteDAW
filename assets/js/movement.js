function showMovementDetails(id, startDate, endDate, place) {
    Swal.fire({
        title: 'Editar Movimiento',
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
        showCancelButton: true,
        confirmButtonText: 'Guardar',
        cancelButtonText: 'Cancelar',
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
        }
    });
}

function saveMovement(data) {
    fetch('controllers/MovementsController.php?editMovement', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(data)
    }).then(response => response.text()) // Change to text() to log the raw response
      .then(responseText => {
          console.log(responseText); // Log the raw response text
          try {
              const responseData = JSON.parse(responseText); // Parse the response text as JSON
              Swal.fire('Guardado', 'El movimiento se ha actualizado correctamente', 'success')
                      .then(() => window.location.reload());
            //   if (responseData.success) {
            //       Swal.fire('Guardado', 'El movimiento se ha actualizado correctamente', 'success')
            //           .then(() => window.location.reload());
            //   } else {
            //       Swal.fire('Error', responseData.message, 'error');
            //   }
          } catch (error) {
              console.error('Error parsing JSON:', error);
              Swal.fire('Error', 'Error en la respuesta del servidor', 'error');
          }
      });
}

// // Test function to simulate editing a movement
// function testEditMovement() {
//     const testId = 1;
//     const testStartDate = '2023-01-01';
//     const testEndDate = '2023-01-10';
//     const testPlace = 'Test Place';

//     showMovementDetails(testId, testStartDate, testEndDate, testPlace);
// }

// // Call the test function to simulate the edit
// testEditMovement();