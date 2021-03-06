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
                <div class="berater-param">
                    <label for="berater">Berater:</label>
                    <select id="berater">
                        <option value="0">All</option>
                        <? foreach(User::all() as $user): ?>
                        <option value="<?=$user->id?>"><?=$user->fullname?></option>
                        <? endforeach; ?>
                    </select>
                </div>
                <input type="submit" class="search-button" id="datesearch-start"/>
            </div>

        </fieldset>


        <div class="hotel-buttons" style="display:none">
            <button id="show-payments" style="display:none">Payments</button>
        </div>
        <br class="clear"/>
        <a id="clear_filter" href="#">Clear filter</a>
    </div>
    <table class="product-list finanzen-list" id="controlpayments-list">
        <thead>
        <tr>
            <th colspan="11">&nbsp;</th>
            <th colspan="3">Anzahlung</th>
            <th colspan="3">Restzahlung</th>
            <th>&nbsp;</th>
            <th>&nbsp;</th>
            <th>&nbsp;</th>
            <th>&nbsp;</th>
            <th>&nbsp;</th>
        </tr>
        <tr>
            <th>№</th>
            <th>BR</th>
            <th class="rg-num">RG-NR</th>
            <th class="ag-num">AG-NR</th>
            <th>BQ</th>
            <th>Vorg-NR</th>
            <th>KD-Name</th>
            <th class="right">RG-Datum</th>
            <th class="right">Abreise</th>
            <th class="right">Rückreise</th>
            <th class="right">Reisepreis</th>
            <th class="right">Betrag</th>
            <th class="right">Faellig</th>
            <th class="right">Status</th>
            <th class="right">Betrag</th>
            <th class="right">Faellig</th>
            <th>Status</th>
            <th>Netto</th>
            <th class="right">Zahl.Diff</th>
            <th class="right">Payment date</th>
            <th>&nbsp;</th>
        </tr>
        </thead>
        <tbody>
        <?=$invoice_list?>
        </tbody>
    </table>
</div>

