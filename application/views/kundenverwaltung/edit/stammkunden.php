<div id="page-header-wr">
    <div id="page-header">
        <a href="dashboard" class="home-link"><img src="img/header-logo.jpg"/></a>
        <ul class="page-path">
            <li><a href="kundenverwaltung">kundenverwaltung</a></li>
            <li><a href="stammkunden">stammkunden</a></li>
            <li><span>stammkunden № <?=$stammkunden->id?></span></li>
        </ul>
    </div>
</div>


<div id="new-stammkunden-page" class="kundenverwaltung-new content">

    <? echo form_open("stammkunden/" . $stammkunden->id) ?>

    <div class="input-block">

        <div class="person-block block">

            <div class="sex-param param">
                <label for="sex">Male:</label>
                <select id="sex" name="sex">
                    <option value="herr" <?=$stammkunden->sex == 'herr' ? 'selected' : ''?>>Herr</option>
                    <option value="frau" <?=$stammkunden->sex == 'frau' ? 'selected' : ''?>>Frau</option>
                </select>
            </div>

            <div class="param">
                <label for="name">Vorname</label>
                <input type="text" id="name" name="name" value="<?=$stammkunden->person_name?>"/>
            </div>

            <div class="param">
                <label for="surname">Nachname</label>
                <input type="text" id="surname" name="surname" value="<?=$stammkunden->person_surname?>"/>
            </div>

        </div>

        <div class="contact-block">
            <h2 class="block-header closed">Kontaktdaten</h2>

            <div class="contact-content">

                <div class="block">

                    <div class="param">
                        <label for="land">Land</label>
                        <input type="text" id="land" name="land" maxlength="20"
                               value="<?=$stammkunden->land?>"/>
                    </div>

                    <div class="param">
                        <label for="ort">Ort</label>
                        <input type="text" id="ort" name="ort" maxlength="30" value="<?=$stammkunden->ort?>"/>
                    </div>

                </div>

                <div class="block">

                    <div class="param">
                        <label for="plz">PLZ</label>
                        <input type="text" id="plz" name="plz" maxlength="6" value="<?=$stammkunden->plz?>"/>
                    </div>

                    <div class="param">
                        <label for="strasse">Strasse</label>
                        <input type="text" id="strasse" name="strasse" maxlength="200"
                               value="<?=$stammkunden->strasse?>"/>
                    </div>
                </div>

                <div class="block">

                    <div class="param">
                        <label for="phone">Phone</label>
                        <input type="text" id="phone" name="phone" value="<?=$stammkunden->phone?>" maxlength="15"/>
                    </div>

                    <div class="param">
                        <label for="mobile">Mobile</label>
                        <input type="text" id="mobile" name="mobile" value="<?=$stammkunden->mobile?>" maxlength="15"/>
                    </div>

                </div>

                <div class="block">

                    <div class="param">
                        <label for="fax">Fax</label>
                        <input type="text" id="fax" name="fax" value="<?=$stammkunden->fax?>" maxlength="15"/>
                    </div>

                    <div class="param">
                        <label for="email">E-Mail</label>
                        <input type="text" id="email" name="email" value="<?=$stammkunden->email?>" maxlength="30"/>
                    </div>

                </div>
            </div>
        </div>

    </div>

    <div class="buttons">
        <a href="stammkunden" id="cancel-button" class="button-link">Abbrechen</a>
        <input type="submit" id="submit-button" name="add_submit" value="Save"/>
    </div>


    </form>

    <br class="clear"/>
</div>
