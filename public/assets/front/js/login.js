axios.interceptors.request.use(function (config) {
    $.blockUI({
        message: `<div class="spinner-border text-white" role="status">
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
    return config;
}, function (error) {
    $.unblockUI();
    return Promise.reject(error);
});

axios.interceptors.response.use(function (response) {
    $.unblockUI();
    return response;
}, function (error) {
    $.unblockUI();
    return Promise.reject(error);
});

//validation
const formAuthentication = document.querySelector('#formLogin');

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
            }
        },
        plugins: {
            trigger: new FormValidation.plugins.Trigger(),
            bootstrap5: new FormValidation.plugins.Bootstrap5({
                eleValidClass: '',
                rowSelector: '.mb-3'
            }),
            // submitButton: new FormValidation.plugins.SubmitButton(),
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

    formAuthentication.addEventListener('submit', function (e) {
        e.preventDefault(); // جلوگیری از ارسال پیش‌فرض فرم

        fv.validate().then(function (status) {
            if (status === 'Valid') {
                e.preventDefault()

                axios.post('/login/auth', {
                    phone: $('#phone').val()
                })
                    .then(function (res) {
                        if (res.data.is_signed_up) {
                            $('#subtitle-login').html(`
                لطفا کد 6 رقمی ارسال شده به شماره
                  <strong>${res.data.phone}</strong>
                  را وارد کنید
                `)
                            $('.login-form-elements').html(createTwoStepForm(true));
                            twoStepForm();

                        } else {
                            $('.login-form-elements').html(createTwoStepForm(false));
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
            }
        });
    });
}

function createTwoStepForm(is_signed_up) {
    return `
        <form id="twoStepsForm" data-is-signed-up="${is_signed_up}">
            <div class="mb-3">
                <div class="auth-input-wrapper d-flex align-items-center justify-content-sm-between numeral-mask-wrapper" dir="ltr">
                    ${Array(6).fill('').map(() => `
                        <input type="number" class="form-control auth-input h-px-50 text-center numeral-mask text-center h-px-50 mx-1 my-2" maxlength="1" required>
                    `).join('')}
                </div>
                <input type="hidden" name="otp" id="otp">
            </div>

            <button type="submit" class="btn btn-default w-100">ورود </button>
        </form>
    `;
}

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


        $('#twoStepsForm').submit(function (e) {
            e.preventDefault()
            if ($('#twoStepsForm').attr('data-is-signed-up') == true) {
                axios.post('/login/token', {
                    otp: $('#otp').val()
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
                        window.location.replace(res.data.redirect)
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
            }else {
                axios.post('/register/token', {
                    otp: $('#otp').val()
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
                        window.location.replace(res.data.redirect)
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
            }



        })
    }
}

function createRegisterForm() {
    return `
      <form id="registerForm">
                            <div class="mb-3">
                                <label for="first_name" class="form-label mt-4">نام</label>
                                <input type="text" id="first_name" name="first_name" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="last_name" class="form-label mt-4">نام خانوادگی</label>
                                <input type="text" id="last_name" name="last_name" class="form-control" required>
                            </div>
            <button type="submit" class="btn btn-default w-100">ادامه </button>

                        </form>
    `;
}




