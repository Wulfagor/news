function magic_dark_wrapper(action, duration) {
    if (duration == undefined) {
        duration = 250;
    }

    if ($("body .dark_wrapper").hasClass("load_page")) {
        $("body .dark_wrapper").animate({"opacity": "0"}, duration, function () {
            $("body .dark_wrapper").css("display", "none");
            $("body .dark_wrapper").removeClass("load_page");
        });

        return true;
    }

    if (action == undefined) {
        if (!open_dark_wrapper) {
            $("body .dark_wrapper").css("display", "block").animate({"opacity": "0.9"}, duration);
            $("body").addClass("dark");
            open_dark_wrapper = 1;
        } else {
            $("body .dark_wrapper").animate({"opacity": "0"}, duration, function () {
                $("body .dark_wrapper").css("display", "none");
                open_dark_wrapper = 0;
            });
            $("body").removeClass("dark");
        }

        return true;
    }

    switch (action) {
        case "show":
            if (!open_dark_wrapper) {
                $("body .dark_wrapper").css("display", "block").animate({"opacity": "0.9"}, duration);
                $("body").addClass("dark");
                open_dark_wrapper = 1;
            }
            return true;
            break;
        case "hide":
            if (open_dark_wrapper) {
                $("body .dark_wrapper").animate({"opacity": "0"}, duration, function () {
                    $("body .dark_wrapper").css("display", "none");
                    open_dark_wrapper = 0;
                });
                $("body").removeClass("dark");
                return true;
            }
            break;
        default:
            magic_dark_wrapper();
            break;
    }

    return true;
}

function show_form_authorization() {
    var deferred = $.Deferred();

    if (open_form_register) {
        open_form_register = 0;
        $("#form_register").removeClass("show_once");
        $(".popup_overlay").removeClass("show_once");
        clearTimeout(timer_clear);
        timer_clear = setTimeout(show_form_authorization, 300);
    } else {
        if (!open_form_authorization) {
            open_form_authorization = 1;

            magic_dark_wrapper("show", 300);
            $(".popup_overlay").addClass("show_once");
            $("#form_authorization").addClass("show_once");
        }
        else {
            open_form_authorization = 0;
            magic_dark_wrapper("hide", 300);
            $("#form_authorization").removeClass("show_once");
            $(".popup_overlay").removeClass("show_once");
        }
    }
}

function show_form_register(success) {
    var deferred = $.Deferred();

    if (success == undefined)
        success = false;

    if (open_form_authorization) {
        open_form_authorization = 0;
        $(".popup_overlay").removeClass("show_once");
        $("#form_authorization").removeClass("show_once");
        clearTimeout(timer_clear);
        timer_clear = setTimeout(show_form_register, 300);
    } else {
        if (!success) {
            if (!open_form_register) {
                open_form_register = 1;

                magic_dark_wrapper("show", 300);
                $(".popup_overlay").addClass("show_once");
                $("#form_register").addClass("show_once");
            } else {
                open_form_register = 0;
                magic_dark_wrapper("hide", 300);
                $(".popup_overlay").removeClass("show_once");
                $("#form_register").removeClass("show_once");
            }
        } else {
            if (!open_form_register_success) {
                open_form_register_success = 1;

                magic_dark_wrapper("show", 300);
                clearTimeout(timer);
                $("#form_register").removeClass("show_once");
                $("#form_register_success").addClass("show_once");
            } else {
                open_form_register_success = 0;
                open_form_register = 0;
                magic_dark_wrapper("hide", 300);
                $("#form_register_success").removeClass("show_once");
                $(".popup_overlay").removeClass("show_once");
            }
        }
    }
}

function only_numbers(key) {
    if (
        (key.charCode < 48 || key.charCode > 57) && //only numbers
        key.charCode != 44 //,
    )
        return false;
}

function initSizeWindow() {
    window_width = $(window).width();
    window_height = $(window).height();
}

function exists(element) {
    return $(element).length;
}

function sleep(milliseconds) {
    var start = new Date().getTime();
    for (var i = 0; i < 1e7; i++) {
        if ((new Date().getTime() - start) > milliseconds) {
            break;
        }
    }
}

function goToHash() {
    var loc = window.location.hash.replace("#", "");
    if (loc == "")
        return false;

    if (!exists("#" + loc))
        return false;

    var destination = $("#" + loc).offset().top;
    $("body").addClass("disable-hover");
    $("body, html").animate({scrollTop: destination}, 500, function () {
        $("body").removeClass("disable-hover");
    });
}

function goToHashManual(loc) {
    if (loc == "")
        return false;

    if (!exists("#" + loc))
        return false;

    var destination = $("#" + loc).offset().top - 50;
    $("body").addClass("disable-hover");
    $("body, html").animate({scrollTop: destination}, 500, function () {
        $("body").removeClass("disable-hover");
    });
}

function checkISMSIE() {
    var rv = -1;
    if (navigator.appName == 'Microsoft Internet Explorer') {
        var ua = navigator.userAgent;
        var re = new RegExp("MSIE ([0-9]{1,}[\.0-9]{0,})");
        if (re.exec(ua) != null)
            rv = parseFloat(RegExp.$1);
    }
    else if (navigator.appName == 'Netscape') {
        var ua = navigator.userAgent;
        var re = new RegExp("Trident/.*rv:([0-9]{1,}[\.0-9]{0,})");
        if (re.exec(ua) != null)
            rv = parseFloat(RegExp.$1);
    }

    if (rv > 0)
        isMSIE = 1;

    return rv;
}

function getUrlParameter(sParam) {
    var sPageURL = decodeURIComponent(window.location.search.substring(1)),
        sURLVariables = sPageURL.split('&'),
        sParameterName,
        i;

    for (i = 0; i < sURLVariables.length; i++) {
        sParameterName = sURLVariables[i].split('=');

        if (sParameterName[0] === sParam) {
            return sParameterName[1] === undefined ? true : sParameterName[1];
        }
    }
}