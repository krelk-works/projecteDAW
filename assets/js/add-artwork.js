const formdata = {
    'id_number_min': 1, // Valor mínimo de la letra del identificador
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

/** Funcionalidad de la autocompletar el identificar según la letra que se haya asignado */
function autocompleteId(letter = null) {
    if (letter) letter = letter.toUpperCase();
    fetch("controllers/ArtworkController.php?getNextId", {
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
            console.log('Respuesta de la API:', data);
            const nexId = Number(data.message) + 1;
            console.log('Siguiente ID:', nexId);
            const idNumber = document.getElementById('id_number');
            const idNumberSub = document.getElementById('id_sub_number');
            idNumber.value = padIdentifierWithZeros(nexId);

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

    if ((subnumber < 0 || subnumber > 99) && subnumber != '') {
        console.log('El subnúmero no está en el rango permitido:', subnumber);
        identifierElements.forEach(element => {
            element.classList.remove('is-valid');
            element.classList.add('is-invalid');
        });
        return;
    }

    fetch("controllers/ArtworkController.php?isIdentifiersValid", {
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

    // Autocargamos el identificador según la letra seleccionada al cargar la página
    debounce(autocompleteId(idLetter.value), 500);

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

    idNumberSub.addEventListener('change', function (element) {
        if (element.target.value === '' || !element.target.value) {
            return;
        }
        if ((Number(element.target.value) > -1 && Number(element.target.value) < 100) || element.target.value.toString().length < 2) {
            idNumberSub.value = padSubWithZeros(element.target.value);
        }
    });

    idNumber.addEventListener('change', function (element) {
        if ((element.target.value && Number(element.target.value) > 0 && Number(element.target.value) < 100000) || element.target.value.toString().length < 5) {
            idNumber.value = padIdentifierWithZeros(element.target.value);
        }
    });
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
fetch("controllers/ArtworkController.php?getFormData", {
    method: "POST",
    headers: {
        "Content-Type": "application/json"
    },
})
.then(response => response.text()) // Leer la respuesta completa como texto
.then(response => {
    try {
        const data = JSON.parse(response); // Convertir la respuesta a JSON
        
        // console.log('Datos de formulario:', data);

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
/* FIN DE LA FUNCIONALIDAD */

// Variables usadas para la funcionalidad de añadir documentos asociados a la obra

let currentDocumentIndex = 0;

/** Funcionalidad de agregar o eliminar documentos asociados a la obra */
if (document.getElementById('add_documents_button')) {
    const addDocumentsButton = document.getElementById('add_documents_button');

    //addDocumentsButton.addEventListener('click', function (event) {
        // event.preventDefault();
        // const documentsList = document.getElementById('documents_list');
        // const documentTemplate = document.getElementById('document_template');
        // const newDocument = documentTemplate.cloneNode(true);
        // newDocument.removeAttribute('id');
        // newDocument.style.display = 'block';
        // documentsList.appendChild(newDocument);
    //});
}

// Inicializamos el índice de documentos
let documentsIndex = 0;

// Función para agregar un nuevo input de tipo file y mostrar la vista previa del archivo
function addDocumentInput() {
    // Obtenemos el contenedor donde se almacenarán los inputs ocultos
    const hiddenInputsContainer = document.getElementById("hidden_inputs");

    // Seleccionamos el contenedor principal donde se agregarán las vistas previas
    const mainPreviewContainer = document.querySelector(".artwork-create-box-multimedia");

    // Creamos el nuevo input oculto con restricción de tipos de documentos
    const newInput = document.createElement("input");
    newInput.type = "file";
    newInput.id = `document_${documentsIndex}`;
    newInput.name = `document_${documentsIndex}`;
    newInput.hidden = true;
    newInput.accept = ".txt, .pdf, .doc, .docx, .ppt, .pptx, .xls, .xlsx"; // Restricción de tipos de archivo

    // Añadimos el nuevo input al contenedor oculto
    hiddenInputsContainer.appendChild(newInput);

    // Escuchamos el cambio de archivo del input para mostrar la vista previa
    newInput.addEventListener("change", function () {
        if (newInput.files && newInput.files[0]) {
            const file = newInput.files[0];

            // Crear el div con clase multimedia-content que contendrá la vista previa
            const outerContainer = document.createElement("div");
            outerContainer.classList.add("multimedia-content");

            // Crear el contenedor interno para la imagen y el nombre del archivo
            const filePreviewContainer = document.createElement("div");
            filePreviewContainer.style.width = "120px";
            filePreviewContainer.style.height = "auto";
            filePreviewContainer.style.display = "flex";
            filePreviewContainer.style.flexDirection = "column";
            filePreviewContainer.style.alignItems = "center";
            filePreviewContainer.setAttribute("data-input-id", newInput.id); // Asociar el contenedor al id del input

            // Crear un icono o imagen genérica para documentos
            const docIcon = document.createElement("img");
            docIcon.src = "assets/img/icono-documento.png"; // Cambia a la ruta de tu ícono de documento
            docIcon.alt = "Vista previa del documento";
            docIcon.style.width = "100px";
            docIcon.style.height = "100px";

            // Crear el nombre del archivo
            const fileName = document.createElement("p");
            fileName.textContent = `${file.name}`;
            fileName.style.fontSize = "12px";
            fileName.style.textAlign = "center";

            // Añadir el icono y el nombre al contenedor de vista previa
            filePreviewContainer.appendChild(docIcon);
            filePreviewContainer.appendChild(fileName);

            // Añadir el contenedor de vista previa al div con clase multimedia-content
            outerContainer.appendChild(filePreviewContainer);

            // Insertar la nueva vista previa al principio del contenedor principal
            mainPreviewContainer.insertBefore(outerContainer, mainPreviewContainer.firstChild);

            // Añadir evento para eliminar el archivo y la vista previa al hacer clic en la imagen
            docIcon.addEventListener("click", function () {
                // SweetAlert para confirmar la eliminación del archivo
                Swal.fire({
                    title: "Estas segur que vols eliminar aquest document?",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonText: "Si, eliminar",
                    cancelButtonText: "Cancel·lar",
                }).then((result) => {
                    /* Read more about isConfirmed, isDenied below */
                    if (result.isConfirmed) {
                        // Eliminamos el input y el contenedor de vista previa asociados
                        const inputToRemove = document.getElementById(filePreviewContainer.getAttribute("data-input-id"));
                        inputToRemove?.remove();
                        outerContainer.remove();
                    }
                });                
            });
        }
    });

    // Simulamos el clic para abrir el selector de archivos
    newInput.click();

    // Aumentamos el índice para el próximo archivo
    documentsIndex++;
}

// Asignamos el evento al botón de agregar documentos
document.getElementById("add_documents_button").addEventListener("click", addDocumentInput);

// Inicializamos el índice de imágenes adicionales
let additionalImagesIndex = 0;

// Función para agregar un nuevo input de tipo file y mostrar la vista previa de la imagen asociada
function addAdditionalImageInput() {
    // Obtenemos el contenedor donde se almacenarán los inputs ocultos
    const hiddenInputsContainer = document.getElementById("hidden_inputs");

    // Seleccionamos el segundo contenedor principal para las imágenes adicionales
    const additionalPreviewContainer = document.querySelectorAll(".artwork-create-box-multimedia")[1];

    // Creamos el nuevo input oculto con restricción de tipos de imágenes
    const newInput = document.createElement("input");
    newInput.type = "file";
    newInput.id = `additional_image_${additionalImagesIndex}`;
    newInput.name = `additional_image_${additionalImagesIndex}`;
    newInput.hidden = true;
    newInput.accept = "image/png, image/jpeg, image/jpg"; // Restricción a tipos de imagen

    // Añadimos el nuevo input al contenedor oculto
    hiddenInputsContainer.appendChild(newInput);

    // Escuchamos el cambio de archivo del input para mostrar la vista previa
    newInput.addEventListener("change", function () {
        if (newInput.files && newInput.files[0]) {
            const file = newInput.files[0];
            const reader = new FileReader();

            reader.onload = function (e) {
                // Crear el div con clase multimedia-content que contendrá la vista previa
                const outerContainer = document.createElement("div");
                outerContainer.classList.add("multimedia-content");

                // Crear el contenedor interno para la imagen y el nombre del archivo
                const imagePreviewContainer = document.createElement("div");
                imagePreviewContainer.style.width = "120px";
                imagePreviewContainer.style.height = "auto";
                imagePreviewContainer.style.display = "flex";
                imagePreviewContainer.style.flexDirection = "column";
                imagePreviewContainer.style.alignItems = "center";
                imagePreviewContainer.setAttribute("data-input-id", newInput.id); // Asociar el contenedor al id del input

                // Crear la vista previa de la imagen real seleccionada
                const imgPreview = document.createElement("img");
                imgPreview.src = e.target.result; // Vista previa real de la imagen
                imgPreview.alt = "Vista previa de la imagen";
                imgPreview.style.width = "100px";
                imgPreview.style.height = "100px";

                // Crear el nombre del archivo
                const fileName = document.createElement("p");
                fileName.textContent = `${file.name}`;
                fileName.style.fontSize = "12px";
                fileName.style.textAlign = "center";

                // Añadir la imagen de vista previa y el nombre al contenedor de vista previa
                imagePreviewContainer.appendChild(imgPreview);
                imagePreviewContainer.appendChild(fileName);

                // Añadir el contenedor de vista previa al div con clase multimedia-content
                outerContainer.appendChild(imagePreviewContainer);

                // Insertar la nueva vista previa al principio del contenedor principal
                additionalPreviewContainer.insertBefore(outerContainer, additionalPreviewContainer.firstChild);

                // Añadir evento para eliminar el archivo y la vista previa al hacer clic en la imagen
                imgPreview.addEventListener("click", function () {
                    // SweetAlert para confirmar la eliminación del archivo
                    Swal.fire({
                        title: "Estas segur que vols eliminar aquesta imatge?",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonText: "Si, eliminar",
                        cancelButtonText: "Cancel·lar",
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Eliminamos el input y el contenedor de vista previa asociados
                            const inputToRemove = document.getElementById(imagePreviewContainer.getAttribute("data-input-id"));
                            inputToRemove?.remove();
                            outerContainer.remove();
                        }
                    });
                });
            };

            reader.readAsDataURL(file); // Lee la imagen para mostrar la vista previa
        }
    });

    // Simulamos el clic para abrir el selector de archivos
    newInput.click();

    // Aumentamos el índice para la próxima imagen adicional
    additionalImagesIndex++;
}

// Asignamos el evento al botón de agregar imágenes adicionales en el segundo contenedor multimedia
document.querySelectorAll(".artwork-create-box-multimedia .multimedia-add-content button")[1]
    .addEventListener("click", addAdditionalImageInput);

// Inicializamos el índice de referencias
let referenceIndex = 0;

// Función para agregar una nueva referencia tras la confirmación del usuario en SweetAlert
function addReference() {
    // SweetAlert para ingresar los datos de la nueva referencia
    Swal.fire({
        title: "Agregar Referencia",
        html:
            '<input id="reference-name" class="swal2-input" placeholder="Nom referència">' +
            '<input id="reference-url" class="swal2-input" style="width: 80%;" placeholder="URL">',
        showCancelButton: true,
        confirmButtonText: "Agregar",
        cancelButtonText: "Cancelar",
        preConfirm: () => {
            const name = Swal.getPopup().querySelector("#reference-name").value;
            const url = Swal.getPopup().querySelector("#reference-url").value;
            if (!name || !url) {
                Swal.showValidationMessage("Por favor, completa ambos campos");
                return false;
            }
            return { name, url };
        }
    }).then((result) => {
        if (result.isConfirmed) {
            createReferenceElement(result.value.name, result.value.url);
        }
    });
}

// Función para crear y agregar un nuevo elemento de referencia en el contenedor de referencias
function createReferenceElement(name, url) {
    // Seleccionamos el contenedor principal para las referencias
    const referenceContainer = document.querySelectorAll(".artwork-create-box-multimedia")[2];

    // Crear el contenedor para la referencia
    const referenceElement = document.createElement("div");
    referenceElement.classList.add("reference-element");
    referenceElement.style.display = "flex";
    referenceElement.style.alignItems = "center";
    referenceElement.style.marginBottom = "10px";
    referenceElement.setAttribute("data-index", referenceIndex);

    // Crear el primer input para el nombre de la referencia
    const nameInput = document.createElement("input");
    nameInput.type = "text";
    nameInput.value = name;
    nameInput.style.width = "20%";
    nameInput.style.marginRight = "5px";
    nameInput.readOnly = true;
    nameInput.setAttribute("id", "reference_name_"+referenceIndex);
    nameInput.setAttribute("name", "reference_name_"+referenceIndex);

    // Crear el segundo input para el URL de la referencia
    const urlInput = document.createElement("input");
    urlInput.type = "text";
    urlInput.value = url;
    urlInput.style.width = "70%";
    urlInput.style.marginRight = "5px";
    urlInput.readOnly = true;
    urlInput.setAttribute("id", "reference_url_"+referenceIndex);
    urlInput.setAttribute("name", "reference_url_"+referenceIndex);

    // Crear el botón de eliminación
    const deleteButton = document.createElement("button");
    deleteButton.style.width = "10%";
    deleteButton.innerHTML = '<i class="fa fa-minus"></i>';
    deleteButton.classList.add("delete-button");

    // Agregar el evento de eliminación con SweetAlert
    deleteButton.addEventListener("click", function (event) {
        event.preventDefault();
        Swal.fire({
            title: "¿Estás seguro que deseas eliminar esta referencia?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Si, eliminar",
            cancelButtonText: "Cancelar",
        }).then((result) => {
            if (result.isConfirmed) {
                referenceElement.remove();
            }
        });
    });

    // Añadir los elementos al contenedor de la referencia
    referenceElement.appendChild(nameInput);
    referenceElement.appendChild(urlInput);
    referenceElement.appendChild(deleteButton);

    // Insertar la nueva referencia al inicio del contenedor de referencias
    referenceContainer.insertBefore(referenceElement, referenceContainer.firstChild);

    // Incrementamos el índice para la próxima referencia
    referenceIndex++;
}

// Asignamos el evento al botón de agregar referencia en el contenedor de referencias
document.querySelectorAll(".artwork-create-box-multimedia .multimedia-add-content button")[2]
    .addEventListener("click", addReference);


// Validaciones del formulario
if (document.getElementById('add-artwork-form')) {
    let form = document.getElementById('add-artwork-form');

    form.addEventListener('submit', function (event) {
        let warningsHTML = '<ul style="text-align:left">';
        let countWarnings = 0;
        let errorsHTML = '<ul style="text-align:left">';
        let countErrors = 0;

        event.preventDefault();

        const defaultImage = document.getElementById('defaultimage');

        // Validamos que se haya seleccionado una imagen por defecto
        if (defaultImage.files.length === 0) {
            errorsHTML += '<li>No has especificat cap imatge principal.</li>';
            countErrors++;
        }

        // Validamos que el número de registro sea válido
        const idLetter = document.getElementById('id_letter');
        const idNumber = document.getElementById('id_number');
        const idSubNumber = document.getElementById('id_sub_number');

        const isValidIdentifier = validateIdentifiers(idLetter, idNumber, idSubNumber);

        if (isValidIdentifier === false) {
            errorsHTML += '<li>El número de registre no és vàlid.</li>';
            countErrors++;
        }

        // Validamos que el título de la obra no esté vacío, el nombre del objeto y la descripción
        const objectName = document.getElementById('object_name');
        const artworkTitle = document.getElementById('artwork_title');
        const artworkDescription = document.getElementById('artwork_description');


        if (objectName.value === '') {
            errorsHTML += '<li>No has especificat cap nom d\'objecte.</li>';
            countErrors++;
        }

        if (artworkTitle.value === '') {
            errorsHTML += '<li>No has especificat cap títol.</li>';
            countErrors++;
        }

        if (artworkDescription.value === '') {
            errorsHTML += '<li>No has especificat cap descripció.</li>';
            countErrors++;
        }

        // Validamos los detalles de la obra
        const authorNames = document.getElementById('author_names');
        const datationsList = document.getElementById('datations_list');
        const registerdate = document.getElementById('register_date');
        const createddate = document.getElementById('created_date');
        const artworkbibliography = document.getElementById('artwork_bibliography');

        if (authorNames.value === '') {
            errorsHTML += '<li>No has especificat cap autor.</li>';
            countErrors++;
        }

        if (datationsList.value === '') {
            errorsHTML += '<li>No has especificat cap datació.</li>';
            countErrors++;
        }

        if (registerdate.value === '') {
            errorsHTML += '<li>No has especificat cap data de registre.</li>';
            countErrors++;
        }

        if (createddate.value === '') {
            errorsHTML += '<li>No has especificat cap data de creació.</li>';
            countErrors++;
        }

        if (artworkbibliography.value === '') {
            errorsHTML += '<li>No has especificat cap bibliografia.</li>';
            countErrors++;
        }

        // Validamos las características de la obra
        const artwork_hight = document.getElementById('artwork_height');
        const artwork_width = document.getElementById('artwork_width');
        const artwork_depth = document.getElementById('artwork_depth');

        if ((artwork_hight.value === '' || artwork_width.value === '' || artwork_depth.value === '') || (artwork_hight.value <= '0' || artwork_width.value <= '0' || artwork_depth.value <= '0')) {
            errorsHTML += '<li>No has especificat una mida valida.</li>';
            countErrors++;
        }

        const artwork_price = document.getElementById('artwork_price');
        const artwork_quantity = document.getElementById('artwork_quantity');
        const artwork_material = document.getElementById('materials_list');

        if (artwork_price.value === '' || artwork_price.value <= '0') {
            errorsHTML += '<li>No has especificat un preu valid.</li>';
            countErrors++;
        }

        if (artwork_quantity.value === '' || artwork_quantity.value <= '0') {
            errorsHTML += '<li>No has especificat una quantitat valida.</li>';
            countErrors++;
        }

        if (artwork_material.value === '') {
            errorsHTML += '<li>No has especificat cap material.</li>';
            countErrors++;
        }

        const artwork_classification = document.getElementById('generic_classification');
        const artwork_tecnique = document.getElementById('tecniques_list');
        const artwork_conservation = document.getElementById('conservations_list');

        if (artwork_classification.value === '') {
            errorsHTML += '<li>No has especificat cap classificació.</li>';
            countErrors++;
        }

        if (artwork_tecnique.value === '') {
            errorsHTML += '<li>No has especificat cap tècnica.</li>';
            countErrors++;
        }

        if (artwork_conservation.value === '') {
            errorsHTML += '<li>No has especificat cap estat de conservació.</li>';
            countErrors++;
        }

        const artwork_getty_material_code = document.getElementById('getty_material_codes_list');
        const artwork_getty_material = document.getElementById('getty_material_list');

        if (artwork_getty_material_code.value === '') {
            errorsHTML += '<li>No has especificat cap codi de material Getty.</li>';
            countErrors++;
        }

        if (artwork_getty_material.value === '') {
            errorsHTML += '<li>No has especificat cap material Getty.</li>';
            countErrors++;
        }

        // Validamos la procedencia de la obra
        const origin_museum = document.getElementById('origin_museum');
        const origin_collection = document.getElementById('origin_collection');
        const origin_place = document.getElementById('origin_place');
        const entry_type = document.getElementById('entry_type_list');

        if (origin_museum.value === '') {
            errorsHTML += '<li>No has especificat cap museu d\'origen.</li>';
            countErrors++;
        }

        if (origin_collection.value === '') {
            errorsHTML += '<li>No has especificat cap col·lecció d\'origen.</li>';
            countErrors++;
        }

        if (origin_place.value === '') {
            errorsHTML += '<li>No has especificat cap lloc d\'origen.</li>';
            countErrors++;
        }

        if (entry_type.value === '') {
            errorsHTML += '<li>No has especificat cap tipus d\'entrada.</li>';
            countErrors++;
        }

        // Validamos la ubicación de la obra
        const artwork_location = document.getElementById('locations_list');
        const execution_place = document.getElementById('execution_place');

        if (artwork_location.value === '') {
            errorsHTML += '<li>No has especificat cap ubicació.</li>';
            countErrors++;
        }

        if (execution_place.value === '') {
            errorsHTML += '<li>No has especificat cap lloc d\'execució.</li>';
            countErrors++;
        }

        // Validamos otros datos de la obra
        const tirage = document.getElementById('tirage');
        const artwork_cancel_cause = document.getElementById('cancel_causes_list');

        if (tirage.value === '') {
            errorsHTML += '<li>No has especificat cap tiratge.</li>';
            countErrors++;
        }

        // Validamos la historia de la obra
        const artwork_history = document.getElementById('artwork_history');

        if (artwork_history.value === '') {
            errorsHTML += '<li>No has especificat cap història.</li>';
            countErrors++;
        }

        // Revisamos si se han añadido documentos asociados a la obra, imagenes adicionales y referencias
        const hiddenInputs = document.getElementById('hidden_inputs');

        let documentCount = 0;
        let additionalImageCount = 0;
        // console.log('Inputs ocultos:', hiddenInputs.children.length);

        // hiddenInputs.forEach(input => {
        //     console.log('Input:', input);
        // });

        // Expresiones regulares para los patrones "document_x" y "additional_image_x"
        const documentPattern = /^document_\d+$/;
        const additionalImagePattern = /^additional_image_\d+$/;

        hiddenInputs.querySelectorAll("input").forEach(input => {
            // Comprueba si el id del input coincide con el patrón "document_x"
            if (documentPattern.test(input.id)) {
                documentCount++;
            }
            // Comprueba si el id del input coincide con el patrón "additional_image_x"
            if (additionalImagePattern.test(input.id)) {
                additionalImageCount++;
            }
        });

        if (documentCount === 0) {
            warningsHTML += '<li>No has pujat cap document associat.</li>';
            countWarnings++;
        }

        if (additionalImageCount === 0) {
            warningsHTML += '<li>No has pujat cap imatge addicional.</li>';
            countWarnings++;
        }


        // if (artwork_cancel_cause.value === '') {
        //     waHTML += '<li>No has especificat cap causa de cancel·lació.</li>';
        //     countErrors++;
        // }

        // Cerramos la lista de advertencias
        warningsHTML += '</ul>';

        // Cerramos la lista de errores
        errorsHTML += '</ul>';

        // Mostramos la alerta de advertencias si no hay errores
        if (countErrors === 0 && countWarnings > 0) {
            Swal.fire({
                title: 'Advertències',
                icon: 'warning',
                html: warningsHTML,
                showCancelButton: true,
                confirmButtonText: 'Continuar',
                cancelButtonText: 'Cancel·lar'
            }).then((result) => {
                if (result.isConfirmed) {
                    const idNumber = document.getElementById('id_number');
                    const idSubNumber = document.getElementById('id_sub_number');

                    idNumber.value = Number(idNumber.value);
                    idSubNumber.value = idSubNumber.value ? Number(idSubNumber.value) : '';
                    form.submit();
                }
            });
        } else {
            // Mostramos la alerta de errores si los hay
            if (countErrors > 0) {
                Swal.fire({
                    title: 'Hi han errors al formulari',
                    icon: 'error',
                    html: errorsHTML
                });
            } else {
                const idNumber = document.getElementById('id_number');
                const idSubNumber = document.getElementById('id_sub_number');

                idNumber.value = Number(idNumber.value);
                idSubNumber.value = idSubNumber.value ? Number(idSubNumber.value) : '';
                // Enviamos el formulario si no hay errores
                form.submit();
            }
        }
    });
}
