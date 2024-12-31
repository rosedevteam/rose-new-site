$(function () {
    var maxlengthInput = $('.bootstrap-maxlength-example'),
        formRepeater = $('.form-repeater');

    // Bootstrap Max Length
    // --------------------------------------------------------------------
    if (maxlengthInput.length) {
        maxlengthInput.each(function () {
            $(this).maxlength({
                warningClass: 'label label-success bg-success text-white',
                limitReachedClass: 'label label-danger',
                separator: ' از ',
                preText: 'شما ',
                postText: ' حرف مجاز را تایپ کرده اید.',
                validate: true,
                threshold: +this.getAttribute('maxlength')
            });
        });
    }

    // Form Repeater
    // ! Using jQuery each loop to add dynamic id and class for inputs. You may need to improve it based on form fields.
    // -----------------------------------------------------------------------------------------------------------------

    if (formRepeater.length) {
        var row = 2;
        var col = 1;
        formRepeater.on('submit', function (e) {
            e.preventDefault();
        });
        console.log($(this))
        formRepeater.repeater({
            show: function () {
                var fromControl = $(this).find('.form-control, .form-select');
                var formLabel = $(this).find('.form-label');

                fromControl.each(function (i) {
                    var id = 'form-repeater-' + row + '-' + col;
                    $(fromControl[i]).attr('id', id);
                    $(formLabel[i]).attr('for', id);
                    col++;
                });
                row++;
                $(this).slideDown();
            },
            hide: function (e) {
                Swal.fire({
                    title: "پاک کردن آیتم",
                    text: "آیا از پاک کردن این آیتم مطمئین هستید؟",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#d33",
                    cancelButtonColor: "#3085d6",
                    confirmButtonText: "حذف",
                    cancelButtonText: "لغو"
                }).then((result) => {
                    if (result.isConfirmed) {
                        $(this).slideUp(e)
                    }
                });

                // confirm('آیا از حذف این المان اطمینان دارید؟') && $(this).slideUp(e);
            }
        });
    }

});

$(function () {
    var formRepeaterLesson = $('.form-repeater-lessons');


    // Form Repeater
    // ! Using jQuery each loop to add dynamic id and class for inputs. You may need to improve it based on form fields.
    // -----------------------------------------------------------------------------------------------------------------

    if (formRepeaterLesson.length) {
        var row = 2;
        var col = 1;
        formRepeaterLesson.on('submit', function (e) {
            e.preventDefault();
        });
        formRepeaterLesson.repeater({
            show: function () {
                var fromControl = $(this).find('.form-control, .form-select');
                var formLabel = $(this).find('.form-label');

                fromControl.each(function (i) {
                    var id = 'form-repeater-' + row + '-' + col;
                    $(fromControl[i]).attr('id', id);
                    $(formLabel[i]).attr('for', id);
                    col++;
                });

                row++;

                $(this).slideDown();
            },
            hide: function (e) {
                Swal.fire({
                    title: "پاک کردن آیتم",
                    text: "آیا از پاک کردن این آیتم مطمئین هستید؟",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#d33",
                    cancelButtonColor: "#3085d6",
                    confirmButtonText: "حذف",
                    cancelButtonText: "لغو"
                }).then((result) => {
                    if (result.isConfirmed) {
                        $(this).slideUp(e)
                    }
                });
            }
        });
    }
});


function removeProductAttr(attrId , e) {
    // console.log()
    Swal.fire({
        title: "پاک کردن آیتم",
        text: "آیا از پاک کردن این آیتم مطمئین هستید؟",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#d33",
        cancelButtonColor: "#3085d6",
        confirmButtonText: "حذف",
        cancelButtonText: "لغو"
    }).then((result) => {
        if (result.isConfirmed) {
            axios.delete(
                `/admin/attributes/${attrId}`
            ).then(function (res) {
                    e.parent().parent().parent().slideUp()
                    Swal.fire({
                        position: "center",
                        icon: "success",
                        title: res.data.message,
                        showConfirmButton: false,
                        timer: 1500
                    });
            })
                .catch(function (err) {
                    Swal.fire({
                        position: "center",
                        icon: "error",
                        title: 'مشکلی در حذف به وجود آمده است',
                        showConfirmButton: false,
                        timer: 1500
                    });
                })
        }
    });
}

function removeProductLesson(lessonId , e) {
    // console.log()
    Swal.fire({
        title: "پاک کردن آیتم",
        text: "آیا از پاک کردن این آیتم مطمئین هستید؟",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#d33",
        cancelButtonColor: "#3085d6",
        confirmButtonText: "حذف",
        cancelButtonText: "لغو"
    }).then((result) => {
        if (result.isConfirmed) {
            axios.delete(
                `/admin/lessons/${lessonId}`
            ).then(function (res) {
                e.parent().parent().parent().slideUp()
                Swal.fire({
                    position: "center",
                    icon: "success",
                    title: res.data.message,
                    showConfirmButton: false,
                    timer: 1500
                });
            })
                .catch(function (err) {
                    Swal.fire({
                        position: "center",
                        icon: "error",
                        title: 'مشکلی در حذف به وجود آمده است',
                        showConfirmButton: false,
                        timer: 1500
                    });
                })
        }
    });
}


$('#is_free').on('change',function () {
    if ($(this).val() == 1){
        $('#lessons-wrapper').show();
    }else {
        $('#lessons-wrapper').hide();
    }
})

// todo fix remove button logic
