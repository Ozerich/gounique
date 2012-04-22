var KEY_ENTER = 13;
var KEY_ESC = 27;
var KEY_RIGHT = 39;
var KEY_LEFT = 37;
var KEY_TAB = 9;

var ONE_DAY = 1000 * 60 * 60 * 24;

function InputToTime(time) {
    return time.substr(0, 2) + '.' + time.substr(2, 2) + '.' + time.substr(4);
}

function str_replace(search, replace, subject) {
    return subject.split(search).join(replace);
}

function DateToInput(a) {
    if (typeof a == 'string')
        a = new Date(str_replace('.', ' ', a));

    return (a.getDate() < 10 ? "0" + a.getDate() : a.getDate()) + "" +
        (a.getMonth() < 9 ? "0" + (a.getMonth() + 1) : (a.getMonth() + 1)) + "" +
        a.getFullYear()
}

function PriceToInput(price) {
    return str_replace('.', '', price);
}

function FixDate(input) {
    return input.substr(0, 2) + "." + input.substr(2, 2) + "." + input.substr(4);
}

function isInt(x) {
    var y = parseInt(x);
    if (isNaN(y)) return false;
    return x == y && x.toString() == y.toString();
}

function validateEmail(email) {

    if (email.length < 5)
        return false;
    var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
    return reg.test(email);
}

function isValidDate(d) {
    if (Object.prototype.toString.call(d) === "[object Date]")
        return !isNaN(d.getTime());
    else
        return false;
}

jQuery.fn.check_empty = function () {
    var result = true;
    $(this).each(function () {
        if ($(this).attr('type') != 'hidden' && $(this).val() == '') {
            result = false;
            $(this).addClass('error');
        }
        else
            $(this).removeClass('error');
    });
    return result;
}

jQuery.fn.reset = function () {
    $(this).find(':input').each(function () {
        switch (this.type) {
            case 'password':
            case 'select-multiple':
            case 'select-one':
            case 'text':
            case 'textarea':
                $(this).val('');
                break;
            case 'checkbox':
            case 'radio':
                this.checked = false;
        }
    });
    return this;
}

jQuery.fn.center = function () {
    this.css("position", "absolute");
    this.css("top", (($(window).height() - this.outerHeight()) / 2) +
        $(window).scrollTop() + "px");
    this.css("left", (($(window).width() - this.outerWidth()) / 2) +
        $(window).scrollLeft() + "px");
    return this;
}

function isNumber(n) {
    return !isNaN(parseFloat(n)) && isFinite(n);
}

jQuery.fn.setdatepicker = function () {
    var old = $(this).val();
    $(this).datepicker({
        changeMonth:true,
        changeYear:true
    }).datepicker("option", "showAnim", "blind").datepicker("option", "dateFormat", 'ddmmyy').val(old);
    return $(this);
}

function OpenOverlay() {
    var maskHeight = $(document).height();
    var maskWidth = $(window).width();
    $('#dark-overlay').css({'width':maskWidth, 'height':maskHeight});
    $('#dark-overlay').fadeIn(1000);
    $('#dark-overlay').fadeTo("slow", 0.8, function () {
        $(this).addClass('finished')
    });
    $('#overlay-window').draggable({containment:'window'});
}

$(document).ready(function () {
    $('.buttonset').buttonset();
    $('.set_datepicker').setdatepicker();
});

