const createNewItem = document.querySelector('#createNewItem');


if (createNewItem) {
    const fv = FormValidation.formValidation(createNewItem, {
        fields: {
            created_at: {
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

$("#content_date").pDatepicker({
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

function createNew() {
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
        url: '/kar-fa/reports',
        method: 'post',
        data: {
            content_date: convertToEnglishDigits($('#content_date').val()),
            description: $('#description').val(),
            type: $('#type').val()
        }
    })
        .then(function (response) {
            $('#reports-list').append(`
                <tr>
                            <td>
                                <strong>${response.data.platform}</strong>
                            </td>
                            <td>
                            ${response.data.report.description}
</td>
 <td>
                            ${response.data.content_date}
                    </td>
<td>
                            ${response.data.created_date}
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
