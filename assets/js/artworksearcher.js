let canceledOnly = false;

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

    // Función para obtener las obras a través de la API
    const getArtworksAPI = (value) => {
        fetch('apis/artworksAPI.php?search=' + value)
        .then(response => response.json()) // Convertir la respuesta a JSON
        .then(data => { // Mostrar los datos en la consola
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
                    HTMLCode += '<div class="list-item">';
                    HTMLCode += '<img src="' + artwork.artwork_image + '" alt="' + artwork.artwork_name + ' ' + artwork.author_name + '">';
                    HTMLCode += '<a href="?page=artwork-view&id=' + artwork.id + '"><h3>' + artwork.artwork_name + '</h3></a>';
                    HTMLCode += '<p><i class="fa-solid fa-user"></i>' + artwork.author_name + '</p>';
                    HTMLCode += '<p><i class="fa-solid fa-location-dot"></i>' + artwork.location_name + '</p>';
                    HTMLCode += '<p><i class="fa-solid fa-bookmark"></i>' + artwork.creation_date + '</p>';
                    HTMLCode += '<p><i class="fa-regular fa-clipboard"></i>' + artwork.text + '</p>';
                    HTMLCode += '</div>';
                    artworksCount++;
                }
            });
        } else {
            $artworks.forEach(artwork => {
                if (!artwork.canceled) {
                    HTMLCode += '<div class="list-item">';
                    HTMLCode += '<img src="' + artwork.artwork_image + '" alt="' + artwork.artwork_name + ' ' + artwork.author_name + '">';
                    HTMLCode += '<a href="?page=artwork-view&id=' + artwork.id + '"><h3>' + artwork.artwork_name + '</h3></a>';
                    HTMLCode += '<p><i class="fa-solid fa-user"></i>' + artwork.author_name + '</p>';
                    HTMLCode += '<p><i class="fa-solid fa-location-dot"></i>' + artwork.location_name + '</p>';
                    HTMLCode += '<p><i class="fa-solid fa-bookmark"></i>' + artwork.creation_date + '</p>';
                    HTMLCode += '<p><i class="fa-regular fa-clipboard"></i>' + artwork.text + '</p>';
                    HTMLCode += '</div>';
                    artworksCount++;
                }
            });
        }
        if (artworksCount === 0) {
            HTMLCode += '<div><h2>No s\'han trobat resultats</h2><p>Intenti amb un altre filtre de cerca.</p></div>';
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
            <a href=""><h4>Datació</h4></a>
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

    /** Añadir filtros adicionales */
    let filters = [];
    const addAdditionalFilters = document.querySelector('#add-additional-filter');
    const resetAdditionalFilters = document.querySelector('#reset-additional-filters');

    removeFilter = (index) => {
        Swal.fire({
            title: 'Estas segur en eliminar aquest filtre?',
            text: 'Filtre a eliminar: ' + filters[index].filterLabel + ' => ' + filters[index].filterValue,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Eliminar',
            cancelButtonText: 'Cancel·lar',
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6'
        }).then((result) => {
            if (result.isConfirmed) {
                filters.splice(index, 1);
                console.log('Filtres:', filters);
                const filterCount = filters.length;
                $('#filter_html_' + index).remove();
                $('#additional-filters-count').text(filterCount);
                addAdditionalFilters.click();
            } else {
                addAdditionalFilters.click();
            }
        });
    };

    getFiltersListHTML = () => {
        if (filters.length === 0) {
            return '<p>No hi ha filtres afegits</p>';
        }
        let HTML = '';
        filters.forEach((filter, index) => {
            HTML += `
                <div style="display: flex; flex-wrap:nowrap; justify-content: space-around; align-items: center; border: 1px solid #464646; border-radius: 5px; padding: 5px; margin-bottom: 5px; transition: background-color .66s" id="filter_html_${index}" class="filter_item">
                    <p style="width: 25%; font-size: 14px;"><strong>${filter.filterLabel}</strong></p>
                    <p style="width: 60%; font-size: 14px;"><strong>Coincidencia</strong>: ${filter.filterValue}</p>
                    <button class="sweelalert_custom" onclick="removeFilter(${index})"><i class="fa-solid fa-trash"></i></button>
                </div>
            `;
        });
        return HTML;
    };

    getHTMLForFilter = (filterType) => {
        let HTML = '';
        switch (filterType) {
            case 'author_filter':
                HTML = `
                    <input id="filterInput" class="swal2-input" placeholder="Escriu el nom de l'autor" required>
                `;
                break;
            case 'artwork_name_filter':
                HTML = `
                    <input id="filterInput" class="swal2-input" placeholder="Escriu el nom de l'obra">
                `;
                break;
            case 'object_name_filter':
                HTML = `
                    <input id="filterInput" class="swal2-input" placeholder="Escriu el nom de l'objecte">
                `;
                break;
            case 'artwork_tecnique_filter':
                HTML = `
                    <input id="filterInput" class="swal2-input" placeholder="Escriu la tecnica de l'obra">
                `;
                break;
            case 'artwork_datation_filter':
                HTML = `
                    <input id="filterInput" type="number" class="swal2-input" placeholder="Escriu inici de la datació">
                    <input id="filterInput2" type="number" class="swal2-input" placeholder="Escriu fi de la datació">
                `;
                break;
            case 'artwork_location_filter':
                HTML = `
                    <input id="filterInput" class="swal2-input" placeholder="Escriu la ubicació de l'obra">
                `;
                break;
            case 'artwork_conservationstatus_filter':
                HTML = `
                    <input id="filterInput" class="swal2-input" placeholder="Escriu l'estat de conservació de l'obra">
                `;
                break;
            case 'artwork_generic_classification_filter':
                HTML = `
                    <input id="filterInput" class="swal2-input" placeholder="Escriu la classificació genèrica de l'obra">
                `;
                break;
            case 'artwork_triage_filter':
                HTML = `
                    <input id="filterInput" class="swal2-input" placeholder="Escriu el tiratge de l'obra">
                `;
                break;
            case 'artwork_register_date_filter':
                HTML = `
                    <input id="filterInput" class="swal2-input" placeholder="Escriu la data de registre de l'obra">
                `;
                break;
            case 'artwork_creation_date_filter':
                HTML = `
                    <input id="filterInput" class="swal2-input" placeholder="Escriu la data de creació de l'obra">
                `;
                break;
            case 'artwork_height_filter':
                HTML = `
                    <input id="filterInput" class="swal2-input" placeholder="Escriu l'altura de l'obra">
                `;
                break;
            case 'artwork_width_filter':
                HTML = `
                    <input id="filterInput" class="swal2-input" placeholder="Escriu l'amplada de l'obra">
                `;
                break;
            case 'artwork_depth_filter':
                HTML = `
                    <input id="filterInput" class="swal2-input" placeholder="Escriu la gruix de l'obra">
                `;
                break;
            case 'artwork_origin_place_filter':
                HTML = `
                    <input id="filterInput" class="swal2-input" placeholder="Escriu el lloc d'origen de l'obra">
                `;
                break;
            case 'artwork_material_filter':
                HTML = `
                    <input id="filterInput" class="swal2-input" placeholder="Escriu el material de l'obra">
                `;
                break;
            case 'artwork_execution_place_filter':
                HTML = `
                    <input id="filterInput" class="swal2-input" placeholder="Escriu el lloc d'execució de l'obra">
                `;
                break;
            default:
                break;
        }
        return HTML;
    };

    isAlreadyAddedThisTypeOfFilter = (filterType) => {
        let isAlreadyAdded = false;
        filters.forEach(filter => {
            if (filter.filterType === filterType) {
                isAlreadyAdded = true;
            }
        });
        return isAlreadyAdded;
    };

    resetAdditionalFilters.addEventListener('click', function (event) {
        event.preventDefault();
        let messageToShow = filters.length > 0 ? 'Tots els filtres han estat eliminats' : 'No hi ha filtres afegits';
        filters = [];
        $('#additional-filters-count').text('0');
        Swal.fire({
            title: 'Filtres',
            text: messageToShow,
            width: '25%',
            icon: 'info',
            timer: 2000
        });
            
    });

    addAdditionalFilters.addEventListener('click', function (event) {
        event.preventDefault();

        const filtersListHTML = getFiltersListHTML();
        
        let currentFilterType = undefined;
        let labelFilter = undefined;

        const principalSwalWidth = filters.length > 0 ? '70%' : false;

        Swal.fire({
            title: 'Gestió de Filtres',
            html: filtersListHTML,
            showCancelButton: true,
            width: principalSwalWidth, // Especifica el ancho como un porcentaje
            confirmButtonText: 'Afegir més',
            cancelButtonText: 'Tornar',
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    title: 'Gestió de Filtres',
                    html: `
                        <select id="filterSelect" class="swal2-select" style="box-sizing: border-box; width:50%;padding:8px;">
                            <option value="author_filter">Autor</option>
                            <option value="artwork_name_filter">Nom d'obra</option>
                            <option value="object_name_filter">Nom del objecte</option>
                            <option value="artwork_tecnique_filter">Tecnica</option>
                            <option value="artwork_datation_filter">Datació</option>
                            <option value="artwork_location_filter">Ubicació</option>
                            <option value="artwork_conservationstatus_filter">Estat</option>
                            <option value="artwork_generic_classification_filter">Classificació generica</option>
                            <option value="artwork_triage_filter">Tiratge</option>
                            <option value="artwork_register_date_filter">Data de registre</option>
                            <option value="artwork_creation_date_filter">Data de creació</option>
                            <option value="artwork_height_filter">Altura</option>
                            <option value="artwork_width_filter">Amplada</option>
                            <option value="artwork_depth_filter">Gruesa</option>
                            <option value="artwork_origin_place_filter">Lloc d'origen</option>
                            <option value="artwork_material_filter">Material</option>
                            <option value="artwork_execution_place_filter">Lloc d'execució</option>
                        </select>
                    `,
                    showCancelButton: true,
                    confirmButtonText: 'Siguiente',
                    cancelButtonText: 'Cancelar',
                    preConfirm: () => {
                        currentFilterType = document.getElementById('filterSelect').value;
                        labelFilter = document.querySelector(`option[value="${currentFilterType}"]`).innerHTML;
                        
                        // return true; // Retorna el valor seleccionado
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        const HTML = getHTMLForFilter(currentFilterType);
                        Swal.fire({
                            title: 'Afegir un nou filtre',
                            html: HTML,
                            showCancelButton: true,
                            confirmButtonText: 'Afegir',
                            cancelButtonText: 'Cancel·lar',
                            preConfirm: () => {
                                const selectedFilter = document.getElementById('filterInput').value;
                                return selectedFilter; // Retorna el valor seleccionado
                            }
                        }).then((result) => {
                            if (result.isConfirmed) {
                                const inputValue = result.value;

                                if (inputValue === '') {
                                    Swal.fire({
                                        title: 'Error',
                                        text: 'El camp no pot estar buit',
                                        icon: 'error',
                                        timer: 2000
                                    }).then(() => {
                                        addAdditionalFilters.click();
                                    });
                                    return; 
                                }

                                let availableOptions = '';

                                if (isAlreadyAddedThisTypeOfFilter(currentFilterType)) {
                                    availableOptions = `
                                        <option value="or">OR</option>
                                    `;
                                } else {
                                    availableOptions = `
                                        <option value="and">AND</option>
                                    `;
                                }
                                
                                Swal.fire({
                                    title: 'Tipus de filtre',
                                    html: `
                                        <p><strong>Filtre</strong>: ${labelFilter}</p>
                                        <p><strong>Valor</strong>: ${inputValue}</p>
                                        <hr style="margin-top: 10px; margin-bottom: 10px;">
                                        <div style="display: flex; flex-wrap:nowrap; justify-content: space-around; align-items: center;">
        
                                            <p stle="width: 30%"><strong>Operador lògic</strong></p>
                                            <select style="width: 50%">
                                                ${availableOptions}
                                            </select>
                                        
                                        </div>
                                    `,
                                    showCancelButton: true,
                                    confirmButtonText: 'Afegir',
                                    cancelButtonText: 'Cancel·lar',
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        const logicalOperator = document.querySelector('select').value;
                                        filters.push({
                                            filterType: currentFilterType,
                                            filterLabel: labelFilter,
                                            filterValue: inputValue,
                                            logicalOperator: logicalOperator
                                        });
                                        // console.log('Filtres:', filters);
        
                                        const filterCount = filters.length;
                                        $('#additional-filters-count').text(filterCount);

                                        addAdditionalFilters.click();
                                    }
                                });
        
                            }
                        });
                    }
                });
            }
        });
    });

}