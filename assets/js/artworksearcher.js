if (document.querySelector("#artworksearch")) {
    const headerCode = `
        <div class="list-header">
            <a href=""><h4>Nom</h4></a>
            <a href=""><h4>Autor</h4></a>
            <a href=""><h4>Ubicació</h4></a>
            <a href=""><h4>Data</h4></a>
            <a href=""><h4>Estat</h4></a>
        </div>
    `;

    let inputSearch = document.querySelector("#artworksearch");

    // Código para cuando se haya cargado la página y no haya nada escrito -> Mostrar todas las obras
    if (inputSearch.value === "") { // Si el input está vacío, mostrar todos los artworks
        setLoadingStatus();
        fetch('http://localhost:8080/projecteDAW/apis/artworksAPI.php?search=')
        .then(response => response.json()) // Convertir la respuesta a JSON
        .then(data => { // Mostrar los datos en la consola
            // console.log(data);
            let HTMLCode = generateHTMLCode(data);
            document.querySelector(".list-container").innerHTML = HTMLCode;
        });
    }

    // Código para cuando se escriba en el input -> Mostrar las obras que coincidan con la búsqueda
    inputSearch.addEventListener("input", (element) => {
        // console.log("Petición de búsqueda: "+element.target.value);
        setLoadingStatus();
        fetch('http://localhost:8080/projecteDAW/apis/artworksAPI.php?search='+element.target.value)
        .then(response => response.json()) // Convertir la respuesta a JSON
        .then(data => { // Mostrar los datos en la consola
            // console.log(data);
            let HTMLCode = generateHTMLCode(data);
            document.querySelector(".list-container").innerHTML = HTMLCode;
        });
    });

    function generateHTMLCode($artworks) {
        
        
        let HTMLCode = headerCode;
        $artworks.forEach(artwork => {
            HTMLCode += '<div class="list-item">';
                HTMLCode += '<img src="' + artwork.URL + '" alt="' + artwork.artwork_name + ' ' + artwork.author_name + '">';
                HTMLCode += '<a href="?page=artwork-administration&artworkID=' + artwork.id + '"><h3>' + artwork.artwork_name + '</h3></a>';
                HTMLCode += '<p><i class="fa-solid fa-user"></i>' + artwork.author_name + '</p>';
                HTMLCode += '<p><i class="fa-solid fa-location-dot"></i>' + artwork.location_name + '</p>';
                HTMLCode += '<p><i class="fa-solid fa-bookmark"></i>' + artwork.creation_date + '</p>';
                HTMLCode += '<p><i class="fa-regular fa-clipboard"></i>' + artwork.text + '</p>';
            HTMLCode += '</div>';
        });

        if ($artworks.length === 0) {
            HTMLCode += '<div><h2>No s\'han trobat resultats</h2><p>Intenti amb un altre filtre de cerca.</p></div>';
        }
        return HTMLCode;
    }

    function setLoadingStatus() {
        let HTMLCode = headerCode;
        HTMLCode += '<div class="loader-container"><div class="loader"></div></div>';
        document.querySelector(".list-container").innerHTML = HTMLCode;
    }
}