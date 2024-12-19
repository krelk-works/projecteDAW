let canceledOnly = false;

if (document.querySelector("#movimentsearcher")) {
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
    // const getMovementsAPI = (value) => fetch("controllers/ArtworkController.php?getArtworksAtLocations", {
    //     method: "POST",
    //     headers: {
    //         "Content-Type": "application/json"
    //     },
    //     body: JSON.stringify({ currentLocation: currentLocation }) // Convertir el array a JSON
    // })
    //     .then(response => response.text())
    //     .catch(error => console.error("Error:", error))}
    
    //     const getMovementsAPI = (value) => {
    //     fetch('apis/movementsAPI.php?search=' + value)
    //     .then(response => { console.log(response.text()) })
    //     .then(response => response.json()) // Convertir la respuesta a JSON
    //     .then(data => { // Mostrar los datos en la consola
    //         console.log('Datos de busqueda de movimientos:', data);
    //         let HTMLCode = generateHTMLCode(data);
    //         document.querySelector(".list-container-moviment").innerHTML = HTMLCode;
    //         isLoading = false;
    //     });
    // }

    const getMovementsAPI = (value) => fetch('apis/movementsAPI.php?search=' + value, {
        method: "GET",
        headers: {
            "Content-Type": "application/json"
        }
    })
    .then(response => response.text()) // Leer la respuesta completa como texto
    .then(response => {
        try {
            console.log(response);
            let data = JSON.parse(response); // Convertir la respuesta a JSON
            let HTMLCode = generateHTMLCode(data);
            document.querySelector(".list-container-moviment").innerHTML = HTMLCode;
            isLoading = false;
        } catch (error) {
            console.error("Error parsing response:", error);
        }
    })
    .catch(error => {
        console.error(error);
    });

    // De-bounce version of the clickHandler Function
    const debouncedgetMovementsAPI = debounce(getMovementsAPI, 500)
    const date = new Date();

    function generateHTMLCode($movements) {
        let HTMLCode = headerCode;
        $movements.forEach(movement => {
            HTMLCode += '<div class="list-item-moviment list-item-moviment-admin">';
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
            document.querySelector(".list-container-moviment").innerHTML = HTMLCode;
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

    let inputSearch = document.querySelector("#movimentsearcher");

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