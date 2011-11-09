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
