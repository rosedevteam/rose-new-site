

persianNumbers = [/۰/g, /۱/g, /۲/g, /۳/g, /۴/g, /۵/g, /۶/g, /۷/g, /۸/g, /۹/g]
arabicNumbers = [/٠/g, /١/g, /٢/g, /٣/g, /٤/g, /٥/g, /٦/g, /٧/g, /٨/g, /٩/g]
convertToEnglishDigits = function (str) {
    if (typeof str === 'string') {
        for (var i = 0; i < 10; i++) {
            str = str.replace(persianNumbers[i], i).replace(arabicNumbers[i], i);
        }
    }
    return str;
};

function createItem() {
    //before ajax request this section clear the message input value

    axios({
        url: '/kara-fa/telegramSubscriptions',
        method: 'POST',
        data: {
            name: $('#name').val(),
            duration: $('#duration').val(),
            price: $('#price').val(),
            product_id: $('#product_id').val()
        }
    })
        .then(function (response) {
            window.location.reload()

        })
        .catch(function (response) {
            const Toast = Swal.mixin({
                toast: true,
                position: "bottom-left",
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.onmouseenter = Swal.stopTimer;
                    toast.onmouseleave = Swal.resumeTimer;
                }
            });
            Toast.fire({
                icon: "error",
                // title: response.response.message
            });
            console.log(response)
        })

}

function editItem(id) {
    //before ajax request this section clear the message input value
    axios.interceptors.request.use(function (config) {
        $.blockUI({
            message:
                '<div class="d-flex justify-content-center"><p class="mb-0">لطفا صبر کنید...</p> <div class="sk-wave m-0 ms-2"><div class="sk-rect sk-wave-rect"></div> <div class="sk-rect sk-wave-rect"></div> <div class="sk-rect sk-wave-rect"></div> <div class="sk-rect sk-wave-rect"></div> <div class="sk-rect sk-wave-rect"></div></div> </div>',
            timeout: 1000,
            css: {
                backgroundColor: 'transparent',
                color: '#fff',
                border: '0',
                width: '80%'
            },
            overlayCSS: {
                opacity: 0.5
            }
        });

        return config
    });

    axios({
        url: `/kara-fa/telegramSubscriptions/${id}/edit`,
        method: 'GET',
    })
        .then(function (response) {
            $('#nameEdit').val(response.data.item.name)
            $('#durationEdit').val(response.data.item.duration)
            $('#priceEdit').val(response.data.item.price).toLocaleString()
            $('#edit-item-id').val(id)
        })


}


function updateItem() {
    //before ajax request this section clear the message input value
    axios.interceptors.request.use(function (config) {
        $.blockUI({
            message:
                '<div class="d-flex justify-content-center"><p class="mb-0">لطفا صبر کنید...</p> <div class="sk-wave m-0 ms-2"><div class="sk-rect sk-wave-rect"></div> <div class="sk-rect sk-wave-rect"></div> <div class="sk-rect sk-wave-rect"></div> <div class="sk-rect sk-wave-rect"></div> <div class="sk-rect sk-wave-rect"></div></div> </div>',
            timeout: 1000,
            css: {
                backgroundColor: 'transparent',
                color: '#fff',
                border: '0',
                width: '80%'
            },
            overlayCSS: {
                opacity: 0.5
            }
        });

        return config
    });

    axios({
        url: `/kara-fa/telegramSubscriptions/${$('#edit-item-id').val()}`,
        method: 'patch',
        data: {
            name: $('#nameEdit').val(),
            duration: $('#durationEdit').val(),
            price: $('#priceEdit').val(),
            product_id: $('#product_idEdit').val(),
            description: $('#descriptionEdit').val(),
        }
    })
        .then(function (response) {
            location.reload();
        })
        .catch(function (response) {
            const Toast = Swal.mixin({
                toast: true,
                position: "bottom-left",
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.onmouseenter = Swal.stopTimer;
                    toast.onmouseleave = Swal.resumeTimer;
                }
            });
            Toast.fire({
                icon: "error",
                title: response.response.data.message
            });
        })
}

// In your Javascript (external .js resource or <script> tag)
