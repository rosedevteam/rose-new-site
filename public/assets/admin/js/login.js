


//validation
const formAuthentication = document.querySelector('#formAuthentication');
const forgetPassForm = document.querySelector('#forgetPassForm');
const resetPassForm = document.querySelector('#resetPassForm');

if (formAuthentication) {
    const fv = FormValidation.formValidation(formAuthentication, {
        fields: {
            phone: {
                validators: {
                    notEmpty: {
                        message: 'لطفا موبایل را وارد کنید'
                    },
                    regexp : {
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

if(forgetPassForm) {
    const forgetPassValidation = FormValidation.formValidation(forgetPassForm, {
        fields: {
            phone: {
                validators: {
                    notEmpty: {
                        message: 'لطفا موبایل را وارد کنید'
                    },
                    regexp : {
                        regexp: '9(0(\\d)|1(\\d)|2(\\d)|3(\\d)|(9(\\d)))\\d{7}$',
                        message: 'موبایل نادرست وارد شده است'
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

if(resetPassForm) {
    const forgetPassValidation = FormValidation.formValidation(resetPassForm, {
        fields: {
            password: {
                validators: {
                    notEmpty: {
                        message: 'لطفا رمز عبور خود را وارد کنید'
                    },
                    stringLength: {
                        min: 6,
                        message: 'رمز عبور باید بیش از 6 کاراکتر باشد'
                    }
                }
            },
            'password-confirm': {
                validators: {
                    notEmpty: {
                        message: 'لطفا رمز عبور را تایید کنید'
                    },
                    identical: {
                        compare: function () {
                            return resetPassForm.querySelector('[name="password"]').value;
                        },
                        message: 'رمز عبور و تایید آن یکسان نیستند'
                    },
                    stringLength: {
                        min: 6,
                        message: 'رمز عبور باید بیش از 6 کاراکتر باشد'
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


const twoStepsForm = document.querySelector('#twoStepsForm');

// Form validation for Add new record
if (twoStepsForm) {
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
}


//loader
let pageBlockSpinner = $('.btn-page-block-spinner');

pageBlockSpinner.on('click', function () {
    $.blockUI({
        message:
            '<div class="sk-wave mx-auto"><div class="sk-rect sk-wave-rect"></div> <div class="sk-rect sk-wave-rect"></div> <div class="sk-rect sk-wave-rect"></div> <div class="sk-rect sk-wave-rect"></div> <div class="sk-rect sk-wave-rect"></div></div>',
        timeout: 1000,
        css: {
            backgroundColor: 'transparent',
            border: '0'
        },
        overlayCSS: {
            opacity: 0.5
        }
    });
});


var timer2 = "2:00";
var interval = setInterval(function() {
    $('#send-again').hide();
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
        $('#send-again').show();
        $('#timer').hide()
    }
    timer2 = minutes + ':' + seconds;
}, 1000);


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
