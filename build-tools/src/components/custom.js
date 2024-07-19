document.addEventListener("DOMContentLoaded", function () {
    function quantityProducts() {
        var quantityArrowMinus = document.querySelector(".quantity-arrow-minus");
        var quantityArrowPlus = document.querySelector(".quantity-arrow-plus");
        var quantityNum = document.querySelector(".input-text.qty.text");

        if (quantityArrowMinus && quantityArrowPlus && quantityNum) {
            quantityArrowMinus.addEventListener("click", function (event) {
                event.preventDefault();
                quantityMinus();
            });

            quantityArrowPlus.addEventListener("click", function (event) {
                event.preventDefault();
                quantityPlus();
            });
        }

        function quantityMinus() {
            if (parseInt(quantityNum.value) > 1) {
                quantityNum.value = parseInt(quantityNum.value) - 1;
            }
        }

        function quantityPlus() {
            quantityNum.value = parseInt(quantityNum.value) + 1;
        }
    }

    quantityProducts();
});

jQuery(document).ready(function ($) {
    // Обработчик для кнопки "Купить"
    $('.ajax_add_to_cart').on('click', function (e) {
        e.preventDefault();

        var $thisButton = $(this);
        var product_id = $thisButton.data('product-id') || $thisButton.closest('form').data('product_id');
        var quantity = $thisButton.siblings('.quantity').find('.qty').val() || 1;

        var data = {
            action: 'woocommerce_ajax_add_to_cart',
            product_id: product_id,
            quantity: quantity,
        };

        $.ajax({
            type: 'POST',
            url: custom_ajax_obj.ajax_url,
            data: data,
            beforeSend: function () {
                $thisButton.addClass('loading');
            },
            complete: function () {
                $thisButton.removeClass('loading');
            },
            success: function (response) {
                if (response.error && response.product_url) {
                    window.location = response.product_url;
                    return;
                } else {
                    // Изменяем текст кнопки на "В корзине"
                    $thisButton.find('.add-to-cart-text').text('В корзине');
                    $thisButton.addClass('in-basket');
                    // Обновление количества товаров в корзине
                    $.ajax({
                        url: custom_ajax_obj.ajax_url,
                        type: 'post',
                        data: {
                            action: 'update_cart_count'
                        },
                        success: function (response) {
                            $('.cart-count').text(response.data.cart_count);
                        },
                        error: function (jqXHR, textStatus, errorThrown) {
                            console.error('Update cart count error:', textStatus, errorThrown);
                        }
                    });
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.error('AJAX error:', textStatus, errorThrown);
            }
        });

        return false;
    });

    // Обработчики для кнопок увеличения и уменьшения количества
    $('.quantity-arrow-minus').click(function () {
        var $qty = $(this).siblings('.quantity').find('.qty');
        var currentVal = parseInt($qty.val());
        if (!isNaN(currentVal) && currentVal > 1) {
            $qty.val(currentVal - 1);
        }
    });

    $('.quantity-arrow-plus').click(function () {
        var $qty = $(this).siblings('.quantity').find('.qty');
        var currentVal = parseInt($qty.val());
        if (!isNaN(currentVal)) {
            $qty.val(currentVal + 1);
        }
    });

    // Обновление корзины при изменении количества
    function updateCartCount() {
        $.ajax({
            url: custom_ajax_obj.ajax_url,
            type: 'post',
            data: {
                action: 'update_cart_count'
            },
            success: function (response) {
                $('.cart-count').text(response.data.cart_count);
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.error('Update cart count error:', textStatus, errorThrown);
            }
        });
    }

    // Добавляем событие на обновление корзины после изменения количества товаров
    $('body').on('added_to_cart', function () {
        updateCartCount();
    });
});

$(document).ready(function () {
    $(document).ajaxStop(function () {
        //добавляем стиль для всех лайкнутых элементов
        $('.delete_item').each(function () {
            var closestLi = $(this).closest('li');
            closestLi.addClass('added_to_wishlist');

            //для слайдера
            var closestSwiper = $(this).closest('.swiper-slide');
            closestSwiper.addClass('added_to_wishlist');

            $('.delete_item').contents().filter(function () {
                return this.nodeType === 3; // Удаляем только текстовые узлы
            }).remove();
        });

        //удаляем стиль для всех НЕ лайкнутых элементов - нужно для страницы карточки когда есть еще блоки просмотренные
        $('.add_to_wishlist').each(function () {
            var closestLi = $(this).closest('li');
            closestLi.removeClass('added_to_wishlist');

            //для слайдера
            var closestSwiper = $(this).closest('.swiper-slide');
            closestSwiper.removeClass('added_to_wishlist');
        });
    });

    // Отслеживаем клик на кнопке удаления из "понравившихся"
    $('body').on('click', '.delete_item', function (e) {
        var closestLi = $(this).closest('li');
        closestLi.removeClass('added_to_wishlist');

        //для слайдера
        var closestSwiper = $(this).closest('.swiper-slide');
        closestSwiper.removeClass('added_to_wishlist');

        // Обновляем счетчик в шапке страницы
        var currentCount = parseInt($('.header-wishlist .wishlist-count').text(), 10);
        $('.header-wishlist .wishlist-count').text(currentCount - 1);
    });

    // Отслеживаем клик на кнопке добавления в "понравившиеся"
    $('body').on('click', '.add_to_wishlist', function (e) {
        var closestLi = $(this).closest('li');
        $('.delete_item').contents().filter(function () {
            return this.nodeType === 3; // Удаляем только текстовые узлы
        }).remove();

        // Проверяем, есть ли уже класс added_to_wishlist
        if (!closestLi.hasClass('added_to_wishlist')) {
            closestLi.addClass('added_to_wishlist');

            // Обновляем счетчик в шапке страницы
            var currentCount = parseInt($('.header-wishlist .wishlist-count').text(), 10);
            $('.header-wishlist .wishlist-count').text(currentCount + 1);
        }
    });
});

jQuery(document).ready(function ($) {
    function updateCurrencySymbol() {
        $('.summary.entry-summary .woocommerce-Price-currencySymbol').text('₽');
    }

    updateCurrencySymbol();

    $(document).ajaxStop(function () {
        updateCurrencySymbol();
    });

    $(document).on('contentUpdated', function () {
        updateCurrencySymbol();
    });
});
