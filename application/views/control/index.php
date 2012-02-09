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
        <div class="hotel-search">
            <label for="search">Search:</label>
            <input class="search-hotel" type="text" id="search"/>
            <div class="search-loading"></div>
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
            <th colspan="2">Last Payment</th>
            <th>&nbsp;</th>
        </tr>
        <tr>
            <th>Vogr-NR</th>
            <th>RG-NR</th>
            <th>Buc.Datum</th>
            <th>RG-Datum</th>
            <th>Abreise</th>
            <th>Ruckreise</th>
            <th>Betrag</th>
            <th>Falling bis</th>
            <th>Status</th>
            <th>Betrag</th>
            <th>Falling bis</th>
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

