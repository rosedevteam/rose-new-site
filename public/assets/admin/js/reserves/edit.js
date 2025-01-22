//validation
const EditProduct = document.querySelector('#EditProduct');

if (EditProduct) {
    const fv = FormValidation.formValidation(EditProduct, {
        fields: {
            title: {
                validators: {
                    notEmpty: {
                        message: 'لطفا نام را وارد کنید'
                    }
                }
            },
            price: {
                validators: {
                    notEmpty: {
                        message: 'لطفا قیمت را وارد کنید'
                    },
                    numeric: {
                        message: 'قیمت باید عدد باشد'
                    }
                }
            }
        },
        plugins: {
            trigger: new FormValidation.plugins.Trigger(),
            bootstrap5: new FormValidation.plugins.Bootstrap5({
                eleValidClass: '',
            }),
            submitButton: new FormValidation.plugins.SubmitButton(),

            defaultSubmit: new FormValidation.plugins.DefaultSubmit(),
            autoFocus: new FormValidation.plugins.AutoFocus()
        },
        init: instance => {
            instance.on('plugins.message.placed', function (e) {
                if (e.element.parentElement.classList.contains('input-group')) {
                    e.element.parentElement.insertAdjacentElement('afterend', e.messageElement);
                }
            });
        }
    });
}

let editTitle = $('#EditProduct #title');
let editPrice = $('#EditProduct #price');
let editSalePrice = $('#EditProduct #sale_price');
let editProductId = $('#EditProduct #edit-product-id');
let stockStatus = $('#EditProduct #is_in_stock');
let isReservable = $('#EditProduct #is_reservable');

//get item details with ajax request
function editItem(id) {

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('#csrf').attr('content'),
            'Content-Type': 'application/json'
        }
    })

    $.ajax({
        type: 'get',
        url: `products/${id}/edit`,
        beforeSend: function () {
            $('#modalEdit .modal-content').block({
                message:
                    '<div class="sk-wave mx-auto"><div class="sk-rect sk-wave-rect"></div> <div class="sk-rect sk-wave-rect"></div> <div class="sk-rect sk-wave-rect"></div> <div class="sk-rect sk-wave-rect"></div> <div class="sk-rect sk-wave-rect"></div></div>',
                timeout: 1000,
                css: {
                    backgroundColor: 'transparent',
                    color: '#fff',
                    border: '0'
                },
                overlayCSS: {
                    opacity: 0.5
                }
            });
        },
        complete: function (res) {
            $('#not_in_stock').removeAttr('selected')
            $('#in_stock').removeAttr('selected')
            $('#can_reserve').removeAttr('selected')
            $('#cant_reserve').removeAttr('selected')

            editTitle.val(res.responseJSON.title);
            editPrice.val(res.responseJSON.price);
            editSalePrice.val(res.responseJSON.sale_price);
            $('#edit-product-id').val(res.responseJSON.id);
            if (res.responseJSON.is_in_stock == 1) {
                $('#in_stock').attr('selected', 'selected')
            } else {
                $('#not_in_stock').attr('selected', 'selected')
            }
            if (res.responseJSON.is_reservable == 1) {
                $('#can_reserve').attr('selected', 'selected')
            } else {
                $('#cant_reserve').attr('selected', 'selected')
            }
        }
    })


}

function updateItem(e) {
    e.preventDefault();
    let id = $('#edit-product-id').val();
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('#csrf').attr('content'),
            'Content-Type': 'application/json'
        }
    });

    axios.interceptors.request.use(function (config) {
        $.blockUI({
            message:
                '<div class="d-flex justify-content-center"><p class="mb-0">لطفا صبر کنید ...</p> <div class="sk-wave m-0 ms-2"><div class="sk-rect sk-wave-rect"></div> <div class="sk-rect sk-wave-rect"></div> <div class="sk-rect sk-wave-rect"></div> <div class="sk-rect sk-wave-rect"></div> <div class="sk-rect sk-wave-rect"></div></div> </div>',
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

    axios.patch(`/kar-fa/products/${id}`, {
        title: editTitle.val(),
        price: editPrice.val(),
        sale_price: editSalePrice.val(),
        is_in_stock: stockStatus.val(),
        is_reservable: isReservable.val(),
        is_free: null
    })

        .then((response) => {
            location.reload()
        })

}
