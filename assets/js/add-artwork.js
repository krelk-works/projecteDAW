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

/** Deshabilitamos la funcionalidad de enviar formulario para los botones, solo la dejamos habilitada para el tipo SUBMIT */
document.querySelectorAll('button').forEach(button => {
    // console.log('Boton encontrado:', button);
    button.addEventListener('click', function (event) {
        // alert('Botón pulsado: ' + button.textContent);
        if (button.type !== 'submit') {
            event.preventDefault();
        }
    });
});

/** Deshabilitamos que al hacer ENTER en cualquier INPUT se envie formulario */
document.querySelectorAll('input').forEach(input => {
    // console.log('Input encontrado:', input);
    input.addEventListener('keydown', function (event) {
        if (event.key === 'Enter') {
            event.preventDefault();
        }
    });
});


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

/** Funcionalidades de la autocompletar campos de [select] según el nombre que se haya asignado */

// Variables para los elementos de los campos de selección
const authorSelect = document.getElementById('author_names');
const datationsList = document.getElementById('datations_list');
const materialsList = document.getElementById('materials_list');
const genericClassificationList = document.getElementById('generic_classification');
const tecniquesList = document.getElementById('tecniques_list');
const conservationsStatusList = document.getElementById('conservations_list');
const gettyMaterialCodeList = document.getElementById('getty_material_codes_list');
const gettyMaterialList = document.getElementById('getty_material_list');
const entryTypeList = document.getElementById('entry_type_list');
const locationsList = document.getElementById('locations_list');
const cancelCausesList = document.getElementById('cancel_causes_list');

// Construir la estructura jerárquica de ubicaciones
function buildLocationTree(data, parentId = null, depth = 0) {
    let result = [];
    data.filter(location => location.parent === parentId).forEach(location => {
        result.push({ ...location, depth });
        result = result.concat(buildLocationTree(data, location.id, depth + 1));
    });
    return result;
}

// Insertar opciones en el select
function populateLocationsSelect(data) {
    buildLocationTree(data).forEach(location => {
        const option = document.createElement('option');
        option.value = location.id;
        option.textContent = `${'\u00A0\u00A0\u00A0'.repeat(location.depth) + '► '} ${location.name}`;
        locationsList.appendChild(option);
    });
}

// Llamada a la API para obtener los datos de los campos de selección de formulario base
fetch("http://localhost:8080/projecteDAW/controllers/ArtworkController.php?getFormData", {
    method: "POST",
    headers: {
        "Content-Type": "application/json"
    },
})
.then(response => response.text()) // Leer la respuesta completa como texto
.then(response => {
    try {
        const data = JSON.parse(response); // Convertir la respuesta a JSON
        
        console.log('Datos de formulario:', data);

        let authorsHTML = '';
        authorsHTML += `<option value="">Sense especificar</option>`;
        data.message.authors.forEach(author => {
            // console.log('Autor:', author.name);
            authorsHTML += `<option value="${author.id}">${author.name}</option>`;
        });
        authorSelect.innerHTML = authorsHTML; // Insertamos las opciones en el select

        let datationsHTML = '';
        datationsHTML += `<option value="">Sense especificar</option>`;
        data.message.datations.forEach(datation => {
            // console.log('Datació:', datation.name);
            datationsHTML += `<option value="${datation.id}">${datation.text} (${datation.start_date} fins ${datation.end_date == null ? 'actualitat' : datation.end_date})</option>`;
        });
        datationsList.innerHTML = datationsHTML; // Insertamos las opciones en el select

        let materialsHTML = '';
        materialsHTML += `<option value="">Sense especificar</option>`;
        data.message.materials.forEach(material => {
            // console.log('Material:', material.text);
            materialsHTML += `<option value="${material.id}">${material.text}</option>`;
        });
        materialsList.innerHTML = materialsHTML; // Insertamos las opciones en el select

        let genericClassificationHTML = '';
        genericClassificationHTML += `<option value="">Sense especificar</option>`;
        data.message.classifications.forEach(classification => {
            // console.log('Clasificación:', classification.text);
            genericClassificationHTML += `<option value="${classification.id}">${classification.text}</option>`;
        });
        genericClassificationList.innerHTML = genericClassificationHTML; // Insertamos las opciones en el select

        let tecniquesHTML = '';
        tecniquesHTML += `<option value="">Sense especificar</option>`;
        data.message.tecniques.forEach(tecnique => {
            // console.log('Tècnica:', tecnique.text);
            tecniquesHTML += `<option value="${tecnique.id}">${tecnique.text}</option>`;
        });
        tecniquesList.innerHTML = tecniquesHTML; // Insertamos las opciones en el select

        let conservationsStatusHTML = '';
        conservationsStatusHTML += `<option value="">Sense especificar</option>`;
        data.message.conservationstatus.forEach(status => {
            // console.log('Estat de conservació:', status.text);
            conservationsStatusHTML += `<option value="${status.id}">${status.text}</option>`;
        });
        conservationsStatusList.innerHTML = conservationsStatusHTML; // Insertamos las opciones en el select

        let gettyMaterialCodeHTML = '';
        gettyMaterialCodeHTML += `<option value="">Sense especificar</option>`;
        data.message.materialgettycodes.forEach(code => {
            // console.log('Codi de material Getty:', code.text);
            gettyMaterialCodeHTML += `<option value="${code.id}">${code.text}</option>`;
        });
        gettyMaterialCodeList.innerHTML = gettyMaterialCodeHTML; // Insertamos las opciones en el select

        let gettyMaterialHTML = '';
        gettyMaterialHTML += `<option value="">Sense especificar</option>`;
        data.message.materialgetty.forEach(material => {
            // console.log('Material Getty:', material.text);
            gettyMaterialHTML += `<option value="${material.id}">${material.text}</option>`;
        });
        gettyMaterialList.innerHTML = gettyMaterialHTML; // Insertamos las opciones en el select

        let entryTypeHTML = '';
        entryTypeHTML += `<option value="">Sense especificar</option>`;
        data.message.entry.forEach(type => {
            // console.log('Tipus d'entrada:', type.text);
            entryTypeHTML += `<option value="${type.id}">${type.text}</option>`;
        });
        entryTypeList.innerHTML = entryTypeHTML; // Insertamos las opciones en el select

        // Las ubicaciones se cargaran pero con algo más de código para crear un árbol de ubicaciones y que sea accesible para el usuario
        let locationsHTML = '';
        locationsHTML += `<option value="">Sense especificar</option>`;
        locationsList.innerHTML = locationsHTML; // Insertamos la opción por defecto en el select
        populateLocationsSelect(data.message.locations); // Insertamos todas las opciones en el select

        let cancelCausesHTML = '';
        cancelCausesHTML += `<option value="">Sense especificar</option>`;
        data.message.cancelcauses.forEach(cause => {
            // console.log('Causa de cancel·lació:', cause.text);
            cancelCausesHTML += `<option value="${cause.id}">${cause.text}</option>`;
        });
        cancelCausesList.innerHTML = cancelCausesHTML; // Insertamos las opciones en el select
    } catch (error) {
        console.error("Error parsing response:", error);
    }
})
.catch(error => {
    console.error('Error: ', error);
});