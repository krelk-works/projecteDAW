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
                    <a href="?page=artwork-view&id=${element.artwork}"><h3>${element.title}</h3><span class="register_number">${registerNumber} &nbsp;&nbsp;&nbsp; ${element.code}</span></a>
                    <p>${element.authorised_worker_name}</p>
                    <p>${element.start_date} &nbsp; - &nbsp; ${element.end_date}</p>
                    <a><button data-comment="${element.comment}" id="show-comment" class="action_button" ><i class="fa-solid fa-user-pen"></i>Comentari</button></a>
                </div>
            `
        });
        
        if (data.length === 0) {
            HTMLCode += '<div><h2>No s\'han trobat resultats</h2><p>Intenti amb un altre filtre de cerca.</p></div>';
        }
        return HTMLCode;
    }

    const headerCode = `
        <div class="list-header">
            <a href="">
                <h4>Nom</h4>
            </a>
            <a href="">
                <h4>&nbsp;&nbsp;&nbsp;Restaurador</h4>
            </a>
            <a href="">
                <h4>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Dates</h4>
            </a>
            <a href="">
                <h4>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Comentari</h4>
            </a>
        </div>
    `

    /** Deshabilitamos que al hacer ENTER en cualquier INPUT se envie formulario */
    document.querySelectorAll('input').forEach(input => {
        input.addEventListener('keydown', function (event) {
            if (event.key === 'Enter') {
                event.preventDefault();
            }
        });
    });

    

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
$(document).on('click', '#show-comment', function() {
    let comment = $(this).data('comment');
    
    Swal.fire({
        title : 'Modificar comentari',
        html: `<textarea class="comment-textarea">${comment}</textarea>`,
        showDenyButton: true,
        showCancelButton: true,
        confirmButtonText: "Guardar",
        denyButtonText: `Descartar cambios`,
        cancelButtonText: 'Cerrar',
        width : '800px'
    }).then((result) => {
        /* Read more about isConfirmed, isDenied below */
        if (result.isConfirmed) {
          Swal.fire("Saved!", "", "success");
        } else if (result.isDenied) {
          Swal.fire("Changes are not saved", "", "info");
        }
    });
});
$(document).ready(function() {
    $('#restoration-create').on('click', function(event) {
        event.preventDefault();
        window.location.href = "?page=restoration-create";
    })
})