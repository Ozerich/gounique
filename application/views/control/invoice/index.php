<div id="page-header-wr">
    <div id="page-header">
        <a href="dashboard" class="home-link"><img src="img/header-logo.jpg"/></a>
        <ul class="page-path">
            <li><a href="control">finance & controlling</a></li>
            <li><a href="control/outgoing">Zahlungsausgänge</a></li>
            <li><span>Landleistungen</span></li>
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
    <table class="product-list finanzen-list" id="invoice-list">
        <thead>
        <tr>
            <th>№</th>
            <th>RG-NR</th>
            <th>Vorg-NR</th>
            <th>KD-Name</th>
            <th class="right">Abreise</th>
            <th class="right">Reisepreis</th>
            <th class="right">Hotels</th>
            <th class="right">Rundreise</th>
            <th class="right">Transfers</th>
            <th class="right">Other</th>
            <th class="right">Total</th>
            <th class="right">Payment<br/>Faellig bis</th>
            <th>&nbsp;</th>
        </tr>
        </thead>
        <tbody>
        <?=$invoice_list?>
        </tbody>
    </table>
</div>

