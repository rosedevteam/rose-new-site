//validation
const formAuthentication = document.querySelector('#loginForm');

if (formAuthentication) {
    const fv = FormValidation.formValidation(formAuthentication, {
        fields: {
            phone: {
                validators: {
                    notEmpty: {
                        message: 'لطفا موبایل را وارد کنید'
                    },
                    regexp: {
                        regexp: '9(0(\\d)|1(\\d)|2(\\d)|3(\\d)|(9(\\d)))\\d{7}$',
                        message: 'موبایل نادرست وارد شده است'
                    }
                }
            },
            password: {
                validators: {
                    notEmpty: {
                        message: 'لطفا رمز عبور خود را وارد کنید'
                    }
                }
            },
        },
        plugins: {
            trigger: new FormValidation.plugins.Trigger(),
            bootstrap5: new FormValidation.plugins.Bootstrap5({
                eleValidClass: '',
                rowSelector: '.mb-3'
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

$('#loginForm').submit( function (e) {
    e.preventDefault()
    axios.interceptors.request.use(function (config) {
        $.blockUI({
            message:
                `   <div class="spinner-border text-white" role="status">
                          <span class="visually-hidden">در حال بارگذاری ...</span>
                        </div>`,
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

    axios.post('/auth', {
        phone: $('#phone').val()
    })
        .then(function (res) {
            if (res.data.is_signed_up) {
                $('.login-form-elements').html(`
                    <form id="twoStepsForm">
                        <div class="mb-3">
                            <div
                                class="auth-input-wrapper d-flex align-items-center justify-content-sm-between numeral-mask-wrapper" dir="ltr">
                                <input type="number"
                                       class="form-control auth-input h-px-50 text-center numeral-mask text-center h-px-50 mx-1 my-2"
                                       maxlength="1" autofocus>
                                <input type="number"
                                       class="form-control auth-input h-px-50 text-center numeral-mask text-center h-px-50 mx-1 my-2"
                                       maxlength="1">
                                <input type="number"
                                       class="form-control auth-input h-px-50 text-center numeral-mask text-center h-px-50 mx-1 my-2"
                                       maxlength="1">
                                <input type="number"
                                       class="form-control auth-input h-px-50 text-center numeral-mask text-center h-px-50 mx-1 my-2"
                                       maxlength="1">
                                <input type="number"
                                       class="form-control auth-input h-px-50 text-center numeral-mask text-center h-px-50 mx-1 my-2"
                                       maxlength="1">
                                <input type="number"
                                       class="form-control auth-input h-px-50 text-center numeral-mask text-center h-px-50 mx-1 my-2"
                                       maxlength="1">
                            </div>
                            <!-- Create a hidden field which is combined by 3 fields above -->
                            <input type="hidden" name="otp">
                        </div>
                        <a class="btn btn-default w-100" role="button" id="login-submit">ورود</a>

                    </form>
                `)
                twoStepForm()
            } else {
                console.log(res.data.is_signed_up)
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


function twoStepForm() {
    const twoStepsForm = document.querySelector('#twoStepsForm');

// Form validation for Add new record
    if (twoStepsForm) {
        //  Two Steps Verification
        const numeralMask = document.querySelectorAll('.numeral-mask');

// Verification masking
        if (numeralMask.length) {
            numeralMask.forEach(e => {
                new Cleave(e, {
                    numeral: true
                });
            });
        }
        const fv = FormValidation.formValidation(twoStepsForm, {
            fields: {
                otp: {
                    validators: {
                        notEmpty: {
                            message: 'لطفا OTP را وارد کنید'
                        }
                    }
                }
            },
            plugins: {
                trigger: new FormValidation.plugins.Trigger(),
                bootstrap5: new FormValidation.plugins.Bootstrap5({
                    eleValidClass: '',
                    rowSelector: '.mb-3'
                }),
                submitButton: new FormValidation.plugins.SubmitButton(),

                defaultSubmit: new FormValidation.plugins.DefaultSubmit(),
                autoFocus: new FormValidation.plugins.AutoFocus()
            }
        });

        const numeralMaskList = twoStepsForm.querySelectorAll('.numeral-mask');
        const keyupHandler = function () {
            let otpFlag = true,
                otpVal = '';
            numeralMaskList.forEach(numeralMaskEl => {
                if (numeralMaskEl.value === '') {
                    otpFlag = false;
                    twoStepsForm.querySelector('[name="otp"]').value = '';
                }
                otpVal = otpVal + numeralMaskEl.value;
            });
            if (otpFlag) {
                twoStepsForm.querySelector('[name="otp"]').value = otpVal;
            }
        };
        numeralMaskList.forEach(numeralMaskEle => {
            numeralMaskEle.addEventListener('keyup', keyupHandler);
        });
        let maskWrapper = document.querySelector('.numeral-mask-wrapper');

        for (let pin of maskWrapper.children) {
            pin.onkeyup = function (e) {
                // While entering value, go to next
                if (pin.nextElementSibling) {
                    if (this.value.length === parseInt(this.attributes['maxlength'].value)) {
                        pin.nextElementSibling.focus();
                    }
                }

                // While deleting entered value, go to previous
                // Delete using backspace and delete
                if (pin.previousElementSibling) {
                    if (e.keyCode === 8 || e.keyCode === 46) {
                        pin.previousElementSibling.focus();
                    }
                }
            };
        }
    }
}



