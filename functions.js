$(document).on("scroll", function () {
    if ($(document).scrollTop() > 90) {
        $("header").addClass("shrink");
    } else {
        $("header").removeClass("shrink");
    }
});

$('a[href*="#"]').not('[href="#"]').not('[href="#0"]').click(function (event) {
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

$('form').submit(function () {
    event.preventDefault();
    $.ajax({
        type: 'POST',
        url: 'submit.php',
        dataType: 'json',
        data: $(this).serialize()
    })
        .done(function (data) {
            if (data.nameErr === '' && data.emailErr === '' && data.messageErr === '') {
                $("input[name='name'], input[name='email'], input[name='subject'], textarea").val('');
                $('button').after('<p>Message sent!</p>');
            } else {
                if (data.messageErr !== '') {
                    $('button').after(data.messageErr);
                }
                if (data.emailErr !== '') {
                    $('button').after(data.emailErr);
                }
                if (data.nameErr !== '') {
                    $('button').after(data.nameErr);
                }
            }
        });
});

/*$(document).bind('ajaxStart', function () {
    $('button').after("<i id='loader' class='fa fa-spinner fa-pulse fa-fw'></i>");
}).bind('ajaxStop', function () {
    $('#loader').remove();
});*/
