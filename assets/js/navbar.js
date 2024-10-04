let profileButton = document.querySelector("#logoutButton");
let pdfButton = document.querySelector("#formGeneratePDFButton");

profileButton.addEventListener("click", function() {
    location.href = "?logout";
});

function toggleMenu() {
    const menu = document.getElementById('dropdownMenu');
    menu.classList.toggle('show');
}

pdfButton.addEventListener("click", (event) => {
    location.href = "?generatePDF";
})