<div id="storeno-page">
    <?=form_open("formular/storeno/" . $formular->id, null, array("formular_id" => $formular->id));?>

    <div class="form-param">
        <label for="percent">% Client</label>
        <input type="text" id="percent" name="client_percent" length="2" maxlength="2"/>
    </div>

    <div class="form-param">
        <label for="provision">Provision</label>
        <input type="text" id="provision" name="provision" length="2" maxlength="2"/>
    </div>

    <div class="form-param">
        <label for="reason">Reason</label>
        <textarea id="reason" name="reason"></textarea>
    </div>

    <button class="btn btn-blue" id="cancel-storeno">Cancel</button>
    <input type="submit" class="btn btn-blue" value="Make Storeno"/>

    </form>
</div>