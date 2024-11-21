var acc = document.getElementsByClassName("accordion");

for (let i = 0; i < acc.length; i++) {
    acc[i].addEventListener("click", function () {
        // Cerrar todos los paneles antes de abrir el actual
        for (let j = 0; j < acc.length; j++) {
            if (acc[j] !== this) {
                acc[j].classList.remove("active");
                acc[j].nextElementSibling.style.maxHeight = null;
            }
        }

        // Alternar el acordeón actual
        this.classList.toggle("active");
        var panel = this.nextElementSibling;
        if (panel.style.maxHeight) {
            panel.style.maxHeight = null;
        } else {
            panel.style.maxHeight = panel.scrollHeight + "px";
        }
    });

    // Comprobar si el acordeón tiene la clase "default_active" al cargar
    if (acc[i].classList.contains("default_active")) {
        const accordion = acc[i];
        const panel = acc[i].nextElementSibling;
        accordion.classList.remove("default_active");
        accordion.classList.toggle("active");
        panel.style.maxHeight = panel.scrollHeight + "px";
        // console.log("Se ha detectado un acordeón con la clase default_active");
    }
}