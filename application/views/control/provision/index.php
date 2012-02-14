<div id="page-header-wr">
    <div id="page-header">
        <a href="dashboard" class="home-link"><img src="img/header-logo.jpg"/></a>
        <ul class="page-path">
            <li><a href="control">finanzen & controling</a></li>
            <li><span>provision payments</span></li>
        </ul>
    </div>
</div>

<div id="control-page" class="content control-page">
    <input type="hidden" id="payments_type" value="provision"/>
    <input type="hidden" id="last_searchquery" value=""/>
    <input type="hidden" id="lastpayment_date" value=""/>
    <input type="hidden" id="lastpayment_amount" value=""/>
    <input type="hidden" id="lastpayment_remark" value=""/>

    <div class="hotellist-top">

        <div class="num-search">
            <div class="param">
                <label for="v_num">Search by Vorg-NR</label>
                <input type="text" id="v_num"/>
            </div>
            <div class="param">
                <label for="r_num">Search by RG-NR</label>
                <input type="text" id="r_num"/>
            </div>
        </div>

        <div class="date-search">

            <label for="search-von">von</label>
            <input type="text" maxlength="8" id="search-von"/>
            <label for="search-bis">bis</label>
            <input type="text" maxlength="8" id="search-bis"/>

            <select id="datesearch-type">
                <option value="provision">Provision</option>
            </select>

            <input type="submit" class="search-button" id="datesearch-start"/>
            <br class="clear"/>

        </div>

        <div class="hotel-buttons">
            <button id="show-payments" style="display:none">Payments</button>
        </div>
        <br class="clear"/>
    </div>
    <table class="product-list" id="controlpayments-list">
        <thead>
        <tr>
            <th>№</th>
            <th class="r-num">AG-NR</th>
            <th class="ag-num">RG-NR</th>
            <th>Vorg-NR</th>
            <th>Betrag</th>
            <th>Faellig bis</th>
            <th>Status</th>
            <th>Payment date</th>
        </tr>
        </thead>
        <tbody>
        <?=$invoice_list?>
        </tbody>
    </table>
</div>

