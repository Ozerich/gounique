<div id="page-header-wr">
    <div id="page-header">
        <a href="dashboard" class="home-link"><img src="img/header-logo.jpg"/></a>
        <ul class="page-path">
            <li><a href="control">finance & controlling</a></li>
            <li><a href="control/invoice">Zahlungsausgang</a></li>
            <li><span>Invoices for <?=$formular->r_num?></span></li>
        </ul>
    </div>
</div>

<div id="formularincoming-page" class="content">
    <input type="hidden" id="invoice_formular_id" value="<?=$formular->id?>"/>

    <div id="flightinvoice-list"><?=$invoice_list?></div>
    <div class="new-flightinvoice">
        <form>
            <div class="top">
                <div class="param inv-number">
                    <label for="inv-number">Inv. Number</label>
                    <input type="text" name="inv-number" id="inv-number" maxlength="10"/>
                </div>
                <div class="param inv-date">
                    <label for="inv-date">Inv. Date</label>
                    <input type="text" class="set_datepicker" name="inv-date" id="inv-date" maxlength="8"/>
                </div>
                <div class="param inv-type">
                    <label for="inv-type">Inv. Type</label>
                    <select id="inv-type" name="inv-type">
                        <? foreach (FlightInvoice::$TYPES as $id => $name): ?>
                        <option value="<?=$id?>"><?=$name?></option>
                        <? endforeach; ?>
                    </select>
                </div>
                <br class="clear"/>
            </div>
            <div class="left">
                <div class="param inv-amount">
                    <label for="inv-amount">Inv. Amount</label>
                    <input type="text" name="inv-amount" maxlength="8" id="inv-amount"/>
                </div>
                <div class="loading_32 loading"></div>
                <button id="inv-newsubmit">New Invoice</button>
            </div>
            <div class="param inv-remark">
                <label for="inv-remark">Remark</label>
                <textarea name="inv-remark" class="inv-remark" id="inv-remark"></textarea>
            </div>
            <br class="clear"/>
        </form>
    </div>
</div>


<div id="invoice-delete-confirm" title="Delete invoice?" style="display:none">
    <p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>
        Are you sure?
    </p>
</div>

<div id="invoicepayment-delete-confirm" title="Delete Payment?" style="display:none">
    <p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>
       Are you sure?
    </p>
</div>