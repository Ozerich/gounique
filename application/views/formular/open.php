<? echo form_open("formular/open"); ?>
    <div class="page" id="resultpage">
        <div class="input">
            <label for="vorgangsnummer">Vorgangsnummer:</label>
            <input type="text" name="vorgan"/>
        </div>
        <br class="clear"/><br/>
        <button class="btn btn-small btn-blue">Open</button>
    </div>
    <input type="hidden" name="step" value="final"/>
</form>