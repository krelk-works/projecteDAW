if(document.querySelector('#search')){
    let isLoading = false

    /*Funcion para el buscador do obras*/
    function debounce(fn,  delay){
        let timer = null

        return(...args)=>{
            if (timer) clearTimeout(timer)
            timer = setTimeout(() => fn(...args), delay)
        }
    }
    
    //Funcion para obtener los usuarios a través de la API
    const getUsersAPI= (value)=>{
        fetch('apis/usersAPI.php?search='+value)
        .then(response=>response.json())//Pasa la respuesta a formato JSON
        .then(data=>{
            let HTMLCode=generateHTMLCode(data)
            document.querySelector(".list-container").innerHTML=HTMLCode
            isLoading = false
        })
    }

    const debouncedgetUsersAPI=debounce(getUsersAPI,500)

    function generateHTMLCode(data){

        const users = data;
        let HTMLCode = headerCode
        users.forEach(user=>{
            HTMLCode += '<div class="list-item">';
            HTMLCode += '<img src="'+ user.profile_img +'" alt="' + user.username + '"class="rounded-profile-images">'
            HTMLCode += '<h3>' + user.username +  '</h3>'
            HTMLCode += '<p> <i class="fa-solid fa-user"></i>' + user.email + '</p>'
            HTMLCode += '<p> <i class="fa-solid fa-bookmark"></i>' + user.role + '</p>'
            HTMLCode += '<a href="?page=user-administration&userID=' + user.id + '"><button class="action_button"><i class="fa-solid fa-user-pen"></i>Modificar</button></a>'
            HTMLCode += '<a href="?page=usuaris&confirm=true&userID=' + user.id + '"><button class="action_button delete_button"><i class="fa-solid fa-user-minus"></i>Eliminar</button></a>'
            HTMLCode += '</div>';
        })

        if (users.length===0){
            HTMLCode+= '<div><h2>No s\'han trobat resultats</h2><p>Intenti amb un altre filtre de cerca.</p></div>'
        }
        return HTMLCode
    }

    function setLoadingStatus() {
        if (!isLoading) {
            isLoading = !isLoading
            let HTMLCode = headerCode
            HTMLCode += '<div class="loader-container"><div class="loader"></div></div>'
            document.querySelector(".list-container").innerHTML = HTMLCode
        }
    }

    /* ----------------------------------- */

    const headerCode = `
        <div class="list-header">
            <a href="">
                <h4>Nom</h4>
            </a>
            <a href="">
                <h4>Correu</h4>
            </a>
            <a href="">
                <h4>Rol</h4>
            </a>
            <a href="">
                <h4>Modificar</h4>
            </a>
            <a href="">
                <h4>Eliminar</h4>
            </a>
        </div>
    `

    /* ----------------------------------- */

    let inputSearch = document.querySelector('#search')

    if(inputSearch.value===""){
        setLoadingStatus()
        debouncedgetUsersAPI(inputSearch.value)
    }

    inputSearch.addEventListener("input", (element) => {
        setLoadingStatus()
        debouncedgetUsersAPI (element.target.value)
    });

}