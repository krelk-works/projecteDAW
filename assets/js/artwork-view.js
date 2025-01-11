// console.log('artwork-view.js loaded');

// Obtener la URL actual
const urlParams = new URLSearchParams(window.location.search);

/** Funcionalidad para rellenar el numero de identificador (registro) con ceros */
function padIdentifierWithZeros(number) {
    // Comprobar si el valor es un número
    if (isNaN(number)) {
        console.error("Error: El valor no es un número.");
        return null; // Devuelve null en caso de error
    }

    // Comprobar si el número está dentro del rango permitido
    if (number < 1 || number > 99999) {
        console.error("Error: El número está fuera del rango permitido (1 - 99999).");
        return null; // Devuelve null en caso de error
    }

    if (number.toString().length > 5) {
        console.log('Número mayor a 5 dígitos:', number);
        const digitnumber = Number(number);
        return digitnumber.toString().padStart(5, '0');
    }

    // Si las comprobaciones son correctas, agrega ceros a la izquierda hasta 5 dígitos
    return number.toString().padStart(5, '0');
}

function padSubWithZeros(number) {
    if (!number) {
        return;
    }
    // Comprobar si el valor es un número
    if (isNaN(number)) {
        console.error("Error: El valor no es un número.");
        return null; // Devuelve null en caso de error
    }

    // Comprobar si el número está dentro del rango permitido
    if ((number < 1 || number > 99) && number != '' && number != 0) {
        console.error("Error: El número está fuera del rango permitido (1 - 99).");
        return null; // Devuelve null en caso de error
    }

    if (number.toString().length > 2) {
        const digitnumber = Number(number);
        return digitnumber.toString().padStart(2, '0');
    }

    // if (number.toString().length === 1 && number == 0) {
    //     return '01';
    // }

    // Si las comprobaciones son correctas, agrega ceros a la izquierda hasta 5 dígitos
    return number.toString().padStart(2, '0');
}



// Comprobar si un parámetro existe
if (urlParams.has('id')) {
    // console.log('id existe y su valor es:', urlParams.get('id'));

    // Start loader spinner

    const loaderContainer = document.createElement('div');
    loaderContainer.className = "loader-container";
    const loader = document.createElement('div');
    loader.className = "loader";
    loaderContainer.appendChild(loader);
    document.querySelector('#artwork-view-container').appendChild(loaderContainer);

    // Obtener los datos de la obra del controlador mediante Api
    fetch('controllers/ArtworkController.php?getArtworkAllData', {
        method: "POST",
        headers: {
            "Content-Type": "application/json"
        },
        body: JSON.stringify({ artworkId: urlParams.get('id') }) // Convertir el array a JSON
    })
        .then(response => response.text()) // Leer la respuesta completa como texto
        .then(data => {
            try {
                // console.log('Hola API...')
                // console.log(data);
                const rawData = JSON.parse(data);
                const artworkData = rawData.message[0]; // Get data from message key

                // console.log(artworkData);

                // Title of artwork
                $('#artwork-title').text(artworkData.title);

                // Artwork identifier
                let identifier = "";
                
                artworkData.id_letter ? identifier += artworkData.id_letter : null;
                artworkData.id_num1 ? identifier += padIdentifierWithZeros(artworkData.id_num1) : null;
                artworkData.id_num2 ? identifier += "."+padSubWithZeros(artworkData.id_num2) : null;

                $('#artwork-identifier').text(identifier);

                // Artwork object name
                // $('#artwork-object-name').text(artworkData.name);

                // Artwork description
                $('#artwork-description').text(artworkData.description);

                // Artwork author
                $('#artwork-author').text(artworkData.author);

                // Artwork datation
                $('#artwork-datation').text(artworkData.datation);

                // Artwork register date
                // Parsing to European format
                let registerDate = new Date(artworkData.register_date);
                registerDate = registerDate.toLocaleDateString('es-ES', { year: 'numeric', month: '2-digit', day: '2-digit' });
                $('#artwork-register-date').text(registerDate);

                // Artwork creation date
                // Parsing to European format
                let creationDate = new Date(artworkData.creation_date);
                creationDate = creationDate.toLocaleDateString('es-ES', { year: 'numeric', month: '2-digit', day: '2-digit' });
                $('#artwork-creation-date').text(creationDate);

                // Artwork bibliography
                $('#artwork-bibliography').text(artworkData.bibliography);

                // Artwork material
                $('#artwork-material').text(artworkData.material);

                // Artwork technique
                $('#artwork-tecnique').text(artworkData.tecnique);

                // Artwork generic classification
                $('#artwork-generic-classification').text(artworkData.genericclassification);

                // Artwork price
                $('#artwork-price').text(artworkData.cost);

                // Artwork amount/quantity
                $('#artwork-amount').text(artworkData.amount);

                // Artwork dimensions
                const dimensions = [
                    artworkData.height,
                    artworkData.width,
                    artworkData.depth
                ];

                // Generating the dimensions string
                let dimensionsString = "";
                dimensions.forEach((dimension, index) => {
                    if (dimension) {
                        dimensionsString += dimension + " cm";
                        if (index < dimensions.length - 1) {
                            dimensionsString += " x ";
                        }
                    }
                });

                $('#artwork-dimensions').text(dimensionsString);

                // Artwork conservation status
                $('#artwork-conservation').text(artworkData.conservationstatus);
                
                // Artwork provenance locations museum
                $('#artwork-museum-name').text(artworkData.museumname);

                // Artwork origin place
                $('#artwork-provenance-place').text(artworkData.originplace);

                // Artwork provenance collection
                $('#artwork-provenance-collection').text(artworkData.provenancecollection);

                // Artwork entry type
                $('#artwork-entry-type').text(artworkData.entry);

                // Artwork location name
                $('#artwork-location-name').text(artworkData.location);

                // Artwork execution place
                $('#artwork-execution-place').text(artworkData.executionplace);

                // Artwork tirage
                $('#artwork-tirage').text(artworkData.triage);

                // Artwork images gallery

                // General image path

                const generalImagePath = artworkData.image;

                // Agregar la imagen principal a la galería si existe
                if (generalImagePath) {
                    const newImageDivElement = document.createElement('div');
                    newImageDivElement.className = "artwork-view-image";
                    const newImageElement = document.createElement('img');
                    newImageElement.src = generalImagePath;
                    newImageElement.alt = "Imatge principal de l'obra";
                    newImageDivElement.appendChild(newImageElement);
                    newImageDivElement.addEventListener('click', () => {
                        // Open image in new tab
                        window.open(generalImagePath, '_blank');
                    });
                    $('.artwork-view-images').append(newImageDivElement);
                }

                // Add additional images to the gallery if they exist



                // Stop loader spinner and delete element
                loaderContainer.remove();

                // Show the artwork view body
                $('#artwork-view-body').fadeIn(500);
                $('#artwork-view-body').css = ("display", "flex");
            } catch (error) {
                console.log('Error parsing JSON data:', data + " | Error: " + error);
            }
            
        })
        .catch(error => console.log(error));

        $("#edit_artwork").click(function() {
            window.open('index.php?page=artwork-update&id='+urlParams.get('id'));
        });
}

movement_create.addEventListener('click', function () {
    Swal.fire({
        title: "Crear moviment",
        icon: "info",
        html: `
        <div class="swal2-content">
            <form id="movement-form" style="display: flex; flex-direction: column; gap: 15px;">
                <div style="display: flex; align-items: center; gap: 10px;">
                    <label for="movement-datainici" style="width: 100px; text-align: right;">Data inici:</label>
                    <input type="date" id="movement-datainici" name="movement-datainici" class="swal2-input" style="flex: 1;">
                </div>
                <div style="display: flex; align-items: center; gap: 10px;">
                    <label for="movement-datafi" style="width: 100px; text-align: right;">Data fi:</label>
                    <input type="date" id="movement-datafi" name="movement-datafi" class="swal2-input" style="flex: 1;">
                </div>
                <div style="display: flex; align-items: center; gap: 10px;">
                    <label for="movement-destinacio" style="width: 100px; text-align: right;">Destinació:</label>
                    <input type="text" id="movement-destinacio" name="movement-destinacio" class="swal2-input" style="flex: 1;">
                </div>
                <input type="hidden" id="artwork-id" name="artwork-id" value="${urlParams.get('id')}">
            </form>
        </div>
        `,
        customClass: {
            popup: 'larger-swal'
        },
        showCancelButton: true,
        confirmButtonText: "Si, crear",
        cancelButtonText: "Cancel·lar",
        preConfirm: () => {
            const datainici = Swal.getPopup().querySelector('#movement-datainici').value;
            const datafi = Swal.getPopup().querySelector('#movement-datafi').value;
            const destinacio = Swal.getPopup().querySelector('#movement-destinacio').value;
            const artworkId = Swal.getPopup().querySelector('#artwork-id').value;
            if (!datainici || !datafi || !destinacio) {
                Swal.showValidationMessage(`Rellena todos los campos`);
            }
            return { datainici, datafi, destinacio, artworkId };
        }
    }).then((result) => {
        if (result.isConfirmed) {
            const formData = result.value;
            fetch('controllers/MovementsController.php?movement', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({
                    start_date: formData.datainici,
                    end_date: formData.datafi,
                    place: formData.destinacio,
                    artwork: formData.artworkId
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.status == 'success') {
                    Swal.fire('Éxito', data.message, 'success');
                } else {
                    Swal.fire('Error', data.message, 'error');
                }
            })
            .catch(error => {
                Swal.fire('Error', 'Hubo un problema al crear el movimiento.', 'error');
                console.error(error);
            });
        }
    });
});

const style = document.createElement('style');
style.textContent = `
    .larger-swal {
        width: 600px !important; /* Cambia este valor para ajustar el ancho */
        max-width: 90%; /* Asegura que no exceda el ancho de la pantalla */
    }
`;
document.head.appendChild(style);
