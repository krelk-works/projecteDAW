let canceledOnly = false;

// Array de filtros avanzados
let advancedFilter = {
    registerNumber: '',
    authors: [],
    tecniques: [],
    materials: [],
    startCDate: '',
    endCDate: '',
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

            if (advancedFilter.startCDate !== '' && advancedFilter.endCDate !== '') {
                const artworkCreationDate = new Date(artwork.creation_date);

                // console.log('Fecha de creación buscada:', advancedFilter.startCDate, advancedFilter.endCDate);
                // console.log('Fecha de creación actual:', artwork.creation_date);
                // console.log(artworkCreationDate <= advancedFilter.startCDate || artworkCreationDate >= advancedFilter.endCDate)

                if (artworkCreationDate <= advancedFilter.startCDate || artworkCreationDate >= advancedFilter.endCDate) {
                    return;
                }
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
        fetch('apis/cancelationsAPI.php?api_key=a0cae8cf-4b15-4887-8b82-1499fd283396&search=' + value)
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
                    HTMLCode += '<p><i class="fa-regular fa-clipboard"></i>' + artwork.text + '</p>';
                    HTMLCode += '</div>';
                    artworksCount++;
                }
            });
        } else {
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
                    HTMLCode += '<a href="#" class="view-artwork" data-worker="' + artwork.authorised_worker + '" data-description="' + artwork.cancel_description + '" data-id="' + artwork.id + '" data-name="' + artwork.artwork_name + '"><h3>' + artwork.artwork_name + '</h3><span class="register_number">' + registerNumber + '</span></a>';
                    HTMLCode += '<p><i class="fa-solid fa-user"></i>' + artwork.author_name + '</p>';
                    HTMLCode += '<p><i class="fa-solid fa-location-dot"></i>' + artwork.location_name + '</p>';
                    HTMLCode += '<p><i class="fa-solid fa-bookmark"></i>' + creationYear + '</p>';
                    HTMLCode += '<p><i class="fa-regular fa-clipboard"></i>' + artwork.text + '</p>';
                    HTMLCode += '</div>';
                    artworksCount++;
                }
            });
            
            // Agregamos el evento a los enlaces después de renderizar el HTML 
            document.addEventListener('click', function (event) {
                if (event.target.closest('.view-artwork')) {
                    event.preventDefault(); // Prevenir la navegación predeterminada del enlace
                    const link = event.target.closest('.view-artwork');
                    const artworkId = link.getAttribute('data-id');
                    const artworkName = link.getAttribute('data-name');
                    const description = link.getAttribute('data-description');
                    const worker = link.getAttribute('data-worker');
            
                    Swal.fire({
                        title: 'Informació sobre la cancel·lació',
                        text: `${worker} diu que: ${description}`,
                        icon: 'info',
                        showCancelButton: true,
                        confirmButtonText: 'Restaurar',
                        cancelButtonText: 'Tornar'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            fetch(`controllers/ArtworkController.php?restoreArtwork=true&id=${artworkId}`, {
                                method: 'GET',
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (data.status === 'success') {
                                    Swal.fire(
                                        'Restaurat!',
                                        data.message,
                                        'success'
                                    ).then(() => {
                                        window.location.href = 'index.php';
                                    });
                                } else {
                                    Swal.fire(
                                        'Error!',
                                        data.message,
                                        'error'
                                    ).then(() => {
                                        window.location.href = 'index.php?page=cancelacions';
                                    });
                                }
                            })
                            .catch(error => {
                                console.error('Error:', error);
                                Swal.fire(
                                    'Error!',
                                    'No s\'ha pogut completar l\'acció',
                                    'error'
                                );
                            });
                        }
                    });
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
            <a href=""><h4>Any</h4></a>
            <a href=""><h4>Estat</h4></a>
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

    createNewArtworkButton.addEventListener("click", () => {
        window.location.href = "?page=artwork-create2";
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
}