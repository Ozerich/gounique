<div id="page-header-wr">
    <div id="page-header">
        <a href="dashboard" class="home-link"><img src="img/header-logo.jpg"/></a>
        <ul class="page-path">
            <li><a href="kundenverwaltung">kundenverwaltung</a></li>
            <li><a href="mitarbeiter">mitarbeiter</a></li>
            <li><span>neu mitarbeiter</span></li>
        </ul>
    </div>
</div>


<div id="new-mitarbeiter-page" class="kundenverwaltung-new content">

    <? echo form_open("mitarbeiter/new") ?>

    <div class="new-block">

        <div class="param">
            <label for="name">Firmenname</label>
            <input type="text" name="name"/>
        </div>

        <div class="param">

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
            <label for="kurzel">Kürzel</label>
            <input type="text" maxlength="2" size="2" name="kurzel"/>
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

        <div class="param">
            <label for="about">Kommentar</label>
            <textarea name="about"></textarea>
        </div>

    </div>

    <div class="buttons">
        <a href="mitarbeiter" class="button-link">Abbrechen</a>
        <input type="submit" name="add_submit" class="" value="Apply"/>
    </div>


    </form>

    <br class="clear"/>
</div>
