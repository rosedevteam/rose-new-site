
$('.select-video').on('click' , function () {
    if ($(this).hasClass('is-loggedin')) {
        let videoSrc = $(this).attr('data-video-src');
        $('.rose-video-player').attr('src' , videoSrc);
    }else {
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
            title: "ورود / ثبت نام",
            text: "لطفا جهت مشاهده ویدیو ابتدا وارد حساب کاربری خود شوید"
        });
    }

})
