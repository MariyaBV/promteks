$(document).ready(function() {
    var swiper = new Swiper('.product-gallery-swiper', {
        direction: "vertical",
        spaceBetween: 10,
        loop: true,
        slidesPerGroup: 4,
        //autoHeight: true,
        //freeMode: true,
        slidesPerView: 4,
        //paginationClickable: true,
        // autoplay: {
        //     delay: 3000,
        //     disableOnInteraction: false,
        // },
        navigation: {
            nextEl: '.product-gallery__swiper-button-next',
        },
        on: {
            init: function() {
                updateSlideVisibility(this);
                checkNavigationVisibility(this);
            },
            resize: function() {
                updateSlideVisibility(this);
                checkNavigationVisibility(this);
            },
            slideChange: function() {
                updateSlideVisibility(this);
            },
            setTranslate: function() {
                updateSlideVisibility(this);
            }
        },
    });

    function checkNavigationVisibility(swiper) {
        var slidesPerView = 4;
        if (swiper.slides.length <= slidesPerView) {
            $(swiper.navigation.nextEl).hide();
        } else {
            $(swiper.navigation.nextEl).show();
        }
    }

    function updateSlideVisibility(swiper) {
        var slides = swiper.slides;
        var swiperHeight = swiper.height;
        var $swiperEl = $('.product-gallery-swiper');
        var swiperOffsetTop = $swiperEl.offset().top;
       

        slides.forEach(slide => {
            console.log("slide", slide);
            var $slide = $(slide);
            var slideTop = $slide.offset().top + swiper.translate;
            var slideBottom = slideTop + $(slide).outerHeight();

            console.log("swiper.translate", swiper.translate, "slideTop", slideTop, "swiperOffsetTop", swiperOffsetTop);
            console.log("slideBottom", slideBottom, "swiperOffsetTop + swiperHeight", swiperOffsetTop + swiperHeight);

            if ((slideTop + 30) >= swiperOffsetTop && slideBottom <= swiperOffsetTop + swiperHeight) {
                $(slide).removeClass('hidden');
            } else {
                $(slide).addClass('hidden');
            }
        });
    }
});

//если нет картинок в слайдере
$(document).ready(function() {
    var $swiperContainer = $('.swiper-container.product-gallery-swiper');
    var $images = $swiperContainer.find('.swiper-wrapper img');

    if ($images.length === 0) {
        $swiperContainer.hide();
    }
});

