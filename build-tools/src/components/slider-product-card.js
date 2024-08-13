$(document).ready(function () {
    var swiper = new Swiper('.product-gallery-swiper', {
        direction: "vertical",
        spaceBetween: 10,
        loop: true,
        slidesPerGroup: 3,
        slidesPerView: 3,
        navigation: {
            nextEl: '.product-gallery__swiper-button-next',
            prevEl: '.product-gallery__swiper-button-prev',
        },
        on: {
            init: function () {
                updateSlideVisibility(this);
                checkNavigationVisibility(this);
            },
            resize: function () {
                updateSlideVisibility(this);
                checkNavigationVisibility(this);
            },
            slideChange: function () {
                updateSlideVisibility(this);
            },
            setTranslate: function () {
                updateSlideVisibility(this);
            }
        },
    });

    var lastAction = 'init'; //состояния последней навигации
    var firstNextClick = true; //первый клик по кнопке "next"

    function checkNavigationVisibility(swiper) {
        var slidesPerView = 3;
        if (swiper.slides.length <= slidesPerView) {
            $(swiper.navigation.nextEl).hide();
            $(swiper.navigation.prevEl).hide();
        } else {
            $(swiper.navigation.nextEl).show();
            $(swiper.navigation.prevEl).hide(); //начальное состояние кнопки прев
        }
    }

    function updateSlideVisibility(swiper) {
        var slides = swiper.slides;
        var swiperHeight = swiper.height;
        var $swiperEl = $('.product-gallery-swiper');
        var swiperOffsetTop = $swiperEl.offset().top;

        slides.forEach(slide => {
            var $slide = $(slide);
            var slideTop;

            // Учитываем направление прокрутки
            if (lastAction === 'next') {
                slideTop = $slide.offset().top + swiper.translate;
            } else if (lastAction === 'prev') {
                slideTop = $slide.offset().top - swiper.getTranslate();
            } else {
                slideTop = $slide.offset().top;
            }

            var slideBottom = slideTop + $(slide).outerHeight();

            if ((slideTop) >= swiperOffsetTop && slideBottom <= swiperOffsetTop + swiperHeight) {
                $(slide).removeClass('hidden');
            } else {
                $(slide).addClass('hidden');
            }

            console.log("translate: ", swiper.translate, "slideTop: ", slideTop, "swiperOffsetTop: ", swiperOffsetTop);
            console.log("slideBottom: ", slideBottom, "swiperOffsetTop + swiperHeight: ", swiperOffsetTop + swiperHeight);

        });
    }

    // Добавляем обработчики событий на кнопки "next" и "prev"
    $(swiper.navigation.nextEl).on('click', function () {
        lastAction = 'next';
        updateSlideVisibility(swiper);

        //делаем кнопку видимой при первом клике по некст
        if (firstNextClick) {
            $(swiper.navigation.prevEl).css('display', 'block');
            firstNextClick = false;
        }
    });

    $(swiper.navigation.prevEl).on('click', function () {
        lastAction = 'prev';
        updateSlideVisibility(swiper);
    });
});

//если нет картинок в слайдере
$(document).ready(function () {
    var $swiperContainer = $('.swiper-container.product-gallery-swiper');
    var $images = $swiperContainer.find('.swiper-wrapper img');

    if ($images.length === 0) {
        $swiperContainer.hide();
    }
});

$(document).ready(function () {
    const swiper_block_sliders_mobile = new Swiper('.product-gallery-swiper-mobile', {
        direction: 'horizontal',
        slidesPerView: 3,
        slidesPerGroup: 3,
        spaceBetween: 10,
        autoHeight: true,
        loop: true,
        navigation: {
            nextEl: '.product-gallery__swiper-button-next-mobile',
            prevEl: '.product-gallery__swiper-button-prev-mobile',
        },
    });
});