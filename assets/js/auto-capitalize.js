// Funcionalidad de primera letra mayúscula en campos que tengan el atributo capitalize
if (document.querySelectorAll('[capitalize]')) {
    document.querySelectorAll('[capitalize]').forEach(element => {
        element.addEventListener('input', function (event) {
            const value = event.target.value;
            event.target.value = value.charAt(0).toUpperCase() + value.slice(1);
        });
    });
}