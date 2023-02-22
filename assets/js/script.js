window.addEventListener("load", function() {
    var swiper = new Swiper(".swiper-container", {
        slidesPerView: 8.5,
        spaceBetween: 30,
        breakpoints: {
            1024: {
                slidesPerView: 6.5,
                spaceBetween: 30,
            },
            768: {
                slidesPerView: 4.5,
                spaceBetween: 30,
            },
            640: {
                slidesPerView: 3.5,
                spaceBetween: 30,
            },
            320: {
                slidesPerView: 2.5,
                spaceBetween: 30,
            }
        },
        mousewheel: true,
    });
});
