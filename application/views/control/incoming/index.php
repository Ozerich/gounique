<div id="page-header-wr">
    <div id="page-header">
        <a href="dashboard" class="home-link"><img src="img/header-logo.jpg"/></a>
        <ul class="page-path">
            <li><a href="control">finance & controlling</a></li>
            <li><span>Zahlungseingang</span></li>
        </ul>
    </div>
</div>

<div id="control-page" class="content control-page">
    <input type="hidden" id="payments_type" value="incoming"/>
    <input type="hidden" id="last_searchquery" value=""/>
    <input type="hidden" id="lastpayment_date" value=""/>
    <input type="hidden" id="lastpayment_amount" value=""/>
    <input type="hidden" id="lastpayment_remark" value=""/>
    <input type="hidden" id="lastpayment_type"/>

    <div class="hotellist-top">

        <fieldset class="num-search">
            <legend>Search by:</legend>
            <div class="param">
                <label for="v_num">Vorg-NR</label>
                <input type="text" id="v_num" maxlength="6"/>
            </div>
            <div class="param">
                <label for="r_num">RG-NR</label>
                <input type="text" id="r_num" maxlength="11"/>
            </div>
        </fieldset>

        <fieldset class="date-search">

            <legend>Search Date</legend>

            <div class="search-wr">
                <label for="search-von">von</label>
                <input type="text" maxlength="8" id="search-von"/>
                <label for="search-bis">bis</label>
                <input type="text" maxlength="8" id="search-bis"/>

                <select id="datesearch-type">
                    <option value="anzahlung">Anzahlung</option>
                    <option value="restzahlung">Restzahlung</option>
                    <option value="rechnung">Rechnungsdatum</option>
                    <option value="versand">Versanddatum</option>
                </select>
            </div>

            <input type="submit" class="search-button" id="datesearch-start"/>
            <br class="clear"/>

        </fieldset>


        <div class="hotel-buttons">
            <button id="show-payments" style="display:none">Payments</button>
        </div>
        <br class="clear"/>
        <a id="clear_filter" href="#">Clear filter</a>
    </div>
    <table class="product-list" id="controlpayments-list">
        <thead>
        <tr>
            <th>&nbsp;</th>
            <th colspan="6">&nbsp;</th>
            <th colspan="3">Anzahlung</th>
            <th colspan="3">Restzahlung</th>
            <th>&nbsp;</th>
            <th>&nbsp;</th>
            <th colspan="3">Versand</th>
        </tr>
        <tr>
            <th class="num">№</th>
            <th class="ag-num">AG-NR</th>
            <th class="rg-num">RG-NR</th>
            <th>Vorg-NR</th>
            <th>Rechnungdatum</th>
            <th>Abreise</th>
            <th>Total</th>
            <th>Betrag</th>
            <th>Faellig bis</th>
            <th>Status</th>
            <th>Betrag</th>
            <th>Faellig bis</th>
            <th>Status</th>
            <th>Storno</th>
            <th>Netto</th>
            <th class="status">Status I</th>
            <th class="status">Status II</th>
            <th>Date</th>
        </tr>
        </thead>
        <tbody>
        <?=$invoice_list?>
        </tbody>
    </table>
</div>

