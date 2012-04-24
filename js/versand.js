function open_comment(evnt) {
    evnt.preventDefault();

    var line = $(evnt.target).parents('tr');

    $('.finance-new-comment').hide();
    $(line).find('.finance-new-comment').show();

    return false;
}

function close_comment(evnt) {
    $('.finance-new-comment').hide();
}

function save_comment(evnt, type) {
    var line = $(evnt.target).parents('tr');
    $(line).find('.comment-baloon pre').html($(line).find('.finance-new-comment-text').val());

    $.post('control/update_comment/' + type + '/' + $(line).find('.formular_id').val(), 'text=' + $(line).find('.finance-new-comment-text').val());
    $('.finance-new-comment').hide();
}

function show_comment_baloon(evnt) {
    var line = $(evnt.target).parents('tr');
    if ($(line).find('.comment-baloon pre').html() != '')
        $(line).find('.comment-baloon').show();
}

function hide_comment_baloon(evnt) {
    var line = $(evnt.target).parents('tr');
    $(line).find('.comment-baloon').hide();
}

function BindPaymentEvents(block) {

    $('#check_versand').click(function () {
        $(this).attr('disabled', 'disabled');
        $.ajax({
            url:'control/versand/' + $('#payments_formular_id').val(),
            type:'post',
            data:'value=' + ($(this).is(':checked') ? 1 : 0),
            success:function () {
                $('#check_versand').removeAttr('disabled');
                $('.closepopup-button').click();
            }
        });
    });

}

function BindSelectLineEvent() {
    $('#controlpayments-list tbody tr').not('.total, .comment').find('td').not('.no-popup').click(function () {
        var line = $(this).parents('tr');
        if ($(line).hasClass('current')) {
            if ($(line).hasClass('no-open'))
                return false;
            $('#show-payments').click();
        }
        else {
            $('#controlpayments-list tr').removeClass('current');
            $('#controlpayments-list tr.comment').hide();
            $(line).addClass('current');
            if ($(line).next().hasClass('comment'))
                $(line).next().show();
        }
    });
}

$(document).ready(function () {
    BindSelectLineEvent();

    $('#dark-overlay').click(function () {

        if (!$(this).hasClass('finished'))
            return false;

        $.ajax({
            url:'versand/search',
            type:'post',
            data:$('#last_searchquery').val(),
            success:function (data) {
                $('#controlpayments-list tbody').empty().html(data);
                BindSelectLineEvent();
            }
        });
        $('#show-payments').hide();
        $(this).fadeOut();
        $(this).removeClass('finished');
        $('#overlay-window').hide();
    });


    $('#show-payments').click(function () {
        OpenOverlay();

        $.ajax({
            url:'versand/info/' + $('#controlpayments-list tr.current .formular_id').val(),
            success:function (data) {
                $('#overlay-window').html(data).show().center();

                $('#payments-page .closepopup-button').click(function () {
                    $('#dark-overlay').click();
                    return false;
                });

                BindPaymentEvents();


            }
        });

        return false;
    });

    $('.num-search #v_num, .num-search #r_num').keyup(function () {
        var val = $(this).val();
        var search_field = $(this).attr('id');
        var search_str = 'search_field=' + search_field + '&search_string=' + val;
        $('#last_searchquery').val(search_str);
        $.ajax({
            url:'versand/search',
            type:'post',
            data:search_str,
            success:function (data) {
                $('#controlpayments-list tbody').empty().html(data);
                BindSelectLineEvent();
            }
        });
    });

    $('#clear_filter').click(function () {
        $('.hotellist-top input').val('');
        $.ajax({
            url:'versand/search',
            success:function (data) {
                $('#controlpayments-list tbody').empty().html(data);
                BindSelectLineEvent();
            }
        });
        return false;
    });

    $('.date-search #datesearch-start').click(function () {

        if ($('.date-search input[type=text]:visible.error').size())return false;

        $(this).addClass('loading');
        var button = $(this);
        var search_field = $(this).attr('id');
        var search_str = 'search_field=' + $('#datesearch-type option:selected').val() + '&von=' + $('#search-von').val() + "&bis=" + $('#search-bis').val();
        if ($('#ag_num').val())
            search_str += '&ag_num=' + $('#ag_num').val();
        if ($('#person').val())
            search_str += '&person=' + $('#person').val();

        $('#last_searchquery').val(search_str);
        $.ajax({
            url:'versand/search',
            type:'post',
            data:search_str,
            success:function (data) {
                $('#controlpayments-list tbody, .finanzen-list tbody').empty().html(data);
                BindSelectLineEvent();
                $(button).removeClass('loading');
            }
        });
    });

    $('.date-search #search-von, .date-search #search-bis').setdatepicker();

    $('.incoming-block .new-invoice').click(function () {
        var new_block = $(this).parents('.incoming-block').find('.newinvoice-block');
        if ($(new_block).is(':visible')) {
            $(this).html('Rechnung');
            $(new_block).find('.save-invoice').hide();
        }
        else
            $(this).html('Close');

        $(new_block).reset().toggle();

        return false;
    });

    $('.incoming-block .incoming-type').change(
        function () {
            var incoming_id = $(this).val();
            var block = $(this).parents('.incoming-block');
            $(block).find('.invoice-list').hide();
            $(block).find('.invoice-list[for=' + incoming_id + ']').show();
        }).change();

    $('.incoming-block .newinvoice-block .invoice-date').setdatepicker();

    $('.incoming-block .save-invoice').click(function () {
        var block = $(this).parents('.incoming-block');

        var error = false;
        $(block).find('.newinvoice-block input[type=text]').each(function () {
            if ($(this).val() == '') {
                $(this).addClass('error');
                error = true;
            }
            else
                $(this).removeClass('error');
        });

        var data = 'date=' + $(block).find('.invoice-date').val() + '&amount=' + $(block).find('.invoice-amount').val() +
            '&remark=' + $(block).find('.invoice-remark').val() + '&type=' + $(block).find('.block-type').val() + '&number=' + $(block).find('.invoice-num').val();
        var button = $(this);
        if (!error) {
            $(button).attr('disabled', 'disabled');
            $.ajax({
                url:'control/update_invoice/' + $(block).find('.save-invoice-id').val(),
                type:'post',
                data:data,
                success:function (data) {
                    $(block).find('input[type=text],textarea').val('');
                    $(block).find('.new-invoice').click();
                    data = jQuery.parseJSON(data);
                    $(block).find('.invoices').empty().html(data.invoices);
                    $('#statistik').empty().html(data.stats);
                    $(block).find('.incoming-type').change();
                    UpdateInvoiceList(block);
                },
                complete:function () {
                    $(button).removeAttr('disabled');
                }
            });
        }
        return false;
    });

    $('.incoming-block .add-invoice').click(function () {

        var block = $(this).parents('.incoming-block');

        var error = false;
        $(block).find('.newinvoice-block input[type=text]').each(function () {
            if ($(this).val() == '') {
                $(this).addClass('error');
                error = true;
            }
            else
                $(this).removeClass('error');
        });

        if (!error) {
            var button = $(this);
            $(this).attr('disabled', 'disabled');
            var type = $(block).find('.block-type').val();
            $.ajax({
                url:'control/add_invoice/' + $('#invoice_formular_id').val() +
                    (type == "other" ? '' : "/" + $(block).find('.incoming-type option:selected').val()),
                type:'post',
                data:'date=' + $(block).find('.invoice-date').val() + '&amount=' + $(block).find('.invoice-amount').val() +
                    '&remark=' + $(block).find('.invoice-remark').val() + '&type=' + $(block).find('.block-type').val() + '&number=' + $(block).find('.invoice-num').val(),
                success:function (data) {
                    $(block).find('input[type=text],textarea').val('');
                    $(button).removeAttr('disabled');
                    $(block).find('.new-invoice').click();
                    data = jQuery.parseJSON(data);
                    $(block).find('.invoices').empty().html(data.invoices);
                    $('#statistik').empty().html(data.stats);
                    $(block).find('.incoming-type').change();
                    UpdateInvoiceList(block);
                }
            });
        }
    });

    UpdateInvoiceList($('.invoice-list'));

    $('#control-page #ag_num').liveSearch({
        url:'kundenverwaltung/livesearch/',
        width:400
    });

    $('#open-outgoing').click(function () {
        $('#close-outgoing').show();
        $('#main-menu').hide();
        $('#outgoing').fadeIn("slow");
        return false;
    });

    $('#close-outgoing').click(function () {
        $('#outgoing').fadeOut(function () {
            $('#main-menu').show();
        });
        return false;
    });


    $('#inv-newsubmit').click(function () {
        if ($('.new-flightinvoice input[type=text]').check_empty() == false)
            return false;
        $('.new-flightinvoice .loading').show();
        $(this).hide();
        $.ajax({
            data:$('.new-flightinvoice form').serialize(),
            type:'post',
            url:'control/add_flightinvoice/' + $('#invoice_formular_id').val(),
            success:function (data) {
                $('#flightinvoice-list').empty().html(data);
                UpdateFlightInvoiceEvents();
                $('.new-flightinvoice').reset();
            },
            complete:function () {
                $('.new-flightinvoice .loading').hide();
                $('.new-flightinvoice #inv-newsubmit').show();
            }
        });
        return false;
    });

    $('#inv-editsubmit').click(function () {
        if ($('.new-flightinvoice input').check_empty() == false)
            return false;
        $('.new-flightinvoice #inv-newsubmit').hide();
        $.ajax({
            data:$('.new-flightinvoice form').serialize(),
            type:'post',
            url:'control/update_flightinvoice/' + $('#invoice_formular_id').val() + '/' + $('#editinvoice_id').val(),
            success:function (data) {
                $('#flightinvoice-list').empty().html(data);
                UpdateFlightInvoiceEvents();
                $('.new-flightinvoice').reset();
                $('#inv-editsubmit').hide();
            },
            complete:function () {
                $('.new-flightinvoice .loading').hide();
                $('.new-flightinvoice #inv-newsubmit').show();
            }
        });
        return false;
    });

    UpdateFlightInvoiceEvents();


});