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

//удаляем слово выберите из фильтров в сайдбар
// jQuery(document).ready(function ($) {
//     function updatePlaceholders() {
//         $('input[placeholder^="Выберите"]').each(function () {
//             var placeholderText = $(this).attr('placeholder');
//             $(this).attr('placeholder', placeholderText.replace(/^Выберите\s*/, ''));
//         });
//     }

//     // обновляем placeholder сразу после загрузки
//     updatePlaceholders();

//     // Наблюдатель за изменениями в DOM
//     var observer = new MutationObserver(updatePlaceholders);
//     observer.observe(document.body, { childList: true, subtree: true });

//     // Останавливаем наблюдение через некоторое время (например, через 5 секунд)
//     setTimeout(function () {
//         observer.disconnect();
//     }, 5000); // 5 секунд
// });

