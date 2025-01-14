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

if (document.querySelector(".list-item-backup-filename")) {
    let listItems = document.querySelectorAll(".list-item-backup-filename");
    listItems.forEach((listItem) => {
        listItem.addEventListener("click", () => {
            let backupName = listItem.innerHTML.toString();
            Swal.fire({
                icon: 'warning',
                title: 'Estàs segur de restaurar aquest backup?',
                html: `A continuació restauraràs el backup <strong>${backupName}</strong>.`,
                showConfirmButton: true,
                confirmButtonText: 'Sí, restaurar',
                showCancelButton: true,
                cancelButtonText: 'Cancel·lar',
            }).then((result) => {
                if (result.isConfirmed) {
                    // Mostrar un indicador de carga mientras se procesa
                    Swal.fire({
                        title: 'Processant...',
                        text: 'La restauració pot tardar uns moments. Si us plau, espera.',
                        icon: 'info',
                        allowOutsideClick: false,
                        showConfirmButton: false,
                        didOpen: () => {
                            Swal.showLoading(); // Mostrar animación de carga
                        },
                    });

                    // Enviar la solicitud al servidor
                    fetch('/apis/backupsAPI.php?restore', {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json"
                        },
                        body: JSON.stringify({ file: backupName })
                    }).then(response => response.json())
                    .then(data => {
                        // Cerrar la alerta de carga
                        Swal.close();

                        if (data.status === 'success') {
                            Swal.fire({
                                title: "Restauració completada",
                                text: "La base de dades s'ha restablert correctament.",
                                icon: "success",
                                confirmButtonText: "D'acord",
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    window.location.href = "index.php"; // Redirigir després de confirmar
                                }
                            });
                        } else {
                            Swal.fire({
                                title: "Hi ha hagut un error",
                                text: "Hi ha hagut un error en la restauració, si us plau, contacti amb un administrador.",
                                icon: "error",
                                confirmButtonText: "D'acord",
                            });
                        }
                    })
                    .catch(error => {
                        // Cerrar la alerta de carga y mostrar un error si falla la solicitud
                        Swal.close();
                        Swal.fire({
                            title: "Error de connexió",
                            text: "No s'ha pogut connectar amb el servidor. Si us plau, intenta-ho més tard.",
                            icon: "error",
                            confirmButtonText: "D'acord",
                        });
                        console.error("Error en la sol·licitud:", error);
                    });
                }
            });
        });
    });
}
