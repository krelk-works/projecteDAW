console.log('add-artwork.js loaded');

/** Funcionalidad de la imagen por defecto de la obra */
if (document.getElementById('add-default-image')) {
    // Obtenemos el elemento HTML del botón de añadir imagen por defecto en caso de existir
    const addDefaultImage = document.getElementById('add-default-image');

    // Nos aseguramos que el elemento input de tipo FILE exista (aunque este oculto)
    if (document.getElementById('defaultimage')) {

        // Obtenemos el elemento input de tipo FILE
        const defaultImage = document.getElementById('defaultimage');

        // Comprobamos si el elemento img donde se mostrará la vista previa existe
        if (document.getElementById('defaultimagepreview')) {

            // Nos aseguramos de que el elemento img donde se mostrará la vista previa existe
            const imagePreview = document.getElementById('defaultimagepreview');

            // Le añadimos una funcionalidad al hacer click sobre el botón
            addDefaultImage.addEventListener('click', function (event) {
                // Evitamos que el formulario se envíe
                event.preventDefault();

                // Simulamos un click sobre el input para que se abra el explorador de archivos
                defaultImage.click();
            });

            // Le añadimos la funcionalidad de eliminar la imagen por defecto
            imagePreview.addEventListener('click', function () {
                Swal.fire({
                    title: "Estas segur que vols eliminar la imatge principal?",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonText: "Si, eliminar",
                    cancelButtonText: "Cancel·lar",
                }).then((result) => {
                    /* Read more about isConfirmed, isDenied below */
                    if (result.isConfirmed) {
                        // Eliminamos la imagen por defecto
                        imagePreview.src = '';
                        imagePreview.style.display = 'none'; // Asegurarse de que no sea visible
                        // Reseteamos el valor del input de tipo FILE
                        defaultImage.value = '';

                        // Cambiamos el texto del botón
                        addDefaultImage.textContent = 'Afegir imatge';
                    }
                });
            });

            // Le añadimos una funcionalidad al cambiar el archivo seleccionado
            defaultImage.addEventListener('change', (event) => {
                const selectedFile = event.target.files[0];
                if (selectedFile) {
                    // console.log('Archivo seleccionado:', selectedFile.name);
                    // Aquí puedes hacer algo con el archivo seleccionado

                    // Usar FileReader para leer la imagen y mostrar la vista previa
                    const reader = new FileReader();

                    // Le añadimos una funcionalidad al cargar la imagen
                    reader.onload = function (e) {
                        // Asignamos la imagen cargada como fuente del elemento de vista previa
                        imagePreview.src = e.target.result;
                        imagePreview.style.display = 'block'; // Asegurarse de que sea visible
                    };

                    reader.readAsDataURL(selectedFile);

                    addDefaultImage.textContent = 'Canviar imatge';
                }
            });
        }


    }
}
/* FIN DE LA FUNCIONALIDAD */

/** Funcionalidad de titulo de la obra sincronizado con el titulo general de la página de creación de obra */
if (document.getElementById('artwork_title')) {
    const artworkTitle = document.getElementById('artwork_title');
    
    artworkTitle.addEventListener('input', function (element) {
        // console.log('Titulo de la obra:', element.target.value);
        if (element.target.value === '') {
            if (document.getElementById('artwork-page-title')) {
                document.getElementById('artwork-page-title').textContent = 'Nova obra';
            }
        } else {
            if (document.getElementById('artwork-page-title')) {
                document.getElementById('artwork-page-title').textContent = element.target.value;
            }
        }
    });
}
/* FIN DE LA FUNCIONALIDAD */