$(document).ready(function () {
    $("#datestart, #dateend").datepicker().datepicker("option", "showAnim", "blind").
        datepicker("option", "dateFormat", 'ddmmyy');

    $('#brutto-submit').click(function () {
        $.ajax({
            url:'statistik/count_brutto',
            type:'post',
            data:'date_start=' + $('#datestart').val() + '&date_end=' + $('#dateend').val(),
            success:function (data) {
                $('#brutto-count .result .value').html(data);
            }
        });
        return false;
    });

    jQuery("#statistik-table").jqGrid(
        {
            url:'statistik/main',
            datatype:"json",
            colNames:['Lfdnr', 'Berater', 'Kundenummer', 'Name', 'Prov%', 'Vorg-NR', 'RG-Nr', 'Buc.Datum', 'RG-Datum', 'KD-Name', 'Abreise', 'Rückreise', 'Brutto'],

            colModel:[
                {name:'ldfnr', index:'id', width:35, align: 'center'},
                {name:'berater', index:'sachbearbeiter', width:90},
                {name:'k_num', index:'k_num', width:90, align: 'center', sortable: false},
                {name:'name', index:'name', width:150, sortable: false},
                {name:'provision', index:'provision', width:35, align: 'center'},
                {name:'v_num', index:'v_num', width:50},
                {name:'r_num', index:'r_num', width:40},
                {name:'created_date', index:'created_date', width:60, align: 'center'},
                {name:'rechnung_date', index:'rechnung_date', width:60, align: 'center'},
                {name:'persons', index:'persons', width:150, sortable: false},
                {name:'departure_date', index:'departure_date', width:60, align: 'center'},
                {name:'arrival_date', index:'arrival_date', width:60, align: 'center'},
                {name:'brutto', index:'brutto', width:50, sortable: false}
            ],
            rowNum:10,
            rowList:[10, 20, 30],
            pager:'#statistik-pager',
            sortname:'id',
            viewrecords:true,
            height: 230,
            sortorder:"desc",
            caption:"Formulars" });

    jQuery("#statistik-table").jqGrid('navGrid', '#statistik-pager', {edit:false, add:false, del:false, find:false, search: false, update: false});

});