<div id="page-header-wr">
    <div id="page-header">
        <a href="dashboard" class="home-link"><img src="img/header-logo.jpg"/></a>
        <ul class="page-path">
            <li><a href="kundenverwaltung">kundenverwaltung</a></li>
            <li><a href="incoming">incoming</a></li>
            <li><span>incoming № <?=$incoming->id?></span></li>
        </ul>
    </div>
</div>


<div id="new-incoming-page" class="kundenverwaltung-new content">

    <? echo form_open("incoming/" . $incoming->id) ?>

    <div class="input-block">

        <div class="param">
            <label for="name">incoming name</label>
            <input type="text" name="name" id="name" value="<?=$incoming->name?>"/>
        </div>

        <div class="contact-block">
            <h2 class="block-header closed">Kontaktdaten</h2>

            <div class="contact-content">

                <div class="person-block block">

                    <div class="param sex-param">
                        <label for="sex">Male:</label>
                        <select id="sex" name="sex">
                            <option value="herr" <?=$incoming->kontakt_sex == "herr" ? "selected" : ""?>>Herr</option>
                            <option value="frau" <?=$incoming->kontakt_sex == "frau" ? "selected" : ""?>>Frau</option>
                        </select>
                    </div>

                    <div class="param">
                        <label for="vorname">Vorname</label>
                        <input type="text" id="vorname" name="vorname" value="<?=$incoming->kontakt_name?>"/>
                    </div>

                    <div class="param">
                        <label for="nachname">Nachname</label>
                        <input type="text" id="nachname" name="nachname" value="<?=$incoming->kontakt_surname?>"/>
                    </div>


                </div>

                <div class="block">

                    <div class="param">
                        <label for="land">Land</label>
                        <input type="text" id="land" name="land" maxlength="20" value="<?=$incoming->kontakt_land?>"/>
                    </div>

                    <div class="param">
                        <label for="ort">Ort</label>
                        <input type="text" id="ort" name="ort" maxlength="30" value="<?=$incoming->kontakt_ort?>"/>
                    </div>

                </div>

                <div class="block">

                    <div class="param">
                        <label for="plz">PLZ</label>
                        <input type="text" id="plz" name="plz" maxlength="6" value="<?=$incoming->kontakt_plz?>"/>
                    </div>

                    <div class="param">
                        <label for="strasse">Strasse</label>
                        <input type="text" id="strasse" name="strasse" maxlength="60"
                               value="<?=$incoming->kontakt_strasse?>"/>
                    </div>
                </div>

                <div class="block">

                    <div class="param">
                        <label for="phone">Phone</label>
                        <input type="text" id="phone" name="phone" maxlength="15"
                               value="<?=$incoming->kontakt_phone?>"/>
                    </div>

                    <div class="param">
                        <label for="fax">Fax</label>
                        <input type="text" id="fax" name="fax" maxlength="15" value="<?=$incoming->kontakt_fax?>"/>
                    </div>
                </div>

                <div class="block">

                    <div class="param">
                        <label for="mobile">Mobile</label>
                        <input type="text" id="mobile" name="mobile" maxlength="15"
                               value="<?=$incoming->kontakt_mobile?>"/>
                    </div>

                    <div class="param">
                        <label for="homepage">Homepage</label>
                        <input type="text" id="homepage" name="homepage" maxlength="30"
                               value="<?=$incoming->kontakt_homepage?>"/>
                    </div>
                </div>

                <div class="block">

                    <div class="param">
                        <label for="email">E-Mail</label>
                        <input type="text" id="email" name="email" maxlength="30"
                               value="<?=$incoming->kontakt_email?>"/>
                    </div>

                    <div class="param">
                        <label for="email2">E-Mail 2</label>
                        <input type="text" id="email2" name="email2" maxlength="30"
                               value="<?=$incoming->kontakt_email2?>"/>
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
                        <input type="text" id="bank-name" name="bank_name" value="<?=$incoming->bank_name?>"
                               maxlength="30"/>
                    </div>

                    <div class="param">
                        <label for="bank-sitz">Sitz</label>
                        <input type="text" id="bank-sitz" name="bank_sitz" value="<?=$incoming->bank_sitz?>"
                               maxlength="30"/>
                    </div>
                </div>

                <div class="block">

                    <div class="param">
                        <label for="bank-blz">BLZ</label>
                        <input type="text" id="bank-blz" name="bank_blz" value="<?=$incoming->bank_blz?>"
                               maxlength="30"/>
                    </div>

                    <div class="param">
                        <label for="bank-konto">Konto Nr.</label>
                        <input type="text" id="bank-konto" name="bank_konto" value="<?=$incoming->bank_konto?>"
                               maxlength="30"/>
                    </div>
                </div>

                <div class="block">

                    <div class="param">
                        <label for="bank-swift">SWIFT/BIC</label>
                        <input type="text" id="bank-swift" name="bank_swift" value="<?=$incoming->bank_swift?>"
                               maxlength="30"/>
                    </div>

                    <div class="param">
                        <label for="bank-iban">IBAN Nr.</label>
                        <input type="text" id="bank-iban" name="bank_iban" value="<?=$incoming->bank_iban?>"
                               maxlength="30"/>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <div class="buttons">
        <a href="incoming" id="cancel-button" class="button-link">Abbrechen</a>
        <input type="submit" id="submit-button" name="add_submit" value="Save"/>
    </div>


    </form>

    <br class="clear"/>
</div>
