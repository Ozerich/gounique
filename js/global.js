var KEY_ENTER = 13;
var KEY_ESC = 27;
var KEY_RIGHT = 39;
var KEY_LEFT = 37;
var KEY_TAB = 9;

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