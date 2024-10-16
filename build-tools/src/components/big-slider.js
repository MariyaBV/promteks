// document.addEventListener('DOMContentLoaded', function () {
//     var searchSections = Array.from(document.querySelectorAll('.block-slider'));

//     searchSections.forEach(searchSection => {
//         const swiperElement = searchSection.querySelector('.swiper');

//         if (swiperElement) {
//             const swiperID = swiperElement.getAttribute('id');

//             if (swiperID) {
//                 const sliderNextBtn = searchSection.querySelector('#next_' + swiperID.replace('slider_swiper', ''));
//                 const sliderPrevBtn = searchSection.querySelector('#prev_' + swiperID.replace('slider_swiper', ''));
//                 const sliderPagination = searchSection.querySelector('#pagination_' + swiperID.replace('slider_swiper', ''));

//                 const swiper_block_sliders = new Swiper("#" + swiperID, {
//                     direction: 'horizontal',
//                     slidesPerView: 1,
//                     slidesPerGroup: 1,
//                     autoHeight: true,
//                     loop: true,
//                     navigation: {
//                         nextEl: sliderNextBtn,
//                         prevEl: sliderPrevBtn,
//                     },
//                     pagination: {
//                         el: sliderPagination,
//                         clickable: true,
//                     },
//                 });
//             }
//         }
//     });
// });

document.addEventListener('DOMContentLoaded', function () {
    var searchSections = Array.from(document.querySelectorAll('.block-slider'));

    searchSections.forEach(searchSection => {
        const swiperElement = searchSection.querySelector('.swiper');

        if (swiperElement) {
            const swiperID = swiperElement.getAttribute('id');
            const slides = swiperElement.querySelectorAll('.swiper-slide'); // Получаем все слайды

            if (swiperID && slides.length > 0) {
                const sliderNextBtn = searchSection.querySelector('#next_' + swiperID.replace('slider_swiper', ''));
                const sliderPrevBtn = searchSection.querySelector('#prev_' + swiperID.replace('slider_swiper', ''));
                const sliderPagination = searchSection.querySelector('#pagination_' + swiperID.replace('slider_swiper', ''));

                if (slides.length === 1) {
                    // Если только один слайд, скрываем кнопки и пагинацию
                    if (sliderNextBtn) sliderNextBtn.style.display = 'none';
                    if (sliderPrevBtn) sliderPrevBtn.style.display = 'none';
                    if (sliderPagination) sliderPagination.style.display = 'none';
                }

                const swiper_block_sliders = new Swiper("#" + swiperID, {
                    direction: 'horizontal',
                    slidesPerView: 1,
                    slidesPerGroup: 1,
                    autoHeight: true,
                    loop: slides.length > 1, // Луп включается только если больше одного слайда
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
