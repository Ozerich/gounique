<div id="page-header-wr">
    <div id="page-header">
        <a href="dashboard" class="home-link"><img src="img/header-logo.jpg"/></a>
        <ul class="page-path">
            <li><a href="kundenverwaltung">kundenverwaltung</a></li>
            <li><a href="incoming">incoming</a></li>
            <li><span>neu incoming</span></li>
        </ul>
    </div>
</div>


<div id="new-incoming-page" class="kundenverwaltung-new content">
    <? echo form_open("incoming/new") ?>

    <div class="new-block">
        <div class="input-block">

            <div class="param">
                <label for="name">Incoming Name</label>
                <input type="text" name="name" id="name"/>
            </div>

            <div class="contact-block">
                <h2 class="block-header closed">Kontaktdaten</h2>

                <div class="contact-content">

                    <div class="person-block block">

                        <div class="param sex-param">
                            <label for="sex">Male:</label>
                            <select id="sex" name="sex">
                                <option value="herr">Herr</option>
                                <option value="frau">Frau</option>
                            </select>
                        </div>

                        <div class="param">
                            <label for="vorname">Vorname</label>
                            <input type="text" id="vorname" name="vorname"/>
                        </div>

                        <div class="param">
                            <label for="nachname">Nachname</label>
                            <input type="text" id="nachname" name="nachname"/>
                        </div>

                    </div>

                    <div class="block">

                        <div class="param">
                            <label for="land">Land</label>
                            <input type="text" id="land" name="land" maxlength="20"/>
                        </div>

                        <div class="param">
                            <label for="ort">Ort</label>
                            <input type="text" id="ort" name="ort" maxlength="30"/>
                        </div>

                    </div>

                    <div class="block">

                        <div class="param">
                            <label for="plz">PLZ</label>
                            <input type="text" id="plz" name="plz" maxlength="6"/>
                        </div>

                        <div class="param">
                            <label for="strasse">Strasse</label>
                            <input type="text" id="strasse" name="strasse" maxlength="200"/>
                        </div>
                    </div>

                    <div class="block">

                        <div class="param">
                            <label for="phone">Phone</label>
                            <input type="text" id="phone" name="phone" maxlength="15"/>
                        </div>

                        <div class="param">
                            <label for="fax">Fax</label>
                            <input type="text" id="fax" name="fax" maxlength="15"/>
                        </div>
                    </div>

                    <div class="block">

                        <div class="param">
                            <label for="mobile">Mobile</label>
                            <input type="text" id="mobile" name="mobile" maxlength="15"/>
                        </div>


                        <div class="param">
                            <label for="homepage">Homepage</label>
                            <input type="text" id="homepage" name="homepage" maxlength="30"/>
                        </div>
                    </div>

                    <div class="block">

                        <div class="param">
                            <label for="email">E-Mail</label>
                            <input type="text" id="email" name="email" maxlength="30"/>
                        </div>

                        <div class="param">
                            <label for="email2">E-Mail 2</label>
                            <input type="text" id="email2" name="email2" maxlength="30"/>
                        </div>

                    </div>
                </div>
            </div>
            <div class="contact-block">
                <h2 class="block-header closed">Bankverbindung</h2>

                <div class="contact-content">
                    <div class="block">

                        <div class="param">
                            <label for="bank-name">Bank</label>
                            <input type="text" id="bank-name" name="bank_name" maxlength="30"/>
                        </div>

                        <div class="param">
                            <label for="bank-sitz">Sitz</label>
                            <input type="text" id="bank-sitz" name="bank_sitz" maxlength="30"/>
                        </div>
                    </div>

                    <div class="block">

                        <div class="param">
                            <label for="bank-blz">BLZ</label>
                            <input type="text" id="bank-blz" name="bank_blz" maxlength="30"/>
                        </div>

                        <div class="param">
                            <label for="bank-konto">Konto Nr.</label>
                            <input type="text" id="bank-konto" name="bank_konto" maxlength="30"/>
                        </div>
                    </div>

                    <div class="block">

                        <div class="param">
                            <label for="bank-swift">SWIFT/BIC</label>
                            <input type="text" id="bank-swift" name="bank_swift" maxlength="30"/>
                        </div>

                        <div class="param">
                            <label for="bank-iban">IBAN Nr.</label>
                            <input type="text" id="bank-iban" name="bank_iban" maxlength="30"/>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="buttons">
            <a href="incoming" id="cancel-button" class="button-link">Abbrechen</a>
            <input type="submit" id="submit-button" name="add_submit" value="Add"/>
        </div>
        </form>

        <br class="clear"/>
    </div>
