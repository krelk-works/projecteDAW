let canceledOnly = false;

if (document.querySelector("#movementsearch")) {
    let isLoading = false;

    /* Funciones para el buscador de obras */
    function debounce(fn, delay) {
        let timer = null

        return (...args) => {
            if (timer) clearTimeout(timer)
            timer = setTimeout(() => fn(...args), delay)
        }
    }

    // Función para obtener las obras a través de la API
    const getMovementsAPI = (value) => {
        fetch('apis/movementsAPI.php?search=' + value)
        .then(response => response.json()) // Convertir la respuesta a JSON
        .then(data => { // Mostrar los datos en la consola
            let HTMLCode = generateHTMLCode(data);
            document.querySelector(".list-container").innerHTML = HTMLCode;
            isLoading = false;
        });
    }

    // De-bounce version of the clickHandler Function
    const debouncedgetMovementsAPI = debounce(getMovementsAPI, 500)
    const date = new Date();

    function generateHTMLCode($movements) {
        let HTMLCode = headerCode;
        $movements.forEach(movement => {
            HTMLCode += '<div class="list-item list-item-moviment list-item-moviment-admin">';
            HTMLCode += '<h3>' + movement.title + '</h3>';
            HTMLCode += '<p>' + movement.start_date + '</p>';
            HTMLCode += '<p>' + movement.end_date + '</p>';
            HTMLCode += '<p>' + movement.place + '</p>';
            HTMLCode += '</div>';
        });
        if ($movements.length === 0) {
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
        <div class="list-header list-header-moviment list-header-moviment-admin">
            <a href="">
                <h4>Títol</h4>
            </a>
            <a href="">
                <h4>Data inici</h4>
            </a>
            <a href="">
                <h4>Data finzalitzacio</h4>
            </a>
            <a href="">
                <h4>Destí del moviment</h4>
            </a>
        </div>
    `;

    let inputSearch = document.querySelector("#movementsearch");

    // Código para cuando se haya cargado la página y no haya nada escrito -> Mostrar todas las obras
    if (inputSearch.value === "") { // Si el input está vacío, mostrar todos los artworks
        setLoadingStatus();
        debouncedgetMovementsAPI(inputSearch.value);
    }

    // Código para cuando se escriba en el input -> Mostrar las obras que coincidan con la búsqueda
    inputSearch.addEventListener("input", (element) => {
        setLoadingStatus();
        debouncedgetMovementsAPI(element.target.value);
    });

    //let createNewExpositionButton = document.querySelector("#new-exposition");

    //createNewArtworkButton.addEventListener("click", () => {
        //window.location.href = "?page=artwork-create";
    //});

}