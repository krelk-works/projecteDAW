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