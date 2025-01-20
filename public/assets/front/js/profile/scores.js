$("[type='number']").keypress(function (evt) {
    evt.preventDefault();
});

(function ($) {

    $.fn.numberstyle = function (options) {

        /*
         * Default settings
         */
        var settings = $.extend({
            value: 0,
            step: undefined,
            min: undefined,
            max: undefined
        }, options);

        /*
         * Init every element
         */
        return this.each(function (i) {

            /*
             * Base options
             */
            var input = $(this);

            /*
       * Add new DOM
       */
            var container = document.createElement('div'),
                btnAdd = document.createElement('div'),
                btnRem = document.createElement('div'),
                min = (settings.min) ? settings.min : input.attr('min'),
                max = (settings.max) ? settings.max : input.attr('max'),
                value = (settings.value) ? settings.value : parseFloat(input.val());
            container.className = 'numberstyle-qty';
            btnAdd.className = (max && value >= max) ? 'qty-btn qty-add disabled' : 'qty-btn qty-add';
            btnAdd.innerHTML = '+';
            btnRem.className = (min && value <= min) ? 'qty-btn qty-rem disabled' : 'qty-btn qty-rem';
            btnRem.innerHTML = '-';
            input.wrap(container);
            input.closest('.numberstyle-qty').prepend(btnRem).append(btnAdd);

            /*
             * Attach events
             */
            // use .off() to prevent triggering twice
            $(document).off('click', '.qty-btn').on('click', '.qty-btn', function (e) {

                var input = $(this).siblings('input'),
                    sibBtn = $(this).siblings('.qty-btn'),
                    step = (settings.step) ? parseFloat(settings.step) : parseFloat(input.attr('step')),
                    min = (settings.min) ? settings.min : (input.attr('min')) ? input.attr('min') : undefined,
                    max = (settings.max) ? settings.max : (input.attr('max')) ? input.attr('max') : undefined,
                    oldValue = parseFloat(input.val()),
                    newVal;

                //Add value
                if ($(this).hasClass('qty-add')) {

                    newVal = (oldValue >= max) ? oldValue : oldValue + step,
                        newVal = (newVal > max) ? max : newVal;

                    if (newVal == max) {
                        $(this).addClass('disabled');
                    }
                    sibBtn.removeClass('disabled');

                    //Remove value
                } else {

                    newVal = (oldValue <= min) ? oldValue : oldValue - step,
                        newVal = (newVal < min) ? min : newVal;

                    if (newVal == min) {
                        $(this).addClass('disabled');
                    }
                    sibBtn.removeClass('disabled');

                }

                //Update value
                input.val(newVal).trigger('change');

            });

            input.on('change', function () {

                const val = parseFloat(input.val()),
                    min = (settings.min) ? settings.min : (input.attr('min')) ? input.attr('min') : undefined,
                    max = (settings.max) ? settings.max : (input.attr('max')) ? input.attr('max') : undefined;

                if (val > max) {
                    input.val(max);
                }

                if (val < min) {
                    input.val(min);
                }
            });

        });
    };


    /*
     * Init
     */

    $('.numberstyle').numberstyle();

}(jQuery));




$('#score-exchange').change(function () {
    let convertedPrice = $('#converted-price')
    let scoreExchange = $('#score-exchange').val()
    var inputValue = $(this).val();
    let walletValue = inputValue * 30;
    convertedPrice.html(Number(walletValue).toLocaleString() + ' تومان')
    if (inputValue == 0) {
        $('#exchange-submit').prop('disabled', true)
    } else {
        $('#exchange-submit').prop('disabled', false)
    }
});

function exchangeScore() {
    console.log($('#score-exchange').val())
    axios({
        method: 'post',
        url: `/score/exchange-score`,
        data: {
            score: $('#score-exchange').val(),
        }
    })
        .then(function (res) {
            location.reload();
            $.unblockUI();
        })
        .catch(function (error) {
            toastr.error(error.response.data.message, 'خطا')
            $.unblockUI();
        })
}

function copyToClipboardReferral(element) {
    console.log(element)
    var $temp = $("<input>");
    $("body").append($temp);
    $temp.val(element).select();
    document.execCommand("copy");
    $temp.remove();
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
        title: "کد معرف کپی شد"
    });
}

function copyToClipboardReferralDesc(element) {
    var $temp = $("<input>");
    $("body").append($temp);
    $temp.val(`
    دوست عزیزم، مشاهده موفقیت شما برای من یک دست آورد مهم هست.
از کد معرف ${element} استفاده کنید تا با 20 درصد تخفیف در دوره مسیر ثروت ساز ثبت نام کنید و در مسیر ارتقای علوم مالی و رشد فردی خود قدم بردارید.
    `).select();
    document.execCommand("copy");
    $temp.remove();
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
        title: "متن دعوت کپی شد"
    });
}
