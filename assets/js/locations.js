let currentLocation = []; // Variable para almacenar las IDs del elemento seleccionado y su jerarquía
const headerCode = `
    <div class="list-header">
        <a href=""><h4>Nom</h4></a>
        <a href=""><h4>Autor</h4></a>
        <a href=""><h4>Ubicació</h4></a>
        <a href=""><h4>Any</h4></a>
        <a href=""><h4>Tècnica</h4></a>
    </div>
`;

// Renderizar el árbol al cargar la página
document.addEventListener('DOMContentLoaded', () => {
    // Función para actualizar la altura máxima del contenedor .panel-tree
    function updatePanelMaxHeight() {
        const panelTree = document.querySelector('.panel-tree');
        panelTree.style.maxHeight = `${panelTree.scrollHeight}px`;
    }

    /** Funcionalidad para rellenar el numero de identificador (registro) con ceros */
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


    function populateArtWorkLocationSelect() {
        // console.log('Current Location:', currentLocation);
        fetch("controllers/ArtworkController.php?getArtworksAtLocations", {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify({ currentLocation: currentLocation }) // Convertir el array a JSON
        })
            .then(response => response.text()) // Leer la respuesta completa como texto
            .then(response => {
                try {
                    const artworks = JSON.parse(response); // Convertir a JSON si es posible
                    let HTMLCode = headerCode;
                    artworks.message.forEach(artwork => {
                        // Generar el número de registro
                        let registerNumber = '';

                        registerNumber += artwork.id_letter === null ? '' : artwork.id_letter;
                        registerNumber += artwork.id_num1 === null ? '' : padIdentifierWithZeros(Number(artwork.id_num1));
                        registerNumber += artwork.id_num2 === null ? '' : '.' + padSubWithZeros(Number(artwork.id_num2));

                        // Transformamos la fecha de artwork.creation_date a un objeto Date y luego solo recogemos el año
                        let creationYear = new Date(artwork.creation_date).getFullYear();

                        HTMLCode += '<div class="list-item" key="' + artwork.id + '">';
                        HTMLCode += '<img src="' + artwork.artwork_image + '" alt="' + artwork.artwork_name + ' ' + artwork.author_name + '">';
                        HTMLCode += '<a href="?page=artwork-view&id=' + artwork.id + '"><h3>' + artwork.artwork_name + '</h3><span class="register_number">' + registerNumber + '</span></a>';
                        HTMLCode += '<p><i class="fa-solid fa-user"></i>' + artwork.author_name + '</p>';
                        HTMLCode += '<p><i class="fa-solid fa-location-dot"></i>' + artwork.location_name + '</p>';
                        HTMLCode += '<p><i class="fa-solid fa-bookmark"></i>' + creationYear + '</p>';
                        HTMLCode += '<p><i class="fa-regular fa-clipboard"></i>' + artwork.tecnique_name + '</p>';
                        HTMLCode += '</div>';
                    });
                    if (artworks.message.length === 0) {
                        HTMLCode += '<div><h2>No s\'han trobat resultats</h2><p>Intenti amb un altre localització.</p></div>';
                    }
                    document.querySelector(".list-container").innerHTML = HTMLCode;
                } catch (error) {
                    console.error("Error parsing response:", error);
                }

            })
            .catch(error => {
                console.log(error);
            });

    }

    function showHelpAnimation(position = undefined) {
        
        const $img = $(".animated-ratoli");

        if (position) {
            $img.css({
                top: (position + 20) + 'px',
            });
        }

        $img.fadeIn(500) // Mostrar la imagen
        .css('display', 'flex')
        .delay(2000) // Esperar un momento
        .fadeOut(500); // Ocultar la imagen
    }

    function loadLocationTree() {
        // Cargar datos de ubicación desde la API al cargar la pagina
        fetch('controllers/LocationController.php?location=all')
            .then(response => response.text())
            .then(data => {
                console.log('Data:', data);
                data = JSON.parse(data);
                // Convertir datos al formato jsTree
                const jstreeData = data.map(item => ({
                    // icon: 'fa-solid fa-location-dot',
                    id: item.id,
                    parent: item.parent === null ? "#" : item.parent, // Nodo raíz si el padre es null
                    text: item.name,
                }));


                // Inicializar jsTree con los datos transformados
                $('#jstree').jstree({
                    'core': {
                        'data': jstreeData,
                        'themes': {
                            'animation': 0, // Desactiva animaciones
                            'icons': false, // Activa iconos
                        }
                    },
                });

                $('#jstree').on('after_open.jstree', function (e, data) {
                    updatePanelMaxHeight();
                });

                $('#jstree').on('close_node.jstree', function (e, data) {
                    updatePanelMaxHeight();
                });

                $('#jstree').on('select_node.jstree', function (e, data) {
                    const selectedNodeId = data.node.id; // ID del nodo seleccionado

                    // Obtener todos los hijos (directos e indirectos) del nodo seleccionado
                    const allChildrenIds = data.instance.get_node(selectedNodeId).children_d;

                    // Agregar la ID del nodo seleccionado al array
                    const resultArray = [selectedNodeId, ...allChildrenIds];

                    // console.log('ID del nodo seleccionado:', selectedNodeId);
                    // console.log('IDs de todos los hijos (descendientes):', allChildrenIds);
                    // console.log('Resultado final (incluye el nodo seleccionado):', resultArray);

                    // Actualizar la variable global con las IDs
                    currentLocation = resultArray;

                    // Llamar a la función para rellenar las obras
                    populateArtWorkLocationSelect();
                });

                // Seleccionar y desplegar el primer nodo al cargar el árbol
                $('#jstree').on('ready.jstree', function () {
                    // Obtener el ID del primer nodo raíz
                    const firstNode = $('#jstree').jstree(true).get_json('#', { flat: true })[0];
                    if (firstNode) {
                        const treeInstance = $('#jstree').jstree(true);

                        // Seleccionar el primer nodo
                        treeInstance.select_node(firstNode.id);

                        // Desplegar el primer nodo
                        treeInstance.open_node(firstNode.id);

                        setTimeout(() => {
                            // Enviamos la posición más baja del div jstree para mostrar la animación de ayuda tras unos 200ms
                            const div = document.getElementById('jstree');
                            const rect = div.getBoundingClientRect();
                            const posicionAbajo = rect.bottom + window.scrollY;
                            // console.log('La posición más baja del div es:', posicionAbajo);
                            // Mostrar la animación de ayuda
                            showHelpAnimation(posicionAbajo);
                        }, 200);
                    }
                });

                // Cuando el arbol esté cargado, seleccionar el primer nodo
                // selectFirstNode();
            })
            .catch(error => {
                console.error('Error fetching location data:', error);
                // const container = document.getElementById('location-tree-container');
                // container.innerHTML = '<p style="padding-left: 15px;">Error al cargar los datos de ubicación.</p>';
                updatePanelMaxHeight(); // Calcular la altura inicial del
            });
    }

    function reloadLocationTree() {
        // Cargar datos de ubicación desde la API al cargar la pagina
        fetch('controllers/LocationController.php?location=all')
            .then(response => response.json())
            .then(data => {
                // Convertir datos al formato jsTree
                const jstreeData = data.map(item => ({
                    // icon: 'fa-solid fa-location-dot',
                    id: item.id,
                    parent: item.parent === null ? "#" : item.parent, // Nodo raíz si el padre es null
                    text: item.name,
                }));

                $('#jstree').jstree(true).settings.core.data = jstreeData; // Establecer los nuevos datos
                $('#jstree').jstree(true).refresh(); // Refrescar todo el árbol

                // setTimeout(() => {
                //     // Obtener el ID del primer nodo raíz
                //     const firstNode = $('#jstree').jstree(true).get_json('#', { flat: true })[0];
                //     if (firstNode) {
                //         const treeInstance = $('#jstree').jstree(true);

                //         // Seleccionar el primer nodo
                //         treeInstance.select_node(firstNode.id);

                //         // Desplegar el primer nodo
                //         treeInstance.open_node(firstNode.id);
                //     }
                // }, 200);

            })
            .catch(error => {
                console.error('Error fetching location data:', error);
                // const container = document.getElementById('location-tree-container');
                // container.innerHTML = '<p style="padding-left: 15px;">Error al cargar los datos de ubicación.</p>';
                updatePanelMaxHeight(); // Calcular la altura inicial del contenedor

            });
    }

    loadLocationTree();

    // Capturar clic derecho en un nodo
    if ($('#context-menu').length) {
        $('#jstree').on('contextmenu.jstree', function (e, data) {
            e.preventDefault(); // Prevenir el menú contextual por defecto
            const nodeId = $(e.target).closest('li').attr('id'); // ID del nodo seleccionado

            if (nodeId) {
                // Mostrar menú contextual
                $('#context-menu')
                    .css({ top: e.pageY + 'px', left: e.pageX + 'px' }) // Posicionar el menú
                    .show()
                    .data('node-id', nodeId); // Guardar la ID del nodo en el menú
            }
        });

        // Ocultar el menú si se hace clic fuera
        $(document).on('click', function () {
            $('#context-menu').hide();
        });

        // Acciones del menú contextual
        $('#add-location').on('click', function () {
            const nodeId = $('#context-menu').data('node-id'); // Obtener ID del nodo

            // Mostrar SweetAlert con el formulario personalizado
            Swal.fire({
                title: 'Nova ubicació',
                html: `
                <div style="width: 100%;">
                    <label for="new-location" style="display: block; font-weight: bold;">Nova ubicació</label>
                    <input id="new-location" type="text" placeholder="Nom de la nova ubicació" style="width: 100%; padding: 8px; margin-top: 10px; border: 1px solid #ccc; border-radius: 5px;">
                </div>
            `,
                showCancelButton: true,
                confirmButtonText: 'Aceptar',
                cancelButtonText: 'Cancelar',
                focusConfirm: false,
                preConfirm: () => {
                    const newLocationName = document.getElementById('new-location').value;
                    if (!newLocationName) {
                        Swal.showValidationMessage('Si us plau, introdueix un nom per a la ubicació.');
                    }
                    return newLocationName; // Devuelve el nombre ingresado
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    const newLocationName = result.value; // Valor del input

                    // Ahora hacemos un fetch enviando el nombre de la nueva ubicación y el ID del nodo padre
                    fetch('controllers/LocationController.php?addlocation', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({
                            parent: nodeId,
                            name: result.value
                        })
                    })
                        .then(response => response.text())
                        .then(data => {
                            // console.log('Respuesta del servidor:', data);
                            data = JSON.parse(data);
                            if (data.status === 'success') {
                                // Recargar el árbol de ubicaciones
                                reloadLocationTree();

                                // Mostrar un mensaje de éxito en SweetAlert
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Ubicació creada',
                                    text: `La ubicació "${newLocationName}" s'ha creat correctament.`,
                                    timer: 3000, // Tiempo en milisegundos (2 segundos)
                                    showConfirmButton: false, // No mostrar el botón de confirmación
                                    timerProgressBar: true, // Mostrar barra de progreso
                                });
                            }
                        })
                        .catch(error => {
                            console.error('Error al crear la ubicació:', error);

                            // Mostrar un mensaje de error en SweetAlert
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'Hi ha hagut un error al crear la ubicació.',
                            });
                        });
                } else {
                    console.log('Operación cancelada.');
                }
            });
        });


        $('#modify-location').on('click', function () {
            const nodeId = $('#context-menu').data('node-id');
        
            // Obtener el nombre del nodo seleccionado utilizando jsTree
            const selectedNode = $('#jstree').jstree(true).get_node(nodeId);
            const nodeName = selectedNode.text; // Obtener solo el texto del nodo seleccionado
        
            // Mostrar SweetAlert con el formulario personalizado
            Swal.fire({
                title: 'Modificar ubicació',
                html: `
                    <div style="width: 100%;">
                        <label for="new-location" style="display: block; font-weight: bold;">Nom de la ubicació</label>
                        <input id="new-location" type="text" value="${nodeName}" placeholder="Nom de la ubicació" style="width: 100%; padding: 8px; margin-top: 10px; border: 1px solid #ccc; border-radius: 5px;">
                    </div>
                `,
                showCancelButton: true,
                confirmButtonText: 'Aceptar',
                cancelButtonText: 'Cancelar',
                focusConfirm: false,
                preConfirm: () => {
                    const newLocationName = document.getElementById('new-location').value;
                    if (!newLocationName) {
                        Swal.showValidationMessage('Si us plau, introdueix un nom per a la ubicació.');
                    }
                    return newLocationName; // Devuelve el nombre ingresado
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    const newLocationName = result.value; // Valor del input
        
                    // Enviar el nombre de la nueva ubicación y el ID del nodo al servidor
                    fetch('controllers/LocationController.php?modifylocation', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({
                            id: nodeId,
                            name: newLocationName
                        })
                    })
                        .then(response => response.text())
                        .then(data => {
                            data = JSON.parse(data);
                            if (data.status === 'success') {
                                // Recargar el árbol de ubicaciones
                                reloadLocationTree();
        
                                // Mostrar un mensaje de éxito en SweetAlert
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Ubicació modificada',
                                    text: `La ubicació "${newLocationName}" s'ha modificat correctament.`,
                                    timer: 2000,
                                    showConfirmButton: false,
                                    timerProgressBar: true,
                                });
                            }
                        })
                        .catch(error => {
                            console.error('Error al modificar la ubicació:', error);
                        });
                } else {
                    console.log('Operación cancelada.');
                }
            });
        });
        



        $('#delete-location').on('click', function () {
            const nodeId = $('#context-menu').data('node-id');

            // Recoger el nombre del nodo seleccionado directamente desde jsTree
            const selectedNode = $('#jstree').jstree(true).get_node(nodeId);
            const nodeName = selectedNode.text; // Nombre del nodo
            // console.log('ID del nodo seleccionado:', nodeId);

            // Mostrar SweetAlert de confirmación
            Swal.fire({
                title: 'Estàs segur?',
                text: `Vols eliminar la ubicació "${nodeName}"? Aquesta acció no es pot desfer.`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Eliminar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Verificar si el nodo tiene hijos
                    if (selectedNode.children.length > 0) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Ubicació amb fills',
                            text: `La ubicació "${nodeName}" té fills. No pots eliminar-la fins que no eliminis tots els fills.`,
                        });
                        return;
                    }

                    // Eliminar la ubicación a través del servidor
                    fetch('controllers/LocationController.php?deletelocation', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({
                            id: nodeId
                        })
                    })
                        .then(response => {
                            if (!response.ok) {
                                throw new Error('Error en la respuesta del servidor');
                            }
                            return response.json();
                        })
                        .then(data => {
                            if (data.status === 'success') {
                                // Recargar el árbol de ubicaciones
                                reloadLocationTree();

                                // Mostrar un mensaje de éxito
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Ubicació eliminada',
                                    text: `La ubicació "${nodeName}" s'ha eliminat correctament.`,
                                });
                            } else {
                                // Mostrar un mensaje de error si algo falla

                                // Calculamos cuantos elementos en total tiene nuestro arbol
                                // para saber si solo queda un elemento y no se puede eliminar
                                // porque no puede quedar vacio
                                const totalNodes = $('#jstree').jstree(true).get_json().length;

                                if (totalNodes === 1) {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Error',
                                        text: 'No pots eliminar l\'única ubicació existent.',
                                    });
                                    return;
                                }

                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: data.message || 'No s\'ha pogut eliminar la ubicació.',
                                });
                            }
                        })
                        .catch(error => {
                            console.error('Error al eliminar la ubicació:', error);

                            // Contar todos los elementos del arbol de ubicaciones
                            const totalNodes = $('#jstree').jstree(true).get_json().length;
                            // console.log('Total de nodos:', totalNodes);
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'S\'ha produït un error al intentar eliminar la ubicació. Elements: ' + totalNodes,
                            });
                        });
                } else {
                    console.log('Operación cancelada.');
                }
            });
        });



    }




});
