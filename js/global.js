var KEY_ENTER = 13;
var KEY_ESC = 27;
var KEY_RIGHT = 39;
var KEY_LEFT = 37;
var KEY_TAB = 9;

var ONE_DAY = 1000*60*60*24;

function InputToTime(time) {
    return time.substr(0, 2) + '.' + time.substr(2, 2) + '.' + time.substr(4);
}

function DateToInput(a) {
    return (a.getDate() < 10 ? "0" + a.getDate() : a.getDate()) + "" +
        (a.getMonth() < 9 ? "0" + (a.getMonth() + 1) : (a.getMonth() + 1)) + "" +
        a.getFullYear()
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