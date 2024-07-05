jQuery(document).ready(function ($) {
    $('.category-list li').has('ul.children').addClass('has-children');

    $('.category-list li.has-children > a').on('click', function (e) {
        e.preventDefault();
        var parent = $(this).parent();
        var children = parent.find('> ul.children');

        if (parent.hasClass('expanded')) {
            parent.removeClass('expanded');
            children.slideUp();
        } else {
            parent.addClass('expanded');
            children.slideDown();
        }
    });

    var currentCategory = $('.category-list .current-cat');
    currentCategory.parents('li').addClass('expanded');
    currentCategory.parents('ul.children').show();
});

// стилизация селекта при выборе значения из выпад списка
$(document).ready(function() {
    function checkSelectValues() {
        $('.attribute-filters__select select').each(function() {
            const $select = $(this);
            const $selectContainer = $select.parent();
            const $resetButton = $selectContainer.find('.reset-button');
            const $verticalLine = $selectContainer.find('.vertical-line');
            const selectedOptionValue = $select.val().trim();

            if (selectedOptionValue !== '') {
                $selectContainer.addClass('option-selected');
                $resetButton.css('opacity', '1');
                $verticalLine.css('display', 'block');
            } else {
                $selectContainer.removeClass('option-selected');
                $resetButton.css('opacity', '0');
                $verticalLine.css('display', 'none');
            }
        });
    }

    checkSelectValues();

    // вызываем ф-ю при изменении значения в селекте
    $('.attribute-filters__select select').on('change', function() {
        checkSelectValues();
    });

    // изменения при нажатии на кнопку - крестик
    $('.reset-button').on('click', function() {
        const $resetButton = $(this);
        const $selectContainer = $resetButton.parent();
        const $select = $selectContainer.find('select');
        $select.val('');
        $select.trigger('change');
    });

    // отслеживаем изменении в url
    function observeURLChanges(callback) {
        let lastUrl = window.location.href;
        new MutationObserver(() => {
            const currentUrl = window.location.href;
            if (currentUrl !== lastUrl) {
                lastUrl = currentUrl;
                callback();
            }
        }).observe(document, { subtree: true, childList: true });
    }

    // вызываем ф-ю при изменении url
    observeURLChanges(checkSelectValues);
});

