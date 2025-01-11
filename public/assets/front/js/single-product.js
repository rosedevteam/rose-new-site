let addToCart =  $('#add-to-cart');

addToCart.on('click' , function (e ) {
    e.preventDefault();
    axios.post(`/cart/add/${$(this).attr('data-product')}` , {
        quantity: $('#pr-quantity').val()
    })
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
            $.unblockUI();

        })
        .catch(function (err) {
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
                text: err.response.data.message
            });
            $.unblockUI();
        })
});

function addToCartSingleProduct(product) {
    let quantity = $('#add-to-cart-quantity').val();
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': document.head.querySelector('meta[name="csrf-token"]').content,
            'Content-Type': 'application/json'
        }
    })
    $.ajax({
        type: 'POST',
        url: `/cart/add/${product}`,
        data: JSON.stringify({
            product: product,
            quantity: quantity,
            _method: 'post'
        }),

        beforeSend: function () {
            $('.add-to-cart-loader').show();
            $('.add-to-cart-text').hide();
        }, //Show spinner
        complete: function (response) {
            $('.add-to-cart-loader').hide();
            $('.add-to-cart-text').show();
            if (response.responseJSON.success == true) {
                Swal.fire({
                    icon: 'success',
                    title: 'موفق',
                    text: response.responseJSON.data,
                    footer: '<a href="https://icworldco.com/cart">مشاهده سبد خرید</a>',
                    confirmButtonText: 'باشه'
                });
                $('#header-cart-items').text(response.responseJSON.cart_items);
                $('#footer-cart-items').text(response.responseJSON.cart_items);
                $('#header-cart-total-price').text(parseInt(response.responseJSON.cart_total_price).toLocaleString())
            }
            if (response.responseJSON.success != true) {
                Swal.fire({
                    icon: 'error',
                    title: 'خطا',
                    text: response.responseJSON.data,
                    footer: '<a href="https://icworldco.com/cart">مشاهده سبد خرید</a>',
                    confirmButtonText: 'باشه'
                });
            }

        },
    });

}
