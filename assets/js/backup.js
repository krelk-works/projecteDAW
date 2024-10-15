if (document.querySelector("#createBackupButton")) {
    let createBackupButton = document.querySelector("#createBackupButton");
    createBackupButton.addEventListener("click", () => {
        createBackupButton.classList.add('animated-border'); // Asocia la animación al elemento
        createBackupButton.disabled = true; // Desactivar el botón después de hacer clic
        createBackupButton.style.color = 'orange';
        createBackupButton.innerHTML = '<i class="fa-regular fa-hourglass-half"></i>Generant Backup...'; // Cambiar el texto del botón para mostrar el proceso en curso
        let backupName = document.querySelector("#backupname").value.toString();
        //console.log("Backup name: " + backupName);
        backupName = backupName.replace(/ /g, '%');
        window.location.href = 'index.php?page=backups' + '&backupname=' + backupName;
    })
}

if (document.querySelector(".list-item-backup")) {
    let listItems = document.querySelectorAll(".list-item-backup");
    listItems.forEach((listItem) => {
        listItem.addEventListener("click", () => {
            let backupName = listItem.getAttribute("data-backupname");
            Swal.fire({
                icon: 'warning',
                title: 'Estàs segur de restaurar aquest backup?',
                html: `A continuació restauraras el backup <strong>`+backupName+`</strong>.`,
                showConfirmButton: true,
                confirmButtonText: 'Si, restaurar',
                showCancelButton: true,
                cancelButtonText: 'Cancel·lar',
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Aquesta funcionalitat encara no està disponible',
                        html: `<i class="fa-regular fa-face-sad-tear"></i> <strong>Disculpi les molesties</strong>.`,
                        showConfirmButton: true,
                        confirmButtonText: 'OK',
                    })
                }
            });
        })
    })
}