$(document).on("scroll", function () {
    "use strict";
    if ($(document).scrollTop() > 90) {
        $("header").addClass("shrink");
    } else {
        $("header").removeClass("shrink");
    }
});

$('a[href*="#"]').not('[href="#"]').not('[href="#0"]').click(function (event) {
    "use strict";
    if (location.pathname.replace(/^\//, '') === this.pathname.replace(/^\//, '') && location.hostname === this.hostname) {
        var target = $(this.hash);
        target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
        if (target.length) {
            event.preventDefault();
            $('html, body').animate({
                scrollTop: target.offset().top
            }, 1000, function () {
                var $target = $(target);
                $target.focus();
                if ($target.is(":focus")) {
                    return false;
                } else {
                    $target.attr('tabindex', '-1');
                    $target.focus();
                }
            });
        }
    }
});

/*global $*/

$("form").submit(function () {
    "use strict";
    event.preventDefault();
    $.ajax({
        type: "POST",
        url: "submit.php",
        data: $(this).serialize(),
        success: function (response) {
            if (response = "Message sent") {
                $("input[name='name'], input[name='email'], input[name='subject'], textarea").val("");
                $("input[name='submit']").after("<p>" + response + "</p>");
            } else {
                $("input[name='submit']").after("<p>" + response + "</p>");
            }
        }
    });
});

/*$('.loader').bind('ajaxStart', function () {
    "use strict";
    $(this).show();
}).bind('ajaxStop', function () {
    "use strict";
    $(this).hide();
});*/
