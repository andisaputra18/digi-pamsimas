loadChildForRegion = async (e, select = null) => {
    let selects = document.querySelectorAll(".region");
    let load = await fetch(`//${window.location.hostname}/region/child/${e.value}`);
    let response = await load.json();
    console.log(response.data);
    let index;

    for( [key, value] of selects.entries() ) {
        if( e.getAttribute('id') === value.getAttribute('id')) index = key;
    }

    select = document.getElementById(select);
    let option_zero = select.children[0];

    if(select) {
        select.innerHTML = "";
        select.appendChild(option_zero);
        for await(value of response.data) {
            let option = document.createElement("option");
            option.value = value.id;
            option.innerHTML = value.name;
            select.appendChild(option);
        }
    }
}

loadModal = (button) => {
    let
    xhr         = new XMLHttpRequest,
    dataClass   = button.getAttribute('data-class'),
    url         = button.getAttribute('data-url'),
    title       = button.getAttribute('data-title'),
    modal       = document.getElementById(button.getAttribute('data-bs-target').slice(1)),
    modalDialog = modal.querySelector('.modal-dialog'),
    modalBody   = modal.querySelector('.modal-body');

    modalDialog.classList.add(dataClass);

    xhr.open('GET', `${url}`);
    xhr.send();

    xhr.onload = () => {
        if(xhr.status >= 200 && xhr.status < 300){
            let modalTitle = modal.querySelector('.modal-title');
            modalTitle.innerHTML = title;
            modalBody.innerHTML = xhr.response;
        }else{
            modalBody.innerHTML = `<h1 class="text-center">Terjadi kesalahan!</h1>`;
        }
    }

    xhr.onerror = () => {
        modalBody.innerHTML = `<h1 class="text-center">Terjadi kesalahan!</h1>`;
    }
}

function confirmDialog(e, text = '', button = 'Ubah') {
    Swal.fire({
        title: 'Apakah anda yakin?',
        text: text,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#33a4dd',
        cancelButtonColor: '#CBCBCB',
        confirmButtonText: button,
        cancelButtonText: 'Batal',
        reverseButtons: true
    }).then((result) => {
        if (result.value) {
            window.location.replace(e.getAttribute('href'))
        } else {
            return event.preventDefault();
        }
    })
}

function confirmDelete(e, text = '', button = 'Hapus') {
    Swal.fire({
        title: 'Apakah anda yakin?',
        text: text,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#CBCBCB',
        confirmButtonText: button,
        cancelButtonText: 'Batal',
        reverseButtons: true
    }).then((result) => {
        if (result.value) {
            window.location.replace(e.getAttribute('href'))
        } else {
            return event.preventDefault();
        }
    })
}

// function confirmDelete(e, text = '', button = 'Hapus') {
//     Swal.fire({
//         title: 'Apakah anda yakin?',
//         text: text,
//         icon: 'warning',
//         showCancelButton: true,
//         confirmButtonColor: '#d33',
//         cancelButtonColor: '#CBCBCB',
//         confirmButtonText: button,
//         cancelButtonText: 'Batal',
//         reverseButtons: true
//     }).then((result) => {
//         if (result.isConfirmed) {
//             $('#form-delete-data').submit();
//         }
//     })
// }
