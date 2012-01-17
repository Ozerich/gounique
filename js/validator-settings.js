$(document).ready(function () {

    $('#createstart-page #v_num, #createformular-page .vnum-input').setValidator({ digits:false, low_letters:false, symbolic:false, max_length: 6});
    $('#createstart-page #r_num').setValidator({ high_letters: false, low_letters:false, symbolic:false});

    $('#createformular-page #flight-price, #createformular-page .param #price').setValidator({only_digits : true});

    $('#createformular-page #personcount').setValidator({only_digits: true});
});