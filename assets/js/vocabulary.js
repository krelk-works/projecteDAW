
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