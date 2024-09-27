let profileButton = document.querySelector("#logoutButton");

profileButton.addEventListener("click", function() {
    location.href = "?logout";
});

function toggleMenu() {
    const menu = document.getElementById('dropdownMenu');
    menu.classList.toggle('show');
}