if (document.querySelector("#logoutButton")) {
  let profileButton = document.querySelector("#logoutButton");

  profileButton.addEventListener("click", function () {
    location.href = "?logout";
  });

  function toggleMenu() {
    const menu = document.getElementById('dropdownMenu');
    menu.classList.toggle('show');
  }
}

if (document.querySelector("#formGeneratePDFButton")) {
  let pdfButton = document.querySelector("#formGeneratePDFButton");

  pdfButton.addEventListener("click", () => {
    //location.href = "?generatePDF";
    window.open('index.php?generatePDF', '_blank');

  })
}

if (document.getElementById("resetFilters")) {

  let resetFilters = document.querySelector("#resetFilters");

  resetFilters.addEventListener("click", (e) => {
    e.preventDefault();
    location.href = "index.php";
    //alert("Filtros reseteados");
  })
}

document.addEventListener("DOMContentLoaded", function () {
  if (document.querySelector(".dropdown1")) {
    const dropdown = document.querySelector(".dropdown1");
    const dropdownMenu = document.querySelector(".dropdown-menu1");
    dropdownMenu.style.display = "none";

    let hideTimeout; // Variable para almacenar el temporizador

    dropdown.addEventListener("mouseenter", function () {
      clearTimeout(hideTimeout); // Cancela cualquier temporizador previo
      dropdownMenu.style.display = "block";
    });

    dropdown.addEventListener("mouseleave", function () {
      hideTimeout = setTimeout(function () {
        dropdownMenu.style.display = "none";
      }, 300); // 1.5 segundos
    });
  }
});