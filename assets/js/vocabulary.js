if (document.querySelector(".entry_edit_button")) {
    let listItems = document.querySelectorAll(".entry_edit_button");
    listItems.forEach((listItem) => {
        listItem.addEventListener("click", () => {
            let valueAttribute = listItem.getAttribute("value");
            let textElement = listItem.closest(".item-vocabulary").querySelector("p").textContent;

            Swal.fire({
                title: 'Introdueix el nou valor',
                input: 'text',
                inputValue: textElement.trim(),
                showCancelButton: true,
                cancelButtonText: 'Cancel·lar',
                confirmButtonText: 'Guardar',
                showLoaderOnConfirm: true,
                preConfirm: (value) => {
                    window.location.href = 'index.php?page=vocabulari' + '&edit_entry=' + valueAttribute + '&edit_entry_text=' + value;
                }
            });
        });
    });
}


if (document.querySelector(".cancelcause_edit_button")) {
    let listItems = document.querySelectorAll(".cancelcause_edit_button");
    listItems.forEach((listItem) => {
        listItem.addEventListener("click", () => {
            let valueAttribute = listItem.getAttribute("value");
            // Obtenemos el texto del elemento <p> hermano más cercano
            let textElement = listItem.closest(".item-vocabulary").querySelector("p").textContent;

            Swal.fire({
                title: 'Introdueix el nou valor',
                input: 'text',
                inputValue: textElement.trim(), // Rellenamos el campo con el texto seleccionado
                showCancelButton: true,
                cancelButtonText: 'Cancel·lar',
                confirmButtonText: 'Guardar',
                showLoaderOnConfirm: true,
                preConfirm: (value) => {
                    window.location.href = 'index.php?page=vocabulari' + '&edit_cancelcause=' + valueAttribute + '&edit_cancelcause_text=' + value;
                }
            });
        })
    }
    );
}

if (document.querySelector(".conservationstatus_edit_button")) {
    let listItems = document.querySelectorAll(".conservationstatus_edit_button");
    listItems.forEach((listItem) => {
        listItem.addEventListener("click", () => {
            let valueAttribute = listItem.getAttribute("value");
            // Obtenemos el texto del elemento <p> hermano más cercano
            let textElement = listItem.closest(".item-vocabulary").querySelector("p").textContent;

            Swal.fire({
                title: 'Introdueix el nou valor',
                input: 'text',
                inputValue: textElement.trim(), // Rellenamos el campo con el texto seleccionado
                showCancelButton: true,
                cancelButtonText: 'Cancel·lar',
                confirmButtonText: 'Guardar',
                showLoaderOnConfirm: true,
                preConfirm: (value) => {
                    window.location.href = 'index.php?page=vocabulari' + '&edit_conservationstatus=' + valueAttribute + '&edit_conservationstatus_text=' + value;
                }
            });
        })
    });
}

if(document.querySelector(".material_edit_button")) {
    let listItems = document.querySelectorAll(".material_edit_button");
    listItems.forEach((listItem) => {
        listItem.addEventListener("click", () => {

            let valueAttribute = listItem.getAttribute("value");
            let item = listItem.closest(".item-vocabulary");

            let textElement = item.querySelector("p:nth-child(1)").textContent.trim();
            let gettyElement = item.querySelector("p:nth-child(2)").textContent.trim();

            Swal.fire({
                title: 'Edita el material',
                html: `
                    <div style="display: flex; flex-direction: column; gap: 15px;">
                        <div style="display: flex; align-items: center; gap: 10px;">
                            <label for="material_text" style="width: 100px; text-align: right;">Text:</label>
                            <input id="material_text" class="swal2-input" value="${textElement}" style="flex: 1;">
                        </div>
                        <div style="display: flex; align-items: center; gap: 10px;">
                            <label for="getty_text" style="width: 100px; text-align: right;">Getty:</label>
                            <input id="getty_text" class="swal2-input" value="${gettyElement}" style="flex: 1;">
                        </div>
                    </div>
                `,
                focusConfirm: false,
                showCancelButton: true,
                cancelButtonText: 'Cancel·lar',
                confirmButtonText: 'Guardar',
                preConfirm: () => {
                    const text = document.getElementById("material_text").value.trim();
                    const getty = document.getElementById("getty_text").value.trim();

                    if (!text || !getty) {
                        Swal.showValidationMessage('Tots els camps són obligatoris');
                        return false;
                    }

                    return { text, getty };
                },
            }).then((result) => {
                if (result.isConfirmed) {
                    const { text, getty } = result.value;

                    window.location.href = `index.php?page=vocabulari&edit_material=${valueAttribute}&edit_material_text=${text}&edit_material_getty=${getty}`;
                }
            });
        });
    });
}

if(document.querySelector(".author_edit_button")) {
    let listItems = document.querySelectorAll(".author_edit_button");
    listItems.forEach((listItem) => {
        listItem.addEventListener("click", () => {

            let valueAttribute = listItem.getAttribute("value");
            let item = listItem.closest(".item-vocabulary");

            let textElement = item.querySelector("p:nth-child(1)").textContent.trim();
            let gettyElement = item.querySelector("p:nth-child(2)").textContent.trim();

            Swal.fire({
                title: 'Edita l\'autor',

                html: `
                    <div style="display: flex; flex-direction: column; gap: 15px;">
                        <div style="display: flex; align-items: center; gap: 10px;">
                            <label for="author_text" style="width: 100px; text-align: right;">Text:</label>
                            <input id="author_text" class="swal2-input" value="${textElement}" style="flex: 1;">
                        </div>
                        <div style="display: flex; align-items: center; gap: 10px;">
                            <label for="getty_text" style="width: 100px; text-align: right;">Getty:</label>
                            <input id="getty_text" class="swal2-input" value="${gettyElement}" style="flex: 1;">
                        </div>
                    </div>
                `,
                focusConfirm: false,
                showCancelButton: true,
                cancelButtonText: 'Cancel·lar',
                confirmButtonText: 'Guardar',
                preConfirm: () => {
                    const text = document.getElementById("author_text").value.trim();
                    const getty = document.getElementById("getty_text").value.trim();

                    if (!text || !getty) {
                        Swal.showValidationMessage('Tots els camps són obligatoris');
                        return false;
                    }

                    return { text, getty };
                },
            }).then((result) => {
                if (result.isConfirmed) {
                    const { text, getty } = result.value;

                    window.location.href = `index.php?page=vocabulari&edit_author=${valueAttribute}&edit_author_text=${text}&edit_author_getty=${getty}`;
                }
            });
        });
    });
}



if (document.querySelector(".datation_edit_button")) {
    let listItems = document.querySelectorAll(".datation_edit_button");
    listItems.forEach((listItem) => {
        listItem.addEventListener("click", () => {
            let valueAttribute = listItem.getAttribute("value");
            let item = listItem.closest(".item-vocabulary");

            let textElement = item.querySelector("p:nth-child(1)").textContent.trim();
            let startDateElement = item.querySelector("p:nth-child(2)").textContent.trim();
            let endDateElement = item.querySelector("p:nth-child(3)").textContent.trim();

            Swal.fire({
                title: 'Edita la datació',
                html: `
                    <div style="display: flex; flex-direction: column; gap: 15px;">
                        <div style="display: flex; align-items: center; gap: 10px;">
                            <label for="datation_text" style="width: 100px; text-align: right;">Text:</label>
                            <input id="datation_text" class="swal2-input" value="${textElement}" style="flex: 1;">
                        </div>
                        <div style="display: flex; align-items: center; gap: 10px;">
                            <label for="start_date" style="width: 100px; text-align: right;">Data d'inici:</label>
                            <input id="start_date" type="text" class="swal2-input" value="${startDateElement}" style="flex: 1;">
                        </div>
                        <div style="display: flex; align-items: center; gap: 10px;">
                            <label for="end_date" style="width: 100px; text-align: right;">Data de fi:</label>
                            <input id="end_date" type="text" class="swal2-input" value="${endDateElement}" style="flex: 1;">
                        </div>
                    </div>
                `,
                focusConfirm: false,
                showCancelButton: true,
                cancelButtonText: 'Cancel·lar',
                confirmButtonText: 'Guardar',
                preConfirm: () => {
                    const text = document.getElementById("datation_text").value.trim();
                    const startDate = document.getElementById("start_date").value.trim();
                    const endDate = document.getElementById("end_date").value.trim();

                    if (!text || !startDate || !endDate) {
                        Swal.showValidationMessage('Tots els camps són obligatoris');
                        return false;
                    }

                    return { text, startDate, endDate };
                },
            }).then((result) => {
                if (result.isConfirmed) {
                    const { text, startDate, endDate } = result.value;

                    window.location.href = `index.php?page=vocabulari&edit_datation=${valueAttribute}&edit_datation_text=${text}&edit_datation_start_date=${startDate}&edit_datation_end_date=${endDate}`;
                }
            });
        });
    });
}

if (document.querySelector(".object_edit_button")) {
    let listItems = document.querySelectorAll(".object_edit_button");
    listItems.forEach((listItem) => {
        listItem.addEventListener("click", () => {
            let valueAttribute = listItem.getAttribute("value");
            let item = listItem.closest(".item-vocabulary");

            let textElement = item.querySelector("p:nth-child(1)").textContent.trim();
            let gettyElement = item.querySelector("p:nth-child(2)").textContent.trim();

            Swal.fire({
                title: 'Edita l\'objecte',

                html: `
                    <div style="display: flex; flex-direction: column; gap: 15px;">
                        <div style="display: flex; align-items: center; gap: 10px;">
                            <label for="object_text" style="width: 100px; text-align: right;">Text:</label>
                            <input id="object_text" class="swal2-input" value="${textElement}" style="flex: 1;">
                        </div>
                        <div style="display: flex; align-items: center; gap: 10px;">
                            <label for="getty_text" style="width: 100px; text-align: right;">Getty:</label>
                            <input id="getty_text" class="swal2-input" value="${gettyElement}" style="flex: 1;">
                        </div>
                    </div>
                `,
                focusConfirm: false,
                showCancelButton: true,
                cancelButtonText: 'Cancel·lar',

                confirmButtonText: 'Guardar',
                preConfirm: () => {
                    const text = document.getElementById("object_text").value.trim();
                    const getty = document.getElementById("getty_text").value.trim();

                    if (!text || !getty) {
                        Swal.showValidationMessage('Tots els camps són obligatoris');
                        return false;
                    }

                    return { text, getty };
                },
            }).then((result) => {
                if (result.isConfirmed) {
                    const { text, getty } = result.value;

                    window.location.href = `index.php?page=vocabulari&edit_object=${valueAttribute}&edit_object_text=${text}&edit_object_getty=${getty}`;
                }
            });
        });
    });
}




if (document.querySelector(".tecnique_edit_button")) {
    let listItems = document.querySelectorAll(".tecnique_edit_button");
    listItems.forEach((listItem) => {
        listItem.addEventListener("click", () => {
            let valueAttribute = listItem.getAttribute("value");
            let item = listItem.closest(".item-vocabulary");

            let textElement = item.querySelector("p:nth-child(1)").textContent.trim();
            let gettyElement = item.querySelector("p:nth-child(2)").textContent.trim();

            Swal.fire({
                title: 'Edita la tècnica',
                
                html: `
                    <div style="display: flex; flex-direction: column; gap: 15px;">
                        <div style="display: flex; align-items: center; gap: 10px;">
                            <label for="tecnique_text" style="width: 100px; text-align: right;">Text:</label>
                            <input id="tecnique_text" class="swal2-input" value="${textElement}" style="flex: 1;">
                        </div>
                        <div style="display: flex; align-items: center; gap: 10px;">
                            <label for="getty_text" style="width: 100px; text-align: right;">Getty:</label>
                            <input id="getty_text" class="swal2-input" value="${gettyElement}" style="flex: 1;">
                        </div>
                    </div>
                `,
                focusConfirm: false,
                showCancelButton: true,
                cancelButtonText: 'Cancel·lar',
                confirmButtonText: 'Guardar',
                preConfirm: () => {
                    const text = document.getElementById("tecnique_text").value.trim();
                    const getty = document.getElementById("getty_text").value.trim();

                    if (!text || !getty) {
                        Swal.showValidationMessage('Tots els camps són obligatoris');
                        return false;
                    }

                    return { text, getty };
                },
            }).then((result) => {
                if (result.isConfirmed) {
                    const { text, getty } = result.value;

                    window.location.href = `index.php?page=vocabulari&edit_tecnique=${valueAttribute}&edit_tecnique_text=${text}&edit_tecnique_getty=${getty}`;
                }
            });
        });
    });
}


            


if (document.querySelector(".expositiontypes_edit_button")) {
    let listItems = document.querySelectorAll(".expositiontypes_edit_button");
    listItems.forEach((listItem) => {
        listItem.addEventListener("click", () => {
            let valueAttribute = listItem.getAttribute("value");
            let textElement = listItem.closest(".item-vocabulary").querySelector("p").textContent;

            Swal.fire({
                title: 'Introdueix el nou valor',
                input: 'text',
                inputValue: textElement.trim(),
                showCancelButton: true,
                cancelButtonText: 'Cancel·lar',
                confirmButtonText: 'Guardar',
                showLoaderOnConfirm: true,
                preConfirm: (value) => {
                    window.location.href = 'index.php?page=vocabulari' + '&edit_expositiontype=' + valueAttribute + '&edit_expositiontype_text=' + value;
                }
            });
        });
    });
}






if (document.querySelector(".entry_delete_button")) {
    let listItems = document.querySelectorAll(".entry_delete_button");
    listItems.forEach((listItem) => {
        listItem.addEventListener("click", () => {
            let valueAttribute = listItem.getAttribute("value");
            Swal.fire({
                icon: 'warning',
                title: 'Estàs segur en esborrar aquest element del vocabulari?',
                showConfirmButton: true,
                confirmButtonText: 'Si, esborrar',
                showCancelButton: true,
                cancelButtonText: 'Cancel·lar',
            }).then((result) => {
                if (result.isConfirmed) {
                   window.location.href = 'index.php?page=vocabulari' + '&delete_entry=' + valueAttribute;
                }
            });
        })
    })
}

if (document.querySelector(".cancelcause_delete_button")) {
    let listItems = document.querySelectorAll(".cancelcause_delete_button");
    listItems.forEach((listItem) => {
        listItem.addEventListener("click", () => {
            let valueAttribute = listItem.getAttribute("value");
            Swal.fire({
                icon: 'warning',
                title: 'Estàs segur en esborrar aquest element del vocabulari?',
                showConfirmButton: true,
                confirmButtonText: 'Si, esborrar',
                showCancelButton: true,
                cancelButtonText: 'Cancel·lar',
            }).then((result) => {
                if (result.isConfirmed) {
                   window.location.href = 'index.php?page=vocabulari' + '&delete_cancelcause=' + valueAttribute;
                }
            });
        })
    })
}

if (document.querySelector(".conservationstatus_delete_button")) {
    let listItems = document.querySelectorAll(".conservationstatus_delete_button");
    listItems.forEach((listItem) => {
        listItem.addEventListener("click", () => {
            let valueAttribute = listItem.getAttribute("value");
            Swal.fire({
                icon: 'warning',
                title: 'Estàs segur en esborrar aquest element del vocabulari?',
                showConfirmButton: true,
                confirmButtonText: 'Si, esborrar',
                showCancelButton: true,
                cancelButtonText: 'Cancel·lar',
            }).then((result) => {
                if (result.isConfirmed) {
                   window.location.href = 'index.php?page=vocabulari' + '&delete_conservationstatus=' + valueAttribute;
                }
            });
        })
    })
}

if (document.querySelector(".expositiontypes_delete_button")) {
    let listItems = document.querySelectorAll(".expositiontypes_delete_button");
    listItems.forEach((listItem) => {
        listItem.addEventListener("click", () => {
            let valueAttribute = listItem.getAttribute("value");
            Swal.fire({
                icon: 'warning',
                title: 'Estàs segur en esborrar aquest element del vocabulari?',
                showConfirmButton: true,
                confirmButtonText: 'Si, esborrar',
                showCancelButton: true,
                cancelButtonText: 'Cancel·lar',
            }).then((result) => {
                if (result.isConfirmed) {
                   window.location.href = 'index.php?page=vocabulari' + '&delete_expositiontype=' + valueAttribute;
                }
            });
        })
    })
}

if (document.querySelector(".author_delete_button")) {
    let listItems = document.querySelectorAll(".author_delete_button");
    listItems.forEach((listItem) => {
        listItem.addEventListener("click", () => {
            let valueAttribute = listItem.getAttribute("value");
            Swal.fire({
                icon: 'warning',
                title: 'Estàs segur en esborrar aquest element del vocabulari?',
                showConfirmButton: true,
                confirmButtonText: 'Si, esborrar',
                showCancelButton: true,
                cancelButtonText: 'Cancel·lar',
            }).then((result) => {
                if (result.isConfirmed) {
                   window.location.href = 'index.php?page=vocabulari' + '&delete_author=' + valueAttribute;
                }
            });
        })
    })
}

if(document.querySelector(".datation_delete_button")) {
    let listItems = document.querySelectorAll(".datation_delete_button");
    listItems.forEach((listItem) => {
        listItem.addEventListener("click", () => {
            let valueAttribute = listItem.getAttribute("value");
            Swal.fire({
                icon: 'warning',
                title: 'Estàs segur en esborrar aquesta datació del vocabulari?',
                showConfirmButton: true,
                confirmButtonText: 'Si, esborrar',
                showCancelButton: true,
                cancelButtonText: 'Cancel·lar',
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = 'index.php?page=vocabulari' + '&delete_datation=' + valueAttribute;
                }
            });
        })
    })
}

if (document.querySelector(".genericclassifications_delete_button")) {
    let listItems = document.querySelectorAll(".genericclassifications_delete_button");
    listItems.forEach((listItem) => {
        listItem.addEventListener("click", () => {
            let valueAttribute = listItem.getAttribute("value");
            Swal.fire({
                icon: 'warning',
                title: 'Estàs segur en esborrar aquest element del vocabulari?',
                showConfirmButton: true,
                confirmButtonText: 'Si, esborrar',
                showCancelButton: true,
                cancelButtonText: 'Cancel·lar',
            }).then((result) => {
                if (result.isConfirmed) {
                   window.location.href = 'index.php?page=vocabulari' + '&delete_genericclassification=' + valueAttribute;
                }
            });
        })
    })
}

if (document.querySelector(".material_delete_button")) {
    let listItems = document.querySelectorAll(".material_delete_button");
    listItems.forEach((listItem) => {
        listItem.addEventListener("click", () => {
            let valueAttribute = listItem.getAttribute("value");
            Swal.fire({
                icon: 'warning',
                title: 'Estàs segur en esborrar aquest element del vocabulari?',
                showConfirmButton: true,
                confirmButtonText: 'Si, esborrar',
                showCancelButton: true,
                cancelButtonText: 'Cancel·lar',
            }).then((result) => {
                if (result.isConfirmed) {
                   window.location.href = 'index.php?page=vocabulari' + '&delete_material=' + valueAttribute;
                }
            });
        })
    })
}

if (document.querySelector(".tecnique_delete_button")) {
    let listItems = document.querySelectorAll(".tecnique_delete_button");
    listItems.forEach((listItem) => {
        listItem.addEventListener("click", () => {
            let valueAttribute = listItem.getAttribute("value");
            Swal.fire({
                icon: 'warning',
                title: 'Estàs segur en esborrar aquest element del vocabulari?',
                showConfirmButton: true,
                confirmButtonText: 'Si, esborrar',
                showCancelButton: true,
                cancelButtonText: 'Cancel·lar',
            }).then((result) => {
                if (result.isConfirmed) {
                   window.location.href = 'index.php?page=vocabulari' + '&delete_tecnique=' + valueAttribute;
                }
            });
        })
    })
}

if (document.querySelector(".object_delete_button")) {
    let listItems = document.querySelectorAll(".object_delete_button");
    listItems.forEach((listItem) => {
        listItem.addEventListener("click", () => {
            let valueAttribute = listItem.getAttribute("value");
            Swal.fire({
                icon: 'warning',
                title: 'Estàs segur en esborrar aquest element del vocabulari?',
                showConfirmButton: true,
                confirmButtonText: 'Si, esborrar',
                showCancelButton: true,
                cancelButtonText: 'Cancel·lar',
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = 'index.php?page=vocabulari' + '&delete_object=' + valueAttribute;
                }
            });
        }
        );
    }
    );
}

if (document.querySelector(".getty_delete_button")) {
    let listItems = document.querySelectorAll(".getty_delete_button");
    listItems.forEach((listItem) => {
        listItem.addEventListener("click", () => {
            let valueAttribute = listItem.getAttribute("value");
            Swal.fire({
                icon: 'warning',
                title: 'Estàs segur en esborrar aquest element del vocabulari?',
                showConfirmButton: true,
                confirmButtonText: 'Si, esborrar',
                showCancelButton: true,
                cancelButtonText: 'Cancel·lar',
            }).then((result) => {
                if (result.isConfirmed) {
                   window.location.href = 'index.php?page=vocabulari' + '&delete_getty=' + valueAttribute;
                }
            });
        })
    })
}


if (document.querySelector("#new_entry_type")) {
    let newEntryType = document.querySelector("#new_entry_type");
    newEntryType.addEventListener("click", () => {
        let newText = document.querySelector("#new_entry_type_value").value;
        window.location.href = 'index.php?page=vocabulari' + '&add_entry=' + newText;
    })
}

if (document.querySelector("#new_cancelcause")) {
    let newEntryType = document.querySelector("#new_cancelcause");
    newEntryType.addEventListener("click", () => {
        let newText = document.querySelector("#new_cancelcause_value").value;
        window.location.href = 'index.php?page=vocabulari' + '&add_cancelcause=' + newText;
    })
}

if (document.querySelector("#new_conservationstatus")) {
    let newEntryType = document.querySelector("#new_conservationstatus");
    newEntryType.addEventListener("click", () => {
        let newText = document.querySelector("#new_conservationstatus_value").value;
        window.location.href = 'index.php?page=vocabulari' + '&add_conservationstatus=' + newText;
    })
}

if (document.querySelector("#new_expositiontype")) {
    let newEntryType = document.querySelector("#new_expositiontype");
    newEntryType.addEventListener("click", () => {
        let newText = document.querySelector("#new_expositiontype_value").value;
        window.location.href = 'index.php?page=vocabulari' + '&add_expositiontype=' + newText;
    })
}

if (document.querySelector("#new_author")) {
    let newEntryType = document.querySelector("#new_author");
    newEntryType.addEventListener("click", () => {
        let newText = document.querySelector("#new_author_value").value;
        let newGetty = document.querySelector("#new_author_getty").value;
        window.location.href = 'index.php?page=vocabulari' + '&add_author=' + newText + '&add_author_getty=' + newGetty;
    })
}

if (document.querySelector("#new_genericclassifications")) {
    let newEntryType = document.querySelector("#new_genericclassifications");
    newEntryType.addEventListener("click", () => {
        let newText = document.querySelector("#new_genericclassifications_value").value;
        window.location.href = 'index.php?page=vocabulari' + '&add_genericclassification=' + newText;
    })
}

if (document.querySelector("#new_material")) {
    let newMaterialButton = document.querySelector("#new_material");
    newMaterialButton.addEventListener("click", () => {
        let newText = document.querySelector("#new_material_value").value;
        let newMaterialGetty = document.querySelector("#new_material_getty").value;
        window.location.href = 'index.php?page=vocabulari' + '&add_material=' + newText + '&add_material_getty=' + newMaterialGetty;
    });
}



if (document.querySelector("#new_tecnique")) {
    let newEntryType = document.querySelector("#new_tecnique");
    newEntryType.addEventListener("click", () => {
        let newText = document.querySelector("#new_tecnique_value").value;
        let newGetty = document.querySelector("#new_tecnique_getty").value;
        window.location.href = 'index.php?page=vocabulari' + '&add_tecnique=' + newText + '&add_tecnique_getty=' + newGetty;
    })
}
if (document.querySelector("#new_object")) {
    let newEntryType = document.querySelector("#new_object");
    newEntryType.addEventListener("click", () => {
        let newText = document.querySelector("#new_object_value").value;
        let newGetty = document.querySelector("#new_object_getty").value;
        window.location.href = 'index.php?page=vocabulari' + '&add_object=' + newText + '&add_object_getty=' + newGetty;
    })
}

if (document.querySelector("#new_getty")) {
    let newEntryType = document.querySelector("#new_getty");
    newEntryType.addEventListener("click", () => {
        let newText = document.querySelector("#new_getty_value").value;
        window.location.href = 'index.php?page=vocabulari' + '&add_getty=' + newText;
    })
}

if (document.querySelector("#new_datation")) {
    let newDatationButton = document.querySelector("#new_datation");
    newDatationButton.addEventListener("click", () => {
        let newText = document.querySelector("#new_datation_value").value;
        let newStartDate = document.querySelector("#new_datation_value1").value;
        let newEndDate = document.querySelector("#new_datation_value2").value;
        window.location.href = 'index.php?page=vocabulari' + '&add_datation=' + newText + '&start_date=' + newStartDate + '&end_date=' + newEndDate;
    });
}
