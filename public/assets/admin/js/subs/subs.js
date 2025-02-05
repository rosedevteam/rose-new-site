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
                        message: 'لطفا توضیحات را وارد کنید'
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

$("#expire_date").persianDatepicker({
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

$("#expire_dateEdit").pDatepicker({
    "inline": false,
    "format": "YYYY/MM/DD",
    "viewMode": "day",
    "initialValue": false,
    "initialValueType": 'persian',
    "minDate": -1539487544000,
    "maxDate": new Date().getTime(),
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
        url: '/kar-fa/subscriptions',
        method: 'POST',
        data: {
            expire_date: convertToEnglishDigits($('#expire_date').val()),
            description: $('#description').val(),
            name: $('#name').val()
        }
    })
        .then(function (response) {
            $('#subs-list').append(`
                <tr>
                            <td>
                                ${response.data.item.name}
                            </td>
                            <td>
${response.data.item.description}
</td>

<td>
${response.data.expire_date}
</td>
                    <td>
                            <button data-bs-toggle="modal"
                                   data-bs-target="#modalEdit"
                                   type="button"
                                   onclick="editItem(${response.data.item.id})"
                                   class="btn btn-sm btn-info item-edit">
                                    ویرایش
                                </button>
                    </td>

                        </tr>
            `)
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
        url: `/kar-fa/subscriptions/${id}/edit`,
        method: 'GET',
    })
        .then(function (response) {
            $('#nameEdit').val(response.data.item.name)
            $('#descriptionEdit').val(response.data.item.description)
            $('#expire_dateEdit').val(response.data.expire_date)
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
        url: `/kar-fa/subscriptions/${$('#edit-item-id').val()}`,
        method: 'patch',
        data: {
            expire_date: convertToEnglishDigits($('#expire_dateEdit').val()),
            description: $('#descriptionEdit').val(),
            name: $('#nameEdit').val()
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
