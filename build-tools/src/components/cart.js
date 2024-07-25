$(document).ready(function ($) {
    if (typeof wc_cart_params !== 'undefined') {
        // Делегируем события для выпадающего списка методов доставки
        $("body").on("click", "ul.custom-shipping-method .init", function () {
            var $options = $(this).closest("ul.custom-shipping-method").children('li:not(.init)');
            $options.toggleClass('visible');
        });

        var allOptions = $("ul.custom-shipping-method").children('li:not(.init)');

        $("body").on("click", "ul.custom-shipping-method li:not(.init)", function () {
            allOptions.removeClass('selected');
            $(this).addClass('selected');
            var selectedHtml = $(this).html();
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

            console.log(selectedMethod, shippingLabel, shippingCost);

            // Сохраняем метод доставки в сессии
            $.ajax({
                type: 'POST',
                url: wc_cart_params.ajax_url, // Используем wc_cart_params для URL
                data: {
                    action: 'save_selected_shipping_method',
                    shipping_method: selectedMethod,
                    shipping_label: shippingLabel,
                    shipping_cost: shippingCost
                },
                success: function() {
                    // Сохраняем выбор в локальном хранилище тк при отправке  данных ajax корзины сбрасывался выбранный метод
                    localStorage.setItem('selected_shipping_method', JSON.stringify({
                        method: selectedMethod,
                        label: shippingLabel,
                        cost: shippingCost
                    }));
                }
            });
        });

        // Запускаем проверку при загрузке страницы
        function restoreSelectedShippingMethod() {
            var savedMethod = localStorage.getItem('selected_shipping_method');
            if (savedMethod) {
                savedMethod = JSON.parse(savedMethod);
                var $input = $('#shipping_method input.shipping_method[value="' + savedMethod.method + '"]');
                if ($input.length) {
                    $input.prop('checked', true);
                    var selectedHtml = $input.closest('li').html();
                    $("ul.custom-shipping-method").children('.init').html(selectedHtml);
                    $input.closest('li').addClass('selected');
                }
            }
        }

        restoreSelectedShippingMethod();

        // Восстановление выбора после обновления корзины (
        $(document).on('updated_cart_totals', function () {
            restoreSelectedShippingMethod();
        });
    }
});


