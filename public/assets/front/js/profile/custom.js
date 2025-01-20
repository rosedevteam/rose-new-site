blogPostsCarousel = document.querySelector('#blog-posts-carousel');

if (blogPostsCarousel) {
    new Swiper(blogPostsCarousel, {
        slidesPerView: 1,
        spaceBetween: 25,
        loop: true,
        centerSlide: true,
        fade: true,
        grabCursor: true,
        pagination: {
            el: ".swiper-pagination",
            clickable: true,
            dynamicBullets: true,
        },
        autoplay: {
            delay: 2000,
        },
        pauseOnMouseEnter: true,
        breakpoints: {
            0: { slidesPerView: 1, },
            520: { slidesPerView: 1 },
            950: { slidesPerView: 1 },
        },
        navigation: {
            prevEl: '.swiper-button-prev',
            nextEl: '.swiper-button-next'
        }
    });
}
