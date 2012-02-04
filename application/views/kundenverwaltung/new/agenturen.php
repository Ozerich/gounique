<div id="page-header-wr">
    <div id="page-header">
        <a href="dashboard" class="home-link"><img src="img/header-logo.jpg"/></a>
        <ul class="page-path">
            <li><a href="kundenverwaltung">kundenverwaltung</a></li>
            <li><a href="agenturen">agenturen</a></li>
            <li><span>neu agenturen</span></li>
        </ul>
    </div>
</div>


<div id="new-agenturen-page" class="kundenverwaltung-new content">

    <? echo form_open("agenturen/new") ?>

    <div class="new-block">

        <div class="param">
            <label for="name">Firmenname</label>
            <input type="text" name="name"/>
        </div>

        <div class="param">
            <label for="address">Adresse</label>
            <input type="text" name="address"/>
        </div>

        <div class="param">
            <label for="plz">PLZ / Ort</label>
            <input type="text" class="plz" name="plz" maxlength="5"/> /
            <input type="text" class="ort" name="ort"/>
        </div>

        <div class="param">
            <label for="website">Web-Seite</label>
            <input type="text" name="website"/>
        </div>

        <div class="param">
            <label>Ansprechpartner</label>
            <input type="radio" name="sex" value="herr" checked/>Herr&nbsp;
            <input type="radio" name="sex" value="frau"/>Frau
        </div>

        <div class="param">
            <label for="contactperson">&nbsp;</label>
            <input type="text" name="person_name"/>
        </div>

        <div class="param">
            <label for="email">E-Mail Adresse</label>
            <input type="text" name="email"/>
        </div>

        <div class="param">
            <label for="phone">Telefon</label>
            <input type="text" name="phone"/>
        </div>

        <div class="param">
            <label for="fax">Fax</label>
            <input type="text" name="fax"/>
        </div>

        <div class="param" id="provision-wr">
            <label for="provision">Provision Prozent</label>
            <input type="text" name="provision"/>
        </div>

        <div class="param">
            <label for="about">Kommentar</label>
            <textarea name="about"></textarea>
        </div>

        <div class="param">
            <label for="ausland">Ausland</label>
            <input type="checkbox" name="ausland" id="ausland" value="1"/>
        </div>

    </div>

    <div class="buttons">
        <a href="agenturen" class="button-link">Abbrechen</a>
        <input type="submit" name="add_submit" class="" value="Apply"/>
    </div>


    </form>

    <br class="clear"/>
</div>
