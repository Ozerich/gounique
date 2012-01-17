jQuery.fn.setValidator = function (conf) {
    var config = jQuery.extend({

        digits:true,
        low_letters:true,
        high_letters:true,
        symbolic:true,
        max_length: 9999999,
        only_digits: false

    }, conf);
    var input = $(this);

    if(config.only_digits)
        config.low_letters = config.high_letters = config.symbolic = false;

    $(input).bind("keypress", function (event) {

        if (event.ctrlKey)return true;
        if (event.keyCode != 0)return true;

        if($(input).val().length >= config.max_length)return false;

        if (event.charCode >= 48 && event.charCode <= 57) {
            if (!config.digits)
                return false;
        }

        else if (event.charCode >= 97 && event.charCode <= 122) {
            if (!config.low_letters)
                return false;
        }

        else  if (event.charCode >= 65 && event.charCode <= 90) {
            if (!config.high_letters)
                return false;
        }

        else {
            if (!config.symbolic)
                return false;
        }

        return true;
    })
}