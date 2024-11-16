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
                    HTMLCode += '<a href="?page=artwork-administration&artworkID=' + artwork.id + '"><h3>' + artwork.artwork_name + '</h3></a>';
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
                    HTMLCode += '<a href="?page=artwork-administration&artworkID=' + artwork.id + '"><h3>' + artwork.artwork_name + '</h3></a>';
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

}