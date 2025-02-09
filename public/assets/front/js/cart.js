let addToCart =  $('#add-to-cart');
let removeBtn = $('.remove-from-cart');
// let addDiscount = $('#submit-discount');
// let deleteDiscount = $('#delete-discount');

addToCart.on('click' , function (e ) {
    e.preventDefault();
    axios.post(`/cart/add/${$(this).attr('data-product')}` , {
        quantity: $('#pr-quantity').val()
    })
        .then(function (res) {
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
                icon: "success",
                title: "موفق",
                text: res.data.message,
                confirmButtonText: 'مشاهده سبد خرید'
            }).then(res => {
                if (res.isConfirmed) {
                    window.location.replace('/cart')
                }
            })
            $('.rose-cart-counter').html(res.data.count)
            $('.cart-total').html(`
            ${res.data.cart_total_price.toLocaleString()}
            تومان
            `);
            $('#nav-cart-inner').append(`
             <li class="parent-cart-item">
                        <div class="product product-widget  pb-3" style="border-bottom: solid #e7e7e7 1px">
                            <figure class="product-main">
                                <a href="products/${res.data.added_item.slug}">
                                    <img src="${res.data.added_item.image}" class="product-main-image">
                                </a>
                            </figure>
                            <div class="product-details">

                                <div class="product-title">
                                    <h3>
                                                  <a href="products/${res.data.added_item.slug}">
                                            ${res.data.added_item.title}
                                        </a>
                                    </h3>
                                </div>

                            </div>
                            <div class="remove-from-cart" data-cart="${res.data.added_item_id}">
                                <a role="button">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                         xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                              d="M15.5457 21.0038H8.45991C7.28371 21.0038 6.30581 20.0982 6.2156 18.9255L5.25 6.37268H18.7556L17.79 18.9255C17.6998 20.0982 16.7219 21.0038 15.5457 21.0038V21.0038Z"
                                              stroke="#E06983" stroke-width="1.5" stroke-linecap="round"
                                              stroke-linejoin="round"/>
                                        <path d="M20.0028 6.37264H3.99609" stroke="#E06983"
                                              stroke-width="1.5" stroke-linecap="round"
                                              stroke-linejoin="round"/>
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                              d="M9.18797 2.99622H14.8153C15.4369 2.99622 15.9408 3.50011 15.9408 4.12168V6.37262H8.0625V4.12168C8.0625 3.50011 8.56639 2.99622 9.18797 2.99622Z"
                                              stroke="#E06983" stroke-width="1.5" stroke-linecap="round"
                                              stroke-linejoin="round"/>
                                        <path d="M13.969 10.8745V16.5019" stroke="#E06983"
                                              stroke-width="1.5" stroke-linecap="round"
                                              stroke-linejoin="round"/>
                                        <path d="M10.0315 10.8745V16.5019" stroke="#E06983"
                                              stroke-width="1.5" stroke-linecap="round"
                                              stroke-linejoin="round"/>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </li>
            `)
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
});
removeBtn.on('click' , function (e) {
    e.preventDefault()
    let item =  $(this).closest('.parent-cart-item')
    axios.delete(`/cart/delete/${$(this).attr('data-cart')}`)
        .then(function (res) {
            item.remove()
            $('.cart-total').html(`
            ${res.data.total.toLocaleString()}
            تومان
            `);

            $('.rose-cart-counter').html(res.data.count)
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
            if (res.data.count == 0) {
                $('.cart-page-inner').html(`
                    <div class="alert alert-info m-4" role="alert" dir="rtl">
                                             هیچ محصولی در سبد خرید شما نیست
                                         </div>
                `)
                // deleteDiscount();
            }
            if (res.data.discount == true) {
                if (res.data.is_cart_discountable == false) {
                    deleteDiscount();
                }
            }

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
})

function addDiscount() {
    event.preventDefault();
    axios.post('/discount/check' , {
        cart: $('#cart-name').val(),
        discount: $('#discount-code').val()
    })
        .then(res => {
            window.location.reload()
            $.unblockUI();

        })
        .catch(err => {
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
}

function deleteDiscount() {
    event.preventDefault();

    axios.post('/discount/delete' , {
        data: {
            cart: $('#cart-name').val()
        }
    })
        .then(res => {
            window.location.reload()
            $.unblockUI();
        })
        .catch(err => {
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
}
