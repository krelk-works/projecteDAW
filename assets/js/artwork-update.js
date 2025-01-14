

$(document).ready(async function() {
    // Obtener la URL actual
    const urlParams = new URLSearchParams(window.location.search);

    if (urlParams.has('id') && urlParams.get('id') && !isNaN(urlParams.get('id'))) {
        // Cargamos las opciones de los campos select del formulario
        await loadSelectFieldsData();

        loadEventHandlers();

        const artworkData = await getArtwork(urlParams.get('id'));

        setFieldsData(artworkData);

        // loadArtworkImageFunctions();
    }
});

// Construir la estructura jerárquica de ubicaciones
function buildLocationTree(data, parentId = null, depth = 0) {
    let result = [];
    data.filter(location => location.parent === parentId).forEach(location => {
        result.push({ ...location, depth });
        result = result.concat(buildLocationTree(data, location.id, depth + 1));
    });
    return result;
}

async function getArtwork(id) {
    // Obtenemos los datos de la obra de arte
    try {
        const artworkData = await fetch('controllers/ArtworkController.php?getArtworkById&id='+id, {
            method: "GET",
            headers: {
                "Content-Type": "application/json"
            },
        }).then(response => response.json()).then(data => {return data.message;});
        return artworkData;
    } catch (error) {
        console.error(error);
        return null;
    }
}

async function loadSelectFieldsData() {
    // Definimos los campos del formulario con sus respectivos identificadores y los identificadores de la base de datos
    const fieldsIdentifiers = [
        { formId: 'author_names', dbId: 'authors' },
        { formId: 'object_names', dbId: 'objects' },
        { formId: 'materials_list', dbId: 'materials' },
        { formId: 'tecniques_list', dbId: 'tecniques' },
        { formId: 'datations_list', dbId: 'datations' },
        { formId: 'generic_classification', dbId: 'classifications' },
        { formId: 'conservations_list', dbId: 'conservationstatus' },
        { formId: 'entry_type_list', dbId: 'entry' },
    ]; 

    // Obtenemos los datos de los campos del formulario
    const fieldsData = await fetch('controllers/ArtworkController.php?getFormData', {
        method: "POST",
        headers: {
            "Content-Type": "application/json"
        },
        body: JSON.stringify({})
    }).then(response => response.json()).then(data => {return data;});

    // Recorremos los campos del formulario y rellenamos las opciones de los campos select
    fieldsIdentifiers.forEach(field => {
        // Obtenemos el campo del formulario
        const formField = document.getElementById(field.formId);

        // Comprobamos si el campo existe
        if (formField) {
            // Obtenemos los datos del campo
            const fieldData = fieldsData.message[field.dbId];

            // Comprobamos si existen datos
            if (fieldData) {
                // Borramos las opciones del campo
                formField.innerHTML = '';
                // Recorremos los datos del campo
                fieldData.forEach(data => {
                    // Creamos un elemento option
                    const option = document.createElement('option');
                    option.value = data.id;
                    option.text = data.name || data.text;

                    // Añadimos el elemento option al campo del formulario
                    formField.appendChild(option);
                });
            }
        }
    });

    // Preparando los datos de las localizaciones
    const locations = [];
    buildLocationTree(fieldsData.message.locations).forEach(location => {
        const locationData = {
            id: location.id,
            name: location.name,
            depth: location.depth
        };
        if (location.children) {
            locationData.children = buildLocationTree(location.children);
        }
        locations.push(locationData);
    });

    // Objeto DOM de las localizaciones
    const locationField = document.getElementById('locations_list');

    // Eliminando las opciones actuales
    locationField.innerHTML = '';

    // Generando las opciones de las localizaciones
    locations.forEach(location => {
        const option = document.createElement('option');
        option.value = location.id;
        option.textContent = `${'\u00A0\u00A0\u00A0'.repeat(location.depth) + '► '} ${location.name}`;
        locationField.appendChild(option);
    });
}

function setFieldsData(artwork) {
    const fieldsIdentifiers = [
        { formId: 'author_names', dbId: 'author' },
        { formId: 'object_names', dbId: 'object' },
        { formId: 'materials_list', dbId: 'material' },
        { formId: 'tecniques_list', dbId: 'tecnique' },
        { formId: 'datations_list', dbId: 'datation' },
        { formId: 'generic_classification', dbId: 'genericclassification' },
        { formId: 'conservations_list', dbId: 'conservationstatus' },
        { formId: 'entry_type_list', dbId: 'entry' },
        { formId: 'locations_list', dbId: 'location' },
        { formId: 'id_letter', dbId: 'id_letter' },
        { formId: 'id_number', dbId: 'id_num1' },
        { formId: 'id_sub_number', dbId: 'id_num2' },
        { formId: 'id_other', dbId: 'otheridnumbers' },
        { formId: 'artwork_title', dbId: 'title' },
        { formId: 'artwork_description', dbId: 'description' },
        { formId: 'created_date', dbId: 'creation_date' },
        { formId: 'artwork_bibliography', dbId: 'bibliography' },
        { formId: 'artwork_height', dbId: 'height' },
        { formId: 'artwork_width', dbId: 'width' },
        { formId: 'artwork_depth', dbId: 'depth' },
        { formId: 'artwork_price', dbId: 'cost' },
        { formId: 'artwork_quantity', dbId: 'amount' },
        { formId: 'origin_museum', dbId: 'museumname' },
        { formId: 'origin_collection', dbId: 'provenancecollection' },
        { formId: 'origin_place', dbId: 'originplace' },
        { formId: 'execution_place', dbId: 'executionplace' },
        { formId: 'tirage', dbId: 'triage' },
        { formId: 'artwork_history', dbId: 'history' },
    ];

    fieldsIdentifiers.forEach(field => {
        const formField = document.getElementById(field.formId);
        if (formField) {
            if (field.dbId === 'id_num1') {
                formField.value = padIdentifierWithZeros(artwork[field.dbId]);
            } else if (field.dbId === 'id_num2') {
                if (artwork[field.dbId] === '' || artwork[field.dbId] === 0 || artwork[field.dbId] === '0' || artwork[field.dbId] === null || artwork[field.dbId] === undefined) {
                    formField.value = '';
                } else {
                    formField.value = padSubWithZeros(artwork[field.dbId]);
                }
            } else if (field.dbId === 'id_letter') {
                if (artwork[field.dbId] === '') {
                    formField.value = '-';
                }
            } else if (field.dbId === 'title') {
                // Setting the title of the page
                formField.value = artwork[field.dbId];
                $("#artwork-page-title").text(artwork[field.dbId]);
            } else {
                formField.value = artwork[field.dbId];
            }
        }
    });

    // Cargamos la imagen principal de la obra de arte si existe
    if (artwork.image && artwork.image !== 'assets/img/noimage.png') {
        // Mostramos la imagen
        const image = $("#defaultimagepreview");
        image.attr("src", artwork.image);
        image.show(600);

        // Ocultamos el mensaje de "agregar imagen"
        const button = $("#add-default-image");
        button.hide();
    }
}

function loadEventHandlers() {
    // Sync title input with title page
    const titlePage = $("#artwork-page-title");
    const titleForm = $("#artwork_title");

    titleForm.on('input', function() {
        titlePage.text(titleForm.val());
    });
    // ------------------------------

    // Prevent form submission
    const form = $("#add-artwork-form");
    form.on('submit', function(event) {
        event.preventDefault();

        const urlParams = new URLSearchParams(window.location.search);
        // alert('Actualización de obra de arte en construcción...');

        // Recogemos los datos necesarios del formulario

        const fieldsIdentifiers = [
            { formId: 'author_names', dbId: 'author' },
            { formId: 'object_names', dbId: 'object' },
            { formId: 'materials_list', dbId: 'material' },
            { formId: 'tecniques_list', dbId: 'tecnique' },
            { formId: 'datations_list', dbId: 'datation' },
            { formId: 'generic_classification', dbId: 'genericclassification' },
            { formId: 'conservations_list', dbId: 'conservationstatus' },
            { formId: 'entry_type_list', dbId: 'entry' },
            { formId: 'locations_list', dbId: 'location' },
            { formId: 'artwork_title', dbId: 'title' },
            { formId: 'artwork_description', dbId: 'description' },
            { formId: 'created_date', dbId: 'creation_date' },
            { formId: 'artwork_bibliography', dbId: 'bibliography' },
            { formId: 'artwork_height', dbId: 'height' },
            { formId: 'artwork_width', dbId: 'width' },
            { formId: 'artwork_depth', dbId: 'depth' },
            { formId: 'artwork_price', dbId: 'cost' },
            { formId: 'artwork_quantity', dbId: 'amount' },
            { formId: 'origin_museum', dbId: 'museumname' },
            { formId: 'origin_collection', dbId: 'provenancecollection' },
            { formId: 'origin_place', dbId: 'originplace' },
            { formId: 'execution_place', dbId: 'executionplace' },
            { formId: 'tirage', dbId: 'triage' },
            { formId: 'artwork_history', dbId: 'history' },
        ];
        
        const artworkData = {}; // Inicializa la variable antes de usarla
        
        for (const field of fieldsIdentifiers) {
            const formField = document.getElementById(field.formId);
            if (formField) {
                artworkData[field.dbId] = formField.value;
                console.log(artworkData[field.dbId], formField.value);
            }
        }
        
        
        // Obtenemos los datos de los campos del formulario
        fetch('/apis/artworksAPI.php?updateArtwork', {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify({ artwork: artworkData, id: urlParams.get('id') })
        }).then(response => response.json()).then(data => {
            if (data.status === 'success') {
                Swal.fire({
                    title: "Registre actualitzat correctament",
                    text: "L'obra d'art s'ha actualitzat correctament.",
                    icon: "success",
                    confirmButtonText: "D'acord",
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = "index.php";
                    }
                });
            } else {
                Swal.fire({
                    title: "Hi ha hagut un error",
                    text: "Hi ha hagut un error en l'actualització de l'obra d'art. Si us plau, torna-ho a intentar.",
                    icon: "error",
                    confirmButtonText: "D'acord",
                });
            }
        });

    });
}

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

    // Si las comprobaciones son correctas, agrega ceros a la izquierda hasta 5 dígitos
    return number.toString().padStart(2, '0');
}

// function loadArtworkImageFunctions() {
//     // Funcionalidad para cargar la imagen principal de la obra de arte
//     const defaultImagePreview = $("#defaultimagepreview");

//     defaultImagePreview.on('click', function() {

//         // alert('Funcionalidad en construcción...');

//         Swal.fire({
//             title: "Estas segur que vols eliminar la imatge principal?",
//             icon: "warning",
//             showCancelButton: true,
//             confirmButtonText: "Si, eliminar",
//             cancelButtonText: "Cancel·lar",
//         }).then((result) => {
//             /* Read more about isConfirmed, isDenied below */
//             if (result.isConfirmed) {
//                 // Eliminamos el input y el contenedor de vista previa asociados
                
//                 fetch('controllers/ArtworkController.php?remfile', {
//                     method: "POST",
//                     headers: {
//                         "Content-Type": "application/json"
//                     },
//                     body: JSON.stringify({
//                         image: defaultImagePreview.attr('src')
//                     })
//                 }).then(response => response.json()).then(data => {return data;});

//             }
//         });  
//     });
    
// }