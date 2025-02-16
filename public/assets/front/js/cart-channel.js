let cartChannelSelector = $('#telegram');

cartChannelSelector.on('change' , function (e) {
    let cart = $('#cart-id').val()
    axios.post(`/cart/updateTelegramSub/${cart}` , {
        telegram_subscription: $(this).val()
    })
        .then(function (res) {
            const Toast = Swal.mixin({
                toast: true,
                position: "top-end",
                showConfirmButton: false,
                customClass: {
                    confirmButton: "btn btn-sm btn-default w-100"
                },
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
                text: res.data.message,
            })
            window.location.reload()
            $.unblockUI();

        })
        .catch(function (err) {
            const Toast = Swal.mixin({
                toast: true,
                position: "top-end",
                showConfirmButton: true,
                customClass: {
                    confirmButton: "btn btn-sm btn-default w-100"
                },
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
                text: err.response.data.message,
                confirmButtonText: 'مشاهده سبد خرید'

            }).then(res => {
                if (res.isConfirmed) {
                    window.location.replace('/cart')
                }
            })
            $.unblockUI();
        })
})
