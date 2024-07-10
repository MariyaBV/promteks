document.addEventListener('DOMContentLoaded', function () {
    var searchSections = Array.from(document.querySelectorAll('.block-slider'));
    console.log("searchSections", searchSections);

    searchSections.forEach(searchSection => {
        const swiperElement = searchSection.querySelector('.swiper');
        console.log("swiper", swiperElement);

        if (swiperElement) {
            const swiperID = swiperElement.getAttribute('id');
            console.log("swiperID", swiperID);

            if (swiperID) {
                const sliderNextBtn = searchSection.querySelector('#next_' + swiperID.replace('slider_swiper', ''));
                console.log("sliderNextBtn", sliderNextBtn);
                const sliderPrevBtn = searchSection.querySelector('#prev_' + swiperID.replace('slider_swiper', ''));
                console.log("sliderPrevBtn", sliderPrevBtn);
                const sliderPagination = searchSection.querySelector('#pagination_' + swiperID.replace('slider_swiper', ''));
                console.log("sliderPagination", sliderPagination);

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