<div id="page-header-wr">
    <div id="page-header">
        <a href="dashboard" class="home-link"><img src="img/header-logo.jpg"/></a>
        <ul class="page-path">
            <li><a href="control">finance & controlling</a></li>
            <li><span>Profit & Loss</span></li>
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

        <div class="hotel-buttons">
            <button id="show-payments" style="display:none">Payments</button>
        </div>
        <br class="clear"/>
    </div>
    <table class="product-list">
        <thead>
        <tr>
            <th>№</th>
            <th>RG-NR</th>
            <th>Vorg-NR</th>
            <th>Abreise</th>
            <th>Total</th>
            <th>Diff</th>
            <th>Flights</th>
            <th>Hotels</th>
            <th>Rundreise</th>
            <th>Transfers</th>
            <th>Other</th>
            <th>Provision</th>
            <th>Total Cost</th>
            <th>Brutto Ergebnis</th>
        </tr>
        </thead>
        <tbody>
        <?=$invoice_list?>
        </tbody>
    </table>
</div>

