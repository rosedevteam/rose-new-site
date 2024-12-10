//mobile menu
let submenu = $('.item-with-submenu');

submenu.click(function () {
    $(this).children('.submenu').slideToggle('fast')
})


$(document).ready(function(){
    var changebox = $(".changebox");

    var firstclone = changebox.children(":first").clone();
    changebox.append(firstclone);

    var fsstr = changebox.parent().css("font-size");
    fsstr = fsstr.slice(0,fsstr.indexOf("p"));
    var fs = parseInt(fsstr);

    changebox.css("height",changebox.parent().css("font-size") );
    ChangeSize(0);
    setInterval(Next,2000);

    function Next(){
        if( typeof Next.i == 'undefined' ) {
            Next.i = 0;
        }
        Next.i++;
        if(Next.i == changebox.children("span").length){
            Next.i = 1;
            changebox.scrollTop(0);
        }
        changebox.animate({scrollTop: (fs*Next.i)+Next.i*5+3},500);
        setTimeout(function(){
            ChangeSize(Next.i);
        },500);

    }

    function ChangeSize(i){
        var word = changebox.children("span").eq(i);
        var wordsize = word.css("width");
        changebox.css("width",wordsize);
    }


});


    const sliderContainer = $('#slider-right');
    const slider = sliderContainer.find('.slider');
    const slides = sliderContainer.find('.slide');
    let activeSlideIndex = 0;
    let isDragging = false;
    let startY;
    let currentTranslate = 0;
    let prevTranslate = 0;

    slider.on('mousedown touchstart', function(e) {
        startDrag(e);
    });

    slider.on('mouseup touchend', function() {
        endDrag();
    });

    slider.on('mouseleave touchcancel', function() {
        endDrag();
    });

    slider.on('mousemove touchmove', function(e) {
        dragging(e);
    });

    function changeSlide(direction) {
        const slideHeight = slides.outerHeight(true) * 3;

        if (direction === 'up') {
            activeSlideIndex++;
            if (activeSlideIndex > slides.length - 3) {
                activeSlideIndex = 0;
            }
        } else if (direction === 'down') {
            activeSlideIndex--;
            if (activeSlideIndex < 0) {
                activeSlideIndex = slides.length - 3;
            }
        }

        slider.css('transform', `translateY(-${activeSlideIndex * slideHeight}px)`);
    }

    function startDrag(e) {
        isDragging = true;
        startY = e.type === 'touchstart' ? e.touches[0].clientY : e.clientY;
        slider.css('transition', 'none');
        slider.css('cursor', 'grabbing');
    }

    function endDrag() {
        if (isDragging) {
            isDragging = false;
            const slideHeight = slides.outerHeight(true) * 3;
            const movedBy = currentTranslate - prevTranslate;

            if (movedBy < -100 && activeSlideIndex < slides.length - 3) {
                activeSlideIndex++;
            } else if (movedBy > 100 && activeSlideIndex > 0) {
                activeSlideIndex--;
            }

            slider.css('transition', 'transform 0.4s ease-in-out');
            slider.css('transform', `translateY(-${activeSlideIndex * slideHeight}px)`);
            prevTranslate = currentTranslate;
            slider.css('cursor', 'grab');
        }
    }

    function dragging(e) {
        if (isDragging) {
            const slideHeight = slides.outerHeight(true) * 3;
            const yPosition = e.type === 'touchmove' ? e.touches[0].clientY - startY : e.clientY - startY;
            currentTranslate = prevTranslate + yPosition;
            slider.css('transform', `translateY(${currentTranslate}px)`);
        }
    }

//     hero section mobile slider
$('.owl-carousel.hero').owlCarousel({
    loop:true,
    rtl:true,
    margin:10,
    responsiveClass:true,
    responsive:{
        0:{
            items:3,
            margin:10,
            nav:false
        },
        600:{
            items:5,
            nav:false
        },
        1000:{
            items:5,
            nav:true,
            loop:false
        }
    }
})


/*----------------------------------*
customize owl carousel
*----------------------------------- */
$(document).ready(function () {
    var carousel = $('[data-owl-options]');
    if (carousel.length) {
        carousel.each(function (index, el) {
            $(this).owlCarousel($(this).data('owl-options'));
        });
    }
});
