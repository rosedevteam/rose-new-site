'use strict';

const form = document.querySelector('#birthday-form')
const modal = $('#set-birthday-modal')

$(function () {
    modal.modal('show')
    $(".date-picker").persianDatepicker({
        initialValue: false,
        format: 'YYYY/MM/DD',
        autoClose: true,
    });

    const fv = FormValidation.formValidation(form, {
        fields: {
            birthday: {
                validators: {
                    notEmpty: {
                        message: 'لطفا تاریخ تولد خود را وارد کنید'
                    },
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
    })

    form.addEventListener('submit', function (e) {
        e.preventDefault()

        fv.validate().then(function (status) {
            if (status === 'Valid') {
                e.preventDefault()
                const birthday = document.querySelector('#birthday').value

                axios.post('/users/birthday', {birthday})
                    .then(function (res) {
                        if (res.data.success) {
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

                            modal.modal('hide')
                            $.unblockUI()
                        }
                    }).catch(e, function () {
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
                    }
                )
            }
        })
    })
})
