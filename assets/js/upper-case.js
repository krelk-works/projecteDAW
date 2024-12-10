document.addEventListener('DOMContentLoaded', function() {
    const inputs = document.querySelectorAll('input[type="text"]');
    
    inputs.forEach(input => {
        input.addEventListener('input', function() {
            // Capitaliza la primera letra de cada palabra
            this.value = this.value.replace(/\b\w/g, char => char.toUpperCase());
        });
    });
});