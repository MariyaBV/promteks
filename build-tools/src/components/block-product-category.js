document.addEventListener("DOMContentLoaded", function () {
    const searchSections = document.querySelectorAll('.product-category');

    searchSections.forEach(searchSection => {
        const swiperElement = searchSection.querySelector('.swiper');
        
        if (swiperElement) {
            const swiperID = swiperElement.getAttribute('id');
            if (swiperID) {
                const swiper_certificates = new Swiper("#" + swiperID, {
                    direction: "horizontal",
                    loop: true,
                    slidesPerView: 2,
                    slidesPerGroup: 2,
                    autoHeight: true,
                    spaceBetween: 15,
                    navigation: {
                        nextEl: ".product-category__next",
                    },
                    breakpoints: {
                        660: {
                            slidesPerView: 3,
                            slidesPerGroup: 3,
                            spaceBetween: 30
                        },
                        961: {
                            slidesPerView: 4,
                            slidesPerGroup: 4,
                            spaceBetween: 40
                        },
                    },
                });
            }
        }
    });
});