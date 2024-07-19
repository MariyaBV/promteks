document.addEventListener('DOMContentLoaded', function() {
    var content = document.querySelector('.description-content');
    var btn = document.querySelector('.custom-description .show-more-btn');

    btn.addEventListener('click', function() {
        content.style.maxHeight = 'none';
        btn.style.display = 'none';
    });
});
