<div id="page-header-wr">
    <div id="page-header">
        <a href="dashboard" class="home-link"><img src="img/header-logo.jpg"/></a>
        <ul class="page-path">
            <li><a href="control">finance & controlling</a></li>
            <li><a href="control/outgoing">Zahlungsausgänge</a></li>
            <li><span>Provisionszahlung</span></li>
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
                    <option value="provision">Provision</option>
                    <option value="abreise">Abreisedatum</option>
                    <option value="arrival">Rückreisedatum</option>
                </select>

                <div class="agenturen-wr">
                    <label for="ag_num">AG-NR:</label>
                    <input type="text" id="ag_num" maxlength="5" size="5"/>
                </div>

                <div class="personen-wr">
                    <label for="ag_num">Kd-Name:</label>
                    <input type="text" id="person"/>
                </div>
            </div>

            <div class="filter-checkboxes-wr">
                <div class="checkbox-param">
                    <label for="ag_num"><input type="checkbox" id="only_open" name="only_open"/>Only open</label>
                </div>
                <input type="submit" class="search-button" id="datesearch-start"/>
            </div>
        </fieldset>

        <div class="hotel-buttons">
            <button id="show-payments" style="display:none">Payments</button>
        </div>
        <br class="clear"/>
        <a id="clear_filter" href="#">Clear filter</a>
    </div>
    <table class="product-list finanzen-list" id="controlpayments-list">
        <thead>
        <tr>
            <th class="num">№</th>
            <th class="ag-num">RG-NR</th>
            <th class="r-num">AG-NR</th>
            <th class="right">Prov. %</th>
			<th>BQ</th>
            <th>Vorg-NR</th>
            <th>Kd-Name</th>
            <th>Abreise</th>
            <th>Rückreise</th>
            <th class="right">Total-RG</th>
            <th class="right">Prov. Betrag</th>
            <th class="right">MwSt</th>
            <th class="right">Faellig bis</th>
            <th>Netto</th>
            <th class="right">Status</th>
            <th class="right">Payment date</th>
            <th>&nbsp;</th>
        </tr>
        </thead>
        <tbody>
        <?=$invoice_list?>
        </tbody>
    </table>
</div>

