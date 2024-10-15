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