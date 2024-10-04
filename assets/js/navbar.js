let profileButton = document.querySelector("#logoutButton");
let pdfButton = document.querySelector("#formGeneratePDFButton");

profileButton.addEventListener("click", function () {
    location.href = "?logout";
});

function toggleMenu() {
    const menu = document.getElementById('dropdownMenu');
    menu.classList.toggle('show');
}

pdfButton.addEventListener("click", (event) => {
    //location.href = "?generatePDF";
    window.open('http://localhost:8080/projecteDAW/index.php?generatePDF', '_blank');

})

// Obtener el elemento select
const authorSelect = document.getElementById('author_select');

// Agregar un evento mouseover al select
authorSelect.addEventListener('mouseover', function (event) {
  // Obtener todas las opciones del select
  const options = event.target.options;
  
  // Iterar sobre cada opción
  for (let i = 0; i < options.length; i++) {
    // Agregar evento mouseover a cada option
    options[i].addEventListener('mouseover', function () {
      options[i].style.backgroundColor = 'blue'; // Cambiar fondo a azul
      options[i].style.color = 'white'; // Cambiar el color del texto a blanco para mejor visibilidad
    });

    // Agregar evento mouseout a cada option para restaurar el fondo original
    options[i].addEventListener('mouseout', function () {
      options[i].style.backgroundColor = ''; // Restaurar fondo original
      options[i].style.color = ''; // Restaurar color original
    });
  }
});
