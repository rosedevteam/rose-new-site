

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
                        $('#subtitle-login').html(`
                لطفا کد 6 رقمی ارسال شده به شماره
                  <strong>${res.data.phone}</strong>
                  را وارد کنید
                `)
                        if (res.data.is_signed_up == true) {
                            $('.login-form-elements').html(createTwoStepForm(true, res.data.phone));
                            twoStepForm(res.data.phone);

                        } else {
                            axios.post('/register/auth', {
                                phone: res.data.phone
                            })
                            $('.login-form-elements').html(createTwoStepForm(false, res.data.phone));
                            twoStepForm(res.data.phone);

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


function createTwoStepForm(is_signed_up, phone) {
    return `
        <form id="twoStepsForm" data-is-signed-up="${is_signed_up}" data-phone="${phone}">
            <div class="mb-3">
                <div class="auth-input-wrapper d-flex align-items-center justify-content-sm-between numeral-mask-wrapper" dir="ltr">
                    ${Array(6).fill('').map(() => `
                        <input type="number" class="form-control auth-input h-px-50 text-center numeral-mask text-center h-px-50 mx-1 my-2" maxlength="1" required>
                    `).join('')}
                </div>
                <input type="hidden" name="otp" id="otp">
            </div>
            <div class="d-flex flex-column align-items-center justify-content-center">
            <div class="countdown my-2"></div>
            <div class="refresh my-2"></div>
</div>
            <button type="submit" class="btn btn-default w-100">ورود </button>
        </form>
    `;
}

function countdownTimer() {
    var timer2 = "02:01";
    var interval = setInterval(function () {

        var timer = timer2.split(':');
        //by parsing integer, I avoid all extra string processing
        var minutes = parseInt(timer[0], 10);
        var seconds = parseInt(timer[1], 10);
        --seconds;
        minutes = (seconds < 0) ? --minutes : minutes;
        seconds = (seconds < 0) ? 59 : seconds;
        seconds = (seconds < 10) ? '0' + seconds : seconds;
        //minutes = (minutes < 10) ?  minutes : minutes;
        $('.countdown').html(minutes + ':' + seconds);
        if (minutes < 0) clearInterval(interval);
        //check if both minutes and seconds are 0
        if ((seconds <= 0) && (minutes <= 0)) {
            clearInterval(interval);
            $('.refresh').show()
            $('.refresh').html(
                `<a class="btn btn-link" onclick="refreshToken($('#twoStepsForm').attr('data-phone') , $('#twoStepsForm').attr('data-is-signed-up'))">ارسال مجدد کد تایید</a>`
            )
        }
        timer2 = minutes + ':' + seconds;
    }, 1000);

}

function refreshToken(phone, is_signed_up) {
    if (is_signed_up == 'true') {
        axios.post('/login/auth', {
            phone: phone
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
                $('.refresh').hide();

                countdownTimer();
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
    } else {
        axios.post('/register/auth', {
            phone: phone
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
                $('.refresh').hide();
                countdownTimer();
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
}

function twoStepForm(phone) {
    countdownTimer()
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
            if ($('#twoStepsForm').attr('data-is-signed-up') == 'true') {
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
            } else {
                axios.post('/register/token', {
                    otp: $('#otp').val(),
                    phone: phone
                })
                    .then(function (res) {
                        $('.login-form-elements').html(createEnterNameLastNameForm());
                        updateUser(res.data.phone);
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


function createEnterNameLastNameForm() {
    return `
      <form id="updateUser">
                            <div class="mb-3">
                                <label for="first_name" class="form-label mt-4">نام</label>
                                <input type="text" id="first_name" name="first_name" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="last_name" class="form-label mt-4">نام خانوادگی</label>
                                <input type="text" id="last_name" name="last_name" class="form-control" required>
                            </div>
            <button type="submit" class="btn btn-default w-100">ورود </button>

                        </form>
    `;
}

function updateUser(phone) {
    $('#updateUser').submit(function (e) {
        e.preventDefault();
        axios.post(`register`, {
            first_name: $('#first_name').val(),
            last_name: $('#last_name').val(),
            phone: phone
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
    })
}
