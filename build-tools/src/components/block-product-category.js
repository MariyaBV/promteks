document.addEventListener("DOMContentLoaded", function () {
    const searchSections = document.querySelectorAll('.product-category');

    searchSections.forEach(searchSection => {
        const swiperElement = searchSection.querySelector('.swiper');

        if (swiperElement) {
            const swiperID = swiperElement.getAttribute('id');
            if (swiperID) {
                const nextButton = searchSection.querySelector('.product-category__next' + swiperID);
                const swiper_certificates = new Swiper("#" + swiperID, {
                    direction: "horizontal",
                    loop: true,
                    slidesPerView: 2,
                    slidesPerGroup: 2,
                    autoHeight: true,
                    spaceBetween: 15,
                    navigation: {
                        nextEl: nextButton,
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
                    on: {
                        init: function () {
                            checkNavigationVisibility(this);
                        },
                        resize: function () {
                            checkNavigationVisibility(this);
                        },
                    },
                });

                function checkNavigationVisibility(swiper) {
                    let slidesPerView = 2;
                    if (window.innerWidth >= 961) {
                        slidesPerView = 4;
                    } else if (window.innerWidth >= 660) {
                        slidesPerView = 3;
                    }

                    if (swiper.slides.length <= slidesPerView) {
                        swiper.navigation.nextEl.style.display = 'none';
                    } else {
                        swiper.navigation.nextEl.style.display = '';
                    }
                }
            }
        }
    });
});
