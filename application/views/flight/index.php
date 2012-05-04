<div id="page-header-wr">
    <div id="page-header">
        <a href="dashboard" class="home-link"><img src="img/header-logo.jpg"/></a>
        <ul class="page-path">
            <li><a href="product">produkt</a></li>
            <li><span>flugverwaltung</span></li>
        </ul>
    </div>
</div>

<div id="flight_page" class="content">

    <div class="hotellist-top">
        <div class="hotel-search">
            <label for="search">Search:</label>
            <input class="search-flight" type="text" id="search"/>

            <div class="search-loading"></div>
        </div>
        <a href="#" onclick="new_flight_open(); return false" class="flight-new button-link">NEU</a>
        <br class="clear"/>
    </div>

    <div id="flight_list_wr">
        <?=$flight_list?>
    </div>


    <div id="new_flight_block" class="new_flight_block modal-dialog">
        <div class="dialog-header">
            <a href="#" class="close" onclick="return close_flight_popup()">x</a>

            <h3>New Flight</h3>
        </div>

        <div class="alert-message success" style="display:none"></div>
        <div class="alert-message error" style="display:none"></div>
        <div class="dialog-content flight-form" id="flight_form">
            <div class="main-info block-line">
                <div class="param">
                    <label for="carrier">Carrier</label>
                    <input type="text" maxlength="10" id="carrier" name="carrier"/>
                </div>

                <div class="param">
                    <label for="flug_num">Flug Nr.</label>
                    <input type="text" maxlength="10" id="flug_num" name="flug_num"/>
                </div>

                <div class="param">
                    <label for="int_num">Int. Nr.</label>
                    <input type="text" maxlength="10" id="int_num" name="int_num"/>
                </div>

                <div class="param">
                    <label for="marge">Marge %</label>
                    <input type="text" maxlength="10" value="18" id="marge" name="marge"/>
                </div>

            </div>

            <div class="tlc-info block-line">
                <div class="param">
                    <label for="tlc_from">Abflughafen</label>
                    <input type="text" maxlength="10" id="tlc_from" name="tlc_from"/>
                </div>

                <div class="param">
                    <label for="tlc_to">Zielflughafen</label>
                    <input type="text" maxlength="10" id="tlc_to" name="tlc_to"/>
                </div>
            </div>

            <div class="checkboxes block-line">
                <div class="param">
                    <label for="crs">CRS Sichtbar<input type="checkbox" name="crs" id="crs"/></label>
                </div>
                <div class="param">
                    <label for="hotel_bindung">Hotel Bindung<input type="checkbox" name="hotel_bindung"
                                                                   id="hotel_bindung"/></label>
                </div>
            </div>

            <div class="taxes-info block-line">
                <div class="param">
                    <label for="carrier">Tax - Gebühren</label>
                    <input type="text" maxlength="10" id="tax_1" value="0" name="tax_1"/>
                </div>

                <div class="param">
                    <label for="tax_2">NF Zuschlag</label>
                    <input type="text" maxlength="10" id="tax_2" value="0" name="tax_2"/>
                </div>

                <div class="param">
                    <label for="tax_3">Sicherheitsgebühr</label>
                    <input type="text" maxlength="10" id="tax_3" value="0" name="tax_3"/>
                </div>

                <div class="param">
                    <label for="tax_4">Kerosinzuschlag</label>
                    <input type="text" maxlength="10" id="tax_4" value="0" name="tax_4"/>
                </div>

            </div>

            <div class="class-info block-line">
                <span class="block-header">Klasses:</span>

                <div class="classes">
                    <div class="class example" style="display: none">
                        <label class="class-name">Klasse A:</label>
                        <input type="text" maxlength="2" for-name="from"/> - <input type="text" maxlength="2"
                                                                                    for-name="to"/>
                        <label class="tax-need">Zuschläge gültig<input for-name="tax_need" type="checkbox"/></label>
                        <a href="#" class="delete" onclick="delete_class(this); return false;"></a>
                    </div>
                </div>
                <button id="new-class" onclick="return new_class();">New Klasse</button>
            </div>

        </div>
        <div class="dialog-footer">
            <button class="cancel" onclick="return close_flight_popup()">Abbrechen</button>
            <button class="add" onclick="return addflight_submit()">Add</button>
        </div>
        <div class="dialog-loading-overlay">
            <span>Loading...</span>
        </div>
    </div>
</div>