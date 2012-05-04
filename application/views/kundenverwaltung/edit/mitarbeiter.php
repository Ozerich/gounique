<div id="page-header-wr">
    <div id="page-header">
        <a href="dashboard" class="home-link"><img src="img/header-logo.jpg"/></a>
        <ul class="page-path">
            <li><a href="kundenverwaltung">kundenverwaltung</a></li>
            <li><span><?=$user->fullname?></span></li>
        </ul>
    </div>
</div>


<div id="edit-agenturen-page" class="kundenverwaltung-new content">

    <? echo form_open("kundenverwaltung/verwalten/" . $user->id) ?>

    <div class="new-block">

        <div class="param">
            <label for="name">Name</label>
            <input type="text" name="name" value="<?=$user->name?>"/>
        </div>

        <div class="param">
            <label for="name">Surname</label>
            <input type="text" name="name" value="<?=$user->surname?>"/>
        </div>


        <div class="param">
            <label for="address">Adresse</label>
            <input type="text" name="address" value="<?=$user->address?>"/>
        </div>

        <div class="param">
            <label for="plz">PLZ / Ort</label>
            <input type="text" class="plz" name="plz" maxlength="5" value="<?=$user->plz?>"/> /
            <input type="text" class="ort" name="ort" value="<?=$user->ort?>"/>
        </div>


        <div class="param">
            <label for="email">E-Mail Adresse</label>
            <input type="text" name="email" value="<?=$user->email?>"/>
        </div>

        <div class="param">
            <label for="phone">Telefon</label>
            <input type="text" name="phone" value="<?=$user->phone?>"/>
        </div>

        <div class="param">
            <label for="about">Kommentar</label>
            <textarea name="about"><?=$user->about?></textarea>
        </div>

    </div>

    <div class="buttons">
        <a href="agenturen" class="button-link">Abbrechen</a>
        <input type="submit" name="edit_submit" class="" value="Apply"/>
    </div>


    </form>

    <br class="clear"/>
</div>