$(function () {
    setNavigation();
});

function setNavigation() {
    var path = window.location.pathname;
    path = path.replace(/\/$/, "");
    path = decodeURIComponent(path);

    $(".nav a").each(function () {
        var href = $(this).attr('href');
        if (path.substring(0, href.length) === href) {
            $('li').removeClass('active');
            $(this).closest('li').addClass('active');
            $(this).closest('ul .submenu').removeClass('nav-hide');
            $(this).closest('ul .submenu').css("display","block");
            $(this).closest('ul .submenu').addClass('nav-show');
        }
    });
}