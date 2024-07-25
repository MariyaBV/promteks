$(document).ready(function() {
    var $content = $('.description-content');
    var $btn = $('.custom-description .show-more-btn');

    if ($content.prop('scrollHeight') > 299) {
        $btn.css('display', 'block');
    } else {
        $btn.css('display', 'none');
    }

    $btn.on('click', function() {
        $content.css('maxHeight', 'none');
        $btn.css('display', 'none');
    });
});

