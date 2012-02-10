<div id="page-header-wr">
    <div id="page-header">
        <a href="dashboard" class="home-link"><img src="img/header-logo.jpg"/></a>
        <ul class="page-path">
            <li><span>kontrolle</span></li>
        </ul>
    </div>
</div>

<div id="control-page" class="content control-page">

    <div class="hotellist-top">

        <div class="num-search">
            <div class="param">
                <label for="v_num">Search by Vorg-NR</label>
                <input type="text" id="v_num"/>
            </div>
            <div class="param">
                <label for="v_num">Search by RG-NR</label>
                <input type="text" id="r_num"/>
            </div>
        </div>

        <div class="date-search">

            <div class="date-item">
                <span class="search-header">Buc.Datum</span>
                <label for="buc-von">von</label>
                <input type="text" class="von" maxlength="8" id="buc-von"/>
                <label for="buc-bis">bis</label>
                <input type="text" class="bis" maxlength="8" id="buc-bis"/>
                <input type="submit" for="buchung" class="search-button" id="buc-search"/>
                <br class="clear"/>
            </div>

            <div class="date-item">
                <span class="search-header">RG-Datum</span>
                <label for="rg-von">von</label>
                <input type="text" class="von" maxlength="8" id="rg-von"/>
                <label for="rg-bis">bis</label>
                <input type="text" class="bis" maxlength="8" id="rg-bis"/>
                <input type="submit" for="rechnung" class="search-button" id="rg-search"/>
                <br class="clear"/>
            </div>

            <div class="date-item">
                <span class="search-header">Abreise Datum</span>
                <label for="abr-von">von</label>
                <input type="text" class="von" maxlength="8" id="abr-von"/>
                <label for="abr-bis">bis</label>
                <input type="text" class="bis" maxlength="8" id="abr-bis"/>
                <input type="submit" for="abreise" class="search-button" id="abr-search"/>
                <br class="clear"/>
            </div>

            <div class="date-item">
                <span class="search-header">Anzahlung Datum</span>
                <label for="anz-von">von</label>
                <input type="text" class="von" maxlength="8" id="anz-von"/>
                <label for="anz-bis">bis</label>
                <input type="text" class="bis" maxlength="8" id="anz-bis"/>
                <input type="submit" for="anzahlung" class="search-button" id="anz-search"/>
                <br class="clear"/>
            </div>

            <div class="date-item">
                <span class="search-header">Restzahlung Datum</span>
                <label for="rest-von">von</label>
                <input type="text" class="von" maxlength="8" id="rest-von"/>
                <label for="rest-bis">bis</label>
                <input type="text" class="bis" maxlength="8" id="rest-bis"/>
                <input type="submit" for="restzahlung" class="search-button" id="rest-search"/>
                <br class="clear"/>
            </div>

        </div>

        <div class="hotel-buttons">
            <button id="show-payments" style="display:none">Payments</button>
        </div>
        <br class="clear"/>
    </div>
    <table class="product-list" id="controlpayments-list">
        <thead>
        <tr>
            <th colspan="4">&nbsp;</th>
            <th colspan="2">Reisedatum</th>
            <th colspan="3">Anzahlung</th>
            <th colspan="3">Restzahlung</th>
            <th colspan="2">Payments</th>
            <th>&nbsp;</th>
        </tr>
        <tr>
            <th>RG-NR</th>
            <th>Vorg-NR</th>
            <th>Buc.Datum</th>
            <th>RG-Datum</th>
            <th>Abreise</th>
            <th>Ruckreise</th>
            <th>Betrag</th>
            <th>Faellig bis</th>
            <th>Status</th>
            <th>Betrag</th>
            <th>Faellig bis</th>
            <th>Status</th>
            <th>Date</th>
            <th>Amount</th>
            <th>Status</th>
        </tr>
        </thead>
        <tbody>
        <?=$invoice_list?>
        </tbody>
    </table>
</div>

