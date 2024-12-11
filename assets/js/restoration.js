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

if($('#restoration-search')){

    let isLoading = false

    function debounce(fn,  delay){
        let timer = null

        return(...args)=>{
            if (timer) clearTimeout(timer)
            timer = setTimeout(() => fn(...args), delay)
        }
    }

    const getRestorationAPI = (value)=>{
        fetch('apis/restorationAPI.php?search='+value)
        .then(response=>response.json())
        .then(data=>{
            let HTMLCode=generateHTMLCode(data)
            $('.list-container').html(HTMLCode)
            isLoading=false
            console.log('object');
        })
    }

    const debouncedgetRestorationAPI=debounce(getRestorationAPI,500)

    function generateHTMLCode(data){
        let HTMLCode = headerCode
        data.forEach(element => {
            let registerNumber = '';
            
            registerNumber += element.id_letter === null ? '' : element.id_letter;
            registerNumber += element.id_num1 === null ? '' : padIdentifierWithZeros(Number(element.id_num1));
            registerNumber += element.id_num2 === null ? '' : '.' + padSubWithZeros(Number(element.id_num2));
            
            HTMLCode+=`
                <div class="list-item">
                    <img src="${element.image}">
                    <a href="?page=artwork-view&id=${element.artwork}"><h3>${element.title}</h3><span class="register_number">${registerNumber}</span></a>
                    <p>${element.code}</p>
                    <p>${element.start_date} - ${element.end_date}<p>
                    <p>${element.authorised_worker_name}<p>
                    <a><button class="action_button"><i class="fa-solid fa-user-pen"></i>Comentari</button></a>
                </div>
            `
        });
        
        if (data.length === 0) {
            HTMLCode += '<div><h2>No s\'han trobat resultats</h2><p>Intenti amb un altre filtre de cerca.</p></div>';
        }
        console.log(HTMLCode);
        return HTMLCode;
    }

    const headerCode = `
        <div class="list-header">
            <a href="">
                <h4>Nom</h4>
            </a>
            <a href="">
                <h4>Restaurador</h4>
            </a>
            <a href="">
                <h4>Data</h4>
            </a>
            <a href="">
                <h4>Codi Restauracio</h4>
            </a>
            <a href="">
                <h4>Comentari</h4>
            </a>
        </div>
    `
    function setLoadingStatus() {
        if (!isLoading) {
            isLoading = !isLoading
            let HTMLCode = headerCode
            HTMLCode += '<div class="loader-container"><div class="loader"></div></div>'
            $(".list-container").html(HTMLCode)
        }
    }

    if($('#restoration-search').val()===''){
        setLoadingStatus()
        debouncedgetRestorationAPI($('#restoration-search').val())
    }

    $('#restoration-search').on('input', function(){
        setLoadingStatus()
        debouncedgetRestorationAPI($(this).val())
    })
}