jQuery(document).ready(function ($) {
    $('.category-list li').has('ul.children').addClass('has-children');
    $('.category-list li.has-children > a').addClass('icon-Down-3');

    $('.category-list li.has-children > a').on('click', function (e) {
        e.preventDefault();
        var parent = $(this).parent();
        var children = parent.find('> ul.children');

        if (parent.hasClass('expanded')) {
            parent.removeClass('expanded').removeClass('icon-Vector-9');
            $(this).addClass('icon-Down-3');
            children.slideUp();
        } else {
            parent.addClass('expanded').addClass('icon-Vector-9');
            $(this).removeClass('icon-Down-3');
            children.slideDown();
        }
    });

    // Применение стиля к ранее выбранному дочернему элементу или родителю - если нет дочерних
    // var selectedCategory = localStorage.getItem('selectedCategory');
    // if (selectedCategory) {
    //     var selectedElement = $('#' + selectedCategory);
    //     selectedElement.addClass('selected');
    //     selectedElement.parents('li').addClass('expanded').children('ul.children').show();
    //     if (selectedElement.parents('li').find('ul.children').length !== 0) {
    //         var parentSelectedElement = selectedElement.parent().parent();
    //         parentSelectedElement.addClass('icon-Vector-9');
    //         var selectedElementLink = parentSelectedElement.find('a');
    //         console.log(selectedElementLink);
    //         selectedElementLink.removeClass('icon-Down-3');
    //     }
    // }

    // Добавление стиля при выборе элемента
    // $('.category-list li a').on('click', function (e) {
    //     var liElement = $(this).parent();
    //     if (liElement.find('ul.children').length === 0) {
    //         // Если у элемента нет дочерних элементов, применяем стиль к нему
    //         $('.category-list li').removeClass('selected');
    //         liElement.addClass('selected');
    //         localStorage.setItem('selectedCategory', liElement.attr('id'));
    //     } else {
    //         // Если у элемента есть дочерние элементы, ничего не делаем
    //         e.preventDefault();
    //     }
    // });

    // Добавление стиля при выборе дочернего элемента
    // $('.category-list ul.children li a').on('click', function (e) {
    //     var liElement = $(this).parent();
    //     $('.category-list li').removeClass('selected');
    //     liElement.addClass('selected');
    //     localStorage.setItem('selectedCategory', liElement.attr('id'));
    // });
});


// стилизация селекта при выборе значения из выпад списка в фильтрах
$(document).ready(function () {
    function checkSelectValues() {
        $('.attribute-filters__select select').each(function () {
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
    $('.attribute-filters__select select').on('change', function () {
        checkSelectValues();
    });

    // изменения при нажатии на кнопку - крестик
    $('.reset-button').on('click', function () {
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

