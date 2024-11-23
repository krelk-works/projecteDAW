let canceledOnly = false;

// Array de filtros avanzados
let advancedFilter = {
    registerNumber: '',
    authors: [],
    tecniques: [],
    materials: [],
    startCDate: '',
    endCDate: '',
};
// ------------------------------

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
}

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
    const data = JSON.parse(response);
    console.log('Data:', data);
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
    console.log('Dropdown is trying to showing');
    if (!isPanelOverflowVisible) {
        filtersContainer.style.overflow = 'visible'; // Cambia el overflow a visible
        console.log('Overflow toggled to visible');
        isPanelOverflowVisible = true;
    }
});

$('.chosen-select').on('chosen:hiding_dropdown', function () {
    console.log('Dropdown is trying to hidding');
    setInterval(() => {
        const chosenDrop = document.querySelector('.chosen-container-active');
        if (isPanelOverflowVisible && !chosenDrop) {
            filtersContainer.style.overflow = 'hidden'; // Cambia el overflow a hidden
            isPanelOverflowVisible = false;
            console.log('Overflow toggled to hidden');
            console.log('--------------------------------------------');
        }
    }, 20);

});

duDatepicker('#daterange', {
    format: 'dd/mm/yyyy',
    rangeDelim: ' fins ',
    range: true,
    // Eventos para recuperar las fechas insertadas
    events: {
        dateChanged: function (data) {
            console.log('From: ' + data.dateFrom + '\nTo: ' + data.dateTo)
        },
    }

});



// Event listener for changes on authors filter
$('#authors').on('change', function () {
    const selectedValues = $(this).val(); // Array de valores seleccionados
    console.log('Valores seleccionados:', selectedValues);
});