
$('.select-video').on('click' , function () {
    console.log('ok')
    let videoSrc = $(this).attr('data-video-src');
    $('.rose-video-player').attr('src' , videoSrc);
})
