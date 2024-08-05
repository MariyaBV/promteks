$(document).ready(function () {
    function quantityProducts() {
        var $quantityArrowMinus = $(".quantity-arrow-minus");
        var $quantityArrowPlus = $(".quantity-arrow-plus");
        var $quantityNum = $(".input-text.qty.text");

        if ($quantityArrowMinus.length && $quantityArrowPlus.length && $quantityNum.length) {
            $quantityArrowMinus.on("click", function (event) {
                event.preventDefault();
                quantityMinus();
            });

            $quantityArrowPlus.on("click", function (event) {
                event.preventDefault();
                quantityPlus();
            });
        }

        function quantityMinus() {
            var currentValue = parseInt($quantityNum.val());
            if (currentValue > 1) {
                $quantityNum.val(currentValue - 1);
            }
        }

        function quantityPlus() {
            var currentValue = parseInt($quantityNum.val());
            $quantityNum.val(currentValue + 1);
        }
    }

    quantityProducts();
});

// Обработчик для кнопки "Купить"
$(document).ready(function ($) {
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
                    updateCartCount();
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
    $(document).on('updated_cart_totals', function () {
        updateCartCount();
        console.log("Cart totals updated.");
    });
});

