const reserveButton = document.querySelector('#reserve')

reserveButton.addEventListener('click', function () {

    axios.post(`/reserve/${this.getAttribute('data-product')}`)
        .then(function (res) {
            const Toast = Swal.mixin({
                toast: true,
                position: "top-end",
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.onmouseenter = Swal.stopTimer;
                    toast.onmouseleave = Swal.resumeTimer;
                }
            });
            Toast.fire({
                icon: "success",
                title: "موفق",
                text: res.data.message
            });
            reserveButton.textContent = 'رزرو شده'
            $.unblockUI();
        }).catch(function (e) {

        const Toast = Swal.mixin({
            toast: true,
            position: "top-end",
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.onmouseenter = Swal.stopTimer;
                toast.onmouseleave = Swal.resumeTimer;
            }
        });
        Toast.fire({
            icon: "warning",
            title: "خطا",
            text: e.response.data.message
        });
        $.unblockUI();
    })
})
