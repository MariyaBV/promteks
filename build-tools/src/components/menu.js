$(document).ready(function($) {
    function checkCatalogInUrl() {
        var url = window.location.href;
        var catalogLink = $('a[href="#catalog"]');
        var blockCatalog = $('#block-catalog');
        
        
        if (url.includes('#catalog') && catalogLink.length) {
            catalogLink.addClass('selected-item-menu');
            blockCatalog.addClass('visible');
        } else {
            catalogLink.removeClass('selected-item-menu');
            blockCatalog.removeClass('visible');
        }
    }

    function toggleCatalogClass(event) {
        event.preventDefault();
        $(this).toggleClass('selected-item-menu');
        var blockCatalog = $('#block-catalog');
        
        if ($(this).hasClass('selected-item-menu')) {
            history.pushState(null, null, '#catalog');
            blockCatalog.addClass('visible');
        } else {
            history.pushState(null, null, window.location.pathname + window.location.search);
            blockCatalog.removeClass('visible');
        }
    }

    function closeCatalogMenu(event) {
        event.preventDefault();
        var catalogLink = $('a[href="#catalog"]');
        var blockCatalog = $('#block-catalog');
        
        catalogLink.removeClass('selected-item-menu');
        blockCatalog.removeClass('visible');
        history.pushState(null, null, window.location.pathname + window.location.search);
    }

    checkCatalogInUrl();

    $('a[href="#catalog"]').on('click', toggleCatalogClass);
    $('#close-catalog-menu').on('click', closeCatalogMenu);
});


$(document).ready(function() {
    $('#burger-menu').click(function() {
        $(this).toggleClass('active');
        $('#main-header').toggleClass('header-fixed');
        $('#site-navigation').toggleClass('visible');
    });

    $('a[href="#catalog"]').on('click', function() {
        $('#site-navigation').removeClass('visible');
        $('#main-header').removeClass('header-fixed');
        $('#burger-menu').removeClass('active');
    });
});



$(document).ready(function($) {
    function closeCatalogSidebar(event) {
        event.preventDefault();
        var sidebarCatalog = $('#catalog-sidebar');
        sidebarCatalog.removeClass('visible-mobile');
    }

    function openCatalogSidebar(event) {
        event.preventDefault();
        var sidebarCatalog = $('#catalog-sidebar');
        sidebarCatalog.addClass('visible-mobile');
    }

    $('#show-catalog-sidebar').on('click', openCatalogSidebar);
    $('#close-catalog-sidebar').on('click', closeCatalogSidebar);
});