
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
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
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

$('#is_free').on('change',function () {
    if ($(this).val() == 1){
        $('#lessons-wrapper').show();
    }else {
        $('#lessons-wrapper').hide();
    }
})
