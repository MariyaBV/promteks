$(document).ready(function ($) {
    $("body").on("click", "ul.custom-shipping-method .init", function () {
        var $options = $(this).closest("ul.custom-shipping-method").children('li:not(.init)');
        $options.toggleClass('visible');
    });

    var allOptions = $("ul.custom-shipping-method").children('li:not(.init)');

    $("body").on("click", "ul.custom-shipping-method li:not(.init)", function () {
        allOptions.removeClass('selected');
        $(this).addClass('selected');

        // убираем <input> чтобы не было одинаковых input c одинаковыми id
        var selectedHtml = $(this).clone().find('input').remove().end().html();

        $("ul.custom-shipping-method").children('.init').html(selectedHtml);
        allOptions.removeClass('visible');

        // Обновляем скрытое радио-поле, чтобы отправить AJAX-запрос только при изменении метода доставки
        var radioInput = $(this).find('input.shipping_method');
        if (radioInput.length) {
            radioInput.prop('checked', true).trigger('change');
        }
    });

    // Обработчик изменения метода доставки
    $("body").on("change", '#shipping_method input.shipping_method', function () {
        var selectedMethod = $(this).val();
        var shippingLabel = $(this).siblings('label').text().trim();
        var shippingCost = $(this).siblings('label').find('.woocommerce-Price-amount').text().trim();

        if (typeof wc_cart_params !== 'undefined') {
            // Сохраняем метод доставки в сессии
            $.ajax({
                type: 'POST',
                url: wc_cart_params.ajax_url,
                data: {
                    action: 'save_selected_shipping_method',
                    shipping_method: selectedMethod,
                    shipping_label: shippingLabel,
                    shipping_cost: shippingCost
                },
                success: function () {
                    // Сохраняем выбор в локальном хранилище тк при отправке данных ajax корзины сбрасывался выбранный метод
                    localStorage.setItem('selected_shipping_method', JSON.stringify({
                        method: selectedMethod,
                        label: shippingLabel,
                        cost: shippingCost
                    }));
                }
            });
        }
    });

    // Обработчик клика по кнопке Оформить заказ
    $("body").on("click", ".checkout-button", function (e) {
        e.preventDefault();

        var checkoutUrl = $(this).attr('href');
        var selectedMethod = localStorage.getItem('selected_shipping_method');
        if (!selectedMethod) {
            selectedMethod = JSON.stringify({ "method": "local_pickup:8", "label": "Самовывоз 0₽", "cost": "0₽" });
        }
        if (selectedMethod) {
            var parsedMethod = JSON.parse(selectedMethod);

            $.when(
                $.ajax({
                    type: 'POST',
                    url: wc_cart_params.ajax_url,
                    data: {
                        action: 'save_selected_shipping_method',
                        shipping_method: parsedMethod.method,
                        shipping_label: parsedMethod.label,
                        shipping_cost: parsedMethod.cost
                    }
                })
            ).done(function () {
                window.location.href = checkoutUrl;
            }).fail(function () {
                // Если что-то пошло не так, всё равно переходим на страницу оформления заказа
                window.location.href = checkoutUrl;
            });
        }

    });

    // Запускаем проверку при загрузке страницы
    function restoreSelectedShippingMethod() {
        var savedMethod = localStorage.getItem('selected_shipping_method');
        if (!savedMethod) {
            savedMethod = JSON.stringify({ "method": "local_pickup:8", "label": "Самовывоз 0₽", "cost": "0₽" });
        }
        if (savedMethod) {
            savedMethod = JSON.parse(savedMethod);
            var $input = $('#shipping_method input.shipping_method[value="' + savedMethod.method + '"]');
            if ($input.length) {
                $input.prop('checked', true);

                // убираем <input> чтобы не было одинаковых input c одинаковыми id
                var selectedHtml = $input.closest('li').clone().find('input').remove().end().html();

                $("ul.custom-shipping-method").children('.init').html(selectedHtml);
                $input.closest('li').addClass('selected');
            }
        }
    }

    restoreSelectedShippingMethod();

    // Восстановление выбора после обновления корзины
    $(document).on('updated_cart_totals', function () {
        restoreSelectedShippingMethod();
    });
});
