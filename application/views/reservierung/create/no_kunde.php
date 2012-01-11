<div id="page-header-wr">
    <div id="page-header">
        <a href="dashboard" class="home-link"><img src="img/header-logo.jpg"/></a>
        <ul class="page-path">
            <li><span>neu formular</span></li>
        </ul>
    </div>
</div>

<div id="findkunde-page" class="reservierung-page content">
    <? echo form_open("reservierung/create/"); ?>
        <p class="error"><?=$error?></p>
        <label for="kundennumer">Kundenummer:</label>
        <input type="text" name="kunde_id" id="kunde_id"/>
        <input type="submit" name="kundennummer-submit" value="next" />
    </form>
</div>

