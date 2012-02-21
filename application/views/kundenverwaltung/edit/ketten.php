<div id="page-header-wr">
    <div id="page-header">
        <a href="dashboard" class="home-link"><img src="img/header-logo.jpg"/></a>
        <ul class="page-path">
            <li><a href="kundenverwaltung">kundenverwaltung</a></li>
            <li><a href="ketten">ketten</a></li>
            <li><span>ketten № <?=$kette->id?></span></li>
        </ul>
    </div>
</div>


<div id="new-ketten-page" class="kundenverwaltung-new content">

    <? echo form_open("ketten/" . $kette->id) ?>

    <div class="input-block">

        <div class="param">
            <label for="name">Ketten name</label>
            <input type="text" name="name" id="name" value="<?=$kette->name?>"/>
        </div>

        <div class="contact-block">
            <h2 class="block-header closed">Kontaktdaten</h2>

            <div class="contact-content">
                <div class="person-block block">

                    <div class="param sex-param">
                        <label for="sex">Male:</label>
                        <select id="sex" name="sex">
                            <option value="herr" <?=$kette->kontakt_sex == "herr" ? "selected" : ""?>>Herr</option>
                            <option value="frau" <?=$kette->kontakt_sex == "frau" ? "selected" : ""?>>Frau</option>
                        </select>
                    </div>

                    <div class="param">
                        <label for="vorname">Vorname</label>
                        <input type="text" id="vorname" name="vorname" value="<?=$kette->kontakt_name?>"/>
                    </div>

                    <div class="param">
                        <label for="nachname">Nachname</label>
                        <input type="text" id="nachname" name="nachname" value="<?=$kette->kontakt_surname?>"/>
                    </div>

                </div>

                <div class="block">

                    <div class="param">
                        <label for="land">Land</label>
                        <input type="text" id="land" name="land" maxlength="20" value="<?=$kette->kontakt_land?>"/>
                    </div>

                    <div class="param">
                        <label for="ort">Ort</label>
                        <input type="text" id="ort" name="ort" maxlength="30" value="<?=$kette->kontakt_ort?>"/>
                    </div>

                </div>

                <div class="block">

                    <div class="param">
                        <label for="plz">PLZ</label>
                        <input type="text" id="plz" name="plz" maxlength="6" value="<?=$kette->kontakt_plz?>"/>
                    </div>

                    <div class="param">
                        <label for="strasse">Strasse</label>
                        <input type="text" id="strasse" name="strasse" maxlength="200"
                               value="<?=$kette->kontakt_strasse?>"/>
                    </div>
                </div>

                <div class="block">

                    <div class="param">
                        <label for="phone">Phone</label>
                        <input type="text" id="phone" name="phone" maxlength="15" value="<?=$kette->kontakt_phone?>"/>
                    </div>

                    <div class="param">
                        <label for="fax">Fax</label>
                        <input type="text" id="fax" name="fax" maxlength="15" value="<?=$kette->kontakt_fax?>"/>
                    </div>
                </div>

                <div class="block">

                    <div class="param">
                        <label for="email">E-Mail</label>
                        <input type="text" id="email" name="email" maxlength="30" value="<?=$kette->kontakt_email?>"/>
                    </div>

                    <div class="param">
                        <label for="homepage">Homepage</label>
                        <input type="text" id="homepage" name="homepage" maxlength="30"
                               value="<?=$kette->kontakt_homepage?>"/>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <div class="buttons">
        <a href="ketten" id="cancel-button" class="button-link">Abbrechen</a>
        <input type="submit" id="submit-button" name="add_submit" value="Save"/>
    </div>


    </form>

    <br class="clear"/>
</div>
