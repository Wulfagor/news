window.isMSIE = 0;
window.window_width = 0;
window.window_height = 0;
window.open_form_authorization = 0;
window.open_form_register = 0;
window.open_form_register_success = 0;
window.open_dark_wrapper = 0;
var body = document.body,
    timer,
    timer_clear;

window.addEventListener('scroll', function () {
    clearTimeout(timer);
    if (!body.classList.contains('disable-hover')) {
        body.classList.add('disable-hover')
    }

    timer = setTimeout(function () {
        body.classList.remove('disable-hover')
    }, 100);
}, false);

$(window).load(function () {
    magic_dark_wrapper();
    $("#form_authorization, #form_register, #form_register_success").addClass("magic");
});

$(document).on("ready", function () {

    checkISMSIE();
    goToHash();
    initSizeWindow();

    $("body").click(function (element) {

        if (open_form_authorization != 0) {
            if ($(element.target).closest("#form_authorization").length != 1 && $(element.target).closest("#menu_item_authorization").length != 1) {
                show_form_authorization();
            }
        }

        if (open_form_register != 0) {
            if ($(element.target).closest("#form_register").length != 1 && $(element.target).closest("#menu_item_register").length != 1) {
                show_form_register();
            }
        }
    });
});

$(document).on({
    ready: function() {
        return $('body').on('click', '.magic_dialog', function(e) {
            var url = false;
            var href_element = $(this).attr("href");
            if(typeof(href_element) != "undefined" && href_element != "") {
                url = href_element;
            }

            if(url) {
                event.preventDefault();

                $.ajax({
                    url: url,
                    success: function(response){
                        bootbox.dialog({
                            message: response
                        });
                    },
                    error: function(response) {
                        console.log(response);
                    }
                });

            } else
                return true;
        });
    }
});