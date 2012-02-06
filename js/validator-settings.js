$(document).ready(function () {

    $('#createstart-page #v_num, #createformular-page .vnum-input').setValidator({max_length: 8});
    $('#createstart-page #r_num').setValidator({ high_letters: false, low_letters:false});

    $('#createformular-page #flight-price, #createformular-page .param #price').setValidator({only_digits : true});

    $('#createformular-page #personcount').setValidator({only_digits: true});

    $('.only-digits').setValidator({only_digits: true});

    $('#price-page input').setValidator({only_digits: true});
});