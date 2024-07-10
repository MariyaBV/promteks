document.addEventListener('DOMContentLoaded', function () {
    var searchSections = Array.from(document.querySelectorAll('.block-slider'));

    searchSections.forEach(searchSection => {
        const swiperElement = searchSection.querySelector('.swiper');

        if (swiperElement) {
            const swiperID = swiperElement.getAttribute('id');

            if (swiperID) {
                const sliderNextBtn = searchSection.querySelector('#next_' + swiperID.replace('slider_swiper', ''));
                const sliderPrevBtn = searchSection.querySelector('#prev_' + swiperID.replace('slider_swiper', ''));
                const sliderPagination = searchSection.querySelector('#pagination_' + swiperID.replace('slider_swiper', ''));

                const swiper_block_sliders = new Swiper("#" + swiperID, {
                    direction: 'horizontal',
                    slidesPerView: 1,
                    slidesPerGroup: 1,
                    autoHeight: true,
                    loop: true,
                    navigation: {
                        nextEl: sliderNextBtn,
                        prevEl: sliderPrevBtn,
                    },
                    pagination: {
                        el: sliderPagination,
                        clickable: true,
                    },
                });
            }
        }
    });
});