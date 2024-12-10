
$('.select-video').on('click' , function () {
    let videoSrc = $(this).attr('data-video-src');
    $('.rose-video-player').attr('src' , videoSrc);
})