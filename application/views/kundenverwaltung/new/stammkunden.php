<div id="page-header-wr">
    <div id="page-header">
        <a href="dashboard" class="home-link"><img src="img/header-logo.jpg"/></a>
        <ul class="page-path">
            <li><a href="kundenverwaltung">kundenverwaltung</a></li>
            <li><a href="stammkunden">stammkunden</a></li>
            <li><span>neu stammkunden</span></li>
        </ul>
    </div>
</div>


<div id="new-stammkunden-page" class="kundenverwaltung-new content">
    <? echo form_open("stammkunden/new") ?>

    <div class="new-block">
        <div class="input-block">

            <div class="person-block block">

                <div class="param sex-param">
                    <label for="sex">Male:</label>
                    <select id="sex" name="sex">
                        <option value="herr">Herr</option>
                        <option value="frau">Frau</option>
                    </select>
                </div>

                <div class="param">
                    <label for="name">Vorname</label>
                    <input type="text" id="name" name="name"/>
                </div>

                <div class="param">
                    <label for="surname">Nachname</label>
                    <input type="text" id="surname" name="surname"/>
                </div>

            </div>

            <div class="contact-block">
                <h2 class="block-header closed">Kontaktdaten</h2>

                <div class="contact-content">

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
                            <label for="mobile">Mobile</label>
                            <input type="text" id="mobile" name="mobile" maxlength="15"/>
                        </div>

                    </div>

                    <div class="block">

                        <div class="param">
                            <label for="fax">Fax</label>
                            <input type="text" id="fax" name="fax" maxlength="15"/>
                        </div>

                        <div class="param">
                            <label for="email">E-Mail</label>
                            <input type="text" id="email" name="email" maxlength="30"/>
                        </div>

                    </div>
                </div>
            </div>

        </div>

        <div class="buttons">
            <a href="stammkunden" id="cancel-button" class="button-link">Abbrechen</a>
            <input type="submit" id="submit-button" name="add_submit" value="Add"/>
        </div>
        </form>

        <br class="clear"/>
    </div>
