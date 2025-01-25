const createNewItem = document.querySelector('#createNewItem');


if (createNewItem) {
    const fv = FormValidation.formValidation(createNewItem, {
        fields: {
            expire_date: {
                validators: {
                    notEmpty: {
                        message: 'لطفا تاریخ را وارد کنید'
                    }
                }
            },
            description: {
                validators: {
                    notEmpty: {
                        message: 'لطفا توضیحات را وارد کنید'
                    }
                }
            },
            name: {
                validators: {
                    notEmpty: {
                        message: 'لطفا نام را وارد کنید'
                    }
                }
            },
        },
        plugins: {
            trigger: new FormValidation.plugins.Trigger(),
            bootstrap5: new FormValidation.plugins.Bootstrap5({
                eleValidClass: '',
            }),
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

$("#start_date").pDatepicker({
    "inline": false,
    "format": "YYYY/MM/DD",
    "viewMode": "day",
    "initialValue": false,
    "initialValueType": 'persian',
    "minDate": -1539487544000,
    "autoClose": true,
    "position": "auto",
    "altField": "#txtBirthday",
    "onlyTimePicker": false,
    "onlySelectOnDate": true,
    "calendarType": "persian",
    "inputDelay": 800,
    "observer": true,
    "calendar": {
        "persian": {
            "locale": "fa",
            "showHint": true,
            "leapYearMode": "algorithmic"
        }
    },
    "navigator": {
        "enabled": true,
        "scroll": {
            "enabled": true
        },
        "text": {
            "btnNextText": "<",
            "btnPrevText": ">"
        }
    },
    "toolbox": {
        "enabled": true,
        "calendarSwitch": {
            "enabled": false,
            "format": "MMMM"
        },
        "todayButton": {
            "enabled": true,
            "text": {
                "fa": "امروز",
                "en": "Today"
            }
        },
        "submitButton": {
            "enabled": true,
            "text": {
                "fa": "بستن",
                "en": "Submit"
            }
        },
        "text": {
            "btnToday": "امروز"
        }
    },
    "timePicker": {
        "enabled": false,
        "step": 1,
        "hour": {
            "enabled": true,
            "step": null
        },
        "minute": {
            "enabled": true,
            "step": null
        },
        "second": {
            "enabled": false,
            "step": null
        },
        "meridian": {
            "enabled": false
        }
    },
    "dayPicker": {
        "enabled": true,
        "titleFormat": "YYYY MMMM"
    },
    "monthPicker": {
        "enabled": true,
        "titleFormat": "YYYY"
    },
    "yearPicker": {
        "enabled": true,
        "titleFormat": "YYYY"
    },
    "responsive": true
});

$("#start_dateEdit").pDatepicker({
    "inline": false,
    "format": "YYYY/MM/DD",
    "viewMode": "day",
    "initialValue": false,
    "initialValueType": 'persian',
    "minDate": -1539487544000,
    "autoClose": true,
    "position": "auto",
    "altField": "#txtBirthday",
    "onlyTimePicker": false,
    "onlySelectOnDate": true,
    "calendarType": "persian",
    "inputDelay": 800,
    "observer": true,
    "calendar": {
        "persian": {
            "locale": "fa",
            "showHint": true,
            "leapYearMode": "algorithmic"
        }
    },
    "navigator": {
        "enabled": true,
        "scroll": {
            "enabled": true
        },
        "text": {
            "btnNextText": "<",
            "btnPrevText": ">"
        }
    },
    "toolbox": {
        "enabled": true,
        "calendarSwitch": {
            "enabled": false,
            "format": "MMMM"
        },
        "todayButton": {
            "enabled": true,
            "text": {
                "fa": "امروز",
                "en": "Today"
            }
        },
        "submitButton": {
            "enabled": true,
            "text": {
                "fa": "بستن",
                "en": "Submit"
            }
        },
        "text": {
            "btnToday": "امروز"
        }
    },
    "timePicker": {
        "enabled": false,
        "step": 1,
        "hour": {
            "enabled": true,
            "step": null
        },
        "minute": {
            "enabled": true,
            "step": null
        },
        "second": {
            "enabled": false,
            "step": null
        },
        "meridian": {
            "enabled": false
        }
    },
    "dayPicker": {
        "enabled": true,
        "titleFormat": "YYYY MMMM"
    },
    "monthPicker": {
        "enabled": true,
        "titleFormat": "YYYY"
    },
    "yearPicker": {
        "enabled": true,
        "titleFormat": "YYYY"
    },
    "responsive": true
});

$("#end_date").pDatepicker({
    "inline": false,
    "format": "YYYY/MM/DD",
    "viewMode": "day",
    "initialValue": false,
    "initialValueType": 'persian',
    "minDate": -1539487544000,
    "autoClose": true,
    "position": "auto",
    "altField": "#txtBirthday",
    "onlyTimePicker": false,
    "onlySelectOnDate": true,
    "calendarType": "persian",
    "inputDelay": 800,
    "observer": true,
    "calendar": {
        "persian": {
            "locale": "fa",
            "showHint": true,
            "leapYearMode": "algorithmic"
        }
    },
    "navigator": {
        "enabled": true,
        "scroll": {
            "enabled": true
        },
        "text": {
            "btnNextText": "<",
            "btnPrevText": ">"
        }
    },
    "toolbox": {
        "enabled": true,
        "calendarSwitch": {
            "enabled": false,
            "format": "MMMM"
        },
        "todayButton": {
            "enabled": true,
            "text": {
                "fa": "امروز",
                "en": "Today"
            }
        },
        "submitButton": {
            "enabled": true,
            "text": {
                "fa": "بستن",
                "en": "Submit"
            }
        },
        "text": {
            "btnToday": "امروز"
        }
    },
    "timePicker": {
        "enabled": false,
        "step": 1,
        "hour": {
            "enabled": true,
            "step": null
        },
        "minute": {
            "enabled": true,
            "step": null
        },
        "second": {
            "enabled": false,
            "step": null
        },
        "meridian": {
            "enabled": false
        }
    },
    "dayPicker": {
        "enabled": true,
        "titleFormat": "YYYY MMMM"
    },
    "monthPicker": {
        "enabled": true,
        "titleFormat": "YYYY"
    },
    "yearPicker": {
        "enabled": true,
        "titleFormat": "YYYY"
    },
    "responsive": true
});

$("#end_dateEdit").pDatepicker({
    "inline": false,
    "format": "YYYY/MM/DD",
    "viewMode": "day",
    "initialValue": false,
    "initialValueType": 'persian',
    "minDate": -1539487544000,
    "autoClose": true,
    "position": "auto",
    "altField": "#txtBirthday",
    "onlyTimePicker": false,
    "onlySelectOnDate": true,
    "calendarType": "persian",
    "inputDelay": 800,
    "observer": true,
    "calendar": {
        "persian": {
            "locale": "fa",
            "showHint": true,
            "leapYearMode": "algorithmic"
        }
    },
    "navigator": {
        "enabled": true,
        "scroll": {
            "enabled": true
        },
        "text": {
            "btnNextText": "<",
            "btnPrevText": ">"
        }
    },
    "toolbox": {
        "enabled": true,
        "calendarSwitch": {
            "enabled": false,
            "format": "MMMM"
        },
        "todayButton": {
            "enabled": true,
            "text": {
                "fa": "امروز",
                "en": "Today"
            }
        },
        "submitButton": {
            "enabled": true,
            "text": {
                "fa": "بستن",
                "en": "Submit"
            }
        },
        "text": {
            "btnToday": "امروز"
        }
    },
    "timePicker": {
        "enabled": false,
        "step": 1,
        "hour": {
            "enabled": true,
            "step": null
        },
        "minute": {
            "enabled": true,
            "step": null
        },
        "second": {
            "enabled": false,
            "step": null
        },
        "meridian": {
            "enabled": false
        }
    },
    "dayPicker": {
        "enabled": true,
        "titleFormat": "YYYY MMMM"
    },
    "monthPicker": {
        "enabled": true,
        "titleFormat": "YYYY"
    },
    "yearPicker": {
        "enabled": true,
        "titleFormat": "YYYY"
    },
    "responsive": true
});


$("#start_dateFilter").pDatepicker({
    "inline": false,
    "format": "YYYY/MM/DD",
    "viewMode": "day",
    "initialValue": false,
    "initialValueType": 'persian',
    "minDate": -1539487544000,
    "autoClose": true,
    "position": "auto",
    "altField": "#from_unix",
    "onlyTimePicker": false,
    "onlySelectOnDate": true,
    "calendarType": "persian",
    "inputDelay": 800,
    "observer": true,
    "persianDigit": false,
    "calendar": {
        "persian": {
            "locale": "fa",
            "showHint": true,
            "leapYearMode": "algorithmic"
        }
    },
    "navigator": {
        "enabled": true,
        "scroll": {
            "enabled": true
        },
        "text": {
            "btnNextText": "<",
            "btnPrevText": ">"
        }
    },
    "toolbox": {
        "enabled": true,
        "calendarSwitch": {
            "enabled": false,
            "format": "MMMM"
        },
        "todayButton": {
            "enabled": true,
            "text": {
                "fa": "امروز",
                "en": "Today"
            }
        },
        "submitButton": {
            "enabled": true,
            "text": {
                "fa": "بستن",
                "en": "Submit"
            }
        },
        "text": {
            "btnToday": "امروز"
        }
    },
    "timePicker": {
        "enabled": false,
        "step": 1,
        "hour": {
            "enabled": true,
            "step": null
        },
        "minute": {
            "enabled": true,
            "step": null
        },
        "second": {
            "enabled": false,
            "step": null
        },
        "meridian": {
            "enabled": false
        }
    },
    "dayPicker": {
        "enabled": true,
        "titleFormat": "YYYY MMMM"
    },
    "monthPicker": {
        "enabled": true,
        "titleFormat": "YYYY"
    },
    "yearPicker": {
        "enabled": true,
        "titleFormat": "YYYY"
    },
    "responsive": true
});
$("#end_dateFilter").pDatepicker({
    "inline": false,
    "format": "YYYY/MM/DD",
    "viewMode": "day",
    "initialValue": false,
    "initialValueType": 'persian',
    "minDate": -1539487544000,
    "autoClose": true,
    "position": "auto",
    "altField": "#to_unix",
    "onlyTimePicker": false,
    "onlySelectOnDate": true,
    "calendarType": "persian",
    "inputDelay": 800,
    "observer": true,
    "calendar": {
        "persian": {
            "locale": "fa",
            "showHint": true,
            "leapYearMode": "algorithmic"
        }
    },
    "navigator": {
        "enabled": true,
        "scroll": {
            "enabled": true
        },
        "text": {
            "btnNextText": "<",
            "btnPrevText": ">"
        }
    },
    "toolbox": {
        "enabled": true,
        "calendarSwitch": {
            "enabled": false,
            "format": "MMMM"
        },
        "todayButton": {
            "enabled": true,
            "text": {
                "fa": "امروز",
                "en": "Today"
            }
        },
        "submitButton": {
            "enabled": true,
            "text": {
                "fa": "بستن",
                "en": "Submit"
            }
        },
        "text": {
            "btnToday": "امروز"
        }
    },
    "timePicker": {
        "enabled": false,
        "step": 1,
        "hour": {
            "enabled": true,
            "step": null
        },
        "minute": {
            "enabled": true,
            "step": null
        },
        "second": {
            "enabled": false,
            "step": null
        },
        "meridian": {
            "enabled": false
        }
    },
    "dayPicker": {
        "enabled": true,
        "titleFormat": "YYYY MMMM"
    },
    "monthPicker": {
        "enabled": true,
        "titleFormat": "YYYY"
    },
    "yearPicker": {
        "enabled": true,
        "titleFormat": "YYYY"
    },
    "responsive": true
});


persianNumbers = [/۰/g, /۱/g, /۲/g, /۳/g, /۴/g, /۵/g, /۶/g, /۷/g, /۸/g, /۹/g]
arabicNumbers = [/٠/g, /١/g, /٢/g, /٣/g, /٤/g, /٥/g, /٦/g, /٧/g, /٨/g, /٩/g]
convertToEnglishDigits = function (str) {
    if (typeof str === 'string') {
        for (var i = 0; i < 10; i++) {
            str = str.replace(persianNumbers[i], i).replace(arabicNumbers[i], i);
        }
    }
    return str;
};

function createItem() {

    //before ajax request this section clear the message input value
    axios.interceptors.request.use(function (config) {
        $.blockUI({
            message:
                '<div class="d-flex justify-content-center"><p class="mb-0">لطفا صبر کنید...</p> <div class="sk-wave m-0 ms-2"><div class="sk-rect sk-wave-rect"></div> <div class="sk-rect sk-wave-rect"></div> <div class="sk-rect sk-wave-rect"></div> <div class="sk-rect sk-wave-rect"></div> <div class="sk-rect sk-wave-rect"></div></div> </div>',
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
    axios({
        url: '/kar-fa/telegrams',
        method: 'POST',
        data: {
            start_date: convertToEnglishDigits($('#start_date').val()),
            end_date: convertToEnglishDigits($('#end_date').val()),
            desc: $('#desc').val(),
            phone: $('#phone').val(),
            duration: $('#duration').val(),
            telegram_id: $('#telegram_id').val(),
            fullname: $('#fullname').val(),
        }
    })
        .then(function (response) {
            $('#tele-list').prepend(`
                <tr>
                            <td>
                            <div class="d-flex flex-column">
                                   <span>${response.data.item.fullname}</span>
                                <small class="emp_post text-truncate text-muted">${response.data.item.phone}</small>
                            </div>

                            </td>
                            <td>
${response.data.item.telegram_id}
</td>

<td>
${response.data.item.duration}
</td>
<td>${response.data.start_date}</td>
<td>${response.data.end_date}</td>
<td>${response.data.is_notified}</td>
<td>${response.data.is_deleted}</td>
<td>${response.data.item.desc}</td>
                    <td>
                            <button data-bs-toggle="modal"
                                   data-bs-target="#modalEdit"
                                   type="button"
                                   onclick="editItem(${response.data.item.id})"
                                   class="btn btn-sm btn-info item-edit">
                                    ویرایش
                                </button>
                                    <button class="btn btn-sm btn-danger"
                                    onclick="removeItem(${response.data.item.id} , $(this))"
                                    type="button">حذف</button></td>
                    </td>

                        </tr>
            `)
            $('#start_date').val('')
            $('#end_date').val('')
            $('#desc').val('')
            $('#phone').val('')
            $('#duration').val('')
            $('#telegram_id').val('')
            $('#fullname').val('')
            $('#modalCenter').modal('toggle');
        })
        .catch(function (response) {
            const Toast = Swal.mixin({
                toast: true,
                position: "bottom-left",
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.onmouseenter = Swal.stopTimer;
                    toast.onmouseleave = Swal.resumeTimer;
                }
            });
            Toast.fire({
                icon: "error",
                title: response.response.data.message
            });
        })

}


function editItem(id) {
    //before ajax request this section clear the message input value
    axios.interceptors.request.use(function (config) {
        $.blockUI({
            message:
                '<div class="d-flex justify-content-center"><p class="mb-0">لطفا صبر کنید...</p> <div class="sk-wave m-0 ms-2"><div class="sk-rect sk-wave-rect"></div> <div class="sk-rect sk-wave-rect"></div> <div class="sk-rect sk-wave-rect"></div> <div class="sk-rect sk-wave-rect"></div> <div class="sk-rect sk-wave-rect"></div></div> </div>',
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

    axios({
        url: `/kar-fa/telegrams/${id}/edit`,
        method: 'GET',
    })
        .then(function (response) {
            $('#fullnameEdit').val(response.data.item.fullname)
            $('#descEdit').val(response.data.item.desc)
            $('#start_dateEdit').val(response.data.start_date)
            $('#end_dateEdit').val(response.data.end_date)
            $('#phoneEdit').val(response.data.item.phone)
            $('#telegram_idEdit').val(response.data.item.telegram_id)
            $('#durationEdit').val(response.data.item.duration)
            $('#is_notifiedEdit').val(response.data.item.is_notified)
            $('#edit-item-id').val(id)
        })


}


function updateItem() {
    //before ajax request this section clear the message input value
    axios.interceptors.request.use(function (config) {
        $.blockUI({
            message:
                '<div class="d-flex justify-content-center"><p class="mb-0">لطفا صبر کنید...</p> <div class="sk-wave m-0 ms-2"><div class="sk-rect sk-wave-rect"></div> <div class="sk-rect sk-wave-rect"></div> <div class="sk-rect sk-wave-rect"></div> <div class="sk-rect sk-wave-rect"></div> <div class="sk-rect sk-wave-rect"></div></div> </div>',
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
    axios({
        url: `/kar-fa/telegrams/${$('#edit-item-id').val()}`,
        method: 'patch',
        data: {
            start_date: convertToEnglishDigits($('#start_dateEdit').val()),
            end_date: convertToEnglishDigits($('#end_dateEdit').val()),
            desc: $('#descEdit').val(),
            phone: $('#phoneEdit').val(),
            duration: $('#durationEdit').val(),
            telegram_id: $('#telegram_idEdit').val(),
            fullname: $('#fullnameEdit').val(),
            is_notified: $('#is_notifiedEdit').val(),
            is_deleted: $('#is_deletedEdit').val(),
        }
    })
        .then(function (response) {

            const Toast = Swal.mixin({
                toast: true,
                position: "bottom-left",
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
                title: response.data.message
            });
            $('#modalEdit').modal('toggle');
            location.reload();
        })
        .catch(function (response) {
            const Toast = Swal.mixin({
                toast: true,
                position: "bottom-left",
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.onmouseenter = Swal.stopTimer;
                    toast.onmouseleave = Swal.resumeTimer;
                }
            });
            Toast.fire({
                icon: "error",
                title: response.response.data.message
            });
        })
}

function removeItem(id, e) {
    const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
            confirmButton: "btn btn-danger ms-3",
            cancelButton: "btn btn-secondary"
        },
        buttonsStyling: false
    });
    swalWithBootstrapButtons.fire({
        title: "آیا از حذف آیتم مطمئن هستید؟",
        text: "این عمل غیر قابل بازگشت میباشد",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "حذف",
        cancelButtonText: "لغو",
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            //before ajax request this section clear the message input value
            axios.interceptors.request.use(function (config) {
                $('.swal2-confirm').html('<span class="spinner-border me-2" role="status" aria-hidden="true"></span>')
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
            axios.delete(`/kar-fa/telegrams/${id}`)
                .then((response) => {
                    const Toast = Swal.mixin({
                        toast: true,
                        position: "bottom-left",
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
                        title: response.data.message
                    });
                    location.reload();
                })
                .catch((response) => {
                    const Toast = Swal.mixin({
                        toast: true,
                        position: "bottom-left",
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true,
                        didOpen: (toast) => {
                            toast.onmouseenter = Swal.stopTimer;
                            toast.onmouseleave = Swal.resumeTimer;
                        }
                    });
                    Toast.fire({
                        icon: "error",
                        title: response.response.data.message
                    });
                })

        }
    });


}
