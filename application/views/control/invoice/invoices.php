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

    <p class="page-header">Invoices for <b><?=$formular->r_num?></b></p>

    <table class="incoming-blocks">
        <tr>

            <td class="incoming-block">
                <input type="hidden" class="block-type" value="hotel"/>

                <div class="type-header">
                    <h2>Hotels</h2>
                    <select class="incoming-type">
                        <? foreach ($formular->incomings as $incoming): ?>
                        <option value="<?=$incoming->id?>"><?=$incoming->name?></option>
                        <? endforeach; ?>
                    </select>
                    <a href="#" class="new-invoice">Rechnung</a>
                    <br class="clear"/>
                </div>
                <div class="newinvoice-block" style="display:none">
                    <div class="param">
                        <label for="invoice-num">Inv. Number</label>
                        <input maxlength="8" type="text" name="invoice-num" class="invoice-num"/>
                    </div>
                    <div class="param">
                        <label for="invoice-date">Inv. Date</label>
                        <input maxlength="8" type="text" name="invoice-date" class="invoice-date"/>
                    </div>
                    <div class="param">
                        <label for="invoice-amount">Inv. Amount</label>
                        <input maxlength="8" type="text" name="invoice-amount" id="invoice-amount"/ >
                    </div>
                    <div class="remark-param">
                        <label for="invoice-remark">Inv. Remark</label>
                        <textarea id="invoice-remark" name="invoice-remark"></textarea>
                    </div>
                    <button class="add-invoice">Add Rechnung</button>
                </div>
                <div class="invoices">
                    <?=$invoices['hotel']?>
                </div>
            </td>

            <td class="incoming-block">
                <input type="hidden" class="block-type" value="transfer"/>

                <div class="type-header">
                    <h2>Transfers</h2>
                    <select class="incoming-type">
                        <? foreach ($formular->incomings as $incoming): ?>
                        <option value="<?=$incoming->id?>"><?=$incoming->name?></option>
                        <? endforeach; ?>
                    </select>
                    <a href="#" class="new-invoice">Rechnung</a>
                    <br class="clear"/>
                </div>
                <div class="newinvoice-block" style="display:none">
                    <div class="param">
                        <label for="invoice-num">Inv. Number</label>
                        <input maxlength="12" type="text" name="invoice-num" class="invoice-num"/>
                    </div>
                    <div class="param">
                        <label for="invoice-date">Inv. Date</label>
                        <input maxlength="8" type="text" name="invoice-date" class="invoice-date"/>
                    </div>
                    <div class="param">
                        <label for="invoice-amount">Inv. Amount</label>
                        <input maxlength="8" type="text" name="invoice-amount" id="invoice-amount"/ >
                    </div>
                    <div class="remark-param">
                        <label for="invoice-remark">Inv. Remark</label>
                        <textarea id="invoice-remark" name="invoice-remark"></textarea>
                    </div>
                    <button class="add-invoice">Add Rechnung</button>
                </div>
                <div class="invoices">
                    <?=$invoices['transfer']?>
                </div>
            </td>
        </tr>
        <tr>

            <td class="incoming-block" style="clear: both">
                <input type="hidden" class="block-type" value="rundreise"/>

                <div class="type-header">
                    <h2>Rundreise</h2>
                    <select class="incoming-type">
                        <? foreach ($formular->incomings as $incoming): ?>
                        <option value="<?=$incoming->id?>"><?=$incoming->name?></option>
                        <? endforeach; ?>
                    </select>
                    <a href="#" class="new-invoice">Rechnung</a>
                    <br class="clear"/>
                </div>
                <div class="newinvoice-block" style="display:none">
                    <div class="param">
                        <label for="invoice-num">Inv. Number</label>
                        <input maxlength="8" type="text" name="invoice-num" class="invoice-num"/>
                    </div>
                    <div class="param">
                        <label for="invoice-date">Inv. Date</label>
                        <input maxlength="8" type="text" name="invoice-date" class="invoice-date"/>
                    </div>
                    <div class="param">
                        <label for="invoice-amount">Inv. Amount</label>
                        <input maxlength="8" type="text" name="invoice-amount" id="invoice-amount"/ >
                    </div>
                    <div class="remark-param">
                        <label for="invoice-remark">Inv. Remark</label>
                        <textarea id="invoice-remark" name="invoice-remark"></textarea>
                    </div>
                    <button class="add-invoice">Add Rechnung</button>
                </div>
                <div class="invoices">
                    <?=$invoices['rundreise']?>
                </div>
            </td>
            <td class="incoming-block">
                <input type="hidden" class="block-type" value="other"/>

                <div class="type-header">
                    <h2>Other</h2>
                    <a href="#" class="new-invoice">Rechnung</a>
                    <br class="clear"/>
                </div>
                <div class="newinvoice-block" style="display:none">
                    <div class="param">
                        <label for="invoice-num">Inv. Number</label>
                        <input maxlength="8" type="text" name="invoice-num" class="invoice-num"/>
                    </div>
                    <div class="param">
                        <label for="invoice-date">Inv. Date</label>
                        <input maxlength="8" type="text" name="invoice-date" class="invoice-date"/>
                    </div>
                    <div class="param">
                        <label for="invoice-amount">Inv. Amount</label>
                        <input maxlength="8" type="text" name="invoice-amount" id="invoice-amount"/ >
                    </div>
                    <div class="remark-param">
                        <label for="invoice-remark">Inv. Remark</label>
                        <textarea id="invoice-remark" name="invoice-remark"></textarea>
                    </div>
                    <button class="add-invoice">Add Rechnung</button>
                </div>
                <div class="invoices">
                    <?=$invoices['other']?>
                </div>
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <table id="statistik" class="stats product-list">
                    <?=$stats?>
                </table>
            </td>
        </tr>
    </table>

</div>

<div id="invoice-delete-confirm" style="display:none">
    Are you sure?
</div>