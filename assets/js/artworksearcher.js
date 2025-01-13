let canceledOnly = false;

// Array de filtros avanzados
let advancedFilter = {
    registerNumber: '',
    authors: [],
    tecniques: [],
    materials: [],
    startYear: 1900,
    endYear: new Date().getFullYear(),
    conservationStatus: []
};
// ------------------------------

/** Funcionalidad para rellenar el numero de identificador (registro) con ceros */
function padIdentifierWithZeros(number) {
    // Comprobar si el valor es un número
    if (isNaN(number)) {
        // console.error("Error: El valor no es un número.");
        return null; // Devuelve null en caso de error
    }

    // Comprobar si el número está dentro del rango permitido
    if (number < 1 || number > 99999) {
        // console.error("Error: El número está fuera del rango permitido (1 - 99999).");
        return null; // Devuelve null en caso de error
    }

    if (number.toString().length > 5) {
        // console.log('Número mayor a 5 dígitos:', number);
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
        // console.error("Error: El valor no es un número.");
        return null; // Devuelve null en caso de error
    }

    // Comprobar si el número está dentro del rango permitido
    if ((number < 1 || number > 99) && number != '' && number != 0) {
        // console.error("Error: El número está fuera del rango permitido (1 - 99).");
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

if (document.querySelector("#artworksearch")) {
    let isLoading = false;

    if (document.getElementById('searchby')) {
        const onlyCanceledCheckbox = document.getElementById('searchby');

        onlyCanceledCheckbox.addEventListener('change', () => {
            if (onlyCanceledCheckbox.checked) {
                canceledOnly = true;
                setLoadingStatus();
                debouncedgetArtworksAPI(inputSearch.value);

            } else {
                canceledOnly = false;
                setLoadingStatus();
                debouncedgetArtworksAPI(inputSearch.value);

            }
        });
    }

    /* Funciones para el buscador de obras */
    function debounce(fn, delay) {
        let timer = null

        return (...args) => {
            if (timer) clearTimeout(timer)
            timer = setTimeout(() => fn(...args), delay)
        }
    }

    function filterArtworks(artworks) {
        let filteredArtworks = [];

        // console.log('Datos de obras => ', artworks);

        artworks.forEach(artwork => {

            // Si cumple con los filtros avanzados agregamos la obra al array de obras filtradas

            if (advancedFilter.authors.length > 0) {
                if (!advancedFilter.authors.includes(artwork.author_id)) {
                    return;
                }
            }

            if (advancedFilter.tecniques.length > 0) {
                if (!advancedFilter.tecniques.includes(artwork.tecnique_id)) {
                    return;
                }
            }

            if (advancedFilter.materials.length > 0) {
                if (!advancedFilter.materials.includes(artwork.material_id)) {
                    return;
                }
            }

            // if (advancedFilter.startCDate !== '' && advancedFilter.endCDate !== '') {
            //     const artworkCreationDate = new Date(artwork.creation_date);

            //     // console.log('Fecha de creación buscada:', advancedFilter.startCDate, advancedFilter.endCDate);
            //     // console.log('Fecha de creación actual:', artwork.creation_date);
            //     // console.log(artworkCreationDate <= advancedFilter.startCDate || artworkCreationDate >= advancedFilter.endCDate)

            //     if (artworkCreationDate <= advancedFilter.startCDate || artworkCreationDate >= advancedFilter.endCDate) {
            //         return;
            //     }
            // }

            // Check if the artwork was created between the selected years

            const artworkCreationYear = new Date(artwork.creation_date).getFullYear();

            if (artworkCreationYear < advancedFilter.startYear || artworkCreationYear > advancedFilter.endYear) {
                return;
            }

            // Transformamos el número de registro a string y le añadimos los ceros necesarios

            let registerNumber = '';

            registerNumber += artwork.id_letter === null ? '' : artwork.id_letter;
            registerNumber += artwork.id_num1 === null ? '' : padIdentifierWithZeros(Number(artwork.id_num1));
            registerNumber += artwork.id_num2 === null ? '' : '.' + padSubWithZeros(Number(artwork.id_num2));

            if (advancedFilter.registerNumber !== '') {
                // console.log('Número de registro buscado:', advancedFilter.registerNumber);
                // console.log('Número de registro actual:', registerNumber);
                if (registerNumber !== advancedFilter.registerNumber) {
                    return;
                }
            }

            if (advancedFilter.conservationStatus.length > 0) {
                if (!advancedFilter.conservationStatus.includes(artwork.conservationstatus_id)) {
                    return;
                }
            }

            filteredArtworks.push(artwork);

        });

        return filteredArtworks;
    };

    // Función para obtener las obras a través de la API
    const getArtworksAPI = (value) => {
        fetch('apis/artworksAPI.php?api_key=a0cae8cf-4b15-4887-8b82-1499fd283396&search=' + value)
            .then(response => response.json()) // Convertir la respuesta a JSON
            .then(data => { // Mostrar los datos en la consola
                data = filterArtworks(data);
                let HTMLCode = generateHTMLCode(data);
                document.querySelector(".list-container").innerHTML = HTMLCode;
                isLoading = false;
            });
    }

    // De-bounce version of the clickHandler Function
    const debouncedgetArtworksAPI = debounce(getArtworksAPI, 500)

    function generateHTMLCode($artworks) {
        let HTMLCode = headerCode;
        let artworksCount = 0;
        if (canceledOnly) {
            $artworks.forEach(artwork => {

                if (artwork.canceled) {
                    let registerNumber = '';

                    registerNumber += artwork.id_letter === null ? '' : artwork.id_letter;
                    registerNumber += artwork.id_num1 === null ? '' : padIdentifierWithZeros(Number(artwork.id_num1));
                    registerNumber += artwork.id_num2 === null ? '' : '.' + padSubWithZeros(Number(artwork.id_num2));

                    // Transformamos la fecha de artwork.creation_date a un objeto Date y luego solo recogemos el año
                    let creationYear = new Date(artwork.creation_date).getFullYear();

                    HTMLCode += '<div class="list-item" key="' + artwork.id + '">';
                    HTMLCode += '<img src="' + artwork.artwork_image + '" alt="' + artwork.artwork_name + ' ' + artwork.author_name + '">';
                    HTMLCode += '<a href="?page=artwork-view&id=' + artwork.id + '"><h3>' + artwork.artwork_name + '</h3><span class="register_number">' + registerNumber + '</span></a>';
                    HTMLCode += '<p><i class="fa-solid fa-user"></i>' + artwork.author_name + '</p>';
                    HTMLCode += '<p><i class="fa-solid fa-location-dot"></i>' + artwork.location_name + '</p>';
                    HTMLCode += '<p><i class="fa-solid fa-bookmark"></i>' + creationYear + '</p>';
                    HTMLCode += '<p><i class="fa-regular fa-clipboard"></i>' + artwork.tecnique_name + '</p>';
                    HTMLCode += '</div>';
                    artworksCount++;
                }
            });
        } else {
            $artworks.forEach(artwork => {
                if (!artwork.canceled) {

                    let registerNumber = '';

                    registerNumber += artwork.id_letter === null ? '' : artwork.id_letter;
                    registerNumber += artwork.id_num1 === null ? '' : padIdentifierWithZeros(Number(artwork.id_num1));
                    registerNumber += artwork.id_num2 === null ? '' : '.' + padSubWithZeros(Number(artwork.id_num2));

                    // Transformamos la fecha de artwork.creation_date a un objeto Date y luego solo recogemos el año
                    let creationYear = new Date(artwork.creation_date).getFullYear();

                    HTMLCode += '<div class="list-item" key="' + artwork.id + '">';
                    HTMLCode += '<img src="' + artwork.artwork_image + '" alt="' + artwork.artwork_name + ' ' + artwork.author_name + '">';
                    HTMLCode += '<a href="?page=artwork-view&id=' + artwork.id + '"><h3>' + artwork.artwork_name + '</h3><span class="register_number">' + registerNumber + '</span></a>';
                    HTMLCode += '<p><i class="fa-solid fa-user"></i>' + artwork.author_name + '</p>';
                    HTMLCode += '<p><i class="fa-solid fa-location-dot"></i>' + artwork.location_name + '</p>';
                    HTMLCode += '<p><i class="fa-solid fa-bookmark"></i>' + creationYear + '</p>';
                    HTMLCode += '<p><i class="fa-regular fa-clipboard"></i>' + artwork.tecnique_name + '</p>';
                    HTMLCode += '</div>';
                    artworksCount++;
                }
            });
        }
        if (artworksCount === 0) {
            HTMLCode += '<div><h2>No s\'han trobat resultats</h2></div>';
        }
        return HTMLCode;
    }

    function setLoadingStatus() {
        if (!isLoading) {
            isLoading = !isLoading;
            let HTMLCode = headerCode;
            HTMLCode += '<div class="loader-container"><div class="loader"></div></div>';
            document.querySelector(".list-container").innerHTML = HTMLCode;
        }
    }
    /* ----------------------------------- */

    const headerCode = `
        <div class="list-header">
            <a href=""><h4>Nom</h4></a>
            <a href=""><h4>Autor</h4></a>
            <a href=""><h4>Ubicació</h4></a>
            <a href=""><h4>Creació</h4></a>
            <a href=""><h4>Tècnica</h4></a>
        </div>
    `;

    let inputSearch = document.querySelector("#artworksearch");

    // Código para cuando se haya cargado la página y no haya nada escrito -> Mostrar todas las obras
    if (inputSearch.value === "") { // Si el input está vacío, mostrar todos los artworks
        setLoadingStatus();
        debouncedgetArtworksAPI(inputSearch.value);
    }

    // Código para cuando se escriba en el input -> Mostrar las obras que coincidan con la búsqueda
    inputSearch.addEventListener("input", (element) => {
        setLoadingStatus();
        debouncedgetArtworksAPI(element.target.value);
    });

    let createNewArtworkButton = document.querySelector("#new-artwork");

    if (createNewArtworkButton) {
        createNewArtworkButton.addEventListener("click", () => {
            window.location.href = "?page=artwork-create2";
        });
    }

    /** Deshabilitamos que al hacer ENTER en cualquier INPUT se envie formulario */
    document.querySelectorAll('input').forEach(input => {
        // console.log('Input encontrado:', input);
        input.addEventListener('keydown', function (event) {
            if (event.key === 'Enter') {
                event.preventDefault();
            }
        });
    });


    // Parte de la búsqueda avanzada
    // -------------------------------------------------------------------------------------------------------------------------------

    let isPanelOverflowVisible = false;

    // Get form data from database
    fetch("controllers/ArtworkController.php?getFormData", {
        method: "POST",
        headers: {
            "Content-Type": "application/json"
        },
    })
        .then(response => response.text()) // Leer la respuesta completa como texto
        .then(response => {
            // console.log(response);
            const data = JSON.parse(response);
            // Rellenar los campos de los filtros avanzados
            const authors = data.message.authors;
            const tecniques = data.message.tecniques;
            const materials = data.message.materials;
            const conservationstatus = data.message.conservationstatus;
            authors.forEach(author => {
                $('#authors').append('<option value="' + author.id + '">' + author.name + '</option>');
            });
            $('#authors').trigger('chosen:updated');
            tecniques.forEach(tecnique => {
                $('#tecniques').append('<option value="' + tecnique.id + '">' + tecnique.text + '</option>');
            });
            $('#tecniques').trigger('chosen:updated');
            materials.forEach(material => {
                $('#materials').append('<option value="' + material.id + '">' + material.text + '</option>');
            });
            $('#materials').trigger('chosen:updated');
            conservationstatus.forEach(status => {
                $('#conservationstatus').append('<option value="' + status.id + '">' + status.text + '</option>');
            });
            $('#conservationstatus').trigger('chosen:updated');
        }).catch(error => console.error('Error:', error));

    $('.chosen-select').chosen({
        no_results_text: "No s'han trobat coincidències",
        width: "100%",
        inherit_select_classes: true,
        clearBtn: true,
        cancelBtn: true,

    });

    const filtersContainer = document.getElementById('filters');

    $('.chosen-select').on('chosen:showing_dropdown', function () {
        // console.log('Dropdown is trying to showing');
        if (!isPanelOverflowVisible) {
            filtersContainer.style.overflow = 'visible'; // Cambia el overflow a visible
            // console.log('Overflow toggled to visible');
            isPanelOverflowVisible = true;
        }
    });

    $('.chosen-select').on('chosen:hiding_dropdown', function () {
        // console.log('Dropdown is trying to hidding');
        setInterval(() => {
            const chosenDrop = document.querySelector('.chosen-container-active');
            if (isPanelOverflowVisible && !chosenDrop) {
                filtersContainer.style.overflow = 'hidden'; // Cambia el overflow a hidden
                isPanelOverflowVisible = false;
                // console.log('Overflow toggled to hidden');
                // console.log('--------------------------------------------');
            }
        }, 20);

    });

    // Event listener for changes on register number filter
    $('#register_identifier').on('input', function () {
        const value = $(this).val();
        // console.log('Número de registro buscado:', value);
        advancedFilter.registerNumber = value;
        setLoadingStatus();
        debouncedgetArtworksAPI(inputSearch.value);
    });

    // Event listener for changes on authors filter
    $('#authors').on('change', function () {
        const selectedValues = $(this).val(); // Array de valores seleccionados
        // console.log('Autores seleccionados:', selectedValues);
        advancedFilter.authors = selectedValues;
        setLoadingStatus();
        getArtworksAPI(inputSearch.value);
    });

    $('#tecniques').on('change', function () {
        const selectedValues = $(this).val(); // Array de valores seleccionados
        // console.log('Técnicas seleccionadas:', selectedValues);
        advancedFilter.tecniques = selectedValues;
        setLoadingStatus();
        getArtworksAPI(inputSearch.value);
    });

    $('#materials').on('change', function () {
        const selectedValues = $(this).val(); // Array de valores seleccionados
        // console.log('Materiales seleccionados:', selectedValues);
        advancedFilter.materials = selectedValues;
        setLoadingStatus();
        getArtworksAPI(inputSearch.value);
    });

    $('#conservationstatus').on('change', function () {
        const selectedValues = $(this).val(); // Array de valores seleccionados
        // console.log('Estados de conservación seleccionados:', selectedValues);
        advancedFilter.conservationStatus = selectedValues;
        setLoadingStatus();
        getArtworksAPI(inputSearch.value);
    });

    $('.delete_filters').on('click', function (event) {
        event.preventDefault();
        // console.log('Borrando filtros...');
        advancedFilter = {
            registerNumber: '',
            authors: [],
            tecniques: [],
            materials: [],
            startYear: 1900,
            endYear: new Date().getFullYear(),
            conservationStatus: []
        };
        $('#register_identifier').val('');
        $('#authors').val('').trigger('chosen:updated');
        $('#tecniques').val('').trigger('chosen:updated');
        $('#materials').val('').trigger('chosen:updated');
        $('#conservationstatus').val('').trigger('chosen:updated');
        $('#start_date').val(advancedFilter.startYear);
        $('#end_date').val(advancedFilter.endYear);
        setLoadingStatus();
        getArtworksAPI(inputSearch.value);
    });

    // Code for date range filter

    const minYear = 1900;
    const maxYear = new Date().getFullYear();

    // Initialize date range filters

    $('#start_date').val(minYear);
    $('#end_date').val(maxYear);

    // Set max year for start date filter and end date filter
    $('#start_date').attr('max', maxYear);
    $('#end_date').attr('max', maxYear);

    // Set min year for start date filter and end date filter
    $('#start_date').attr('min', minYear);
    $('#end_date').attr('min', minYear);


    // Changes on start year
    $('#start_date').on('input', function () {
        const value = $(this).val();

        if (value > minYear && value <= maxYear) {
            // Change the min attribute of the end date filter
            $('#end_date').attr('min', value);
            advancedFilter.startYear = value;
            setLoadingStatus();
            getArtworksAPI(inputSearch.value);
        }
    });

    // Changes on end year
    $('#end_date').on('input', function () {
        const value = $(this).val();

        if (value > minYear && value <= maxYear) {
            // Change the max attribute of the start date filter
            $('#start_date').attr('max', value);
            advancedFilter.endYear = value;
            setLoadingStatus();
            getArtworksAPI(inputSearch.value);
        }
    });
}