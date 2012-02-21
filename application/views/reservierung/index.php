<div id="page-header-wr">
    <div id="page-header">
        <a href="dashboard" class="home-link"><img src="img/header-logo.jpg"/></a>
        <ul class="page-path">
            <li><span>neu formular</span></li>
        </ul>
    </div>
</div>

<div id="createstart-page" class="reservierung-page content">
    <? echo form_open("reservierung/"); ?>
    <p class="error"><?=$error?></p>
    <label for="kunde_id">Kundennummer / Agenturnummer:</label>
    <input type="text" name="kunde_id" id="kunde_id"/>
    <input type="submit" name="kundennummer-submit" value="Create"/>
    <a class="button-link" href="reservierung/create">Create new</a>
    </form>
    <br/><br/>
    <? echo form_open("reservierung/open"); ?>
    <label for="v_num">Vorgangsnummer:</label>
    <input type="text" maxlength="6" name="v_num" id="v_num"/>
    <input type="submit" name="view-vnum" value="Open"/>
    <br/><br/>
	<label for="v_num">Kundenname:</label>
    <input type="text" name="kunde_name" id="kunde_name"/>
    <input type="hidden" name="formular_id"/>
    <input type="submit" name="view-kundename" value="Open"/>
    <br/><br/>
    <label for="r_num">Rechnungsnummer:</label>
    <input type="text" maxlength="9" name="r_num" id="r_num"/>
    <input type="submit" name="view-rnum" value="Open"/>
    </form>
</div>

