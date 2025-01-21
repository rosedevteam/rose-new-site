blogPostsCarousel = document.querySelector('#blog-posts-carousel');
studentReportsCarousel = document.querySelector('#students-reports-carousel');
dailyReportsCarousel = document.querySelector('#daily-reports-carousel');

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

if (studentReportsCarousel) {
    new Swiper(studentReportsCarousel, {
        slidesPerView: 2,
        spaceBetween: 25,
        loop: true,
        centerSlide: true,
        fade: true,
        grabCursor: true,
        autoplay: {
            delay: 3000,
        },
        pagination: {
            el: ".swiper-pagination",
            clickable: true,
            dynamicBullets: true,
        },
        pauseOnMouseEnter: true,
        breakpoints: {
            0: { slidesPerView: 1, },
            520: { slidesPerView: 1 },
            950: { slidesPerView: 2 },
        },
        navigation: {
            prevEl: '.swiper-button-prev',
            nextEl: '.swiper-button-next'
        }
    });
}

if (dailyReportsCarousel) {
    new Swiper(studentReportsCarousel, {
        slidesPerView: 2,
        spaceBetween: 25,
        loop: true,
        centerSlide: true,
        fade: true,
        grabCursor: true,
        autoplay: {
            delay: 3000,
        },
        pagination: {
            el: ".swiper-pagination",
            clickable: true,
            dynamicBullets: true,
        },
        pauseOnMouseEnter: true,
        breakpoints: {
            0: { slidesPerView: 1, },
            520: { slidesPerView: 1 },
            950: { slidesPerView: 2 },
        },
        navigation: {
            prevEl: '.swiper-button-prev',
            nextEl: '.swiper-button-next'
        }
    });
}


