$(document).on("scroll", function () {
    if ($(document).scrollTop() > 90) {
        $("header").addClass("shrink");
    } else {
        $("header").removeClass("shrink");
    }
});

$('a[href*="#"]')
    .not('[href="#"]')
    .not('[href="#0"]')
    .click(function (event) {
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

$('form').submit(function (event) {
    var formData = {
        'name' : $('input[name=name]').val(),
        'email' : $('input[name=email]').val(),
        'subject' : $('input[name=subject]').val(),
        'message' : $('input[name=message]').val()
    };
    
    $.ajax({
        type : 'POST',
        url : 'submit.php',
        data : formData,
        dataType : 'json',
        encode : true
    })
        .done(function (data) {
            alert("success");
        });
    event.preventDefault();
});