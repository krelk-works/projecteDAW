let canceledOnly = false;

if (document.querySelector("#expositionsearch")) {
    let isLoading = false;
    
    if (document.getElementById('searchby')) {
        const onlyCanceledCheckbox = document.getElementById('searchby');
    
        onlyCanceledCheckbox.addEventListener('change', () => {
            if (onlyCanceledCheckbox.checked) {
                canceledOnly = true;
                setLoadingStatus();
                debouncedgetExpositionsAPI(inputSearch.value);
                
            } else {
                canceledOnly = false;
                setLoadingStatus();
                debouncedgetExpositionsAPI(inputSearch.value);
                
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
    const getExpositionsAPI = (value) => {
        fetch('apis/expositionsAPI.php?search=' + value)
        .then(response => response.json()) // Convertir la respuesta a JSON
        .then(data => { // Mostrar los datos en la consola
            let HTMLCode = generateHTMLCode(data);
            document.querySelector(".list-container").innerHTML = HTMLCode;
            isLoading = false;
        });
    }

    // De-bounce version of the clickHandler Function
    const debouncedgetExpositionsAPI = debounce(getExpositionsAPI, 500)
    const date = new Date();

    function generateHTMLCode($expositions) {
        let HTMLCode = headerCode;
        if (canceledOnly) {

        $expositions.forEach(exposition => {

            
            if (new Date(exposition.end_date) <= date) {     
                HTMLCode += '<div class="list-item list-item-expositions">';
                HTMLCode += '<h3>' + exposition.name + '</h3>';
                HTMLCode += '<p>' + exposition.start_date + '</p>';
                HTMLCode += '<p>' + exposition.end_date + '</p>';
                HTMLCode += '<p>' + exposition.expositionlocation + '</p>';
                HTMLCode += '<p>' + exposition.text + '</p>';
                HTMLCode += '<a href="?page=exposition-administration&expoID='  + exposition.id +  '"><button class="action_button expo_button">Gestionar</button></a>';
                HTMLCode += '</div>';
            }
        });
        } else {
            
            $expositions.forEach(exposition => {
                // console.log(new Date(exposition.end_date) <= date);
                // console.log("COMPARE DATE: " ,new Date(exposition.end_date), " Current DATE: " ,date);
                if (new Date(exposition.end_date) > date) {
                    HTMLCode += '<div class="list-item list-item-expositions">';
                    HTMLCode += '<h3>' + exposition.name + '</h3>';
                    HTMLCode += '<p>' + exposition.start_date + '</p>';
                    HTMLCode += '<p>' + exposition.end_date + '</p>';
                    HTMLCode += '<p>' + exposition.expositionlocation + '</p>';
                    HTMLCode += '<p>' + exposition.text + '</p>';
                    HTMLCode += '<a href="?page=exposition-administration&expoID='  + exposition.id +  '"><button class="action_button expo_button">Gestionar</button></a>';
                    HTMLCode += '</div>';
                }
            });
        }
        if ($expositions.length === 0) {
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
        <div class="list-header list-header-expositions">
            <a href="">
                <h4>Nom exposició</h4>
            </a>
            <a href="">
                <h4>Data d'inici</h4>
            </a>
            <a href="">
                <h4>Data de finalització</h4>
            </a>
            <a href="">
                <h4>Lloc exposició</h4>
            </a>
            <a href="">
                <h4>Tipus exposició</h4>
            </a>
            <a href="">
                <h4>Opcions</h4>
            </a>
        </div>
    `;

    let inputSearch = document.querySelector("#expositionsearch");

    // Código para cuando se haya cargado la página y no haya nada escrito -> Mostrar todas las obras
    if (inputSearch.value === "") { // Si el input está vacío, mostrar todos los artworks
        setLoadingStatus();
        debouncedgetExpositionsAPI(inputSearch.value);
    }

    // Código para cuando se escriba en el input -> Mostrar las obras que coincidan con la búsqueda
    inputSearch.addEventListener("input", (element) => {
        setLoadingStatus();
        debouncedgetExpositionsAPI(element.target.value);
    });

    //let createNewExpositionButton = document.querySelector("#new-exposition");

    //createNewArtworkButton.addEventListener("click", () => {
        //window.location.href = "?page=artwork-create";
    //});

}