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
    <input type="hidden" id="payments_type" value="invoice"/>
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
                          <option value="abreise">Abreisedatum</option>
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


                  <input type="submit" class="search-button" id="datesearch-start"/>
                  <br class="clear"/>

              </fieldset>


              <div class="hotel-buttons" style="display:none">
                  <button id="show-payments" style="display:none">Payments</button>
              </div>
              <br class="clear"/>
              <a id="clear_filter" href="#">Clear filter</a>
          </div>

    <table class="product-list finanzen-list" id="invoice-list">
        <thead>
        <tr>
            <th>№</th>
            <th>RG-NR</th>
            <th>BQ</th>
            <th>Vorg-NR</th>
            <th>KD-Name</th>
            <th class="right">Abreise</th>
            <th class="right">Rückreise</th>
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

