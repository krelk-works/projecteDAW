// Obtener la URL actual
const urlParams = new URLSearchParams(window.location.search);

// Comprobar si un parámetro existe
if (urlParams.has('id')) {
    try {
        // Obtener el valor de un parámetro y lo transformamos a número
        const id = Number(urlParams.get('id')); // '1' -> 1
        console.log('El parámetro id es un número');
        console.log('Procedemos con la carga de datos en el formulario');

        // Obtener los datos de la obra del controlador mediante Api
    fetch('controllers/ArtworkController.php?getArtworkAllData', {
        method: "POST",
        headers: {
            "Content-Type": "application/json"
        },
        body: JSON.stringify({ artworkId: id })
    })
        .then(response => response.text()) // Leer la respuesta completa como texto
        .then(data => {
            try {

                // console.log('Hola API...')
                // console.log(data);
                const rawData = JSON.parse(data);
                const artworkData = rawData.message[0]; // Get data from message key

                console.log(artworkData);

                
            } catch (error) {
                console.log('Error parsing JSON data:', data + " | Error: " + error);
            }
            
        })
        .catch(error => console.log(error));
    } catch (error) {
        // Error no es un número
        console.error('Error: El parámetro id no es un número');
    }
} else {
    // Error no existe el parámetro id en la URL
    console.log('Error: No existe el parámetro id en la URL');
}

/** Funcionalidad para rellenar el numero de identificador (registro) con ceros */
function padIdentifierWithZeros(number) {
    // Comprobar si el valor es un número
    if (isNaN(number)) {
        console.error("Error: El valor no es un número.");
        return null; // Devuelve null en caso de error
    }

    // Comprobar si el número está dentro del rango permitido
    if (number < 1 || number > 99999) {
        console.error("Error: El número está fuera del rango permitido (1 - 99999).");
        return null; // Devuelve null en caso de error
    }

    if (number.toString().length > 5) {
        console.log('Número mayor a 5 dígitos:', number);
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
        console.error("Error: El valor no es un número.");
        return null; // Devuelve null en caso de error
    }

    // Comprobar si el número está dentro del rango permitido
    if ((number < 1 || number > 99) && number != '' && number != 0) {
        console.error("Error: El número está fuera del rango permitido (1 - 99).");
        return null; // Devuelve null en caso de error
    }

    if (number.toString().length > 2) {
        const digitnumber = Number(number);
        return digitnumber.toString().padStart(2, '0');
    }

    // Si las comprobaciones son correctas, agrega ceros a la izquierda hasta 5 dígitos
    return number.toString().padStart(2, '0');
}
