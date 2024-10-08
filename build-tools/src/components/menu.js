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

    function openCatalog(event) {
        event.preventDefault();
        var catalogLink = $(this);
        //console.log(catalogLink);
        var blockCatalog = $('#block-catalog');
        $('#main-header').addClass('header-not-fixed');
        
        //if (!catalogLink.hasClass('selected-item-menu')) {
            //console.log('open');
            catalogLink.addClass('selected-item-menu');
            blockCatalog.addClass('display_block');
            setTimeout(() => {
                blockCatalog.addClass('visible');
            }, 200);
            history.pushState(null, null, '#catalog');
        //}
    }

    function closeCatalogMenu(event) {
        event.preventDefault();
        var catalogLink = $('a[href="#catalog"]');
        var blockCatalog = $('#block-catalog');
        
        catalogLink.removeClass('selected-item-menu');
        blockCatalog.removeClass('visible');
            setTimeout(() => {
                blockCatalog.removeClass('display_block');
            }, 500);
        history.pushState(null, null, window.location.pathname + window.location.search);
    }

    function closeCatalogMenuBack(event) {
        event.preventDefault();
        var blockCatalog = $('#block-catalog');
        
        blockCatalog.removeClass('visible');
            setTimeout(() => {
                blockCatalog.removeClass('display_block');
            }, 500);
        history.pushState(null, null, window.location.pathname + window.location.search);
        $('#main-header').removeClass('header-not-fixed');
    }

    checkCatalogInUrl();

    $('a[href="#catalog"]').on('click', openCatalog);
    $('#close-catalog-menu').on('click', closeCatalogMenu);
    $('#close-catalog-menu-back').on('click', closeCatalogMenuBack);
});


$(document).ready(function() {
    $('#burger-menu').click(function() {
        $(this).toggleClass('active');
        $('#site-navigation').toggleClass('visible');
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
    $('#close-catalog-sidebar-x').on('click', closeCatalogSidebar);
});