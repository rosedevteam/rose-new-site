
$('.select-video').on('click' , function () {
    let videoSrc = $(this).attr('href');
    $('.rose-video-player').attr('src' , videoSrc);
})
