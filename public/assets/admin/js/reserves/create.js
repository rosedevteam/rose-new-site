const createProduct = document.querySelector('#createNewProduct');


if (createProduct) {
    const fv = FormValidation.formValidation(createProduct, {
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
