console.log('add-artwork.js loaded');

let formdata = {
    'id_number_min': 10000, // Valor mínimo de la letra del identificador
    'id_number_max': 99999, // Valor máximo de la letra del identificador
};

/** Funciones debounce para evitar spammear la API */
function debounce(fn, delay) {
    let timer = null

    return (...args) => {
        if (timer) clearTimeout(timer)
        timer = setTimeout(() => fn(...args), delay)
    }
}

/** Funcionalidad de la imagen por defecto de la obra */
if (document.getElementById('add-default-image')) {
    // Obtenemos el elemento HTML del botón de añadir imagen por defecto en caso de existir
    const addDefaultImage = document.getElementById('add-default-image');

    // Nos aseguramos que el elemento input de tipo FILE exista (aunque este oculto)
    if (document.getElementById('defaultimage')) {

        // Obtenemos el elemento input de tipo FILE
        const defaultImage = document.getElementById('defaultimage');

        // Comprobamos si el elemento img donde se mostrará la vista previa existe
        if (document.getElementById('defaultimagepreview')) {

            // Nos aseguramos de que el elemento img donde se mostrará la vista previa existe
            const imagePreview = document.getElementById('defaultimagepreview');

            // Le añadimos una funcionalidad al hacer click sobre el botón
            addDefaultImage.addEventListener('click', function (event) {
                // Evitamos que el formulario se envíe
                event.preventDefault();

                // Simulamos un click sobre el input para que se abra el explorador de archivos
                defaultImage.click();
            });

            // Le añadimos la funcionalidad de eliminar la imagen por defecto
            imagePreview.addEventListener('click', function () {
                Swal.fire({
                    title: "Estas segur que vols eliminar la imatge principal?",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonText: "Si, eliminar",
                    cancelButtonText: "Cancel·lar",
                }).then((result) => {
                    /* Read more about isConfirmed, isDenied below */
                    if (result.isConfirmed) {
                        // Eliminamos la imagen por defecto
                        imagePreview.src = '';
                        imagePreview.style.display = 'none'; // Asegurarse de que no sea visible
                        // Reseteamos el valor del input de tipo FILE
                        defaultImage.value = '';

                        // Cambiamos el texto del botón
                        addDefaultImage.textContent = 'Afegir imatge';
                    }
                });
            });

            // Le añadimos una funcionalidad al cambiar el archivo seleccionado
            defaultImage.addEventListener('change', (event) => {
                const selectedFile = event.target.files[0];
                if (selectedFile) {
                    // console.log('Archivo seleccionado:', selectedFile.name);
                    // Aquí puedes hacer algo con el archivo seleccionado

                    // Usar FileReader para leer la imagen y mostrar la vista previa
                    const reader = new FileReader();

                    // Le añadimos una funcionalidad al cargar la imagen
                    reader.onload = function (e) {
                        // Asignamos la imagen cargada como fuente del elemento de vista previa
                        imagePreview.src = e.target.result;
                        imagePreview.style.display = 'block'; // Asegurarse de que sea visible
                    };

                    reader.readAsDataURL(selectedFile);

                    addDefaultImage.textContent = 'Canviar imatge';
                }
            });
        }


    }
}
/* FIN DE LA FUNCIONALIDAD */

/** Funcionalidad de la autocompletar el identificar según la letra que se haya asignado */
function autocompleteId(letter = null) {
    fetch("http://localhost:8080/projecteDAW/controllers/ArtworkController.php?getNextId", {
        method: "POST",
        headers: {
            "Content-Type": "application/json"
        },
        body: JSON.stringify({ letter }) // Convertir el array a JSON
    })
    .then(response => response.text()) // Leer la respuesta completa como texto
    .then(response => {
        try {
            const data = JSON.parse(response);
            const nexId = Number(data.message) + 1;
            const idNumber = document.getElementById('id_number');
            const idNumberSub = document.getElementById('id_sub_number');
            idNumber.value = nexId;

            // Establecemos el valor mínimo del campo como el siguiente ID para evitar errores de validación
            idNumber.setAttribute('min', nexId);

            // Actualizamos el valor mínimo del formulario
            formdata.id_letter_min = nexId;
            
            // // Eliminamos la clase de campo invalido si la tiene
            // idNumber.classList.forEach(clase => {
            //     if (clase === 'is-invalid') {
            //         console.log('Se ha eliminado la clase de campo invalido del campo:', idNumber);
            //         idNumber.classList.remove('is-invalid');
            //     }
            // });

            // // Añadimos la clase de campo valido
            // idNumber.classList.add('is-valid');
            debounce(validateIdentifiers(letter, nexId, idNumberSub.value), 500);
        } catch (error) {
            console.error("Error parsing response:", error);
        }
        
    })
    .catch(error => {
        console.error('Error: ', error);
    });
}

function validateIdentifiers(letter, number, subnumber) {
    // console.log('Validando identificador:', letter, number, subnumber);

    const identifierElements = [
        document.getElementById('id_letter'),
        document.getElementById('id_number'),
        document.getElementById('id_sub_number')
    ];

    // Evitamos llamar a la API si el número no está en el rango permitido
    if (number < formdata.id_number_min || number > formdata.id_number_max) {
        console.log('El número no está en el rango permitido:', number);
        identifierElements.forEach(element => {
            element.classList.remove('is-valid');
            element.classList.add('is-invalid');
        });
        return;
    }

    if ((subnumber < 10 || subnumber > 99) && subnumber != '') {
        console.log('El subnúmero no está en el rango permitido:', subnumber);
        identifierElements.forEach(element => {
            element.classList.remove('is-valid');
            element.classList.add('is-invalid');
        });
        return;
    }

    fetch("http://localhost:8080/projecteDAW/controllers/ArtworkController.php?isIdentifiersValid", {
        method: "POST",
        headers: {
            "Content-Type": "application/json"
        },
        body: JSON.stringify({ letter, number, subnumber }) // Convertir el array a JSON
    })
    .then(response => response.text()) // Leer la respuesta completa como texto
    .then(response => {
        try {
            const data = JSON.parse(response);
            if (data.status === 'success') {
                console.log('[ok] Identificador válido.');
                identifierElements.forEach(element => {
                    element.classList.remove('is-invalid');
                    element.classList.add('is-valid');
                });
            } else {
                console.log('[!] Identificador NO válido.');
                identifierElements.forEach(element => {
                    element.classList.remove('is-valid');
                    element.classList.add('is-invalid');
                });
            }
        } catch (error) {
            console.error("Error parsing response:", error);
            identifierElements.forEach(element => {
                element.classList.remove('is-valid');
                element.classList.add('is-invalid');
            });
            return;
        }
    })
    .catch(error => {
        console.error('Error: ', error);
        identifierElements.forEach(element => {
            element.classList.remove('is-valid');
            element.classList.add('is-invalid');
        });
        return;
    });
}

if (document.getElementById('id_letter') && document.getElementById('id_number')) {

    const idLetter = document.getElementById('id_letter');
    const idNumber = document.getElementById('id_number');
    const idNumberSub = document.getElementById('id_sub_number');

    // Autocargamos el identificador según la letra seleccionada
    debounce(autocompleteId(idLetter.value), 500);

    // idNumber.classList.forEach(clase => {
    //     console.log('Clase:', clase);
    // });

    idLetter.addEventListener('change', function (element) {
        debounce(autocompleteId(element.target.value), 500);
        // Eliminamos el valor del campo de subnúmero cuando cambiamos de letra ya que es un campo opcional
        idNumberSub.value = '';
    });

    idNumber.addEventListener('input', function (element) {
        debounce(validateIdentifiers(idLetter.value, element.target.value, idNumberSub.value), 2000);
    });

    idNumberSub.addEventListener('input', function (element) {
        debounce(validateIdentifiers(idLetter.value, idNumber.value, element.target.value), 2000);
    });

    // idNumberSub.addEventListener('input', function (element) {
    //     if (!isValidId(idLetter.value, idNumber.value, element.target.value)) {
    //         // Añadimos la clase de campo invalido
    //         element.target.classList.remove('is-valid');
    //         element.target.classList.add('is-invalid');
    //     } else {
    //         // Añadimos la clase de campo valido
    //         element.target.classList.remove('is-invalid');
    //         element.target.classList.add('is-valid');
    //     }
    // });
}

/** Funcionalidad de titulo de la obra sincronizado con el titulo general de la página de creación de obra */
if (document.getElementById('artwork_title')) {
    const artworkTitle = document.getElementById('artwork_title');
    
    artworkTitle.addEventListener('input', function (element) {
        // console.log('Titulo de la obra:', element.target.value);
        if (element.target.value === '') {
            if (document.getElementById('artwork-page-title')) {
                document.getElementById('artwork-page-title').textContent = 'Nova obra';
            }
        } else {
            if (document.getElementById('artwork-page-title')) {
                document.getElementById('artwork-page-title').textContent = element.target.value;
            }
        }
    });
}
/* FIN DE LA FUNCIONALIDAD */