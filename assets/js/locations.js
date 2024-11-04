let currentLocation = []; // Variable para almacenar las IDs del elemento seleccionado y su jerarquía
const headerCode = `
    <div class="list-header">
        <a href=""><h4>Nom</h4></a>
        <a href=""><h4>Autor</h4></a>
        <a href=""><h4>Ubicació</h4></a>
        <a href=""><h4>Datació</h4></a>
        <a href=""><h4>Estat</h4></a>
    </div>
`;

function populateArtWorkLocationSelect() {
    // console.log('Current Location:', currentLocation);
    fetch("http://localhost:8080/projecteDAW/controllers/ArtworkController.php?getArtworksAtLocations", {
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
                // console.log("Se ha recibido la obra: "+element.artwork_name);
                HTMLCode += '<div class="list-item">';
                HTMLCode += '<img src="' + artwork.URL + '" alt="' + artwork.artwork_name + ' ' + artwork.author_name + '">';
                HTMLCode += '<a href="?page=artwork-administration&artworkID=' + artwork.id + '"><h3>' + artwork.artwork_name + '</h3></a>';
                HTMLCode += '<p><i class="fa-solid fa-user"></i>' + artwork.author_name + '</p>';
                HTMLCode += '<p><i class="fa-solid fa-location-dot"></i>' + artwork.location_name + '</p>';
                HTMLCode += '<p><i class="fa-solid fa-bookmark"></i>' + artwork.creation_date + '</p>';
                HTMLCode += '<p><i class="fa-regular fa-clipboard"></i>' + artwork.text + '</p>';
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

// Función para renderizar el árbol de ubicaciones
function renderLocationTree(data, containerId) {
    const container = document.getElementById(containerId);
    const nodeMap = {};
    let firstRootNode; // Variable para almacenar el primer nodo raíz

    // Crear nodos y almacenar en un mapa de ID
    data.forEach(location => {
        nodeMap[location.id] = {
            ...location,
            children: [],
            element: null,
            parentElement: null // Añadir referencia al padre
        };
    });

    // Establecer las relaciones padre-hijo y asignar referencias a los padres
    data.forEach(location => {
        if (location.parent) {
            nodeMap[location.parent].children.push(nodeMap[location.id]);
            nodeMap[location.id].parentElement = nodeMap[location.parent]; // Asignar referencia al padre
        } else if (!firstRootNode) {
            firstRootNode = location.id; // Guardar el primer nodo raíz
        }
    });

    // Función recursiva para crear el árbol
    function createNodeElement(node) {
        const nodeElement = document.createElement('li');
        nodeElement.className = 'location-node';

        const label = document.createElement('label');
        label.textContent = node.name;
        label.onclick = () => toggleNode(nodeElement, node.id, nodeMap);
        nodeElement.appendChild(label);

        // Solo agrega el contenedor de hijos si el nodo tiene hijos
        if (node.children.length > 0) {
            nodeElement.classList.add('has-children'); // Clase para nodos con hijos
            const childrenContainer = document.createElement('ul');
            childrenContainer.className = 'location-node-children';
            node.children.forEach(child => {
                childrenContainer.appendChild(createNodeElement(child));
            });
            nodeElement.appendChild(childrenContainer);
        }

        node.element = nodeElement;
        return nodeElement;
    }

    // Agregar nodos al contenedor principal
    const rootNodes = data.filter(location => !location.parent);
    const rootUl = document.createElement('ul');
    rootNodes.forEach(rootNode => {
        rootUl.appendChild(createNodeElement(nodeMap[rootNode.id]));
    });
    container.innerHTML = ''; // Limpiar el contenedor
    container.appendChild(rootUl);

    // Expande automáticamente el primer nodo raíz
    if (firstRootNode) {
        const firstRootElement = nodeMap[firstRootNode].element;
        toggleNode(firstRootElement, firstRootNode, nodeMap);
        
        // Actualizar currentLocation con la jerarquía del primer nodo raíz
        currentLocation = getHierarchyIds(firstRootNode, nodeMap);
        // console.log("Initial Current Location:", currentLocation);
        // populateArtWorkLocationSelect(); // Llamar a la función para enviar la ubicación actual
    }
}

// Función para alternar la apertura de nodos y actualizar currentLocation
function toggleNode(nodeElement, nodeId, nodeMap) {
    const parent = nodeElement.parentElement;

    // Cierra otros nodos en el mismo nivel
    Array.from(parent.children).forEach(child => {
        if (child !== nodeElement && child.classList.contains('open')) {
            child.classList.remove('open');
        }
    });

    // Alternar el estado del nodo actual
    const isOpening = !nodeElement.classList.contains('open');
    nodeElement.classList.toggle('open');
    updatePanelMaxHeight();

    // Actualizar currentLocation con el ID del nodo, sus padres y sus hijos
    if (isOpening) {
        currentLocation = getHierarchyIds(nodeId, nodeMap);
    } else {
        // Si el nodo se cierra, cerrar todos sus hijos y actualizar currentLocation usando el nodo padre
        closeChildNodes(nodeElement);
        const parentNode = nodeMap[nodeId].parentElement;
        currentLocation = parentNode ? getHierarchyIds(parentNode.id, nodeMap) : [];
    }
    // Nos aseguramos que hayan IDs de localizaciones para enviar una petición de llenado de obras en el frontend
    currentLocation.length > 0 ? populateArtWorkLocationSelect() : null; // Llamar a la función para enviar la ubicación actual

    // Registrar en consola el valor actual de currentLocation
    // console.log("Current Location:", currentLocation);
}

// Función para cerrar todos los nodos hijos recursivamente
function closeChildNodes(nodeElement) {
    const childNodes = nodeElement.querySelectorAll('.location-node.open');
    childNodes.forEach(child => child.classList.remove('open'));
}

// Función para obtener el ID del nodo más profundo seleccionado y sus hijos inmediatos
function getHierarchyIds(nodeId, nodeMap) {
    const ids = new Set();
    let currentNode = nodeMap[nodeId];

    // Recorrer hacia abajo hasta encontrar el nodo más profundo seleccionado
    while (currentNode.children.length > 0) {
        const openChild = currentNode.children.find(child => child.element.classList.contains('open'));
        if (openChild) {
            currentNode = openChild;
        } else {
            break;
        }
    }

    // Añadir el ID del nodo más profundo seleccionado
    ids.add(currentNode.id);

    // Añadir los IDs de los hijos inmediatos del nodo más profundo seleccionado
    currentNode.children.forEach(child => {
        ids.add(child.id);
    });

    return Array.from(ids); // Convertir el Set a un Array
}



// Función para actualizar la altura máxima del contenedor .panel-tree
function updatePanelMaxHeight() {
    const panelTree = document.querySelector('.panel-tree');
    panelTree.style.maxHeight = `${panelTree.scrollHeight}px`;
}

// Datos JSON de ejemplo
// const locationData = [
//     { "id": "10", "name": "Edifici principal", "parent": null },
//     { "id": "11", "name": "Planta 1", "parent": "10" },
//     { "id": "12", "name": "Planta 2", "parent": "10" },
//     { "id": "13", "name": "Planta 3", "parent": "10" },
//     { "id": "16", "name": "Sala 1", "parent": "11" },
//     { "id": "17", "name": "Sala 2", "parent": "11" },
//     { "id": "18", "name": "Sala 3", "parent": "12" },
//     { "id": "19", "name": "Sala 4", "parent": "12" },
//     { "id": "20", "name": "Sala 5", "parent": "12" },
//     { "id": "21", "name": "Sala 6", "parent": "13" },
//     { "id": "22", "name": "Sala 7", "parent": "13" },
//     { "id": "23", "name": "Sala 8", "parent": "13" }
// ];

// Renderizar el árbol al cargar la página
document.addEventListener('DOMContentLoaded', () => {
    // Cargar datos de ubicación desde la API al cargar la pagina
    fetch('http://localhost:8080/projecteDAW/controllers/locationController.php?location=all')
        .then(response => response.json())
        .then(data => {
            renderLocationTree(data, 'location-tree-container');
            updatePanelMaxHeight(); // Calcular la altura inicial del panel
        })
        .catch(error => {
            console.error('Error fetching location data:', error);
            const container = document.getElementById('location-tree-container');
            container.innerHTML = '<p style="padding-left: 15px;">Error al cargar los datos de ubicación.</p>';
            updatePanelMaxHeight(); // Calcular la altura inicial del
        });

        
});
